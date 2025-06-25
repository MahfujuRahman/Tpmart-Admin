<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Flag;
use App\Models\Unit;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductSize;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ChildCategory;
use Yajra\DataTables\DataTables;
use App\Models\PackageProductItem;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\Facades\Image;

class PackageProductController extends Controller
{
    /**
     * Display package products listing page
     */
    public function index()
    {
        return view('backend.package_product.index');
    }

    /**
     * Get package products data for DataTable
     */
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('products')
                ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
                ->select(
                    'products.*',
                    'categories.name as category_name',
                    'brands.name as brand_name'
                )
                ->where('products.is_package', 1)
                ->orderBy('products.id', 'desc')
                ->get();

            return DataTables::of($data)
                ->addColumn('image', function ($data) {
                    $imagePath = $data->image ? url($data->image) : url('demo_products/demo_product.png');
                    return '<img src="' . $imagePath . '" class="gridProductImage" style="width: 50px; height: 50px; object-fit: cover;">';
                })
                ->addColumn('price', function ($data) {
                    $price = '৳' . number_format($data->price, 2);
                    if ($data->discount_price > 0) {
                        $price .= '<br><small class="text-muted"><del>৳' . number_format($data->discount_price, 2) . '</del></small>';
                    }
                    return $price;
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return '<span class="badge badge-success">Active</span>';
                    } else {
                        return '<span class="badge badge-warning">Inactive</span>';
                    }
                })
                ->addColumn('package_items_count', function ($data) {
                    $count = PackageProductItem::where('package_product_id', $data->id)->count();
                    return '<span class="badge badge-info">' . $count . ' items</span>';
                })
                ->addColumn('action', function ($data) {
                    $btn = '<a href="' . url('package-products/' . $data->id . '/edit') . '" class="btn btn-sm btn-warning mb-1"><i class="fas fa-edit"></i> Edit</a>';
                    $btn .= ' <a href="' . url('package-products/' . $data->id . '/manage-items') . '" class="btn btn-sm btn-info mb-1"><i class="fas fa-list"></i> Manage Items</a>';
                    $btn .= ' <a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-sm btn-danger mb-1 deleteBtn"><i class="fas fa-trash"></i> Delete</a>';
                    return $btn;
                })
                ->addIndexColumn()
                ->rawColumns(['image', 'price', 'status', 'package_items_count', 'action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new package product
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        $units = Unit::where('status', 1)->get();
        $flags = Flag::where('status', 1)->get();
        $products = Product::where('status', 1)->where('is_package', 0)->get(); // Exclude package products
        $colors = Color::get();
        $sizes = ProductSize::orderBy('serial', 'asc')->get();

        return view('backend.package_product.create', compact(
            'categories',
            'brands',
            'units',
            'flags',
            'products',
            'colors',
            'sizes'
        ));
    }

    /**
     * Store a newly created package product
     */
    public function store(Request $request)
    {
        // dd($request->all()); // Debugging line to check request data
        $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'status' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'package_items' => 'required|array|min:1',
            'package_items.*.product_id' => 'required|exists:products,id',
            'package_items.*.quantity' => 'required|integer|min:1',
        ]);

        // Handle image upload
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $location = public_path('productImages/');

            if ($image->extension() == 'svg') {
                $image->move($location, $imageName);
            } else {
                Image::make($image)->save($location . $imageName, 60);
            }

            $imageFileName = $location . $imageName;
        }

        // Generate slug
        $clean = preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($request->name));
        $slug = preg_replace('!\s+!', '-', $clean);

        DB::beginTransaction();
        try {
            $product = new Product();
            $product->name = $request->name;
            $product->short_description = $request->short_description;
            $product->description = $request->description;
            $product->category_id = $request->category_id;
            $product->subcategory_id = $request->subcategory_id;
            $product->childcategory_id = $request->childcategory_id;
            $product->brand_id = $request->brand_id;
            $product->image = $imageFileName;
            $product->price = $request->price;
            $product->stock = $request->stock;

            $product->discount_price = $request->discount_price ?? 0;
            $product->stock = 0; // Package products don't have direct stock
            $product->unit_id = $request->unit_id;
            $product->tags = $request->tags;
            $product->meta_title = $request->meta_title;
            $product->meta_keywords = $request->meta_keywords;
            $product->meta_description = $request->meta_description;
            $product->status = $request->status;
            $product->is_package = 1; // Mark as package product
            $product->has_variant = 0; // Package products don't have variants
            $product->slug = $slug . "-" . time() . Str::random(5);
            $product->created_at = Carbon::now();
            $product->save();

            // Add package items
            foreach ($request->package_items as $item) {
                PackageProductItem::create([
                    'package_product_id' => $product->id,
                    'product_id' => $item['product_id'],
                    'color_id' => !empty($item['color_id']) ? $item['color_id'] : null,
                    'size_id' => !empty($item['size_id']) ? $item['size_id'] : null,
                    'quantity' => $item['quantity'],
                ]);
            }

            DB::commit();
            Toastr::success('Package Product Created Successfully!', 'Success');
            return redirect()->route('PackageProducts.Index')->with('success', 'Package Product Created Successfully with ' . count($request->package_items) . ' items');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Error creating package product: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing a package product
     */
    public function edit($id)
    {
        $product = Product::where('id', $id)->where('is_package', 1)->firstOrFail();
        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        $units = Unit::where('status', 1)->get();
        $flags = Flag::where('status', 1)->get();
        $subcategories = Subcategory::where('category_id', $product->category_id)->get();
        $childcategories = ChildCategory::where('category_id', $product->category_id)
            ->where('subcategory_id', $product->subcategory_id)
            ->get();

        return view('backend.package_product.edit', compact(
            'product',
            'categories',
            'brands',
            'units',
            'flags',
            'subcategories',
            'childcategories'
        ));
    }

    /**
     * Update a package product
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required',
            'price' => 'required|numeric|min:0',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::where('id', $id)->where('is_package', 1)->firstOrFail();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && file_exists(public_path('productImages/' . $product->image))) {
                unlink(public_path('productImages/' . $product->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $location = public_path('productImages/');

            if ($image->extension() == 'svg') {
                $image->move($location, $imageName);
            } else {
                Image::make($image)->save($location . $imageName, 60);
            }
            $product->image = $location . $imageName;
        }

        $product->name = $request->name;
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->childcategory_id = $request->childcategory_id;
        $product->brand_id = $request->brand_id;
        $product->price = $request->price;
        $product->discount_price = $request->discount_price ?? 0;
        $product->unit_id = $request->unit_id;
        $product->stock = $request->stock;
        $product->tags = $request->tags;
        $product->meta_title = $request->meta_title;
        $product->meta_keywords = $request->meta_keywords;
        $product->meta_description = $request->meta_description;
        $product->status = $request->status;
        $product->updated_at = Carbon::now();
        $product->save();

        Toastr::success('Package Product Updated Successfully!', 'Success');
        return back()->with('success', 'Package Product Updated Successfully');
    }

    /**
     * Remove a package product
     */
    public function destroy($id)
    {
        $product = Product::where('id', $id)->where('is_package', 1)->firstOrFail();

        // Delete package items
        PackageProductItem::where('package_product_id', $id)->delete();

        // Delete image
        if ($product->image && file_exists(public_path('productImages/' . $product->image))) {
            unlink(public_path('productImages/' . $product->image));
        }

        $product->delete();
        Toastr::success('Package Product Deleted Successfully!', 'Success');
        return response()->json(['success' => 'Package Product deleted successfully.']);
    }

    /**
     * Show package items management page
     */
    public function manageItems($id)
    {
        $package = Product::where('id', $id)->where('is_package', 1)->firstOrFail();
        $packageItems = PackageProductItem::where('package_product_id', $id)
            ->with(['product', 'color', 'size'])
            ->get();

        // Get available products (excluding packages)
        $products = Product::where('status', 1)->where('is_package', 0)->get();
        $colors = Color::get();
        $sizes = ProductSize::orderBy('serial', 'asc')->get();

        return view('backend.package_product.manage_items', compact(
            'package',
            'packageItems',
            'products',
            'colors',
            'sizes'
        ));
    }

    /**
     * Add item to package
     */
    public function addItem(Request $request, $packageId)
    {

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'required|exists:product_sizes,id',
        ]);

        // Check if item already exists
        $existingItem = PackageProductItem::where('package_product_id', $packageId)
            ->where('product_id', $request->product_id)
            ->where('color_id', $request->color_id)
            ->where('size_id', $request->size_id)
            ->first();

        if ($existingItem) {
            return back()->with('error', 'This product with same color and size already exists in package');
        }

        PackageProductItem::create([
            'package_product_id' => $packageId,
            'product_id' => $request->product_id,
            'color_id' => $request->color_id,
            'size_id' => $request->size_id,
            'quantity' => $request->quantity,
        ]);

        return back()->with('success', 'Item added to package successfully');
    }

    /**
     * Update package item
     */
    public function updateItem(Request $request, $packageId, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'color_id' => 'nullable|exists:colors,id',
            'size_id' => 'nullable|exists:product_sizes,id',
        ]);

        $item = PackageProductItem::findOrFail($itemId);
        $item->update([
            'quantity' => $request->quantity,
            'color_id' => $request->color_id,
            'size_id' => $request->size_id,
        ]);

        return back()->with('success', 'Package item updated successfully');
    }

    /**
     * Remove item from package
     */
    public function removeItem($packageId, $itemId)
    {
        $item = PackageProductItem::findOrFail($itemId);
        if ($item->product && $item->product->image && file_exists(public_path('productImages/' . $item->product->image))) {
            unlink(public_path('productImages/' . $item->product->image));
        }
        $item->delete();

        Toastr::success('Item removed from package Successfully!', 'Success');
        return response()->json(['success' => 'Item removed from package successfully.']);
    }

    /**
     * Get product variants for AJAX
     */
    public function getProductVariants($productId)
    {

        // First try to get variants from product_variants table
        $colors = DB::table('product_variants')
            ->leftJoin('colors', 'product_variants.color_id', 'colors.id')
            ->select('colors.*')
            ->where('product_variants.product_id', $productId)
            ->where('product_variants.stock', '>', 0)
            ->groupBy('product_variants.color_id')
            ->get();

        $sizes = DB::table('product_variants')
            ->leftJoin('product_sizes', 'product_variants.size_id', 'product_sizes.id')
            ->select('product_sizes.*')
            ->where('product_variants.product_id', $productId)
            ->where('product_variants.stock', '>', 0)
            ->whereNotNull('product_variants.size_id')
            ->groupBy('product_variants.size_id')
            ->get();

        return response()->json([
            'colors' => $colors,
            'sizes' => $sizes
        ]);
    }
}

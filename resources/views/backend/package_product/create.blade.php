@extends('backend.master')

@section('header_css')
    <link href="{{url('assets')}}/plugins/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
    <link href="{{url('assets')}}/plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{url('assets')}}/css/tagsinput.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <style>
        .select2-selection{
            height: 34px !important;
            border: 1px solid #ced4da !important;
        }
        .select2 {
            width: 100% !important;
        }
        .bootstrap-tagsinput .badge {
            margin: 2px 2px !important;
        }

        .product-card-title .card-title::before{
            top: 13px
        }
    </style>
@endsection

@section('page_title')
    Package Product
@endsection
@section('page_heading')
    Add New Package Product
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-body">

                    <form class="needs-validation" method="POST" action="{{url('package-products')}}" enctype="multipart/form-data">
                        @csrf

                        <div class="row border-bottom mb-4 pb-2">
                            <div class="col-lg-6 product-card-title">
                                <h4 class="card-title mb-3" style="font-size: 18px; padding-top: 12px;">Add New Package Product</h4>
                            </div>
                            <div class="col-lg-6 text-right">
                                <a href="{{ url('package-products') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Package Image</h5>
                                        <div class="form-group">
                                            <label for="image">Package Image <span class="text-danger">*</span></label>
                                            <input type="file" name="image" class="dropify" data-height="200" data-max-file-size="2M" accept="image/*"/>
                                            <div class="invalid-feedback" style="display: block;">
                                                @error('image')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Basic Information</h5>
                                        
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="name">Package Name <span class="text-danger">*</span></label>
                                                    <input type="text" id="name" name="name" maxlength="255" class="form-control" placeholder="Enter Package Product Name Here" value="{{ old('name') }}" >
                                                    <div class="invalid-feedback" style="display: block;">
                                                        @error('name')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="stock">Stock <span class="text-danger">*</span></label>
                                                    <input type="number" id="stock" name="stock" min="1" class="form-control" value="{{ old('stock') ?? 1}}">
                                                    <div class="invalid-feedback" style="display: block;">
                                                        @error('stock')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="low_stock">Low Stock <span class="text-danger">*</span></label>
                                                    <input type="number" id="low_stock" name="low_stock" min="1" class="form-control" value="{{ old('low_stock') ?? 1}}">
                                                    <div class="invalid-feedback" style="display: block;">
                                                        @error('low_stock')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="category_id">Category<span class="text-danger">*</span></label>
                                                    <select name="category_id" data-toggle="select2" class="form-control" id="category_id" >
                                                        @php
                                                            echo App\Models\Category::getDropDownList('name', old('category_id'));
                                                        @endphp
                                                    </select>
                                                    <div class="invalid-feedback" style="display: block;">
                                                        @error('category_id')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="subcategory_id">Subcategory</label>
                                                    <select name="subcategory_id" data-toggle="select2" class="form-control" id="subcategory_id">
                                                        <option value="">Select Subcategory</option>
                                                    </select>
                                                    <div class="invalid-feedback" style="display: block;">
                                                        @error('subcategory_id')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="childcategory_id">Child Category</label>
                                                    <select name="childcategory_id" data-toggle="select2" class="form-control" id="childcategory_id">
                                                        <option value="">Select Child Category</option>
                                                    </select>
                                                    <div class="invalid-feedback" style="display: block;">
                                                        @error('childcategory_id')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="brand_id">Brand</label>
                                                    <select name="brand_id" data-toggle="select2" class="form-control" id="brand_id">
                                                        @php
                                                            echo App\Models\Brand::getDropDownList('name', old('brand_id'));
                                                        @endphp
                                                    </select>
                                                    <div class="invalid-feedback" style="display: block;">
                                                        @error('brand_id')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="price">Package Price <span class="text-danger">*</span></label>
                                                    <input type="number" id="price" name="price" step="0.01" min="0" class="form-control" placeholder="0.00" value="{{ old('price') }}" >
                                                    <div class="invalid-feedback" style="display: block;">
                                                        @error('price')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="discount_price">Discount Price</label>
                                                    <input type="number" id="discount_price" name="discount_price" step="0.01" min="0" class="form-control" placeholder="0.00" value="{{ old('discount_price') }}">
                                                    <div class="invalid-feedback" style="display: block;">
                                                        @error('discount_price')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="unit_id">Unit</label>
                                                    <select name="unit_id" data-toggle="select2" class="form-control" id="unit_id">
                                                        @php
                                                            echo App\Models\Unit::getDropDownList('name', old('unit_id'));
                                                        @endphp
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="status">Status <span class="text-danger">*</span></label>
                                                    <select name="status" class="form-control" id="status" >
                                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title">Package Description</h5>
                                
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="short_description">Short Description</label>
                                            <textarea id="short_description" name="short_description" maxlength="1000" class="form-control" rows="3" placeholder="Write Package Short Description Here">{{ old('short_description') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea id="description" name="description" class="form-control" placeholder="Write Package Description Here">{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="tags">Tags</label>
                                            <input type="text" id="tags" name="tags" class="form-control" data-role="tagsinput" placeholder="Enter Tags" value="{{ old('tags') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title">Package Items <span class="text-danger">*</span></h5>
                                <p class="text-muted">Select products to include in this package</p>
                                
                                <div class="row mb-3">
                                    <div class="col-lg-8">
                                        <select id="product_select" class="form-control select2" style="width: 100%;">
                                            <option value="">Select a product to add...</option>
                                            @foreach(App\Models\Product::where('is_package', false)->where('status', 1)->get() as $product)
                                                <option value="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}">
                                                    {{ $product->name }} - ৳{{ number_format($product->price, 2) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <button type="button" id="add_product_btn" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Add Product
                                        </button>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="package_items_table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Product</th>
                                                <th>Color</th>
                                                <th>Size</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="package_items_tbody">
                                            <tr id="no_items_row">
                                                <td colspan="7" class="text-center text-muted">No products added to package yet</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="5" class="text-right">Package Total:</th>
                                                <th id="package_total">৳0.00</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> 
                                    <strong>Note:</strong> The package price above should be less than the total of individual items to provide value to customers.
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title">SEO Information</h5>
                                
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="meta_title">Meta Title</label>
                                            <input type="text" id="meta_title" name="meta_title" maxlength="255" class="form-control" placeholder="Enter Meta Title" value="{{ old('meta_title') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="meta_keywords">Meta Keywords</label>
                                            <input type="text" id="meta_keywords" name="meta_keywords" class="form-control" data-role="tagsinput" placeholder="Enter Meta Keywords" value="{{ old('meta_keywords') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="meta_description">Meta Description</label>
                                            <textarea id="meta_description" name="meta_description" maxlength="500" class="form-control" rows="3" placeholder="Enter Meta Description">{{ old('meta_description') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center pt-3">
                            <a href="{{url('package-products')}}" style="width: 130px;" class="btn btn-danger d-inline-block text-white m-2" type="submit"><i class="mdi mdi-cancel"></i> Cancel</a>
                            <button class="btn btn-primary m-2" style="width: 180px;" type="submit"><i class="fas fa-save"></i> Save Package</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_js')
    <script src="{{url('assets')}}/plugins/dropify/dropify.min.js"></script>
    <script src="{{url('assets')}}/pages/fileuploads-demo.js"></script>
    <script src="{{url('assets')}}/plugins/select2/select2.min.js"></script>
    <script src="{{url('assets')}}/js/tagsinput.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('[data-toggle="select2"]').select2();

        $('#description').summernote({
            placeholder: 'Write Package Description Here',
            tabsize: 2,
            height: 300
        });

        // Category wise subcategory
        $(document).ready(function () {
            $('#category_id').on('change', function () {
                var categoryId = this.value;
                $("#subcategory_id").html('');
                $("#childcategory_id").html('');
                $.ajax({
                    url: "{{url('/category/wise/subcategory')}}",
                    type: "POST",
                    data: {
                        category_id: categoryId,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#subcategory_id').html('<option value="">Select Subcategory</option>');
                        $('#childcategory_id').html('<option value="">Select Child Category</option>');
                        $.each(result, function (key, value) {
                            $("#subcategory_id").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });

        // Subcategory wise child category
        $(document).ready(function () {
            $('#subcategory_id').on('change', function () {
                var subCategoryId = this.value;
                $("#childcategory_id").html('');
                $.ajax({
                    url: "{{url('/subcategory/wise/childcategory')}}",
                    type: "POST",
                    data: {
                        subcategory_id: subCategoryId,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#childcategory_id').html('<option value="">Select Child Category</option>');
                        $.each(result, function (key, value) {
                            $("#childcategory_id").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });

        // Package Items Management
        let packageItems = [];
        let itemCounter = 0;

        // Initialize Select2 for product selection
        $('#product_select').select2({
            placeholder: 'Search and select a product...',
            allowClear: true
        });

        // Add product to package
        $('#add_product_btn').on('click', function() {
            const productSelect = $('#product_select');
            const selectedProductId = productSelect.val();
            const selectedOption = productSelect.find('option:selected');

            if (!selectedProductId) {
                alert('Please select a product first.');
                return;
            }

            // Check if product already exists
            if (packageItems.find(item => item.product_id == selectedProductId)) {
                alert('This product is already added to the package.');
                return;
            }

            const productData = {
                product_id: selectedProductId,
                name: selectedOption.data('name'),
                price: parseFloat(selectedOption.data('price')),
                quantity: 1,
                color_id: '',
                size_id: ''
            };

            // Get product variants
            getProductVariants(selectedProductId, productData);
        });

        // Get product variants (colors and sizes)
        function getProductVariants(productId, productData) {
            console.log('Getting variants for product ID:', productId);
            $.ajax({
                url: "{{ url('get-product-variants') }}/" + productId,
                type: "GET",
                success: function(response) {
                    console.log('Variants response:', response);
                    addItemToTable(productData, response.colors, response.sizes);
                    $('#product_select').val('').trigger('change');
                },
                error: function(xhr, status, error) {
                    console.log('Error getting variants:', error);
                    console.log('Response:', xhr.responseText);
                    // If no variants, add with empty options
                    addItemToTable(productData, [], []);
                    $('#product_select').val('').trigger('change');
                }
            });
        }

        // Add item to table
        function addItemToTable(productData, colors, sizes) {
            itemCounter++;
            const itemId = 'item_' + itemCounter;
            
            // Build color options
            let colorOptions = '<option value="">No Color</option>';
            colors.forEach(color => {
                colorOptions += `<option value="${color.id}">${color.name}</option>`;
            });
            
            // Build size options
            let sizeOptions = '<option value="">No Size</option>';
            sizes.forEach(size => {
                sizeOptions += `<option value="${size.id}">${size.name}</option>`;
            });

            const row = `
                <tr id="${itemId}">
                    <td>
                        ${productData.name}
                        <input type="hidden" name="package_items[${itemCounter}][product_id]" value="${productData.product_id}">
                    </td>
                    <td>
                        <select name="package_items[${itemCounter}][color_id]" class="form-control">
                            ${colorOptions}
                        </select>
                    </td>
                    <td>
                        <select name="package_items[${itemCounter}][size_id]" class="form-control">
                            ${sizeOptions}
                        </select>
                    </td>
                    <td>
                        <input type="number" name="package_items[${itemCounter}][quantity]" 
                               class="form-control quantity-input" min="1" value="1" data-price="${productData.price}">
                    </td>
                    <td>৳${productData.price.toFixed(2)}</td>
                    <td class="item-total">৳${productData.price.toFixed(2)}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-item" data-item-id="${itemId}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;

            // Remove "no items" row if it exists
            $('#no_items_row').remove();
            
            // Add the new row
            $('#package_items_tbody').append(row);
            
            // Add to items array
            packageItems.push({
                id: itemId,
                product_id: productData.product_id,
                price: productData.price,
                quantity: 1
            });

            updatePackageTotal();
        }

        // Remove item from package
        $(document).on('click', '.remove-item', function() {
            const itemId = $(this).data('item-id');
            
            // Remove from array
            packageItems = packageItems.filter(item => item.id !== itemId);
            
            // Remove row
            $('#' + itemId).remove();
            
            // Show "no items" row if table is empty
            if (packageItems.length === 0) {
                $('#package_items_tbody').append(`
                    <tr id="no_items_row">
                        <td colspan="7" class="text-center text-muted">No products added to package yet</td>
                    </tr>
                `);
            }
            
            updatePackageTotal();
        });

        // Update quantity and totals
        $(document).on('input', '.quantity-input', function() {
            const quantity = parseInt($(this).val()) || 1;
            const price = parseFloat($(this).data('price'));
            const total = quantity * price;
            
            // Update item total
            $(this).closest('tr').find('.item-total').text('৳' + total.toFixed(2));
            
            // Update package items array
            const row = $(this).closest('tr');
            const itemId = row.attr('id');
            const item = packageItems.find(item => item.id === itemId);
            if (item) {
                item.quantity = quantity;
            }
            
            updatePackageTotal();
        });

        // Update package total
        function updatePackageTotal() {
            let total = 0;
            packageItems.forEach(item => {
                total += item.price * item.quantity;
            });
            $('#package_total').text('৳' + total.toFixed(2));
        }

        // Form validation
        $('form').on('submit', function(e) {
            if (packageItems.length === 0) {
                e.preventDefault();
                alert('Please add at least one product to the package.');
                return false;
            }
        });
    </script>
@endsection

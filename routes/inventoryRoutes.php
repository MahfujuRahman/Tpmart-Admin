<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Outlet\SupplierSourceController;
use App\Http\Controllers\Inventory\ProductSupplierController;
use App\Http\Controllers\Inventory\ProductWarehouseController;
use App\Http\Controllers\Inventory\Models\ProductWarehouseRoom;
use App\Http\Controllers\Inventory\ProductPurchaseOrderController;
use App\Http\Controllers\Inventory\ProductWarehouseRoomController;
use App\Http\Controllers\Inventory\ProductPurchaseChargeController;
use App\Http\Controllers\Inventory\ProductPurchaseQuotationController;
use App\Http\Controllers\Inventory\ProductWarehouseRoomCartoonController;

Route::group(['middleware' => ['auth', 'CheckUserType', 'DemoMode']], function () {

    // product warehouse routes
    Route::get('/add/new/product-warehouse', [ProductWarehouseController::class, 'addNewProductWarehouse'])->name('AddNewProductWarehouse');
    //  Route::post('/subcategory/wise/childcategory', [ProductController::class, 'childcategorySubcategoryWise'])->name('ChildcategorySubcategoryWise');
    Route::post('/save/new/product-warehouse', [ProductWarehouseController::class, 'saveNewProductWarehouse'])->name('SaveNewProductWarehouse');
    Route::get('/view/all/product-warehouse', [ProductWarehouseController::class, 'viewAllProductWarehouse'])->name('ViewAllProductWarehouse');
    Route::get('/delete/product-warehouse/{slug}', [ProductWarehouseController::class, 'deleteProductWarehouse'])->name('DeleteProductWarehouse');
    Route::get('/edit/product-warehouse/{slug}', [ProductWarehouseController::class, 'editProductWarehouse'])->name('EditProductWarehouse');
    Route::post('/update/product-warehouse', [ProductWarehouseController::class, 'updateProductWarehouse'])->name('UpdateProductWarehouse');
    //  Route::post('/add/another/variant', [ProductController::class, 'addAnotherVariant'])->name('AddAnotherVariant');
    //  Route::get('/delete/product/variant/{id}', [ProductController::class, 'deleteProductVariant'])->name('DeleteProductVariant');
    //  Route::get('/products/from/excel', [ProductController::class, 'productsFromExcel'])->name('ProductsFromExcel');
    //  Route::post('/upload/product/from/excel', [ProductController::class, 'uploadProductsFromExcel'])->name('UploadProductsFromExcel');


     // product warehouse rooms routes
     Route::get('/add/new/product-warehouse-room', [ProductWarehouseRoomController::class, 'addNewProductWarehouseRoom'])->name('AddNewProductWarehouseRoom');
     //  Route::post('/subcategory/wise/childcategory', [ProductController::class, 'childcategorySubcategoryWise'])->name('ChildcategorySubcategoryWise');
     Route::post('/save/new/product-warehouse-room', [ProductWarehouseRoomController::class, 'saveNewProductWarehouseRoom'])->name('SaveNewProductWarehouseRoom');
     Route::get('/view/all/product-warehouse-room', [ProductWarehouseRoomController::class, 'viewAllProductWarehouseRoom'])->name('ViewAllProductWarehouseRoom');
     Route::get('/delete/product-warehouse-room/{slug}', [ProductWarehouseRoomController::class, 'deleteProductWarehouseRoom'])->name('DeleteProductWarehouseRoom');
     Route::get('/edit/product-warehouse-room/{slug}', [ProductWarehouseRoomController::class, 'editProductWarehouseRoom'])->name('EditProductWarehouseRoom');
     Route::post('/update/product-warehouse-room', [ProductWarehouseRoomController::class, 'updateProductWarehouseRoom'])->name('UpdateProductWarehouseRoom');
     Route::post('/get-product-warehouse-rooms', [ProductWarehouseRoomController::class, 'getProductWarehouseRooms'])->name('get.product.warehouse.rooms');
     Route::get('/get-warehouse-rooms/{warehouseId}', function ($warehouseId) {
        $rooms = ProductWarehouseRoom::where('product_warehouse_id', $warehouseId)->get();
        return response()->json(['rooms' => $rooms]);
    });
    

     // product warehouse room cartoon routes
     Route::get('/add/new/product-warehouse-room-cartoon', [ProductWarehouseRoomCartoonController::class, 'addNewProductWarehouseRoomCartoon'])->name('AddNewProductWarehouseRoomCartoon');
     //  Route::post('/subcategory/wise/childcategory', [ProductController::class, 'childcategorySubcategoryWise'])->name('ChildcategorySubcategoryWise');
     Route::post('/save/new/product-warehouse-room-cartoon', [ProductWarehouseRoomCartoonController::class, 'saveNewProductWarehouseRoomCartoon'])->name('SaveNewProductWarehouseRoomCartoon');
     Route::get('/view/all/product-warehouse-room-cartoon', [ProductWarehouseRoomCartoonController::class, 'viewAllProductWarehouseRoomCartoon'])->name('ViewAllProductWarehouseRoomCartoon');
     Route::get('/delete/product-warehouse-room-cartoon/{slug}', [ProductWarehouseRoomCartoonController::class, 'deleteProductWarehouseRoomCartoon'])->name('DeleteProductWarehouseRoom');
     Route::get('/edit/product-warehouse-room-cartoon/{slug}', [ProductWarehouseRoomCartoonController::class, 'editProductWarehouseRoomCartoon'])->name('EditProductWarehouseRoomCartoon');
     Route::post('/update/product-warehouse-room-cartoon', [ProductWarehouseRoomCartoonController::class, 'updateProductWarehouseRoomCartoon'])->name('UpdateProductWarehouseRoomCartoon');
     Route::post('/get-product-warehouse-room-cartoons', [ProductWarehouseRoomCartoonController::class, 'getProductWarehouseRoomCartoon'])->name('get.product.warehouse.room.cartoon');

    // product supplier routes
    Route::get('/add/new/product-supplier', [ProductSupplierController::class, 'addNewProductSupplier'])->name('AddNewProductSupplier');    
    Route::post('/save/new/product-supplier', [ProductSupplierController::class, 'saveNewProductSupplier'])->name('SaveNewProductSupplier');
    Route::get('/view/all/product-supplier', [ProductSupplierController::class, 'viewAllProductSupplier'])->name('ViewAllProductSupplier');
    Route::get('/delete/product-supplier/{slug}', [ProductSupplierController::class, 'deleteProductSupplier'])->name('DeleteProductSupplier');
    Route::get('/edit/product-supplier/{slug}', [ProductSupplierController::class, 'editProductSupplier'])->name('EditProductSupplier');
    Route::post('/update/product-supplier', [ProductSupplierController::class, 'updateProductSupplier'])->name('UpdateProductSupplier');

     // Supplier Source Type 
    Route::get('/add/new/supplier-source', [SupplierSourceController::class, 'addNewSupplierSource'])->name('AddNewSupplierSource');    
    Route::post('/save/new/supplier-source', [SupplierSourceController::class, 'saveNewSupplierSource'])->name('SaveNewSupplierSource');
    Route::get('/view/all/supplier-source', [SupplierSourceController::class, 'viewAllSupplierSource'])->name('ViewAllSupplierSource');
    Route::get('/delete/supplier-source/{slug}', [SupplierSourceController::class, 'deleteSupplierSource'])->name('DeleteSupplierSource');
    Route::get('/edit/supplier-source/{slug}', [SupplierSourceController::class, 'editSupplierSource'])->name('EditSupplierSource');      
    Route::post('/update/supplier-source', [SupplierSourceController::class, 'updateSupplierSource'])->name('UpdateSupplierSource');


    Route::get('/get-warehouse-rooms', [ProductWarehouseController::class, 'getWarehouseRooms']);
    Route::get('/get-warehouse-room-cartoons', [ProductWarehouseController::class, 'getWarehouseRoomCartoons']);

    // Route::get('get-rooms/{warehouseId}', [WarehouseController::class, 'getRooms'])->name('get.rooms');
    // Route::get('get-cartoons/{roomId}', [WarehouseController::class, 'getCartoons'])->name('get.cartoons');

    Route::get('/api/get-rooms/{warehouseId}', [ProductWarehouseController::class, 'apiGetetWarehouseRooms']);
    Route::get('/api/get-cartoons/{warehouseId}/{roomId}', [ProductWarehouseController::class, 'apiGetetWarehouseRoomCartoons']);


    // purchase product quotation routes
    Route::get('/add/new/purchase-product/quotation', [ProductPurchaseQuotationController::class, 'addNewPurchaseProductQuotation'])->name('AddNewPurchaseProductQuotation');    
    Route::post('/save/new/purchase-product/quotation', [ProductPurchaseQuotationController::class, 'saveNewPurchaseProductQuotation'])->name('SaveNewPurchaseProductQuotation');
    Route::get('/view/all/purchase-product/quotation', [ProductPurchaseQuotationController::class, 'viewAllPurchaseProductQuotation'])->name('ViewAllPurchaseProductQuotation');
    Route::get('/delete/purchase-product/quotation/{slug}', [ProductPurchaseQuotationController::class, 'deletePurchaseProductQuotation'])->name('DeletePurchaseProductQuotation');
    Route::get('/edit/purchase-product/quotation/{slug}', [ProductPurchaseQuotationController::class, 'editPurchaseProductQuotation'])->name('EditPurchaseProductQuotation');
    Route::get('/edit/purchase-product/sales/quotation/{slug}', [ProductPurchaseQuotationController::class, 'editPurchaseProductSalesQuotation'])->name('EditPurchaseProductSalesQuotation');
    Route::get('api/edit/purchase-product/quotation/{slug}', [ProductPurchaseQuotationController::class, 'apiEditPurchaseProduct'])->name('ApiEditPurchaseProductQuotation');
    Route::post('/update/purchase-product/quotation', [ProductPurchaseQuotationController::class, 'updatePurchaseProductQuotation'])->name('UpdatePurchaseProductQuotation');
    Route::post('/update/purchase-product/sales/quotation', [ProductPurchaseQuotationController::class, 'updatePurchaseProductSalesQuotation'])->name('UpdatePurchaseProductSalesQuotation');

    Route::get('/api/products/search', [ProductPurchaseQuotationController::class, 'searchProduct'])->name('SearchProduct');    

    // purchase product order routes
    Route::get('/add/new/purchase-product/order', [ProductPurchaseOrderController::class, 'addNewPurchaseProductOrder'])->name('AddNewPurchaseProductOrder');    
    Route::post('/save/new/purchase-product/order', [ProductPurchaseOrderController::class, 'saveNewPurchaseProductOrder'])->name('SaveNewPurchaseProductOrder');http://127.0.0.1:8000/view/all/customers
    Route::get('/view/all/purchase-product/order', [ProductPurchaseOrderController::class, 'viewAllPurchaseProductOrder'])->name('ViewAllPurchaseProductOrder');
    Route::get('/delete/purchase-product/order/{slug}', [ProductPurchaseOrderController::class, 'deletePurchaseProductOrder'])->name('DeletePurchaseProductOrder');
    Route::get('/edit/purchase-product/order/{slug}', [ProductPurchaseOrderController::class, 'editPurchaseProductOrder'])->name('EditPurchaseProductOrder');
    Route::get('/edit/purchase-product/order/confirm/{slug}', [ProductPurchaseOrderController::class, 'editPurchaseProductOrderConfirm'])->name('EditPurchaseProductOrderConfirm');
    Route::get('api/edit/purchase-product/order/{slug}', [ProductPurchaseOrderController::class, 'apiEditPurchaseProduct'])->name('ApiEditPurchaseProductOrder');
    Route::post('/update/purchase-product/order', [ProductPurchaseOrderController::class, 'updatePurchaseProductOrder'])->name('UpdatePurchaseProductOrder');
    

    // purchase product other charge
    Route::get('/add/new/purchase-product/charge', [ProductPurchaseChargeController::class, 'addNewPurchaseProductCharge'])->name('AddNewPurchaseProductCharge');    
    Route::post('/save/new/purchase-product/charge', [ProductPurchaseChargeController::class, 'saveNewPurchaseProductCharge'])->name('SaveNewPurchaseProductCharge');
    Route::get('/view/all/purchase-product/charge', [ProductPurchaseChargeController::class, 'viewAllPurchaseProductCharge'])->name('ViewAllPurchaseProductCharge');
    Route::get('/delete/purchase-product/charge/{slug}', [ProductPurchaseChargeController::class, 'deletePurchaseProductCharge'])->name('DeletePurchaseProductCharge');
    Route::get('/edit/purchase-product/charge/{slug}', [ProductPurchaseChargeController::class, 'editPurchaseProductCharge'])->name('EditPurchaseProductCharge');      
    Route::post('/update/purchase-product/charge', [ProductPurchaseChargeController::class, 'updatePurchaseProductCharge'])->name('UpdatePurchaseProductCharge');

    // Customer 
    Route::get('/add/new/customers', [CustomerController::class, 'addNewCustomer'])->name('AddNewCustomers');    
    Route::post('/save/new/customers', [CustomerController::class, 'saveNewCustomer'])->name('SaveNewCustomers');
    Route::get('/view/all/customer', [CustomerController::class, 'viewAllCustomer'])->name('ViewAllCustomer');
    Route::get('/delete/customers/{slug}', [CustomerController::class, 'deleteCustomer'])->name('DeleteCustomers');
    Route::get('/edit/customers/{slug}', [CustomerController::class, 'editCustomer'])->name('EditCustomers');      
    Route::post('/update/customers', [CustomerController::class, 'updateCustomer'])->name('UpdateCustomers');

});
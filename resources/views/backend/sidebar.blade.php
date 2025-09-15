<!-- Left Menu Start -->
<div style="padding: 10px;">
    <input type="text" id="menuSearch" placeholder="Search menu..."
        style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
</div>

<ul class="metismenu list-unstyled" id="side-menu">
    <li>
        <a href="{{ url('/home') }}" data-active-paths="{{ url('/home') }}">
            <i class="feather-home"></i>
            <span> Ecommerce Dashboard</span>
        </a>
    </li>
    <li>
        <a href="{{ url('/crm-home') }}" data-active-paths="{{ url('/crm-home') }}">
            <i class="feather-home"></i>
            <span> CRM Dashboard</span>
        </a>
    </li>
    <li>
        <a href="{{ url('/accounts-home') }}" data-active-paths="{{ url('/accounts-home') }}">
            <i class="feather-home"></i>
            <span> Accounts Dashboard</span>
        </a>
    </li>
    <li>
        <a href="{{ url('/inventory-home') }}" data-active-paths="{{ url('/inventory-home') }}">
            <i class="feather-home"></i>
            <span> Inventory Dashboard</span>
        </a>
    </li>
    <li>
        <a href="{{ url('/create/new/order') }}" data-active-paths="{{ url('/create/new/order') }}">
            <i class="feather-home"></i>
            <span> Pos System</span>
        </a>
    </li>

    {{-- Start E-commerce Module --}}
    <hr style="border-color: #c8c8c836; margin-top: 12px; margin-bottom: 12px;">
    <li class="menu-title" style="color: khaki; text-shadow: 1px 1px 2px black;">E-commerce Modules</li>
    <li>
        <a href="javascript: void(0);" class="has-arrow">
            <i class="feather-settings"></i>
            <span>Config</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ url('/config/setup') }}" data-active-paths="{{ url('/config/setup') }}">Setup Your
                    Config</a>
            </li>

            {{-- tech industry --}}
            {{-- @if (DB::table('config_setups')->where('code', 'storage')->first())
            <li><a href="{{ url('/view/all/storages') }}">Storage</a></li>
            @endif
            @if (DB::table('config_setups')->where('code', 'sim')->first())
            <li><a href="{{ url('/view/all/sims') }}">SIM Type</a></li>
            @endif
            @if (DB::table('config_setups')->where('code', 'device_condition')->first())
            <li><a href="{{ url('/view/all/device/conditions') }}">Device Condition</a></li>
            @endif --}}

            {{-- <li>
                <a href="javascript: void(0);" class="has-arrow"><i class="fas fa-sms"></i><span>SMS Service</span></a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{ url('/view/sms/templates') }}">SMS Templates</a></li>
                    <li><a href="{{ url('/send/sms/page') }}">Send SMS</a></li>
                    <li><a href="{{ url('/view/sms/history') }}">SMS History</a></li>
                </ul>
            </li> --}}

            <li>
                <a href="{{ url('/view/email/credential') }}" data-active-paths="{{ url('/view/email/credential') }}">
                    Email Configure (SMTP)
                </a>
            </li>
            {{-- <li><a href="{{ url('/view/email/templates') }}">Email Templates</a></li> --}}
            {{-- <li><a href="{{ url('/setup/sms/gateways') }}">SMS Gateway</a></li> --}}
            <li><a href="{{ url('/setup/payment/gateways') }}"
                    data-active-paths="{{ url('/setup/payment/gateways') }}">
                    Payment Gateway
                </a>
            </li>

        </ul>
    </li>
    <li>
        <a href="javascript: void(0);" class="has-arrow"><i class="feather-settings"></i><span>Product
                Attributes</span></a>
        <ul class="sub-menu" aria-expanded="false">

            {{-- Fshion Insdustry --}}
            @if (DB::table('config_setups')->where('code', 'product_size')->first())
                <li>
                    <a href="{{ url('/view/all/sizes') }}"
                        data-active-paths="{{ url('/view/all/sizes') }},{{ url('/rearrange/size') }}">
                        Product Sizes
                    </a>
                </li>
            @endif

            {{-- common --}}
            @if (DB::table('config_setups')->where('code', 'color')->first())
                <li>
                    <a href="{{ url('/view/all/colors') }}" data-active-paths="{{ url('/view/all/colors') }}">
                        Product Colors
                    </a>
                </li>
            @endif

            @if (DB::table('config_setups')->where('code', 'measurement_unit')->first())
                <li>
                    <a href="{{ url('/view/all/units') }}" data-active-paths="{{ url('/view/all/units') }}">
                        Measurement Units
                    </a>
                </li>
            @endif

            <li>
                <a href="{{ url('/view/all/brands') }}"
                    data-active-paths="{{ url('/view/all/brands') }},{{ url('/add/new/brand') }},{{ url('/rearrange/brands') }},{{ url('edit/brand/*') }}">
                    Product Brands
                </a>
            </li>
            <li>
                <a href="{{ url('/view/all/models') }}"
                    data-active-paths="{{ url('/view/all/models') }}, {{ url('add/new/model') }},{{ url('edit/model/*') }}">
                    Models of Brand
                </a>
            </li>
            <li>
                <a href="{{ url('/view/all/flags') }}" data-active-paths="{{ url('/view/all/flags') }}">
                    Product Flags
                </a>
            </li>
        </ul>
    </li>

    <li>
        <a href="{{ url('/view/all/category') }}"
            data-active-paths="{{ url('/view/all/category') }},{{ url('/add/new/category') }},{{ url('/edit/category/*') }},{{ url('/rearrange/category') }}">
            <i class="feather-sliders"></i>
            <span>Category</span>
            <span style="color:lightgreen" title="Total Products">
                ({{ DB::table('categories')->count() }})
            </span>
        </a>
    </li>

    <li>
        <a href="{{ url('/view/all/subcategory') }}"
            data-active-paths="{{ url('/view/all/subcategory') }},{{ url('/add/new/subcategory') }},{{ url('/edit/subcategory/*') }},{{ url('/rearrange/subcategory') }}">
            <i class="feather-command"></i>
            <span>Subcategory</span>
            <span style="color:lightgreen" title="Total Products">
                ({{ DB::table('subcategories')->count() }})
            </span>
        </a>
        {{-- <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{ url('/add/new/subcategory') }}">Add New Subcategory</a></li>
            <li><a href="{{ url('/view/all/subcategory') }}">View All Subcategories</a></li>
        </ul> --}}
    </li>
    <li>
        <a href="{{ url('/view/all/childcategory') }}"
            data-active-paths="{{ url('/view/all/childcategory') }},{{ url('/add/new/childcategory') }},{{ url('/edit/childcategory/*') }},{{ url('/rearrange/childcategory') }}">
            <i class="feather-git-pull-request"></i><span>Child Category</span>
            <span style="color:lightgreen" title="Total Products">
                ({{ DB::table('child_categories')->count() }})
            </span>

        </a>
    </li>
    <li>
        <a href="javascript: void(0);" class="has-arrow">
            <i class="feather-box"></i>
            <span>Manage Products</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            {{-- <li>
                <a href="{{ url('view/all/product-color') }}">
                    View All Products Color
                    <span style="color:lightgreen" title="Total Products">
                        ({{DB::table('colors')->count()}})
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ url('view/all/product-size') }}">
                    View All Attribute
                    <span style="color:lightgreen" title="Total Products">
                        ({{DB::table('colors')->count()}})
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ url('view/all/product-size-value') }}">
                    View All Attribute Value
                    <span style="color:lightgreen" title="Total Products">
                        ({{DB::table('product_sizes')->count()}})
                    </span>
                </a>
            </li> --}}
            <li>
                <a href="{{ url('/view/all/product') }}"
                    data-active-paths="{{ url('/view/all/product') }},{{ url('/add/new/product') }},{{ url('/edit/product/*') }},{{ url('/rearrange/product') }}">
                    View All Products
                    <span style="color:lightgreen" title="Total Products">
                        ({{ DB::table('products')->where('is_package', false)->count() }})
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ url('/view/product/reviews') }}" data-active-paths="{{ url('/view/product/reviews') }}">
                    Products's Review
                    <span style="color:goldenrod" title="Indicate Pending Review">
                        (@php
                            echo DB::table('product_reviews')->where('status', 0)->count();
                        @endphp)
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ url('/view/product/question/answer') }}"
                    data-active-paths="{{ url('/view/product/question/answer') }}">
                    Product Ques/Ans
                    <span style="color:goldenrod" title="Indicate Unanswered Questions">
                        (@php
                            echo DB::table('product_question_answers')
                                ->whereNull('answer')
                                ->orWhere('answer', '=', '')
                                ->count();
                        @endphp)
                    </span>
                </a>
            </li>
        </ul>
    </li>

      <li>
        <a href="{{ url('/package-products') }}"
            data-active-paths="{{ url('/package-products') }}, {{ url('/package-products/create') }}, {{ url('/package-products/*/edit') }}, {{ url('/package-products/*/manage-items') }}">
            <i class="feather-package"></i> Package Products
            <span style="color:lightgreen" title="Total Package Products">
                ({{ DB::table('products')->where('is_package', true)->count() }})
            </span>
        </a>
    </li>


    <li>
        <a href="javascript: void(0);" class="has-arrow">
            <i class="feather-shopping-cart"></i>
            <span>Manage Orders</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a style="color: white !important;" href="{{ url('/view/orders') }}"
                    data-active-paths="{{ url('/view/orders') }}, {{ url('create/new/order') }},{{ url('order/details/*') }}">
                    All Orders
                    (@php echo DB::table('orders')->count(); @endphp)
                </a>
            </li>
            <li>
                <a style="color: wheat !important;" href="{{ url('/view/pending/orders') }}"
                    data-active-paths="{{ url('/view/pending/orders') }}, {{ url('order/edit/*') }}">
                    Pending Orders
                    (@php
                        echo DB::table('orders')->where('order_status', 0)->count();
                    @endphp)
                </a>
            </li>
            <li>
                <a style="color: skyblue !important;" href="{{ url('/view/approved/orders') }}"
                    data-active-paths="{{ url('/view/approved/orders') }}">
                    Approved Orders
                    (@php
                        echo DB::table('orders')->where('order_status', 1)->count();
                    @endphp)
                </a>
            </li>
            <li>
                <a style="color: wheat !important;" href="{{ url('/view/dispatch/orders') }}"
                    data-active-paths="{{ url('/view/dispatch/orders') }}">
                    Dispatch Orders
                    (@php
                        echo DB::table('orders')->where('order_status', 2)->count();
                    @endphp)
                </a>
            </li>
            <li>
                <a style="color: violet !important;" href="{{ url('/view/intransit/orders') }}"
                    data-active-paths="{{ url('/view/intransit/orders') }}">
                    Intransit Orders
                    (@php
                        echo DB::table('orders')->where('order_status', 3)->count();
                    @endphp)
                </a>
            </li>
            <li>
                <a style="color: #0c0 !important;" href="{{ url('/view/delivered/orders') }}"
                    data-active-paths="{{ url('/view/delivered/orders') }}">
                    Delivered Orders
                    (@php
                        echo DB::table('orders')->where('order_status', 4)->count();
                    @endphp)
                </a>
            </li>
            <li>
                <a style="color: tomato !important;" href="{{ url('/view/picked/orders') }}"
                    data-active-paths="{{ url('/view/picked/orders') }}">
                    Return Orders
                    (@php
                        echo DB::table('orders')->where('order_status', 5)->count();
                    @endphp)
                </a>
            </li>
            <li>
                <a style="color: red !important;" href="{{ url('/view/cancelled/orders') }}"
                    data-active-paths="{{ url('/view/cancelled/orders') }}">
                    Cancelled Orders
                    (@php
                        echo DB::table('orders')->where('order_status', 6)->count();
                    @endphp)
                </a>
            </li>
            <li>
                <a style="color: red !important;" href="{{ url('view/trash/orders') }}"
                    data-active-paths="{{ url('view/trash/orders') }}">
                    Trashed Orders
                    (@php
                        echo DB::table('orders')->where('deleted_at', '!=', null)->count();
                    @endphp)
                </a>
            </li>
        </ul>
    </li>
    {{-- <li>
        <a href="javascript: void(0);" class="has-arrow"><i class="feather-box"></i><span>Old Purchase
                Product</span></a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{ url('/add/new/product-purchase/quotation') }}">Add Quotation</a></li>
            <li>
                <a href="{{ url('/view/all/product-purchase/quotation') }}">
                    All Quotations
                    <span style="color:lightgreen" title="Total Product Quotations">
                        ({{DB::table('product_purchase_quotations')->count()}})
                    </span>
                </a>
            </li>
            <li><a href="{{ url('/add/new/product-purchase/order') }}">Add Order</a></li>
            <li>
                <a href="{{ url('/view/all/product-purchase/order') }}">
                    All Orders
                    <span style="color:lightgreen" title="Total Product Orders">
                        ({{DB::table('product_purchase_orders')->count()}})
                    </span>
                </a>
            </li>
        </ul>
    </li> --}}

    <li>
        <a href="{{ route('ViewAllInvoices') }}" data-active-paths="{{ route('ViewAllInvoices') }}">
            <i class="feather-file-text"></i>
            <span>Pos Invoices</span>
            <span style="color:lightgreen" title="Total Invoices">
                (@php echo DB::table('orders')->where('order_from', 3)->where('invoice_generated', 1)->count(); @endphp)
            </span>
        </a>

    </li>
    <li>
        <a href="{{ url('/view/all/promo/codes') }}"
            data-active-paths="{{ url('/view/all/promo/codes') }},{{ url('/add/new/code') }},{{ url('/edit/promo/code/*') }}">
            <i class="feather-gift"></i>
            <span>Promo Codes</span>
            <span style="color:lightgreen" title="Total Products">
                ({{ DB::table('promo_codes')->count() }})
            </span>
        </a>
    </li>

    {{-- <li><a href="{{ url('/file-manager') }}"><i class="fas fa-folder-open"></i><span>File Manager</span></a></li>
    --}}

    <li>
        <a href="javascript: void(0);" class="has-arrow">
            <i class="feather-bell"></i>
            <span>Push Notification</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ url('/send/notification/page') }}"
                    data-active-paths="{{ url('/send/notification/page') }}">
                    Send Notification
                </a>
            </li>
            <li>
                <a href="{{ url('/view/all/notifications') }}"
                    data-active-paths="{{ url('/view/all/notifications') }}">
                    Prevoious Notifications
                </a>
            </li>
        </ul>
    </li>

    <li>
        <a href="{{ url('/view/customers/wishlist') }}" data-active-paths="{{ url('/view/customers/wishlist') }}">
            <i class="feather-heart"></i>
            <span>Customer's Wishlist</span>
        </a>
    </li>
    <li>
        <a href="{{ url('/view/delivery/charges') }}" data-active-paths="{{ url('/view/delivery/charges') }}">
            <i class="feather-truck"></i>
            <span>Delivery Charges</span>
        </a>
    </li>
    <li>
        <a href="{{ url('/view/upazila/thana') }}" data-active-paths="{{ url('/view/upazila/thana') }}">
            <i class="dripicons-location"></i>
            <span>Upazila & Thana</span>
        </a>
    </li>
    <li><a href="{{ url('/view/payment/history') }}" data-active-paths="{{ url('/view/payment/history') }}">
            <i class="feather-dollar-sign"></i>
            <span>Payment History</span>
        </a>
    </li>

    <li>
        <a href="javascript: void(0);" class="has-arrow"><i class="feather-printer"></i><span>Generate
                Report</span></a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ url('/sales/report') }}" data-active-paths="{{ url('/sales/report') }}">Sales
                    Report</a>
            </li>
        </ul>
    </li>
    {{-- End E-commerce Module --}}


    {{-- Start Inventory Module --}}
    <hr style="border-color: #c8c8c836; margin-top: 12px; margin-bottom: 12px;">
    <li class="menu-title" style="color: khaki; text-shadow: 1px 1px 2px black;">Inventory Modules</li>
    <li>
        <a href="{{ url('/view/all/product-warehouse') }}"
            data-active-paths="{{ url('/view/all/product-warehouse') }}, {{ url('/add/new/product-warehouse') }}, {{ url('/edit/product-warehouse/*') }}">
            <i class="feather-box"></i>
            <span>Product Warehouse</span>
            <span style="color:lightgreen" title="Total Product Warehouses">
                ({{ DB::table('product_warehouses')->count() }})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ url('/view/all/product-warehouse-room') }}"
            data-active-paths="{{ url('/view/all/product-warehouse-room') }}, {{ url('/add/new/product-warehouse-room') }}, {{ url('/edit/product-warehouse-room/*') }}">
            <i class="feather-box"></i>Warehouse Room
            <span style="color:lightgreen" title="Total Product Warehouse Rooms">
                ({{ DB::table('product_warehouse_rooms')->count() }})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ url('/view/all/product-warehouse-room-cartoon') }}"
            data-active-paths="{{ url('/view/all/product-warehouse-room-cartoon') }}, {{ url('/add/new/product-warehouse-room-cartoon') }}, {{ url('/edit/product-warehouse-room-cartoon/*') }}">
            <i class="feather-box"></i> Room Cartoon
            <span style="color:lightgreen" title="Total Product Warehouse Room cartoons">
                ({{ DB::table('product_warehouse_room_cartoons')->count() }})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ url('/view/all/supplier-source') }}"
            data-active-paths="{{ url('/view/all/supplier-source') }}, {{ url('/add/new/supplier-source') }}, {{ url('/edit/supplier-source/*') }}">
            <i class="feather-box"></i> Supplier Src Type
            <span style="color:lightgreen" title="Total CS Types">
                ({{ DB::table('supplier_source_types')->count() }})
            </span>
        </a>
    </li>

    <li>
        <a href="{{ url('/view/all/product-supplier') }}"
            data-active-paths="{{ url('/view/all/product-supplier') }}, {{ url('/add/new/product-supplier') }}, {{ url('/edit/product-supplier/*') }}">
            <i class="feather-box"></i> Product Suppliers
            <span style="color:lightgreen" title="Total Product Suppliers">
                ({{ DB::table('product_suppliers')->count() }})
            </span>
        </a>
    </li>


    <li>
        <a href="javascript: void(0);" class="has-arrow">
            <i class="feather-box"></i>
            <span>Product Purchase</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ url('/view/all/purchase-product/charge') }}"
                    data-active-paths="{{ url('/view/all/purchase-product/charge') }}, {{ url('/add/new/purchase-product/charge') }}, {{ url('/edit/purchase-product/charge/*') }}">
                    Other Charge Types
                </a>
            </li>
            <li>
                <a href="{{ url('/view/all/purchase-product/quotation') }}"
                    data-active-paths="{{ url('/view/all/purchase-product/quotation') }}, {{ url('/add/new/purchase-product/quotation') }}, {{ url('/edit/purchase-product/quotation/*') }}, {{ url('edit/purchase-product/sales/quotation/*') }}">
                    View All Quotations
                    <span style="color:lightgreen" title="Total Product Purchase Quotations">
                        ({{ DB::table('product_purchase_quotations')->count() }})
                    </span>
                </a>
            </li>
            {{-- <a href="javascript: void(0);" class="has-arrow"><i class="feather-box"></i><span>Order</span></a> --}}

            <li>
                <a href="{{ url('/view/all/purchase-product/order') }}"
                    data-active-paths="{{ url('/view/all/purchase-product/order') }}, {{ url('/add/new/purchase-product/order') }}, {{ url('/edit/purchase-product/order/*') }}, {{ url('edit/purchase-product/sales/order/*') }}">
                    View All Orders
                    <span style="color:lightgreen" title="Total Product Purchase Orders">
                        ({{ DB::table('product_purchase_orders')->count() }})
                    </span>
                </a>
            </li>

        </ul>
    </li>

    <li>
        <a href="javascript: void(0);" class="has-arrow">
            <i class="feather-printer"></i>
            <span>Generate Report</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ url('/product/purchase/report') }}"
                    data-active-paths="{{ url('/product/purchase/report') }}">
                    Product Purchase Report
                </a>
            </li>
        </ul>
    </li>
    {{-- End Inventory Module --}}


    {{-- Start Accounts Module --}}
    <hr style="border-color: #c8c8c836; margin-top: 12px; margin-bottom: 12px;">
    <li class="menu-title" style="color: khaki; text-shadow: 1px 1px 2px black;">Accounts Modules</li>
    <li>
        <a href="javascript:void(0);" class="has-arrow">
            <i class="feather-layers"></i><span>Chart of Accounts</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ route('account-types.index') }}" data-active-paths="{{ route('account-types.index') }}">
                    <i class="feather-list"></i>
                    <span>Account Types</span>
                </a>
            </li>
            <li>
                <a href="{{ route('group.index') }}" data-active-paths="{{ route('group.index') }}">
                    <i class="feather-folder"></i>
                    <span>Group Name</span>
                </a>
            </li>
            <li>
                <a href="{{ route('subsidiary-ledger.index') }}" data-active-paths="{{ route('subsidiary-ledger.index') }}">
                    <i class="feather-layers"></i>
                    <span>Subsidiary Ledger</span>
                </a>
            </li>
            <li>
                <a href="{{ route('chart-of-accounts.index') }}" data-active-paths="{{ route('chart-of-accounts.index') }}">
                    <i class="fas fa-sitemap"></i>
                    <span>Chart of Accounts</span>
                </a>
            </li>
            <li>
                <a href="{{ route('accounts-configuration.index') }}" data-active-paths="{{ route('accounts-configuration.index') }}">
                    <i class="fas fa-cogs"></i>
                    <span>Accounts Configuration</span>
                </a>
            </li>
        </ul>
    </li>
    
    

    <li>
        <a href="javascript:void(0);" class="has-arrow">
            <i class="feather-file-text"></i><span>Voucher Entry</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ route('voucher.payment') }}" data-active-paths="{{ route('voucher.payment') }}">
                    <i class="feather-credit-card"></i>
                    <span>Payment Voucher</span>
                </a>
            </li>
            <li>
                <a href="{{ route('voucher.receive') }}" data-active-paths="{{ route('voucher.receive') }}">
                    <i class="feather-download"></i>
                    <span>Receive Voucher</span>
                </a>
            </li>
            <li>
                <a href="{{ route('voucher.journal') }}" data-active-paths="{{ route('voucher.journal') }}">
                    <i class="feather-book"></i>
                    <span>Journal Voucher</span>
                </a>
            </li>
            <li>
                <a href="{{ route('contra-voucher.index') }}" data-active-paths="{{ route('contra-voucher.index') }}, {{ route('contra-voucher.create') }}, {{ route('contra-voucher.edit', '*') }}, {{ route('contra-voucher.show', '*') }}, {{ route('contra-voucher.print', '*') }}">
                    <i class="feather-refresh-ccw"></i>
                    <span>Contra Voucher</span>
                </a>
            </li>
        </ul>
    </li>

    <!-- Route::get('/journal-report', [JournalVoucherController::class, 'journalReport'])->name('reports.journal-report');
        Route::get('/lager-report', [PaymentVoucherController::class, 'lagerReport'])->name('reports.lager-report');
        Route::get('/balance-sheet-report', [ReceiveVoucherController::class, 'balanceSheetReport'])->name('reports.balance-sheet-report');
        Route::get('/income-statement-report', [ContraVoucherController::class, 'incomeStatementReport'])->name('reports.income-statement-report'); -->
    <li>
        <a href="javascript: void(0);" class="has-arrow"><i class="feather-settings"></i><span>Reports</span></a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ route('reports.journal-report') }}" data-active-paths="{{ route('reports.journal-report') }}">
                    <i class="feather-book"></i>
                    <span>Journal</span>
                </a>
            </li>
            <li>
                <a href="{{ route('reports.lager-report') }}" data-active-paths="{{ route('reports.lager-report') }}">
                    <i class="feather-credit-card"></i>
                    <span>Lager</span></a>
            </li>
            <li>
                <a href="{{ route('reports.balance-sheet-report') }}"
                    data-active-paths="{{ route('reports.balance-sheet-report') }}">
                    <i class="feather-layers"></i>
                    <span>Balance Sheet</span>
                </a>
            </li>
            <li>
                <a href="{{ route('reports.income-statement-report') }}"
                    data-active-paths="{{ route('reports.income-statement-report') }}">
                        <i class="feather-trending-up"></i>
                    <span>Income Statement</span>
                </a>
            </li>
            <!-- <li>
                <a href="{{ route('reports.journal-report') }}" data-active-paths="{{ route('reports.journal-report') }}">
                    <i class="feather-trending-up"></i>
                    <span>Journal Voucher Report</span>
                </a>
            </li> -->
        </ul>
    </li>
    


    <!-- <li>
        <a href="{{ url('/view/all/payment-type') }}"
            data-active-paths="{{ url('/view/all/payment-type') }}, {{ url('/add/new/payment-type') }}, {{ url('/edit/payment-type/*') }}">
            <i class="feather-box"></i> Payment Types
            <span style="color:lightgreen" title="Total CS Types">
                ({{ DB::table('db_paymenttypes')->count() }})
            </span>
        </a>
    </li>
    <li>

        <a href="{{ url('/view/all/expense-category') }}"
            data-active-paths="{{ url('/view/all/expense-category') }}, {{ url('/add/new/expense-category') }}, {{ url('/edit/expense-category/*') }}">
            <i class="feather-box"></i> Expense Categories
            <span style="color:lightgreen" title="Total Categories">
                ({{ DB::table('db_expense_categories')->count() }})
            </span>
        </a>

    </li>
    <li>
        <a href="{{ url('/view/all/ac-account') }}"
            data-active-paths="{{ url('/view/all/ac-account') }}, {{ url('/add/new/ac-account') }}, {{ url('/edit/ac-account/*') }}">
            <i class="feather-box"></i> All Accounts
            <span style="color:lightgreen" title="Total Accounts">
                ({{ DB::table('ac_accounts')->count() }})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ route('ViewAllExpense') }}"
            data-active-paths="{{ route('ViewAllExpense') }}, {{ url('/add/new/expense') }}, {{ url('/edit/expense/*') }}">
            <i class="feather-box"></i> All Expenses
            <span style="color:lightgreen" title="Total Expenses">
                ({{ DB::table('db_expenses')->count() }})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ route('ViewAllDeposit') }}"
            data-active-paths="{{ route('ViewAllDeposit') }}, {{ url('/add/new/deposit') }}, {{ url('/edit/deposit/*') }}">
            <i class="feather-box"></i> All Deposits
            <span style="color:lightgreen" title="Total Deposits">
                ({{ DB::table('ac_transactions')->count() }})
            </span>
        </a>
    </li> -->


    <!-- <li>
        <a href="javascript: void(0);" class="has-arrow"><i class="feather-settings"></i><span>Reports</span></a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ route('journal.index') }}" data-active-paths="{{ route('journal.index') }}">
                    <i class="feather-box"></i>
                    <span>Journal</span>
                </a>
            </li>
            <li>
                <a href="{{ route('ledger.index') }}" data-active-paths="{{ route('ledger.index') }}">
                    <i class="feather-box"></i>
                    <span>Ledger</span></a>
            </li>
            <li>
                <a href="{{ route('ledger.balance_sheet') }}"
                    data-active-paths="{{ route('ledger.balance_sheet') }}">
                    <i class="feather-box"></i>
                    <span>Balance Sheet</span>
                </a>
            </li>
            <li>
                <a href="{{ route('ledger.income_statement') }}"
                    data-active-paths="{{ route('ledger.income_statement') }}">
                    <i class="feather-box"></i>
                    <span>Income Statement</span>
                </a>
            </li>
            <li>
                <a href="{{ route('voucher.journal.report') }}" data-active-paths="{{ route('voucher.journal.report') }}">
                    <i class="feather-bar-chart-2"></i>
                    <span>Journal Voucher Report</span>
                </a>
            </li>
        </ul>
    </li> -->
    {{-- End Accounts Module --}}

    {{-- Start Crm Module --}}
    <hr style="border-color: #c8c8c836; margin-top: 12px; margin-bottom: 12px;">
    <li class="menu-title" style="color: khaki; text-shadow: 1px 1px 2px black;">CRM Modules</li>
    <li>
        <a href="{{ url('/view/all/customer-source') }}"
            data-active-paths="{{ url('/view/all/customer-source') }}, {{ url('/add/new/customer-source') }}, {{ url('/edit/customer-source/*') }}">
            <i class="feather-box"></i> Customer Src Type
            <span style="color:lightgreen" title="Total CS Types">
                ({{ DB::table('customer_source_types')->count() }})
            </span>
        </a>
    </li>
    <li>

        <a href="{{ url('/view/all/customer-category') }}"
            data-active-paths="{{ url('/view/all/customer-category') }}, {{ url('/add/new/customer-category') }}, {{ url('/edit/customer-category/*') }}">
            <i class="feather-box"></i> Customer Category
            <span style="color:lightgreen" title="Total Categories">
                ({{ DB::table('customer_categories')->count() }})
            </span>
        </a>

    </li>
    <li>
        <a href="{{ url('/view/all/customer') }}"
            data-active-paths="{{ url('/view/all/customer') }}, {{ url('/add/new/customers') }}, {{ url('/edit/customers/*') }}">
            <i class="feather-box"></i> Customers
            <span style="color:lightgreen" title="Total Customers">
                ({{ DB::table('customers')->count() }})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ route('ViewAllCustomerEcommerce') }}"
            data-active-paths="{{ route('ViewAllCustomerEcommerce') }}, {{ url('/add/new/customer-ecommerce') }}, {{ url('/edit/customer-ecommerce/*') }}">
            <i class="feather-box"></i> E-Customer
            <span style="color:lightgreen" title="Total Contact Histories">
                ({{ DB::table('users')->where('user_type', 3)->count() }})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ route('ViewAllCustomerContactHistories') }}"
            data-active-paths="{{ route('ViewAllCustomerContactHistories') }}, {{ url('/add/new/customer-contact-history') }}, {{ url('/edit/customer-contact-history/*') }}">
            <i class="feather-box"></i> Contacts History
            <span style="color:lightgreen" title="Total Contact Histories">
                ({{ DB::table('customer_contact_histories')->count() }})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ url('/view/all/customer-next-contact-date') }}"
            data-active-paths="{{ url('/view/all/customer-next-contact-date') }}, {{ url('/add/new/customer-next-contact-date') }}, {{ url('/edit/customer-next-contact-date/*') }}">
            <i class="feather-box"></i> Next Date Contacts
            <span style="color:lightgreen" title="Total Contact Histories">
                ({{ DB::table('customer_next_contact_dates')->count() }})
            </span>
        </a>
    </li>

    <li>
        <a href="javascript: void(0);" class="has-arrow">
            <i class="fas fa-headset"></i>
            <span>Support Ticket</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a style="color: skyblue !important;" href="{{ url('/pending/support/tickets') }}"
                    data-active-paths="{{ url('/pending/support/tickets') }}, {{ url('view/support/messages/*') }}">
                    Pending Supports
                    (@php
                        echo DB::table('support_tickets')->where('status', 0)->orWhere('status', 1)->count();
                    @endphp)
                </a>
            </li>
            <li>
                <a style="color: #0c0 !important;" href="{{ url('/solved/support/tickets') }}"
                    data-active-paths="{{ url('/solved/support/tickets') }},{{ url('view/support/messages/*') }}">
                    Solved Supports
                    (@php
                        echo DB::table('support_tickets')->where('status', 2)->count();
                    @endphp)
                </a>
            </li>
            <li>
                <a style="color: goldenrod !important;" href="{{ url('/on/hold/support/tickets') }}"
                    data-active-paths="{{ url('/on/hold/support/tickets') }},{{ url('view/support/messages/*') }}">
                    On Hold Supports
                    (@php
                        echo DB::table('support_tickets')->where('status', 4)->count();
                    @endphp)
                </a>
            </li>
            <li>
                <a style="color: red !important;" href="{{ url('/rejected/support/tickets') }}"
                    data-active-paths="{{ url('/rejected/support/tickets') }},{{ url('view/support/messages/*') }}">
                    Rejected Supports
                    (@php
                        echo DB::table('support_tickets')->where('status', 3)->count();
                    @endphp)
                </a>
            </li>
        </ul>
    </li>
    <li>
        <a href="{{ url('/view/all/contact/requests') }}"
            data-active-paths="{{ url('/view/all/contact/requests') }}">
            <i class="feather-phone-forwarded"></i>
            <span>Contact Request</span>
        </a>
    </li>
    <li>
        <a href="{{ url('/view/all/subscribed/users') }}"
            data-active-paths="{{ url('/view/all/subscribed/users') }}">
            <i class="feather-user-check"></i>
            <span>Subscribed Users</span>
        </a>
    </li>
    {{-- End Crm Modules --}}

    {{-- Start User Role Permission Module --}}
    <hr style="border-color: #c8c8c836; margin-top: 12px; margin-bottom: 5px;">
    <li class="menu-title" style="color: khaki; text-shadow: 1px 1px 2px black;">User Role Permission</li>

    <li>
        <a href="{{ url('/view/system/users') }}"
            data-active-paths="{{ url('/view/system/users') }}, {{ url('add/new/system/user') }}, {{ url('edit/system/user/*') }}">
            <i class="fas fa-user-shield"></i>
            <span>System Users</span>
        </a>
    </li>
    <li>
        <a href="{{ url('/view/user/roles') }}"
            data-active-paths="{{ url('/view/user/roles') }}, {{ url('/new/user/role') }}, {{ url('/edit/user/role/*') }}">
            <i class="feather-user-plus"></i>
            <span>User Roles</span>
        </a>
    </li>
    <li>
        <a href="{{ url('/view/user/role/permission') }}"
            data-active-paths="{{ url('/view/user/role/permission') }}, {{ url('/assign/role/permission/*') }}">
            <i class="mdi mdi-security"></i>
            <span>Assign Role Permission</span>
        </a>
    </li>
    <li>
        <a href="{{ url('/view/permission/routes') }}" data-active-paths="{{ url('/view/permission/routes') }}">
            <i class="feather-git-merge"></i>
            <span>Permission Routes</span>
        </a>
    </li>
    {{-- End User Role Permission Module --}}


    {{-- Start Website Config Module --}}
    <hr style="border-color: #c8c8c836; margin-top: 12px; margin-bottom: 5px;">
    <li class="menu-title" style="color: khaki; text-shadow: 1px 1px 2px black;">Website Config</li>

    <li>
        <a href="{{ url('/general/info') }}" data-active-paths="{{ url('/general/info') }}">
            <i class="feather-grid"></i>
            <span>General Info</span>
        </a>
    </li>
    <li>
        <a href="{{ url('/website/theme/page') }}" data-active-paths="{{ url('/website/theme/page') }}">
            <i class="mdi mdi-format-color-fill" style="font-size: 18px"></i>
            <span>Website Theme Color</span>
        </a>
    </li>
    <li>
        <a href="{{ url('/social/media/page') }}" data-active-paths="{{ url('/social/media/page') }}">
            <i class="mdi mdi-link-variant" style="font-size: 17px"></i>
            <span>Social Media Links</span>
        </a>
    </li>
    <li>
        <a href="{{ url('/seo/homepage') }}" data-active-paths="{{ url('/seo/homepage') }}">
            <i class="dripicons-search"></i>
            <span>Home Page SEO</span>
        </a>
    </li>
    <li>
        <a href="{{ url('/custom/css/js') }}" data-active-paths="{{ url('/custom/css/js') }}">
            <i class="feather-code"></i>
            <span>Custom CSS & JS</span>
        </a>
    </li>
    <li>
        <a href="{{ url('/social/chat/script/page') }}" data-active-paths="{{ url('/social/chat/script/page') }}">
            <i class="mdi mdi-code-brackets"></i>
            <span>Social & Chat Scripts</span>
        </a>
    </li>
    {{-- End Website Config Module --}}

    {{-- Start Content Management Module --}}
    <hr style="border-color: #c8c8c836; margin-top: 12px; margin-bottom: 12px;">
    <li class="menu-title" style="color: khaki; text-shadow: 1px 1px 2px black;">Content Management</li>

    <li>
        <a href="javascript: void(0);" class="has-arrow"><i class="feather-image"></i><span>Sliders &
                Banners</span></a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ url('/view/all/sliders') }}"
                    data-active-paths="{{ url('/view/all/sliders') }}, {{ url('/add/new/slider') }}, 
                {{ url('/edit/slider/*') }}, {{ url('/rearrange/slider') }}">
                    View All Sliders
                </a>
            </li>
            <li>
                <a href="{{ url('/view/all/banners') }}"
                    data-active-paths="{{ url('/view/all/banners') }}, {{ url('/add/new/banner') }}, 
                 {{ url('/edit/banner/*') }}, {{ url('/rearrange/banners') }}">
                    View All Banners
                </a>
            </li>
            <li>
                <a href="{{ url('/view/promotional/banner') }}"
                    data-active-paths="{{ url('/view/promotional/banner') }}">
                    Promotional Banner
                </a>
            </li>
            <li>
                <a href="{{ url('/view/all/side-banner') }}"
                    data-active-paths="{{ url('/view/all/side-banner') }}, {{ url('/add/new/side-banner') }}, {{ url('edit/side-banner/*') }}">
                    Side Banner
                </a>
            </li>
        </ul>
    </li>
    <li>
        <a href="{{ url('/view/testimonials') }}"
            data-active-paths="{{ url('/view/testimonials') }}, 
        {{ url('/add/testimonial') }}, {{ url('/edit/testimonial/*') }}">
            <i class="feather-message-square"></i>
            <span>Testimonials</span>
        </a>
    </li>
    <li>
        <a href="javascript: void(0);" class="has-arrow"><i class="feather-file-text"></i><span>Manage
                Blogs</span></a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ url('/blog/categories') }}"
                    data-active-paths="{{ url('/blog/categories') }}, {{ url('/rearrange/blog/category') }}">
                    Blog Categories
                </a>
            </li>
            <li>
                <a href="{{ url('/add/new/blog') }}" data-active-paths="{{ url('/add/new/blog') }}">
                    Write a Blog
                </a>
            </li>
            <li>
                <a href="{{ url('/view/all/blogs') }}"
                    data-active-paths="{{ url('/view/all/blogs') }}, {{ url('/edit/blog/*') }}">
                    View All Blogs
                </a>
            </li>
        </ul>
    </li>
    <li>
        <a href="javascript: void(0);" class="has-arrow">
            <i class="feather-alert-triangle"></i>
            <span>Terms & Policies</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ url('/terms/and/condition') }}" data-active-paths="{{ url('/terms/and/condition') }}">
                    Terms & Condition
                </a>
            </li>
            <li>
                <a href="{{ url('/view/privacy/policy') }}" data-active-paths="{{ url('/view/privacy/policy') }}">
                    Privacy Policy
                </a>
            </li>
            <li>
                <a href="{{ url('/view/shipping/policy') }}"
                    data-active-paths="{{ url('/view/shipping/policy') }}">
                    Shipping Policy
                </a>
            </li>
            <li>
                <a href="{{ url('/view/return/policy') }}" data-active-paths="{{ url('/view/return/policy') }}">
                    Return Policy
                </a>
            </li>
        </ul>
    </li>
    <li>
        <a href="{{ url('/view/all/pages') }}"
            data-active-paths="{{ url('/view/all/pages') }}, {{ url('/create/new/page') }}, {{ url('edit/custom/page/*') }}">
            <i class="feather-file-plus"></i>
            <span>Custom Pages</span>
            <span style="color:lightgreen" title="Total Outlets">
                ({{ DB::table('custom_pages')->count() }})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ url('/view/all/outlet') }}"
            data-active-paths="{{ url('/view/all/outlet') }}, {{ url('/add/new/outlet') }}, {{ url('/edit/outlet/*') }}">
            <i class="feather-box"></i> View All Outlets
            <span style="color:lightgreen" title="Total Outlets">
                ({{ DB::table('outlets')->count() }})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ url('/view/all/video-gallery') }}"
            data-active-paths="{{ url('/view/all/video-gallery') }}, {{ url('/add/new/video-gallery') }}, 
            {{ url('/edit/video-gallery/*') }}">
            <i class="feather-box"></i> View All Videos
            <span style="color:lightgreen" title="Total Videos">
                ({{ DB::table('video_galleries')->count() }})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ url('/about/us/page') }}" data-active-paths="{{ url('/about/us/page') }}">
            <i class="feather-globe"></i>
            <span>About Us</span>
        </a>
    </li>
    <li>
        <a href="{{ url('/view/all/faqs') }}"
            data-active-paths="{{ url('/view/all/faqs') }}, {{ url('/add/new/faq') }}, {{ url('/edit/faq/*') }}">
            <i class="far fa-question-circle"></i>
            <span>FAQ's</span>
        </a>
    </li>
    {{-- End Content Management Module --}}

    {{-- Start Download & Backup Module --}}
    <hr style="border-color: #c8c8c836; margin-top: 12px; margin-bottom: 12px;">
    <li class="menu-title" style="color: khaki; text-shadow: 1px 1px 2px black;">Download & Backup</li>

    <li>
        <a href="{{ url('/download/database/backup') }}"
            data-active-paths="{{ url('/download/database/backup') }}"
            onclick="return confirm('Are you sure you want to download the database backup?');">
            <i class="feather-database"></i>
            Database Backup
        </a>
    </li>
    <li>
        <a href="{{ url('/download/product/files/backup') }}"
            data-active-paths="{{ url('/download/product/files/backup') }}"
            onclick="return confirm('Are you sure you want to download the product images backup?');">
            <i class="feather-image"></i>Product Images Backup</a>
    </li>
    <li>
        <a href="{{ url('/download/user/files/backup') }}"
            data-active-paths="{{ url('/download/user/files/backup') }}"
            onclick="return confirm('Are you sure you want to download the user images backup?');">
            <i class="feather-user"></i>User Images Backup</a>
    </li>
    <li>
        <a href="{{ url('/download/banner/files/backup') }}"
            data-active-paths="{{ url('/download/banner/files/backup') }}"
            onclick="return confirm('Are you sure you want to download the banner images backup?');">
            <i class="feather-layers"></i>Banner Images Backup</a>
    </li>
    <li>
        <a href="{{ url('/download/category/files/backup') }}"
            data-active-paths="{{ url('/download/category/files/backup') }}"
            onclick="return confirm('Are you sure you want to download the category icon backup?');">
            <i class="feather-grid"></i>Category Icon Backup</a>
    </li>
    <li>
        <a href="{{ url('/download/subcategory/files/backup') }}" data-active-paths=""
            onclick="return confirm('Are you sure you want to download the subcategory backup?');">
            <i class="feather-list"></i>Subcategory Backup</a>
    </li>
    <li>
        <a href="{{ url('/download/flag/files/backup') }}"
            data-active-paths="{{ url('/download/flag/files/backup') }}"
            onclick="return confirm('Are you sure you want to download the flag icon backup?');">
            <i class="feather-flag"></i>Flag Icon Backup</a>
    </li>
    <li>
        <a href="{{ url('/download/ticket/files/backup') }}"
            data-active-paths="{{ url('/download/ticket/files/backup') }}"
            onclick="return confirm('Are you sure you want to download the ticket files backup?');">
            <i class="feather-file"></i>Ticket Files Backup</a>
    </li>
    <li>
        <a href="{{ url('/download/blog/files/backup') }}"
            data-active-paths="{{ url('/download/blog/files/backup') }}"
            onclick="return confirm('Are you sure you want to download the blog files backup?');">
            <i class="feather-file-text"></i>Blog Files Backup</a>
    </li>
    <li>
        <a href="{{ url('/download/other/files/backup') }}"
            data-active-paths="{{ url('/download/other/files/backup') }}"
            onclick="return confirm('Are you sure you want to download the other images backup?');">
            <i class="feather-folder"></i>Other Images Backup</a>
    </li>

    <hr style="border-color: #c8c8c836; margin-top: 12px; margin-bottom: 12px;">

    <li>
        <a href="javascript: void(0);" class="has-arrow">
            <i class="feather-box"></i>
            <span>Demo Products</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ url('/generate/demo/products') }}"
                    data-active-paths="{{ url('/generate/demo/products') }}">
                    Generate Products
                </a>
            </li>
            <li>
                <a href="{{ url('/remove/demo/products/page') }}"
                    data-active-paths="{{ url('/remove/demo/products/page') }}">
                    Remove Products
                </a>
            </li>
        </ul>
    </li>
    <li><a href="{{ url('/clear/cache') }}"><i class="feather-rotate-cw"></i><span>Clear Cache</span></a></li>
    <li>
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="feather-log-out"></i><span>Logout</span>
        </a>
    </li>
</ul>

<script>
    document.getElementById('menuSearch').addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        const menuItems = document.querySelectorAll('#side-menu > li');
        const sideMenu = document.getElementById('side-menu');
        const sectionsWithVisibleItems = new Set();

        menuItems.forEach(item => {
            const mainLink = item.querySelector('a');
            const submenu = item.querySelector('.sub-menu');
            const mainText = mainLink?.innerText.toLowerCase() || '';
            const mainMatch = mainText.includes(query);
            let subMatch = false;

            if (submenu) {
                const subItems = submenu.querySelectorAll('li');
                subItems.forEach(subItem => {
                    const subText = subItem.innerText.toLowerCase();
                    const match = subText.includes(query);
                    subItem.style.display = match || mainMatch ? '' : 'none';
                    if (match) subMatch = true;
                });

                if (mainMatch || subMatch) {
                    item.style.display = '';
                    submenu.style.display = '';
                    item.classList.add('mm-active');
                    submenu.classList.add('mm-show');
                    sectionsWithVisibleItems.add(getMenuSection(item));
                } else {
                    item.style.display = 'none';
                    submenu.style.display = 'none';
                    item.classList.remove('mm-active');
                    submenu.classList.remove('mm-show');
                }
            } else {
                const match = mainText.includes(query);
                item.style.display = match ? '' : 'none';
                if (match) sectionsWithVisibleItems.add(getMenuSection(item));
            }
        });

        // Show/hide .menu-title and <hr> based on visible section items
        const children = Array.from(sideMenu.children);
        for (let i = 0; i < children.length; i++) {
            const node = children[i];

            // Handle <hr>
            if (node.tagName === 'HR') {
                const nextTitle = getNextMenuTitle(children, i);
                const showHr = nextTitle && sectionsWithVisibleItems.has(nextTitle.textContent.trim());
                node.style.display = showHr ? '' : 'none';
            }

            // Handle .menu-title
            if (node.classList?.contains('menu-title')) {
                const sectionText = node.textContent.trim();
                node.style.display = sectionsWithVisibleItems.has(sectionText) ? '' : 'none';
            }
        }
    });

    function getMenuSection(item) {
        let prev = item.previousElementSibling;
        while (prev) {
            if (prev.classList?.contains('menu-title')) {
                return prev.textContent.trim();
            }
            prev = prev.previousElementSibling;
        }
        return '';
    }

    function getNextMenuTitle(children, index) {
        for (let j = index + 1; j < children.length; j++) {
            const next = children[j];
            if (next.classList?.contains('menu-title')) {
                return next;
            }
            if (next.tagName === 'LI') {
                const section = getMenuSection(next);
                if (section) return children.find(el => el.classList?.contains('menu-title') && el.textContent
                    .trim() === section);
            }
        }
        return null;
    }
</script>

<style>
    /* Enhanced Menu Search Styles */

    /* Search container styling */
    .menu-search-container {
        padding: 10px;
        background: rgba(0, 0, 0, 0.1);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    #menuSearch {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #555;
        border-radius: 5px;
        background: #444;
        color: white;
        font-size: 14px;
        box-sizing: border-box;
    }

    #menuSearch::placeholder {
        color: #aaa;
    }

    #menuSearch:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
    }
</style>

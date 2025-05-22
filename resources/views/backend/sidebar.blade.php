<!-- Left Menu Start -->
<ul class="metismenu list-unstyled" id="side-menu">
    <li>
        <a href="{{ url('/home') }}">
            <i class="feather-home"></i>
            <span> Ecommerce Dashboard</span>
        </a>
    </li>
    <li>
        <a href="{{ url('/crm-home') }}">
            <i class="feather-home"></i>
            <span> CRM Dashboard</span>
        </a>
    </li>
    <li>
        <a href="{{ url('/accounts-home') }}">
            <i class="feather-home"></i>
            <span> Accounts Dashboard</span>
        </a>
    </li>


    <hr style="border-color: #c8c8c836; margin-top: 12px; margin-bottom: 12px;">
    <li class="menu-title" style="color: khaki; text-shadow: 1px 1px 2px black;">E-commerce Modules</li>
    <li>
        <a href="javascript: void(0);" class="has-arrow"><i class="feather-settings"></i><span>Config</span></a>
        <ul class="sub-menu" aria-expanded="false">

            <li><a href="{{ url('/config/setup') }}">Setup Your Config</a></li>

            {{-- tech industry --}}
            {{-- @if(DB::table('config_setups')->where('code', 'storage')->first())
            <li><a href="{{ url('/view/all/storages') }}">Storage</a></li>
            @endif
            @if(DB::table('config_setups')->where('code', 'sim')->first())
            <li><a href="{{ url('/view/all/sims') }}">SIM Type</a></li>
            @endif
            @if(DB::table('config_setups')->where('code', 'device_condition')->first())
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

            <li><a href="{{ url('/view/email/credential') }}">Email Configure (SMTP)</a></li>
            {{-- <li><a href="{{ url('/view/email/templates') }}">Email Templates</a></li> --}}
            {{-- <li><a href="{{ url('/setup/sms/gateways') }}">SMS Gateway</a></li> --}}
            <li><a href="{{ url('/setup/payment/gateways') }}">Payment Gateway</a></li>

        </ul>
    </li>
    <li>
        <a href="javascript: void(0);" class="has-arrow"><i class="feather-settings"></i><span>Product
                Attributes</span></a>
        <ul class="sub-menu" aria-expanded="false">

            {{-- Fshion Insdustry --}}
            @if(DB::table('config_setups')->where('code', 'product_size')->first())
                <li><a href="{{ url('/view/all/sizes') }}">Product Sizes</a></li>
            @endif

            {{-- common --}}
            @if(DB::table('config_setups')->where('code', 'color')->first())
                <li><a href="{{ url('/view/all/colors') }}">Product Colors</a></li>
            @endif

            @if(DB::table('config_setups')->where('code', 'measurement_unit')->first())
                <li><a href="{{ url('/view/all/units') }}">Measurement Units</a></li>
            @endif


            <li><a href="{{ url('/view/all/brands') }}">Product Brands</a></li>
            <li><a href="{{ url('/view/all/models') }}">Models of Brand</a></li>
            <li><a href="{{ url('/view/all/flags') }}">Product Flags</a></li>

        </ul>
    </li>

    <li>
        <a href="{{ url('/view/all/category') }}"><i class="feather-sliders"></i><span>Category</span></a>
    </li>
    <li>
        <a href="{{ url('/view/all/subcategory') }}"><i class="feather-command"></i><span>Subcategory</span></a>
        {{-- <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{ url('/add/new/subcategory') }}">Add New Subcategory</a></li>
            <li><a href="{{ url('/view/all/subcategory') }}">View All Subcategories</a></li>
        </ul> --}}
    </li>
    <li>
        <a href="{{ url('/view/all/childcategory') }}"><i class="feather-git-pull-request"></i><span>Child
                Category</span></a>
    </li>
    <li>
        <a href="javascript: void(0);" class="has-arrow"><i class="feather-box"></i><span>Manage Products</span></a>
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
                <a href="{{ url('/view/all/product') }}">
                    View All Products
                    <span style="color:lightgreen" title="Total Products">
                        ({{DB::table('products')->count()}})
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ url('/view/product/reviews') }}">
                    Products's Review
                    <span style="color:goldenrod" title="Indicate Pending Review">
                        (@php
                            echo DB::table('product_reviews')
                                ->where('status', 0)
                                ->count();
                        @endphp)
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ url('/view/product/question/answer') }}">
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
        <a href="javascript: void(0);" class="has-arrow"><i class="feather-shopping-cart"></i><span>Manage
                Orders</span></a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a style="color: white !important;" href="{{ url('/view/orders') }}">All Orders (@php echo
                    DB::table('orders')->count(); @endphp)</a>
            </li>
            <li><a style="color: skyblue !important;" href="{{ url('/view/pending/orders') }}">Pending Orders
                    (@php
                        echo DB::table('orders')
                            ->where('order_status', 0)
                            ->count();
                    @endphp)</a>
            </li>
            <li><a style="color: wheat !important;" href="{{ url('/view/approved/orders') }}">Approved Orders
                    (@php
                        echo DB::table('orders')
                            ->where('order_status', 1)
                            ->count();
                    @endphp)</a></li>
            <li><a style="color: violet !important;" href="{{ url('/view/intransit/orders') }}">Intransit Orders
                    (@php
                        echo DB::table('orders')
                            ->where('order_status', 2)
                            ->count();
                    @endphp)</a></li>
            <li><a style="color: #0c0 !important;" href="{{ url('/view/delivered/orders') }}">Delivered Orders
                    (@php
                        echo DB::table('orders')
                            ->where('order_status', 3)
                            ->count();
                    @endphp)</a></li>
            <li><a style="color: tomato !important;" href="{{ url('/view/picked/orders') }}">Picked Orders
                    (@php
                        echo DB::table('orders')
                            ->where('order_status', 5)
                            ->count();
                    @endphp)</a></li>
            <li><a style="color: red !important;" href="{{ url('/view/cancelled/orders') }}">Cancelled Orders
                    (@php
                        echo DB::table('orders')
                            ->where('order_status', 4)
                            ->count();
                    @endphp)</a></li>
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
        <a href="{{ url('/view/all/promo/codes') }}"><i class="feather-gift"></i><span>Promo Codes</span></a>
    </li>

    {{-- <li><a href="{{ url('/file-manager') }}"><i class="fas fa-folder-open"></i><span>File Manager</span></a></li>
    --}}

    <li>
        <a href="javascript: void(0);" class="has-arrow"><i class="feather-bell"></i><span>Push Notification</span></a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{ url('/send/notification/page') }}">Send Notification</a></li>
            <li><a href="{{ url('/view/all/notifications') }}">Prevoious Notifications</a></li>
        </ul>
    </li>

    <li><a href="{{ url('/view/customers/wishlist') }}"><i class="feather-heart"></i><span>Customer's
                Wishlist</span></a></li>
    <li><a href="{{ url('/view/delivery/charges') }}"><i class="feather-truck"></i><span>Delivery Charges</span></a>
    </li>
    <li><a href="{{ url('/view/upazila/thana') }}"><i class="dripicons-location"></i><span>Upazila & Thana</span></a>
    </li>
    <li><a href="{{ url('/view/payment/history') }}"><i class="feather-dollar-sign"></i><span>Payment History</span></a>
    </li>

    <li>
        <a href="javascript: void(0);" class="has-arrow"><i class="feather-printer"></i><span>Generate Report</span></a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{ url('/sales/report') }}">Sales Report</a></li>
        </ul>
    </li>

    <hr style="border-color: #c8c8c836; margin-top: 12px; margin-bottom: 12px;">
    <li class="menu-title" style="color: khaki; text-shadow: 1px 1px 2px black;">Inventory Modules</li>
    <li>
        <a href="{{ url('/view/all/product-warehouse') }}"><i class="feather-box"></i>
            <span>Product Warehouse</span>
            <span style="color:lightgreen" title="Total Product Warehouses">
                ({{DB::table('product_warehouses')->count()}})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ url('/view/all/product-warehouse-room') }}">
            <i class="feather-box"></i>Warehouse Room
            <span style="color:lightgreen" title="Total Product Warehouse Rooms">
                ({{DB::table('product_warehouse_rooms')->count()}})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ url('/view/all/product-warehouse-room-cartoon') }}">
            <i class="feather-box"></i> Room Cartoon
            <span style="color:lightgreen" title="Total Product Warehouse Room cartoons">
                ({{DB::table('product_warehouse_room_cartoons')->count()}})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ url('/view/all/supplier-source') }}">
            <i class="feather-box"></i> Supplier Src Type
            <span style="color:lightgreen" title="Total CS Types">
                ({{DB::table('supplier_source_types')->count()}})
            </span>
        </a>
    </li>

    <li>
        <a href="{{ url('/view/all/product-supplier') }}">
            <i class="feather-box"></i> Product Suppliers
            <span style="color:lightgreen" title="Total Product Suppliers">
                ({{DB::table('product_suppliers')->count()}})
            </span>
        </a>
    </li>

    <li><a href="{{ url('/view/all/customers') }}"><i class="feather-users"></i>
            <span>Customers</span>
            <span style="color:lightgreen" title="Total CS Types">
                ({{DB::table('users')->where('user_type', 3)->count()}})
            </span>
        </a></li>

    <li>
        <a href="javascript: void(0);" class="has-arrow"><i class="feather-box"></i><span>Product Purchase</span></a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{ url('/view/all/purchase-product/charge') }}">Other Charge Types</a></li>
            <li>
                <a href="{{ url('/view/all/purchase-product/quotation') }}">
                    View All Quotations
                    <span style="color:lightgreen" title="Total Product Purchase Quotations">
                        ({{DB::table('product_purchase_quotations')->count()}})
                    </span>
                </a>
            </li>
            {{-- <a href="javascript: void(0);" class="has-arrow"><i class="feather-box"></i><span>Order</span></a> --}}

            <li>
                <a href="{{ url('/view/all/purchase-product/order') }}">
                    View All Orders
                    <span style="color:lightgreen" title="Total Product Purchase Orders">
                        ({{DB::table('product_purchase_orders')->count()}})
                    </span>
                </a>
            </li>

        </ul>
    </li>


    <hr style="border-color: #c8c8c836; margin-top: 12px; margin-bottom: 12px;">
    <li class="menu-title" style="color: khaki; text-shadow: 1px 1px 2px black;">Accounts Modules</li>

    <li>
        <a href="{{ url('/view/all/payment-type') }}">
            <i class="feather-box"></i> Payment Types
            <span style="color:lightgreen" title="Total CS Types">
                ({{DB::table('db_paymenttypes')->count()}})
            </span>
        </a>
    </li>
    <li>

        <a href="{{ url('/view/all/expense-category') }}">
            <i class="feather-box"></i> Expense Categories
            <span style="color:lightgreen" title="Total Categories">
                ({{DB::table('db_expense_categories')->count()}})
            </span>
        </a>

    </li>
    <li>
        <a href="{{ url('/view/all/ac-account') }}">
            <i class="feather-box"></i> All Accounts
            <span style="color:lightgreen" title="Total Accounts">
                ({{DB::table('ac_accounts')->count()}})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ route('ViewAllExpense') }}">
            <i class="feather-box"></i> All Expenses
            <span style="color:lightgreen" title="Total Expenses">
                ({{DB::table('db_expenses')->count()}})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ route('ViewAllDeposit') }}">
            <i class="feather-box"></i> All Deposits
            <span style="color:lightgreen" title="Total Deposits">
                ({{DB::table('ac_transactions')->count()}})
            </span>
        </a>
    </li>


    <li>
        <a href="javascript: void(0);" class="has-arrow"><i class="feather-settings"></i><span>Reports</span></a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ route('journal.index') }}">
                    <i class="feather-box"></i>
                    <span>Journal</span>
                </a>
            </li>
            <li>
                <a href="{{ route('ledger.index') }}">
                    <i class="feather-box"></i>
                    <span>Ledger</span></a>
            </li>
            <li>
                <a href="{{ route('ledger.balance_sheet') }}">
                    <i class="feather-box"></i>
                    <span>Balance Sheet</span>
                </a>
            </li>
            <li>
                <a href="{{ route('ledger.income_statement') }}">
                    <i class="feather-box"></i>
                    <span>Income Statement</span>
                </a>
            </li>
        </ul>
    </li>

    <hr style="border-color: #c8c8c836; margin-top: 12px; margin-bottom: 12px;">
    <li class="menu-title" style="color: khaki; text-shadow: 1px 1px 2px black;">CRM Modules</li>
    <li>
        <a href="{{ url('/view/all/customer-source') }}">
            <i class="feather-box"></i> Customer Src Type
            <span style="color:lightgreen" title="Total CS Types">
                ({{DB::table('customer_source_types')->count()}})
            </span>
        </a>
    </li>
    <li>

        <a href="{{ url('/view/all/customer-category') }}">
            <i class="feather-box"></i> Customer Category
            <span style="color:lightgreen" title="Total Categories">
                ({{DB::table('customer_categories')->count()}})
            </span>
        </a>

    </li>
    <li>
        <a href="{{ url('/view/all/customer') }}">
            <i class="feather-box"></i> Customers
            <span style="color:lightgreen" title="Total Customers">
                ({{DB::table('customers')->count()}})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ route('ViewAllCustomerContactHistories') }}">
            <i class="feather-box"></i> Contacts History
            <span style="color:lightgreen" title="Total Contact Histories">
                ({{DB::table('customer_contact_histories')->count()}})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ route('ViewAllCustomerEcommerce') }}">
            <i class="feather-box"></i> E-Customer
            <span style="color:lightgreen" title="Total Contact Histories">
                ({{DB::table('users')->where('user_type', 3)->count()}})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ url('/view/all/customer-next-contact-date') }}">
            <i class="feather-box"></i> Next Date Contacts
            <span style="color:lightgreen" title="Total Contact Histories">
                ({{DB::table('customer_next_contact_dates')->count()}})
            </span>
        </a>
    </li>

    <li>
        <a href="javascript: void(0);" class="has-arrow"><i class="fas fa-headset"></i><span>Support
                Ticket</span></a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a style="color: skyblue !important;" href="{{ url('/pending/support/tickets') }}">Pending Supports
                    (@php
                        echo DB::table('support_tickets')
                            ->where('status', 0)
                            ->orWhere('status', 1)
                            ->count();
                    @endphp)</a></li>
            <li><a style="color: #0c0 !important;" href="{{ url('/solved/support/tickets') }}">Solved Supports
                    (@php
                        echo DB::table('support_tickets')
                            ->where('status', 2)
                            ->count();
                    @endphp)</a></li>
            <li><a style="color: goldenrod !important;" href="{{ url('/on/hold/support/tickets') }}">On Hold Supports
                    (@php
                        echo DB::table('support_tickets')
                            ->where('status', 4)
                            ->count();
                    @endphp)</a></li>
            <li><a style="color: red !important;" href="{{ url('/rejected/support/tickets') }}">Rejected Supports
                    (@php
                        echo DB::table('support_tickets')
                            ->where('status', 3)
                            ->count();
                    @endphp)</a></li>
        </ul>
    </li>
    <li><a href="{{ url('/view/all/contact/requests') }}"><i class="feather-phone-forwarded"></i><span>Contact
                Request</span></a></li>
    <li><a href="{{ url('/view/all/subscribed/users') }}"><i class="feather-user-check"></i><span>Subscribed
                Users</span></a></li>

    <hr style="border-color: #c8c8c836; margin-top: 12px; margin-bottom: 5px;">
    <li class="menu-title" style="color: khaki; text-shadow: 1px 1px 2px black;">User Role Permission</li>
    <li><a href="{{ url('/view/system/users') }}"><i class="fas fa-user-shield"></i><span>System Users</span></a></li>
    <li><a href="{{ url('/view/permission/routes') }}"><i class="feather-git-merge"></i><span>Permission
                Routes</span></a></li>
    <li><a href="{{ url('/view/user/roles') }}"><i class="feather-user-plus"></i><span>User Roles</span></a></li>
    <li><a href="{{ url('/view/user/role/permission') }}"><i class="mdi mdi-security"></i><span>Assign Role
                Permission</span></a></li>

    <hr style="border-color: #c8c8c836; margin-top: 12px; margin-bottom: 5px;">
    <li class="menu-title" style="color: khaki; text-shadow: 1px 1px 2px black;">Website Config</li>
    <li><a href="{{ url('/general/info') }}"><i class="feather-grid"></i><span>General Info</span></a></li>
    <li><a href="{{ url('/website/theme/page') }}"><i class="mdi mdi-format-color-fill"
                style="font-size: 18px"></i><span>Website Theme Color</span></a></li>
    <li><a href="{{ url('/social/media/page') }}"><i class="mdi mdi-link-variant"
                style="font-size: 17px"></i><span>Social Media Links</span></a></li>
    <li><a href="{{ url('/seo/homepage') }}"><i class="dripicons-search"></i><span>Home Page SEO</span></a></li>
    <li><a href="{{ url('/custom/css/js') }}"><i class="feather-code"></i><span>Custom CSS & JS</span></a></li>
    <li><a href="{{ url('/social/chat/script/page') }}"><i class="mdi mdi-code-brackets"></i><span>Social & Chat
                Scripts</span></a></li>

    <hr style="border-color: #c8c8c836; margin-top: 12px; margin-bottom: 12px;">
    <li class="menu-title" style="color: khaki; text-shadow: 1px 1px 2px black;">Content Management</li>
    <li>
        <a href="javascript: void(0);" class="has-arrow"><i class="feather-image"></i><span>Sliders & Banners</span></a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{ url('/view/all/sliders') }}">View All Sliders</a></li>
            <li><a href="{{ url('/view/all/banners') }}">View All Banners</a></li>
            <li><a href="{{ url('/view/promotional/banner') }}">Promotional Banner</a></li>
            <li><a href="{{ url('/view/all/side-banner') }}">Side Banner</a></li>
        </ul>
    </li>
    <li>
        <a href="{{ url('/view/testimonials') }}">
            <i class="feather-message-square"></i>
            <span>Testimonials</span>
        </a>
    </li>
    <li>
        <a href="javascript: void(0);" class="has-arrow"><i class="feather-file-text"></i><span>Manage Blogs</span></a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{ url('/blog/categories') }}">Blog Categories</a></li>
            <li><a href="{{ url('/add/new/blog') }}">Write a Blog</a></li>
            <li><a href="{{ url('/view/all/blogs') }}">View All Blogs</a></li>
        </ul>
    </li>
    <li>
        <a href="javascript: void(0);" class="has-arrow"><i class="feather-alert-triangle"></i><span>Terms &
                Policies</span></a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{ url('/terms/and/condition') }}">Terms & Condition</a></li>
            <li><a href="{{ url('/view/privacy/policy') }}">Privacy Policy</a></li>
            <li><a href="{{ url('/view/shipping/policy') }}">Shipping Policy</a></li>
            <li><a href="{{ url('/view/return/policy') }}">Return Policy</a></li>
        </ul>
    </li>
    <li>
        <a href="{{ url('/view/all/pages') }}"><i class="feather-file-plus"></i>
            <span>Custom Pages</span>
            <span style="color:lightgreen" title="Total Outlets">
                ({{DB::table('custom_pages')->count()}})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ url('/view/all/outlet') }}">
            <i class="feather-box"></i> View All Outlets
            <span style="color:lightgreen" title="Total Outlets">
                ({{DB::table('outlets')->count()}})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ url('/view/all/video-gallery') }}">
            <i class="feather-box"></i> View All Videos
            <span style="color:lightgreen" title="Total Videos">
                ({{DB::table('video_galleries')->count()}})
            </span>
        </a>
    </li>
    <li><a href="{{ url('/about/us/page') }}"><i class="feather-globe"></i><span>About Us</span></a></li>
    <li><a href="{{ url('/view/all/faqs') }}"><i class="far fa-question-circle"></i><span>FAQ's</span></a></li>

    <hr style="border-color: #c8c8c836; margin-top: 12px; margin-bottom: 12px;">
    <li class="menu-title" style="color: khaki; text-shadow: 1px 1px 2px black;">Download & Backup</li>


    <li>
        <a href="{{ url('/download/database/backup') }}"
           onclick="return confirm('Are you sure you want to download the database backup?');">
            <i class="feather-database"></i>
            Database Backup
        </a>
    </li>
    <li>
        <a href="{{ url('/download/product/files/backup') }}"
           onclick="return confirm('Are you sure you want to download the product images backup?');">
            <i class="feather-image"></i>Product Images Backup</a>
    </li>
    <li>
        <a href="{{ url('/download/user/files/backup') }}"
           onclick="return confirm('Are you sure you want to download the user images backup?');">
            <i class="feather-user"></i>User Images Backup</a>
    </li>
    <li>
        <a href="{{ url('/download/banner/files/backup') }}"
           onclick="return confirm('Are you sure you want to download the banner images backup?');">
            <i class="feather-layers"></i>Banner Images Backup</a>
    </li>
    <li>
        <a href="{{ url('/download/category/files/backup') }}"
           onclick="return confirm('Are you sure you want to download the category icon backup?');">
            <i class="feather-grid"></i>Category Icon Backup</a>
    </li>
    <li>
        <a href="{{ url('/download/subcategory/files/backup') }}"
           onclick="return confirm('Are you sure you want to download the subcategory backup?');">
            <i class="feather-list"></i>Subcategory Backup</a>
    </li>
    <li>
        <a href="{{ url('/download/flag/files/backup') }}"
           onclick="return confirm('Are you sure you want to download the flag icon backup?');">
            <i class="feather-flag"></i>Flag Icon Backup</a>
    </li>
    <li>
        <a href="{{ url('/download/ticket/files/backup') }}"
           onclick="return confirm('Are you sure you want to download the ticket files backup?');">
            <i class="feather-file"></i>Ticket Files Backup</a>
    </li>
    <li>
        <a href="{{ url('/download/blog/files/backup') }}"
           onclick="return confirm('Are you sure you want to download the blog files backup?');">
            <i class="feather-file-text"></i>Blog Files Backup</a>
    </li>
    <li>
        <a href="{{ url('/download/other/files/backup') }}"
           onclick="return confirm('Are you sure you want to download the other images backup?');">
            <i class="feather-folder"></i>Other Images Backup</a>
    </li>

    <hr style="border-color: #c8c8c836; margin-top: 12px; margin-bottom: 12px;">

    <li>
        <a href="javascript: void(0);" class="has-arrow"><i class="feather-box"></i><span>Demo Products</span></a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{ url('/generate/demo/products') }}">Generate Products</a></li>
            <li><a href="{{ url('/remove/demo/products/page') }}">Remove Products</a></li>
        </ul>
    </li>
    <li><a href="{{ url('/clear/cache') }}"><i class="feather-rotate-cw"></i><span>Clear Cache</span></a></li>
    <li><a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                class="feather-log-out"></i><span>Logout</span></a></li>

</ul>
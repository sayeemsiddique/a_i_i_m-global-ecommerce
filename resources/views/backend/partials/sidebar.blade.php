
<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
    <!--begin::Brand-->
    <div class="brand flex-column-auto" id="kt_brand" style="padding: 10px">
        <!--begin::Logo-->
        <a href="{{route('index')}}" class="brand-logo">

            <img alt="Logo" src="{{ asset('storage/setting/' . $global_setting->logo) }}" style="max-height: 45px;"/>
            {{-- <h6 class="mt-1 ml-5" style="color: #f1f1f1; font-size:12px;"> {{ $global_setting->sub_title ?? ''}}</h6> --}}
        </a>
        <!--end::Logo-->
        <!--begin::Toggle-->
        {{-- <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
            <span class="svg-icon svg-icon svg-icon-xl">
                <i  class="fab fa-uncharted"></i>
            </span>
        </button> --}}
        <!--end::Toolbar-->
    </div>
    <!--end::Brand-->
    <!--begin::Aside Menu-->
    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper" style="background: #FFF !important;">
        <!--begin::Menu Container-->
        <div id="kt_aside_menu" class="aside-menu mb-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
            <!--begin::Menu Nav-->
            <ul class="menu-nav">
                <li class="menu-item {{ session('lsbm') == 'dashboard' ? ' menu-item-active ' : '' }} " aria-haspopup="true">
                    <a href="{{route('admin.index')}}" class="menu-link">
                        <span class="svg-icon menu-icon">
                            <i  class="fas fa-th"></i>
                        </span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>

                {{-- Manage order --}}
                @can('manage_order')
                    <li class="menu-item menu-item-submenu {{ session('lsbm') == 'manage_order' ? ' menu-item-open ' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <i class="fas fa-cart-arrow-down"></i>
                            </span>
                            <span class="menu-text">Order Management</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent " aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">Order Management</span>
                                    </span>
                                </li>

                                @can('order_list')
                                    <li class="menu-item {{ session('lsbsm') == 'order_list' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.order.index')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">All Orders</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('pending_order_list')
                                    <li class="menu-item {{ session('lsbsm') == 'pending_order_list' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.order.pending_list')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Pending Orders</span>
                                        </a>
                                    </li>
                                @endcan

                                {{-- @can('declined_order_list')
                                    <li class="menu-item {{ session('lsbsm') == 'declined_order_list' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.order.declined_list')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Declined Orders</span>
                                        </a>
                                    </li>
                                @endcan --}}

                                @can('order_return')
                                    <li class="menu-item {{ session('lsbsm') == 'order_return' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.order.order_return')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Order Return</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('order_return_list')
                                    <li class="menu-item {{ session('lsbsm') == 'order_return_list' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.order.order_return_list')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Order Return List</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('manage_review')
                                    <li class="menu-item {{ session('lsbsm') == 'manage_review' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{ route('admin.review.index') }}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Manage Review</span>
                                        </a>
                                    </li>
                                @endcan

                            </ul>
                        </div>
                    </li>
                @endcan

                @can('product_setting')
                    <!-- Product Settings -->
                    <li class="menu-item menu-item-submenu {{ session('lsbm') == 'product_setting' ? ' menu-item-open ' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <i class="fab fa-product-hunt"></i>
                            </span>
                            <span class="menu-text">Manage Product</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent " aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">Manage Product</span>
                                    </span>
                                </li>

                                {{-- @can('stock_report')
                                    <li class="menu-item {{ session('lsbsm') == 'stock_report' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.stockReport.index')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Product Inventory Report</span>
                                        </a>
                                    </li>
                                @endcan --}}

                                @can('all_category')
                                    <li class="menu-item {{ session('lsbsm') == 'all_category' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.category.index')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Manage Category</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('all_brand')
                                    <li class="menu-item {{ session('lsbsm') == 'all_brand' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.brand.index')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Manage Brand</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('all_varient_type')
                                    <li class="menu-item {{ session('lsbsm') == 'all_varient_type' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.varienttype.index')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Manage Variant Type</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('manage_varient_value')
                                    <li class="menu-item {{ session('lsbsm') == 'manage_varient_value' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.varient_value.index')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Manage Variant Value</span>
                                        </a>
                                    </li>
                                @endcan

                                {{-- @can('all_vat_type')
                                    <li class="menu-item {{ session('lsbsm') == 'all_vat_type' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.vat.index')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Manage Vat Type</span>
                                        </a>
                                    </li>
                                @endcan --}}

                                {{-- @can('all_material_product')
                                    <li class="menu-item {{ session('lsbsm') == 'all_material_product' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.product.material_index')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Manage Store Product</span>
                                        </a>
                                    </li>
                                @endcan --}}

                                @can('add_product')
                                    <li class="menu-item {{ session('lsbsm') == 'add_product' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.product.create')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Add Product</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('all_product')
                                    <li class="menu-item {{ session('lsbsm') == 'all_product' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.product.index')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">All Products</span>
                                        </a>
                                    </li>
                                @endcan

                                {{-- @can('add_packing_type')
                                    <li class="menu-item {{ session('lsbsm') == 'add_packing_type' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.packing_type.create')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Add Packing Type</span>
                                        </a>
                                    </li>
                                @endcan --}}

                                {{-- @can('all_packing_types')
                                    <li class="menu-item {{ session('lsbsm') == 'all_packing_types' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.packing_type.index')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">All Packing Types</span>
                                        </a>
                                    </li>
                                @endcan --}}

                            </ul>
                        </div>
                    </li>
                @endcan

                @can('inventory_management')
                    <!-- user management -->
                    <li class="menu-item menu-item-submenu {{ session('lsbm') == 'inventory_management' ? ' menu-item-open ' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <i class="fas fa-warehouse"></i>
                            </span>
                            <span class="menu-text">Inventory Management</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent " aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">Inventory Management</span>
                                    </span>
                                </li>

                                @can('product_stock')
                                    <li class="menu-item {{ session('lsbsm') == 'product_stock' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.product.stock')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Product Inventory</span>
                                        </a>
                                    </li>
                                @endcan

                                {{-- @can('material_product_stock')
                                    <li class="menu-item {{ session('lsbsm') == 'material_product_stock' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.product.material_stock')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Store Product Inventory</span>
                                        </a>
                                    </li>
                                @endcan --}}

                                @can('reconciliation_product_stock')
                                    <li class="menu-item {{ session('lsbsm') == 'reconciliation_product_stock' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.productDamage.create')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Adjust Damage Product</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('damage_list')
                                    <li class="menu-item {{ session('lsbsm') == 'damage_list' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.productDamage.index')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Damage Product List</span>
                                        </a>
                                    </li>
                                @endcan

                            </ul>
                        </div>
                    </li>
                @endcan

                {{-- @can('store_management')
                <!-- pos management -->
                <li class="menu-item menu-item-submenu {{ session('lsbm') == 'store_management' ? ' menu-item-open ' : '' }}"
                    aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                            <i  class="fab fa-uncharted"></i>

                        </span>
                        <span class="menu-text">Sales Center</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item menu-item-parent " aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">Sales Center</span>
                                </span>
                            </li>

                            @can('point_of_sale')
                                <li class="menu-item {{ session('lsbsm') == 'point_of_sale' ? ' menu-item-active ' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('admin.pos.create') }}" class="menu-link">
                                        <i class="far fa-dot-circle">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Point Of Sales (POS)</span>
                                    </a>
                                </li>
                            @endcan

                            @can('pos_order_list')
                                <li class="menu-item {{ session('lsbsm') == 'pos_order_list' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                    <a href="{{route('admin.pos.orderList')}}" class="menu-link">
                                        <i class="far fa-dot-circle">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Completed Sales</span>
                                    </a>
                                </li>
                            @endcan

                        </ul>
                    </div>
                </li>

                @endcan --}}

                {{-- Manage Bank --}}
                {{-- @can('manage_bank')
                    <!-- user management -->
                    <li class="menu-item menu-item-submenu {{ session('lsbm') == 'manage_bank' ? ' menu-item-open ' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <i  class="fab fa-uncharted"></i>
                            </span>
                            <span class="menu-text">Bank Management</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent " aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">Bank Management</span>
                                    </span>
                                </li>

                                @can('add_bank')
                                    <li class="menu-item {{ session('lsbsm') == 'add_bank' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.bank.create')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Add Bank Account</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('all_banks')
                                    <li class="menu-item {{ session('lsbsm') == 'all_banks' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.bank.index')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">All Bank Accounts</span>
                                        </a>
                                    </li>
                                @endcan

                            </ul>
                        </div>
                    </li>
                @endcan --}}



                @can('user_management')
                    <!-- user management -->
                    <li class="menu-item menu-item-submenu {{ session('lsbm') == 'roles' ? ' menu-item-open ' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <i class="fas fa-users"></i>
                            </span>
                            <span class="menu-text">User Management</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent " aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">User Management</span>
                                    </span>
                                </li>

                                @can('add_user')
                                    <li class="menu-item {{ session('lsbsm') == 'addUser' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.user.create')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Add User</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('all_users')
                                    <li class="menu-item {{ session('lsbsm') == 'allUsers' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.user.index')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">All Users List</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('all_roles')
                                    <li class="menu-item {{ session('lsbsm') == 'allRoles' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.role.index')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">All Roles</span>
                                        </a>
                                    </li>
                               @endcan

                               @can('all_department')
                                    <li class="menu-item {{ session('lsbssm') == 'all_department' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.department.index')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Manage Department</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('all_designation')
                                    <li class="menu-item {{ session('lsbssm') == 'all_designation' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.designation.index')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Manage Designation</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('all_permissions')
                                    <li class="menu-item {{ session('lsbsm') == 'permissions' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.permission.index')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">All Permissions</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('assign_permission')
                                    <li class="menu-item {{ session('lsbsm') == 'assignPerm' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.rolePermission.index')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Assign Permission</span>
                                        </a>
                                    </li>
                                @endcan


                            </ul>
                        </div>
                    </li>
                @endcan

                @can('manage_location')

                    <li class="menu-item menu-item-submenu {{ session('lsbm') == 'manage_location' ? ' menu-item-open ' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <i class="fas fa-map-marker"></i>
                            </span>
                            <span class="menu-text">Manage Location</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent " aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">Manage Location</span>
                                    </span>
                                </li>

                                @can('manage_region')
                                    <li class="menu-item {{ session('lsbsm') == 'manage_region' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.region.index')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Manage Region</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('manage_district')
                                    <li class="menu-item {{ session('lsbsm') == 'manage_district' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.district.index')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Manage District</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('manage_upazila')
                                    <li class="menu-item {{ session('lsbsm') == 'manage_upazila' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.upazila.index')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Manage Upazila / Thana</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                {{-- Manage page --}}
                @can('manage_page')
                    <!-- user management -->
                    <li class="menu-item menu-item-submenu {{ session('lsbm') == 'manage_page' ? ' menu-item-open ' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <i class="fas fa-pager"></i>
                            </span>
                            <span class="menu-text">Pages Management</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent " aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">Pages Management</span>
                                    </span>
                                </li>

                                @can('manage_page')
                                    <li class="menu-item {{ session('lsbsm') == 'manage_page' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.page.index')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Pages Management</span>
                                        </a>
                                    </li>
                                @endcan

                            </ul>
                        </div>
                    </li>
                @endcan

                @can('report_management')
                    <!-- Report Management -->
                    <li class="menu-item menu-item-submenu {{ session('lsbm') == 'report_management' ? ' menu-item-open ' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <i class="fas fa-receipt"></i>
                            </span>
                            <span class="menu-text">Report Management</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent " aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">Report Management</span>
                                    </span>
                                </li>

                                @can('stock_report')
                                    <li class="menu-item {{ session('lsbsm') == 'stock_report' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.stockReport.index')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Product Inventory Report</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('stock_in_report_by_product')
                                    <li class="menu-item {{ session('lsbsm') == 'stock_in_report_by_product' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.stockReport.stock_in_report_by_product')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Product Stock History Report</span>
                                        </a>
                                    </li>
                                @endcan

                                {{-- @can('store_product_report_by_product')
                                    <li class="menu-item {{ session('lsbsm') == 'store_product_report_by_product' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.stockReport.store_product_report_by_product')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Store Stock History Report</span>
                                        </a>
                                    </li>
                                @endcan --}}

                                @can('store_stock_report')
                                    <li class="menu-item {{ session('lsbsm') == 'store_stock_report' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.stockReport.storeStock')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Store Inventory Report</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('sales_report')
                                    <li class="menu-item {{ session('lsbsm') == 'sales_report' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.salesReport.index')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Sales Report</span>
                                        </a>
                                    </li>
                                @endcan

                                {{-- @can('daily_sales_report')
                                    <li class="menu-item {{ session('lsbsm') == 'daily_sales_report' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.salesReport.daily')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Daily Sales Report</span>
                                        </a>
                                    </li>
                                @endcan --}}

                                {{-- @can('dealer_sales_report')
                                    <li class="menu-item {{ session('lsbsm') == 'dealer_sales_report' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.salesReport.dealerSales')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Dealer Sales Report</span>
                                        </a>
                                    </li>
                                @endcan --}}

                                {{-- @can('customer_sales_report')
                                    <li class="menu-item {{ session('lsbsm') == 'customer_sales_report' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.salesReport.customerSales')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Retail Customer Sales Report</span>
                                        </a>
                                    </li>
                                @endcan --}}

                                @can('inventory_report_product_wise')
                                    <li class="menu-item {{ session('lsbsm') == 'inventory_report_product_wise' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.salesReport.inventory_report_product_wise')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Inventory Report Product Wise</span>
                                        </a>
                                    </li>
                                @endcan

                                {{-- @can('gatepass_report')
                                    <li class="menu-item {{ session('lsbsm') == 'gatepass_report' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.gatepass.report')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Gatepass Report</span>
                                        </a>
                                    </li>
                                @endcan --}}

                                {{-- @can('dealer_commission_report')
                                    <li class="menu-item {{ session('lsbsm') == 'dealer_commission_report' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.salesReport.commission_report.dealer')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Dealer Commission Reoprt</span>
                                        </a>
                                    </li>
                                @endcan --}}

                                {{-- @can('vat_sd_commission_report')
                                    <li class="menu-item {{ session('lsbsm') == 'vat_sd_commission_report' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{route('admin.salesReport.vat_sd_cmmmission')}}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">VAT, SD, Commission and TDS Report</span>
                                        </a>
                                    </li>
                                @endcan --}}

                            </ul>
                        </div>
                    </li>
                @endcan

                @can('settings')
                    <li class="menu-item menu-item-submenu {{ session('lsbm') == 'settings' ? ' menu-item-open ' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <i  class="fab fa-uncharted"></i>
                            </span>
                            <span class="menu-text">Settings</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent " aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">Settings</span>
                                    </span>
                                </li>

                                @can('manage_slider')
                                    <li class="menu-item {{ session('lsbsm') == 'manage_slider' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{ route('admin.slider.index') }}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Slider Setting</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('website_settings')
                                    <li class="menu-item {{ session('lsbsm') == 'website_settings' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{ route('admin.setting.edit', ['id'=>1]) }}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Website Settings</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('all_voucher')
                                    <li class="menu-item {{ session('lsbsm') == 'all_voucher' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{ route('admin.voucher.index') }}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Manage Voucher</span>
                                        </a>
                                    </li>
                                @endcan


                            </ul>
                        </div>
                    </li>
                @endcan

                {{-- @can('settings')
                    <li class="menu-item menu-item-submenu {{ session('lsbm') == 'settings' ? ' menu-item-open ' : '' }}"  aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <i  class="fab fa-uncharted"></i>
                            </span>
                            <span class="menu-text">Settings</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">Settings</span>
                                    </span>
                                </li>

                                @can('customer_setting')
                                <li class="menu-item menu-item-submenu {{ session('lsbsm') == 'customer_setting' ? ' menu-item-open ' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="javascript:;" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Customer Setting</span>

                                        <i class="menu-arrow"></i>
                                    </a>

                                    @can('add_customer')
                                    <div class="menu-submenu">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">
                                            <li class="menu-item {{ session('lsbssm') == 'add_customer' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                                <a href="{{ route('admin.customer.create_customer') }}" class="menu-link">
                                                    <i class="far fa-dot-circle">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">Add Customer</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                    @endcan

                                    @can('all_customers')
                                    <div class="menu-submenu">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">
                                            <li class="menu-item {{ session('lsbssm') == 'all_customers' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                                <a href="{{ route('admin.customer.all_customer') }}" class="menu-link">
                                                    <i class="far fa-dot-circle">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">All Customer List</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    @endcan

                                    @can('blocked_customer')
                                    <div class="menu-submenu">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">
                                            <li class="menu-item {{ session('lsbssm') == 'blocked_customer' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                                <a href="{{ route('admin.customer.blocked_customer') }}" class="menu-link">
                                                    <i class="far fa-dot-circle">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">Blocked Customer List</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    @endcan

                                </li>
                                @endcan

                                @can('corporate_setting')
                                <li class="menu-item menu-item-submenu {{ session('lsbsm') == 'corporate_setting' ? ' menu-item-open ' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="javascript:;" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Corporate Consumer Setting</span>

                                        <i class="menu-arrow"></i>
                                    </a>

                                    @can('add_corporate')
                                    <div class="menu-submenu">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">
                                            <li class="menu-item {{ session('lsbssm') == 'add_corporate' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                                <a href="{{ route('admin.customer.create_corporate') }}" class="menu-link">
                                                    <i class="far fa-dot-circle">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">Add Corporate Consumer</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                    @endcan

                                    @can('all_corporates')
                                    <div class="menu-submenu">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">
                                            <li class="menu-item {{ session('lsbssm') == 'all_corporates' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                                <a href="{{ route('admin.customer.all_corporate') }}" class="menu-link">
                                                    <i class="far fa-dot-circle">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">All Corporate Consumer List</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                    @endcan

                                    @can('pending_corporate')
                                    <div class="menu-submenu">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">
                                            <li class="menu-item {{ session('lsbssm') == 'pending_corporate' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                                <a href="{{ route('admin.customer.pending_corporate') }}" class="menu-link">
                                                    <i class="far fa-dot-circle">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">Pending Corporate Consumer List</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                    @endcan

                                    @can('approved_corporate')
                                    <div class="menu-submenu">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">
                                            <li class="menu-item {{ session('lsbssm') == 'approved_corporate' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                                <a href="{{ route('admin.customer.approved_corporate') }}" class="menu-link">
                                                    <i class="far fa-dot-circle">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">Approved Corporate Consumer List</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                    @endcan

                                    @can('blocked_corporate')
                                    <div class="menu-submenu">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">
                                            <li class="menu-item {{ session('lsbssm') == 'blocked_corporate' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                                <a href="{{ route('admin.customer.blocked_corporate') }}" class="menu-link">
                                                    <i class="far fa-dot-circle">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">Blocked Corporate Consumer List</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    @endcan

                                    @can('declined_corporate')
                                    <div class="menu-submenu">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">
                                            <li class="menu-item {{ session('lsbssm') == 'declined_corporate' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                                <a href="{{ route('admin.customer.declined_corporate') }}" class="menu-link">
                                                    <i class="far fa-dot-circle">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">Declined Corporate Consumer List</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    @endcan

                                </li>
                                @endcan

                                @can('dealer_setting')
                                <li class="menu-item menu-item-submenu {{ session('lsbsm') == 'dealer_setting' ? ' menu-item-open ' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="javascript:;" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Dealer Setting</span>
                                        <i class="menu-arrow"></i>
                                    </a>

                                    @can('add_dealer')
                                    <div class="menu-submenu">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">
                                            <li class="menu-item {{ session('lsbssm') == 'add_dealer' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                                <a href="{{ route('admin.customer.create_dealer') }}" class="menu-link">
                                                    <i class="far fa-dot-circle">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">Add Dealer</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    @endcan

                                    @can('all_dealers')
                                    <div class="menu-submenu">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">
                                            <li class="menu-item {{ session('lsbssm') == 'all_dealers' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                                <a href="{{ route('admin.customer.all_dealer') }}" class="menu-link">
                                                    <i class="far fa-dot-circle">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">All Dealer List</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    @endcan

                                    @can('pending_dealer')
                                    <div class="menu-submenu">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">
                                            <li class="menu-item {{ session('lsbssm') == 'pending_dealer' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                                <a href="{{ route('admin.customer.pending_dealer') }}" class="menu-link">
                                                    <i class="far fa-dot-circle">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">Pending Dealer List</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                    @endcan

                                    @can('approved_dealer')
                                        <div class="menu-submenu">
                                            <i class="menu-arrow"></i>
                                            <ul class="menu-subnav">
                                                <li class="menu-item {{ session('lsbssm') == 'approved_dealer' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                                    <a href="{{ route('admin.customer.approved_dealer') }}" class="menu-link">
                                                        <i class="far fa-dot-circle">
                                                            <span></span>
                                                        </i>
                                                        <span class="menu-text">Approved Dealer List</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    @endcan

                                    @can('blocked_dealer')
                                    <div class="menu-submenu">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">
                                            <li class="menu-item {{ session('lsbssm') == 'blocked_dealer' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                                <a href="{{ route('admin.customer.blocked_dealer') }}" class="menu-link">
                                                    <i class="far fa-dot-circle">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">Blocked Dealer List</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    @endcan

                                    @can('declined_dealer')
                                    <div class="menu-submenu">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">
                                            <li class="menu-item {{ session('lsbssm') == 'declined_dealer' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                                <a href="{{ route('admin.customer.declined_dealer') }}" class="menu-link">
                                                    <i class="far fa-dot-circle">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">Declined Dealer List</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    @endcan

                                </li>
                                @endcan

                                <li class="menu-item menu-item-submenu  {{ session('lsbsm') == 'org_setting' ? ' menu-item-open ' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="javascript:;" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Organization Setting</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="menu-submenu">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">



                                            @can('all_vehicles')
                                                <li class="menu-item {{ session('lsbssm') == 'all_vehicles' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                                    <a href="{{route('admin.vehicle.index')}}" class="menu-link">
                                                        <i class="far fa-dot-circle">
                                                            <span></span>
                                                        </i>
                                                        <span class="menu-text">Manage Vehicle</span>
                                                    </a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </li>



                                @can('order_settings')
                                    <li class="menu-item {{ session('lsbsm') == 'order_settings' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                                        <a href="{{ route('admin.setting.setting_edit', ['id'=>1]) }}" class="menu-link">
                                            <i class="far fa-dot-circle">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Order Setting</span>
                                        </a>

                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan --}}

                {{-- @can('website_settings')
                <li class="menu-item {{ session('lsbm') == 'setup' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                    <a href="{{ route('admin.setting.edit', ['id'=>1]) }}" class="menu-link">
                        <span class="svg-icon menu-icon">
                            <i  class="fas fa-cogs"></i>
                        </span>
                        <span class="menu-text">Website Settings</span>
                    </a>
                </li>
                @endcan --}}

                {{-- @can('log_info')
                <li class="menu-item {{ session('lsbm') == 'log_info' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                    <a href="{{ route('admin.loginfo.index') }}" class="menu-link">
                        <span class="svg-icon menu-icon">
                            <i  class="fab fa-uncharted"></i>
                        </span>
                        <span class="menu-text">Log Record</span>
                    </a>
                </li>
                @endcan --}}

                {{-- @can('db_backup')
                <li class="menu-item {{ session('lsbm') == 'db_backup' ? ' menu-item-active ' : '' }}" aria-haspopup="true">
                    <button class="menu-link" style="background: none; border: none;" onclick="backup()">
                        <span class="svg-icon menu-icon">
                            <i  class="fab fa-uncharted"></i>
                        </span>
                        <span class="menu-text">Data Backup</span>
                    </button>
                </li>
                @endcan --}}

                {{-- logout --}}
                <li class="menu-item" aria-haspopup="true">
                    <a target="_blank" href="{{ route('logout') }}" class="menu-link" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <span class="svg-icon menu-icon">
                            <i  class="fas fa-sign-out-alt"></i>
                        </span>
                        <span class="menu-text">Logout</span>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </a>
                </li>

            </ul>
            <!--end::Menu Nav-->
        </div>
        <!--end::Menu Container-->
    </div>
    <!--end::Aside Menu-->
</div>

<style>
    .menu-icon i {
        color: #bb212a;
        font-size: 15px;
    }
</style>

<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{

    // Front-end contoller
    FrontEndController,
    IndexController,
    OrderController,
    UserController,
    AdminSearchContoller,
    RoleController,
    PermissionController,
    RolePermissionController,
    CategoryController,
    ProductController,
    PackingTypeController,
    PointOfSaleController,
    BankController,
    PageController,
    BrandController,
    VarientTypeController,
    VatController,
    CustomerController,
    DepartmentController,
    DesignationController,
    VehicleController,
    SettingController,
    ProductVarientController,
    SliderController,
    ShippingAddressController,
    ReviewController,
    ProductDamageController,
    StockReportController,
    SalesReportController,
    OrderReturnController,
    SslCommerzPaymentController,
};

use App\Http\Middleware\SetLocale;
use App\Http\Middleware\AuthGates;
use App\Http\Middleware\CustomerAuth;


Route::get('/clear', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('view:clear');

    return "Clean";
    // return what you want
});

Route::get('/link-storage', function() {
    $exitCode = Artisan::call('storage:link');

    return "Linked";
    // return what you want
});
Route::middleware([SetLocale::class])->group(function () {
    Route::get('/track-order-status', [FrontendController::class, 'getOrderTrack'])->name('getOrderTrack');
    Route::post('/notification-read', [DynamicDependentController::class, 'notification_read'])->name('notification_read');
    Route::post('/forget-password', [FrontendController::class, 'forget_password'])->name('forget_password');
    Route::get('/child-category', [CategoryController::class, 'get_child_category'])->name('get_child_category');

    Route::get('/user-login', [FrontendController::class, 'login'])->name('bjkb.login');
    Route::post('/user-login', [FrontendController::class, 'user_login'])->name('login');
    Route::post('/registration', [FrontendController::class, 'registration'])->name('user_.registration');
    Route::get('/store', [FrontendController::class, 'store_grid'])->name('store.grid');
    Route::get('/product-detail/{id}', [FrontendController::class, 'product_detail'])->name('product-detail');
    Route::get('/order-track', [FrontendController::class, 'order_track'])->name('order_track');

    Route::get('/page/{type}', [FrontendController::class, 'page'])->name('front.page');
    Route::get('/page-info/{slug}', [FrontendController::class, 'page_info'])->name('front.page_info');

    Route::get('/cart', [FrontendController::class, 'cart'])->name('cart');
    // About us page
    Route::get('/about-us', [FrontendController::class, 'aboutus'])->name('aboutus');
    // Contact us page
    Route::get('/contact-us', [FrontendController::class, 'contactus'])->name('contactus');

    Route::get('/user-logout', [FrontendController::class, 'user_logout'])->name('user_logout');
    Route::post('/logout', [FrontendController::class, 'logout'])->name('logout');

    Route::get('/get-districts', [FrontendController::class, 'getDistrictsAJAX'])->name('districts');

    Route::get('/get-upazilas', [FrontendController::class, 'getUpazilasAJAX'])->name('upazilas');

    Route::post('/offices', [FrontendController::class, 'getOfficesByUpazila'])->name('offices');

    Route::post('/designations', [FrontendController::class, 'getDesignationsByLevel'])->name('designations');

    Route::post('/divisions', [FrontendController::class, 'getDivisionsByWing'])->name('divisions');

    Route::middleware([CustomerAuth::class])->group(function () {

        Route::post('/update-cart-data', [FrontendController::class, 'update_cart_data'])->name('update_cart_data');
        Route::post('/checkout-complete', [FrontendController::class, 'checkout_complete'])->name('checkout_complete');
        Route::get('/notification-redirect/{id}/{type}', [FrontendController::class, 'notificationRedirect'])->name('notificationRedirect');
        Route::get('/order-list', [FrontendController::class, 'account_orders'])->name('account_orders');
        // Route::get('/address', [FrontendController::class, 'account_address'])->name('account_address');
        Route::get('/account-details', [FrontendController::class, 'accountDetails'])->name('accountDetails');
        Route::get('/account-password', [FrontendController::class, 'accountPassword'])->name('accountPassword');
        Route::get('/order-details/{orderId}', [FrontendController::class, 'orderDetails'])->name('orderDetails');
        Route::post('/cancel-order/{order_id}', [FrontendController::class, 'cancel_order'])->name('cancel_order');
        Route::post('/edit-address/{user}', [FrontendController::class, 'edit_address'])->name('edit_address');
        Route::post('/edit-info/{user}', [FrontendController::class, 'edit_info'])->name('edit_info');
        Route::post('/edit-password/{user}', [FrontendController::class, 'edit_password'])->name('edit_password');
        Route::get('/add-to-cart', [FrontendController::class, 'add_to_cart'])->name('add_to_cart');
        Route::get('/buy-add-to-cart', [FrontendController::class, 'buy_add_to_cart'])->name('buy_add_to_cart');
        Route::post('/cart-update', [FrontendController::class, 'update_cart'])->name('update_cart');

        Route::prefix('shipping-address')->as('shipping_address.')->group(function () {
            Route::get('/index', [ShippingAddressController::class, 'index'])->name('index');
            Route::get('/create', [ShippingAddressController::class, 'create'])->name('create');
            Route::post('/store', [ShippingAddressController::class, 'store'])->name('store');
            Route::get('/show/{id}', [ShippingAddressController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [ShippingAddressController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [ShippingAddressController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [ShippingAddressController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('admin')->as('admin.')->middleware([AuthGates::class])->group(function () {
            Route::get('search/ajax/{type}', [AdminSearchContoller::class, 'ajaxSearch'])->name('searchAjax');
            Route::get('/', [IndexController::class, 'adminDashboard'])->name('index');

            Route::prefix('order')->as('order.')->group(function () {
                Route::get('/index', [OrderController::class, 'index'])->name('index');
                Route::get('/show/{id}', [OrderController::class, 'show'])->name('show');
                Route::get('/destroy/{id}', [OrderController::class, 'delete'])->name('delete');
                Route::get('/payment-update', [OrderController::class, 'paymentUpdate'])->name('paymentUpdate');
                Route::get('/order-update', [OrderController::class, 'orderUpdate'])->name('orderUpdate');
                Route::get('/delivery-update', [OrderController::class, 'deliveryUpdate'])->name('deliveryUpdate');
                Route::get('/pending-list', [OrderController::class, 'pending_list'])->name('pending_list');
                Route::get('/completed-list', [OrderController::class, 'completed_list'])->name('completed_list');
                Route::get('/declined-list', [OrderController::class, 'declined_list'])->name('declined_list');
                Route::post('/payment-update', [OrderController::class, 'orderStatusUpdate'])->name('orderStatusUpdate');

                Route::get('/stock-in-list', [OrderController::class, 'stock_in_list'])->name('stock_in_list');
                Route::get('/deduct-stock-list', [OrderController::class, 'deduct_stock_list'])->name('deduct_stock_list');
                Route::get('/stock-in/{id}', [OrderController::class, 'stock_in_show'])->name('stock_in_show');
                Route::get('/approved/{id}', [OrderController::class, 'approved'])->name('approved');
                Route::get('/completed-list', [OrderController::class, 'completed_list'])->name('completed_list');

                Route::get('/order-return', [OrderReturnController::class, 'order_return'])->name('order_return');
                Route::post('/order-return-confirm', [OrderReturnController::class, 'order_return_confirm'])->name('order_return_confirm');
                Route::get('/order-return-list', [OrderReturnController::class, 'order_return_list'])->name('order_return_list');
                Route::get('/order-return/show/{id}', [OrderReturnController::class, 'order_return_show'])->name('order_return_show');

            });


            Route::prefix('product')->as('product.')->group(function () {

                Route::get('/index', [ProductController::class, 'index'])->name('index');
                Route::get('/create', [ProductController::class, 'create'])->name('create');
                Route::post('/store', [ProductController::class, 'store'])->name('store');
                Route::get('/show/{id}', [ProductController::class, 'show'])->name('show');
                Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
                Route::post('/update/{id}', [ProductController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [ProductController::class, 'destroy'])->name('delete');

                Route::get('/stock', [ProductController::class, 'stock'])->name('stock');
                Route::get('/add-stock', [ProductController::class, 'add_stock'])->name('add_stock');
                Route::post('/store-stock', [ProductController::class, 'store_inventory'])->name('store_inventory');

                // material

                Route::get('/materials', [ProductController::class, 'material_index'])->name('material_index');
                Route::post('/material-store', [ProductController::class, 'material_store'])->name('material_store');
                Route::post('/material-update/{id}', [ProductController::class, 'material_update'])->name('material_update');
                Route::get('/material-stock', [ProductController::class, 'material_stock'])->name('material_stock');
                Route::get('/material-add-stock', [ProductController::class, 'material_add_stock'])->name('material_add_stock');
                Route::post('/material-store-stock', [ProductController::class, 'store_material_inventory'])->name('store_material_inventory');
                Route::get('/material-deduct-stock', [ProductController::class, 'material_deduct_stock'])->name('material_deduct_stock');
                Route::get('/material-stock-in-list', [ProductController::class, 'material_add_stock_history'])->name('material_add_stock_history');
            });

            Route::prefix('packing-type')->as('packing_type.')->group(function () {
                Route::get('/index', [PackingTypeController::class, 'index'])->name('index');
                Route::get('/create', [PackingTypeController::class, 'create'])->name('create');
                Route::post('/store', [PackingTypeController::class, 'store'])->name('store');
                Route::get('/show/{id}', [PackingTypeController::class, 'show'])->name('show');
                Route::get('/edit/{id}', [PackingTypeController::class, 'edit'])->name('edit');
                Route::patch('/update/{packing_type}', [PackingTypeController::class, 'update'])->name('update');
                Route::get('/delete/{packing_type}', [PackingTypeController::class, 'statusChange'])->name('delete');
                Route::get('/destroy/{id}', [PackingTypeController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('pos')->as('pos.')->group(function () {
                Route::get('/create', [PointOfSaleController::class, 'create'])->name('create');
                Route::get('/add-to-cart/{item}', [PointOfSaleController::class, 'store'])->name('store');
                Route::get('/update-cart/{item}/{quantity}', [PointOfSaleController::class, 'update'])->name('update');
                Route::get('/delete-from-cart/{id}', [PointOfSaleController::class, 'delete'])->name('delete');
                Route::post('/submit-order', [PointOfSaleController::class, 'submit'])->name('submit');
                Route::get('/order-list', [PointOfSaleController::class, 'orderList'])->name('orderList');
            });

            Route::prefix('bank')->as('bank.')->group(function () {
                Route::get('/index', [BankController::class, 'index'])->name('index');
                Route::get('/create', [BankController::class, 'create'])->name('create');
                Route::post('/store', [BankController::class, 'store'])->name('store');
                Route::get('/show/{id}', [BankController::class, 'show'])->name('show');
                Route::get('/edit/{id}', [BankController::class, 'edit'])->name('edit');
                Route::patch('/update/{bank}', [BankController::class, 'update'])->name('update');
                Route::get('/delete/{bank}', [BankController::class, 'statusChange'])->name('delete');
                Route::get('/destroy/{id}', [BankController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('page')->as('page.')->group(function () {
                Route::get('/', [PageController::class, 'index'])->name('index');
                Route::get('create', [PageController::class, 'create'])->name('create');
                Route::post('store', [PageController::class, 'store'])->name('store');
                Route::PATCH('/update/{id}', [PageController::class, 'update'])->name('update');
                Route::get('/show/{id}', [PageController::class, 'show'])->name('show');
                Route::get('/edit/{id}', [PageController::class, 'edit'])->name('edit');
                Route::get('/delete/{id}', [PageController::class, 'delete'])->name('delete');

                Route::get('/about-us', [PageController::class, 'aboutus'])->name('aboutus');
                Route::post('/update/about-us', [PageController::class, 'updateAboutus'])->name('updateAboutus');
                Route::get('/contact-us', [PageController::class, 'contactus'])->name('contactus');
                Route::post('/update/contact-us', [PageController::class, 'updateContactus'])->name('updateContactus');
                Route::get('/page-detail/{type}', [PageController::class, 'pageDetail'])->name('pageDetail');
                Route::post('/updatePage/{type}', [PageController::class, 'updatePage'])->name('updatePage');
            });

            Route::prefix('user')->as('user.')->group(function () {
                Route::get('/index', [UserController::class, 'index'])->name('index');
                Route::get('/pending', [UserController::class, 'pending'])->name('pending');
                Route::get('/approved', [UserController::class, 'approved'])->name('approved');
                Route::get('/create', [UserController::class, 'create'])->name('create');
                Route::post('/store', [UserController::class, 'store'])->name('store');
                Route::get('/show/{id}', [UserController::class, 'show'])->name('show');
                Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
                Route::patch('/update/{user}', [UserController::class, 'update'])->name('update');
                Route::get('/block/{user}', [UserController::class, 'block'])->name('block');
                Route::get('/delete/{user}', [UserController::class, 'destroy'])->name('delete');
                Route::get('/approve/{user}', [UserController::class, 'approve'])->name('approve');

                Route::get('/editProfile/{username}/', [UserController::class, 'editProfile'])->name('editProfile');
                Route::patch('/updateProfile/{user}', [UserController::class, 'updateProfile'])->name('updateProfile');
                Route::patch('/updatePassword/{user}', [UserController::class, 'updatePassword'])->name('updatePassword');
            });

            Route::prefix('role')->as('role.')->group(function () {
                Route::get('/index', [RoleController::class, 'index'])->name('index');
                Route::post('/create', [RoleController::class, 'create'])->name('create');
                Route::post('/update/{id}', [RoleController::class, 'update'])->name('update');
                Route::get('/status/change/{id}', [RoleController::class, 'statusChange'])->name('statusChange');
            });

            Route::prefix('permission')->as('permission.')->group(function () {
                Route::get('/index', [PermissionController::class, 'index'])->name('index');
                Route::post('/create', [PermissionController::class, 'create'])->name('create');
                Route::post('/update/{id}', [PermissionController::class, 'update'])->name('update');
            });


            Route::prefix('role-permission')->as('rolePermission.')->group(function () {
                Route::get('/index', [PermissionController::class, 'index'])->name('index');
                Route::get('/create', [PermissionController::class, 'create'])->name('create');
                Route::get('/edit/{rolePermission}', [PermissionController::class, 'edit'])->name('edit');
                Route::get('/select/new/role', [PermissionController::class, 'selectNewRole'])->name('selectNewRole');
                Route::post('/store', [PermissionController::class, 'store'])->name('store');
                Route::post('/update/{rolePermission}', [PermissionController::class, 'update'])->name('update');
            });

            Route::prefix('category')->as('category.')->group(function () {
                Route::get('/index', [CategoryController::class, 'index'])->name('index');
                Route::get('/create', [CategoryController::class, 'create'])->name('create');
                Route::post('/store', [CategoryController::class, 'store'])->name('store');
                Route::get('/show/{id}', [CategoryController::class, 'show'])->name('show');
                Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
                Route::patch('/update/{id}', [CategoryController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [CategoryController::class, 'destroy'])->name('delete');
            });

            Route::prefix('brand')->as('brand.')->group(function () {
                Route::get('/index', [BrandController::class, 'index'])->name('index');
                Route::get('/create', [BrandController::class, 'create'])->name('create');
                Route::post('/store', [BrandController::class, 'store'])->name('store');
                Route::get('/show/{id}', [BrandController::class, 'show'])->name('show');
                Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('edit');
                Route::patch('/update/{id}', [BrandController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [BrandController::class, 'destroy'])->name('delete');
            });

            Route::prefix('varient-type')->as('varienttype.')->group(function () {
                Route::get('/index', [VarientTypeController::class, 'index'])->name('index');
                Route::get('/create', [VarientTypeController::class, 'create'])->name('create');
                Route::post('/store', [VarientTypeController::class, 'store'])->name('store');
                Route::get('/show/{id}', [VarientTypeController::class, 'show'])->name('show');
                Route::get('/edit/{id}', [VarientTypeController::class, 'edit'])->name('edit');
                Route::patch('/update/{id}', [VarientTypeController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [VarientTypeController::class, 'destroy'])->name('delete');
            });

            Route::prefix('vat')->as('vat.')->group(function () {
                Route::get('/index', [VatController::class, 'index'])->name('index');
                Route::get('/create', [VatController::class, 'create'])->name('create');
                Route::post('/store', [VatController::class, 'store'])->name('store');
                Route::get('/show/{id}', [VatController::class, 'show'])->name('show');
                Route::get('/edit/{id}', [VatController::class, 'edit'])->name('edit');
                Route::post('/update/{id}', [VatController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [VatController::class, 'destroy'])->name('delete');
            });

            Route::prefix('customer')->as('customer.')->group(function () {
                Route::get('/all_customer', [CustomerController::class, 'all_customer'])->name('all_customer');
                Route::get('/all_corporate', [CustomerController::class, 'all_corporate'])->name('all_corporate');
                Route::get('/all_dealer', [CustomerController::class, 'all_dealer'])->name('all_dealer');

                Route::get('/pending_corporate', [CustomerController::class, 'pending_corporate'])->name('pending_corporate');
                Route::get('/pending_dealer', [CustomerController::class, 'pending_dealer'])->name('pending_dealer');

                Route::get('/approved_corporate', [CustomerController::class, 'approved_corporate'])->name('approved_corporate');
                Route::get('/approved_dealer', [CustomerController::class, 'approved_dealer'])->name('approved_dealer');

                Route::get('/blocked_customer', [CustomerController::class, 'blocked_customer'])->name('blocked_customer');
                Route::get('/blocked_corporate', [CustomerController::class, 'blocked_corporate'])->name('blocked_corporate');
                Route::get('/blocked_dealer', [CustomerController::class, 'blocked_dealer'])->name('blocked_dealer');

                Route::get('/declined_corporate', [CustomerController::class, 'declined_corporate'])->name('declined_corporate');
                Route::get('/declined_dealer', [CustomerController::class, 'declined_dealer'])->name('declined_dealer');

                Route::get('/create_customer', [CustomerController::class, 'create_customer'])->name('create_customer');
                Route::get('/create_corporate', [CustomerController::class, 'create_corporate'])->name('create_corporate');
                Route::get('/create_dealer', [CustomerController::class, 'create_dealer'])->name('create_dealer');
                Route::post('/store', [CustomerController::class, 'store'])->name('store');
                Route::get('/show/{id}', [CustomerController::class, 'show'])->name('show');
                Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('edit');
                Route::patch('/update/{user}', [CustomerController::class, 'update'])->name('update');
                Route::get('/block/{user}', [CustomerController::class, 'block'])->name('block');
                Route::get('/delete/{user}', [CustomerController::class, 'destroy'])->name('delete');
                Route::get('/approve/{user}', [CustomerController::class, 'approve'])->name('approve');
            });

            Route::prefix('department')->as('department.')->group(function () {
                Route::get('/index', [DepartmentController::class, 'index'])->name('index');
                Route::get('/create', [DepartmentController::class, 'create'])->name('create');
                Route::post('/store', [DepartmentController::class, 'store'])->name('store');
                Route::get('/show/{id}', [DepartmentController::class, 'show'])->name('show');
                Route::get('/edit/{id}', [DepartmentController::class, 'edit'])->name('edit');
                Route::patch('/update/{department}', [DepartmentController::class, 'update'])->name('update');
                Route::get('/delete/{department}', [DepartmentController::class, 'statusChange'])->name('delete');
                Route::get('/destroy/{id}', [DepartmentController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('designation')->as('designation.')->group(function () {
                Route::get('/index', [DesignationController::class, 'index'])->name('index');
                Route::get('/create', [DesignationController::class, 'create'])->name('create');
                Route::post('/store', [DesignationController::class, 'store'])->name('store');
                Route::get('/edit/{designation}', [DesignationController::class, 'edit'])->name('edit');
                Route::post('/update/{designation}', [DesignationController::class, 'update'])->name('update');
                Route::post('/destroy/{designation}', [DesignationController::class, 'destroy'])->name('destroy');
                Route::get('/delete/{id}', [DesignationController::class, 'delete'])->name('delete');
            });

            Route::prefix('vehicle')->as('vehicle.')->group(function () {
                Route::get('/index', [VehicleController::class, 'index'])->name('index');
                Route::get('/create', [VehicleController::class, 'create'])->name('create');
                Route::post('/store', [VehicleController::class, 'store'])->name('store');
                Route::get('/show/{id}', [VehicleController::class, 'show'])->name('show');
                Route::get('/edit/{id}', [VehicleController::class, 'edit'])->name('edit');
                Route::patch('/update/{vehicle}', [VehicleController::class, 'update'])->name('update');
                Route::get('/delete/{vehicle}', [VehicleController::class, 'statusChange'])->name('delete');
                Route::get('/destroy/{id}', [VehicleController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('setting')->as('setting.')->group(function () {
                Route::get('/edit/{id}',[SettingController::class, 'edit'])->name('edit');
                Route::post('/update/{setting}',[SettingController::class, 'update'])->name('update');
                Route::get('/order_setting/{id}',[SettingController::class, 'setting_edit'])->name('setting_edit');
                Route::post('/order_setting_update/{setting}',[SettingController::class, 'setting_update'])->name('setting_update');
                // template setting
                Route::get('/index', [SettingController::class, 'templateSetting'])->name('templateSetting');
                Route::get('/showtemp/{template}', [SettingController::class, 'showTemp'])->name('showTemp');
                Route::get('/edit-template/{template}',[SettingController::class, 'editTemplate'])->name('editTemplate');
                Route::get('/create-template',[SettingController::class, 'createTemplate'])->name('createTemplate');
                Route::post('/store-template',[SettingController::class, 'storeTemplate'])->name('storeTemplate');
                Route::post('/update-template/{template}',[SettingController::class, 'updateTemplate'])->name('updateTemplate');
                Route::post('/destroy/{template}',[SettingController::class, 'destroy'])->name('destroy');

            });

            Route::prefix('/product/varient')->as('product.varient.')->group(function () {
                // Route::get('/index', ['uses' => 'Backend\Admin\ProductVarientController@index'])->name('product.varient.index');
                // Route::get('/create', ['uses' => 'Backend\Admin\ProductVarientController@create'])->name('product.varient.create');
                // Route::post('/store', ['uses' => 'Backend\Admin\ProductVarientController@store'])->name('product.varient.store');
                // Route::get('/show/{id}', ['uses' => 'Backend\Admin\ProductVarientController@show'])->name('product.varient.show');
                // Route::get('/edit/{id}', ['uses' => 'Backend\Admin\ProductVarientController@edit'])->name('product.varient.edit');
                // Route::post('/update/{id}', ['uses' => 'Backend\Admin\ProductVarientController@update'])->name('product.varient.update');
                Route::get('/delete/{id}', [ProductVarientController::class, 'destroy'])->name('delete');
            });

            Route::group(['prefix' => '/sales-report', 'as' => 'salesReport.'], function() {
                Route::get('/index', [SalesReportController::class, 'index'])->name('index');
                Route::get('/filter', [SalesReportController::class, 'filter'])->name('filter');

                Route::get('/dealer-sales-report', [SalesReportController::class, 'dealerSalesReport'])->name('dealerSales');
                Route::get('/dealer-filter', [SalesReportController::class, 'dealerFilter'])->name('dealerFilter');
                Route::get('/commission-report/dealer', [SalesReportController::class, 'commission_report_dealer'])->name('commission_report.dealer');
                Route::get('/vat-sd-commision-report', [SalesReportController::class, 'vat_sd_commision_report'])->name('vat_sd_cmmmission');

                Route::get('/customer-sales-report', [SalesReportController::class, 'customerSales'])->name('customerSales');

                Route::get('/customer-filter', [SalesReportController::class, 'customerFilter'])->name('customerFilter');
                Route::get('/daily-report', [SalesReportController::class, 'daily'])->name('daily');

                Route::get('/inventory-report-product-wise', [SalesReportController::class, 'inventory_report_product_wise'])->name('inventory_report_product_wise');
            });

            Route::group(['prefix' => '/review', 'as' => 'review.'], function() {
                Route::get('/index', [ReviewController::class, 'index'])->name('index');
                Route::post('/store/{product_id}/{user_id}', [ReviewController::class, 'store'])->name('store');
                Route::get('/publish/{review}', [ReviewController::class, 'publish'])->name('publish');
                Route::get('/delete/{id}', [ReviewController::class, 'destroy'])->name('destroy');
            });

            Route::group(['prefix' => '/product/damage','as' => 'productDamage.'], function() {
                Route::get('/index', [ProductDamageController::class, 'index'])->name('index');
                Route::get('/create', [ProductDamageController::class, 'create'])->name('create');
                Route::post('/store', [ProductDamageController::class, 'store'])->name('store');
                Route::get('/{product}/get-products',[ProductDamageController::class, 'getProduct'])->name('getProduct');
                Route::get('/{product}/get-product-varient',[ProductDamageController::class, 'getProductVarient'])->name('getProductVarient');
                Route::get('/{product}/get-stock',[ProductDamageController::class, 'getStock'])->name('getStock');
                Route::get('/{product}/get-varient-stock',[ProductDamageController::class, 'getVarientStock'])->name('getVarientStock');
                Route::get('/delete/{id}', [ProductDamageController::class, 'destroy'])->name('delete');
            });

            Route::group(['prefix' => '/stock-report', 'as' => 'stockReport.'], function() {
                Route::get('/index', [StockReportController::class, 'index'])->name('index');
                Route::get('/store-stock', [StockReportController::class, 'storeStock'])->name('storeStock');
                Route::get('/filter/{type?}', [StockReportController::class, 'filter'])->name('filter');
                Route::get('/stock-history-report', [StockReportController::class, 'stock_in_report_by_product'])->name('stock_in_report_by_product');
                Route::get('/store-product-history-report', [StockReportController::class, 'store_product_report_by_product'])->name('store_product_report_by_product');
            });

            Route::group(['prefix' => '/gatepass', 'as' => 'gatepass.'], function() {
                Route::get('/report', [ReportController::class, 'gatepass_report'])->name('report');
                Route::get('/report_filter', [ReportController::class, 'gatepass_report_filter'])->name('report_filter');

            });

            Route::group(['prefix' => '/slider', 'as' => 'slider.'], function() {
                Route::get('/index', [SliderController::class, 'index'])->name('index');
                Route::get('/create', [SliderController::class, 'create'])->name('create');
                Route::post('/store', [SliderController::class, 'store'])->name('store');
                Route::get('/show/{id}', [SliderController::class, 'show'])->name('show');
                Route::get('/edit/{id}', [SliderController::class, 'edit'])->name('edit');
                Route::post('/update/{id}', [SliderController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [SliderController::class, 'delete'])->name('delete');
            });

            Route::group(['prefix' => '/loginfo', 'as' => 'loginfo.'], function() {
                Route::get('/index', [LogInfoController::class, 'index'])->name('index');
                Route::get('/delete/{id}', [LogInfoController::class, 'destroy'])->name('destroy');
            });

            Route::group(['prefix' => '/upload', 'as' => 'upload.'], function() {

                Route::get('/remove/{id}', [ProductController::class, 'upload_remove'])->name('remove');

            });

        });

        Route::get('/accountDashboard', [FrontendController::class, 'account'])->name('account');
        Route::get('/checkout', [FrontendController::class, 'checkout'])->name('checkout');
        Route::get('/remove-cart-item', [FrontendController::class, 'remove_cart_item'])->name('remove_cart_item');
    });
    Route::get('/', [FrontendController::class, 'index'])->name('index');
    Route::get('/guest-add-to-cart', [FrontendController::class, 'guest_add_to_cart'])->name('guest_add_to_cart');
    Route::get('/guest-cart-view', [FrontendController::class, 'guest_cart_view'])->name('guest_cart_view');
    Route::get('/remove-guest-cart-item', [FrontendController::class, 'remove_guest_cart_item'])->name('remove_guest_cart_item');
    Route::get('/view-cart-section', [FrontendController::class, 'view_cart_section'])->name('view_cart_section');
    Route::post('/sent-otp-code', [FrontendController::class, 'sent_otp_code'])->name('sent_otp_code');
    Route::post('/resend-otp', [FrontEndController::class, 'resendOtp'])->name('resendOtp');
    Route::post('/verify-otp', [FrontEndController::class, 'verifyOtp'])->name('verifyOtp');
    Route::get('/check-auth', [FrontEndController::class, 'check_auth'])->name('check_auth');
    Route::post('/forgot-sent-otp-code', [FrontendController::class, 'sent_forgot_password_otp_code'])->name('sent_forgot_password_otp_code');
    Route::post('/forgot-verify-otp-code', [FrontendController::class, 'forgot_password_otp_verify'])->name('forgot_password_otp_verify');

    Route::post('/success', [SslCommerzPaymentController::class, 'success']);
    Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
    Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);
    Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);


});


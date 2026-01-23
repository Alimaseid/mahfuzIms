<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\LoginTimeExceptionController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\BusinessLocationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\IssuingController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemReturnController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PaymentLedgerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\SalesPaymentController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ItemTransferController;
use App\Http\Controllers\ShelfController;
use App\Http\Controllers\DisposalController;
use App\Http\Controllers\GoodReceivingController;
use App\Http\Controllers\ItemShelfController;
use App\Http\Controllers\ItemUnitController;
use App\Http\Controllers\LoginTimePolicyController;
use App\Http\Controllers\OpeningBalanceController;
use App\Http\Controllers\PurchasePlanController;
use Database\Factories\CategoryFactory;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::controller(IndexController::class)
    ->middleware(['auth', 'verified'])->group(function () {
        Route::get('/', 'index')->name('dashboard');
        // Route::get('/', 'expired')->name('expired');
    });
Route::middleware(['auth', 'role:Super Admin'])

    ->name('admin.')
    ->group(function () {

        Route::get('/time-policy', [LoginTimePolicyController::class, 'index'])
            ->name('time-policy.index');

        Route::post('/time-policy', [LoginTimePolicyController::class, 'store'])
            ->name('time-policy.store');
    });


Route::middleware(['auth', 'role:Super Admin'])
    ->name('admin.')
    ->group(function () {

        Route::get('/login-exceptions', [LoginTimeExceptionController::class, 'index'])
            ->name('login-exceptions.index');

        Route::post('/login-exceptions', [LoginTimeExceptionController::class, 'store'])
            ->name('login-exceptions.store');

        Route::put('/login-exceptions/{exception}', [LoginTimeExceptionController::class, 'update'])
            ->name('login-exceptions.update');

        Route::patch('/login-exceptions/{exception}/toggle', [LoginTimeExceptionController::class, 'toggle'])
            ->name('login-exceptions.toggle');
    });



Route::controller(BusinessLocationController::class)
    ->middleware(['auth', 'verified', 'isSetRole', 'manage_vendor'])->group(function () {
        Route::get('/location', 'index');
        Route::post('/add-location', 'addLocation');
        Route::post('/edit-location-{id}', 'editLocation');
        Route::get('delete-location-{id}', 'deleteLocation');
        Route::get('ItemsOn-{id}', 'itemsOnShop');
    });

Route::controller(ShelfController::class)
    ->middleware(['auth', 'verified', 'isSetRole'])->group(function () {
        Route::get('/shelfs', 'index');
        Route::post('/add-shelf', 'addShelf');
        Route::post('/edit-shelf-{id}', 'editShelf');
        Route::get('delete-shelf-{id}', 'deleteShelf');
    });

Route::controller(ItemUnitController::class)
    ->middleware(['auth', 'verified', 'isSetRole'])->group(function () {
        Route::get('/item_unit', 'index');
        Route::post('/add-item_unit', 'addItemUnit');
        Route::post('/edit-item_unit-{id}', 'editItemUnit');
        Route::get('delete-item_unit-{id}', 'deleteItemUnit');
    });


Route::controller(DisposalController::class)
    ->middleware(['auth', 'verified', 'isSetRole'])->group(function () {
        Route::get('/disposals', 'index');
        Route::post('/add-disposal', 'addDisposal');
        Route::post('/edit-disposal-{id}', 'editDisposal');
        Route::get('delete-disposal-{id}', 'deleteDisposal');
    });

Route::controller(OwnerController::class)
    ->middleware(['auth', 'verified', 'isSetRole', 'manage_vendor'])->group(function () {
        Route::post('/add-owner', 'addOwner');
        Route::post('/edit-owner-{id}', 'editOwner');
        Route::get('delete-owner-{id}', 'deleteOwner');
    });

Route::controller(ItemController::class)
    ->middleware(['auth', 'verified', 'isSetRole', 'manage_item'])->group(function () {
        Route::get('/items', 'index');
        Route::post('/add-item', 'addItem');
        Route::post('/edit-item-{id}', 'editItem');
        Route::get('delete-item-{id}', 'deleteItem');
        Route::post('search-item', 'searchItem');
    });

Route::controller(BatchController::class)
    ->middleware(['auth', 'verified', 'isSetRole', 'manage_item'])->group(function () {
        Route::get('/batchs-{id}', 'index');
        Route::post('/add-batchs', 'addBatch');
        Route::post('/edit-batchs-{id}', 'editBatchs');
        Route::get('delete-batchs-{id}', 'deleteBatchs');
        Route::get('/get-batches/{item_id}', 'getBatches');
    });
Route::get('/get-batches/{itemId}', [GoodReceivingController::class, 'getBatches']);


Route::controller(ItemShelfController::class)
    ->middleware(['auth', 'verified', 'isSetRole', 'manage_item'])->group(function () {
        Route::get('/itemShelf-{id}', 'index');
        Route::post('/add-itemShelf', 'addItemShelf');
        Route::get('delete-itemShelf-{id}', 'deleteItemShelf');
    });


Route::controller(CategoryController::class)
    ->middleware(['auth', 'verified', 'isSetRole'])->group(function () {
        Route::get('/category', 'index');
        Route::post('/add-category', 'addCategory');
        Route::post('/edit-category-{id}', 'editCategory');
        Route::get('delete-category-{id}', 'deleteCategory');
    });

Route::controller(CustomerController::class)
    ->middleware(['auth', 'verified', 'isSetRole', 'manage_customer'])->group(function () {
        Route::get('customers', 'index');
        Route::get('creditCustomers', 'creditSales');
        Route::post('add-customer', 'addCustomer');
        Route::post('edit-customer-{id}', 'editCustomer');
        Route::post('search-customer', 'searchCustomer');
        Route::get('delete-customer-{id}', 'deleteCustomer');
    });

Route::controller(VendorController::class)
    ->middleware(['auth', 'verified', 'isSetRole', 'manage_item'])->group(function () {
        Route::get('vendors', 'index');
        Route::post('add-vendor', 'addVendor');
        Route::post('edit-vendor-{id}', 'editVendor');
        Route::post('search-vendor', 'searchVendor');
        Route::get('delete-vendor-{id}', 'deleteVendor');
    });

Route::controller(OpeningBalanceController::class)
    ->middleware(['auth', 'verified', 'isSetRole', 'manage_item'])->group(function () {
        Route::get('set_opening_balance-{id}', 'index');
        Route::post('add-Opening_balance', 'addOpening_balance');
        Route::post('edit-Opening_balance-{id}', 'editOpening_balance');
        Route::post('search-Opening_balance', 'searchOpening_balance');
        Route::get('delete-Opening_balance-{id}', 'deleteOpening_balance');
    });

Route::controller(PurchaseOrderController::class)
    ->middleware(['auth', 'verified', 'isSetRole', 'manage_purchase'])->group(function () {
        Route::get('purchase-orders', 'index');
        Route::post('add-purchase-order', 'addPurchaseOrder');
        Route::post('edit-purchase-order-{id}', 'editPurchaseOrder');
        Route::post('search-purchase-order', 'searchPurchaseOrders');
        Route::get('delete-purchase-order-{id}', 'deletePurchaseOrders');
        Route::post('editPurchaseOrder-{id}', 'editPurchaseOrder');
        Route::get('purcahsePayments-{id}', 'purchsePayments');
        Route::post('purchasePayment-{owner_id}-{vendor_id}', 'purchasePayment');
        Route::post('/editPurchasePayment-{id}', 'editPurchasePayment');
        Route::get('deletePurchasePayment-{id}', 'deletePurchasePayment');
        Route::get('vendorPurchaseHistory-{id}', 'vendorPurchaseHistory');
    });

Route::controller(GoodReceivingController::class)
    ->middleware(['auth', 'verified', 'isSetRole'])->group(function () {
        Route::post('import', 'import')->name('good-receivings.import');
        Route::get('good-receiving', 'index');
        Route::post('add-good-receiving', 'addGoodReceiving');
        Route::post('edit-good-receiving-{id}', 'editGoodReceiving');
        Route::get('delete-good-receiving-{id}', 'deleteGoodReceivings');
    });
Route::controller(PurchasePlanController::class)
    ->middleware(['auth', 'verified', 'isSetRole'])->group(function () {
        Route::get('purchase_plan', 'index');
        Route::get('planned_item', 'plannedItem');
        Route::get('delete-plans-{id}', 'deletePlans');
        Route::post('move-{id}', 'move')->name('purchase-plan.move');
    });

// Route::post('/good-receivings/import', [GoodReceivingController::class, 'import'])->name('good-receivings.import');
Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity.logs');
Route::controller(SalesOrderController::class)
    ->middleware(['auth', 'verified', 'isSetRole', 'manage_sales'])->group(function () {
        Route::get('sales-order', 'index');
        Route::get('addsales', 'create');
        Route::get('editsales-{id}', 'edit');
        Route::post('add-sales-order', 'addSalesOrder');
        Route::post('edit-sales-order-{id}', 'editSalesOrder');
        Route::post('search-sales-order', 'searchSalesOrders');
        Route::get('delete-sales-order-{id}', 'deleteSalesOrders');
        Route::post('getItemForSale', 'getItemForSale');
        Route::post('e_getItemForSale', 'e_getItemForSale');
        Route::post('xgetItemForSale', 'xgetItemForSale');
        Route::get('sales-invoice-{id}', 'printSalesInvoice');
        Route::get('unpaid-sales', 'unpaidSales');
        Route::get('acceptIssue-{id}', 'acceptIssue');
        Route::get('customerSalesHitory-{id}', 'customerSalesHitory')->middleware('customer_history');
        Route::post('add-sales-order-from-shop', 'addSalesOrderFromShop');
    });

Route::controller(PaymentLedgerController::class)
    ->middleware(['auth', 'verified', 'isSetRole', 'approval'])->group(function () {
        Route::get('/payment', 'index');
        Route::get('/purchase-payment', 'purchasePayment');
        Route::get('customerPayments-{id}', 'customerPayments')->middleware('customer_history');
        Route::post('editCustomerPayment-{id}', 'editCustomerPayment')->middleware('customer_history');
        Route::post('/Payment-{id}', 'payment');
        Route::post('bank', 'addNewBank');
        Route::get('payment approval', 'paymentApproval');
        Route::get('payment approval-{id}', 'approvePayment');
        Route::get('payment reject-{id}', 'rejectPayment');
    });



// Route::controller(SalesPaymentController::class)
// ->middleware(['auth','verified'])->group(function(){
//     Route::get('/payments','index');
//     Route::post('salesPayment-{order_id}-{customer_id}-{location_id}','addSalesPayment');
//     Route::post('/editSalesPayment-{id}','editSalesPayment');
//     Route::get('/deleteSalesPayment-{id}','deleteSalesPayment');
//     Route::get('/ customer-history-{id}','customerSalesHistory');
// });

Route::controller(StoreController::class)
    ->middleware(['auth', 'verified', 'isSetRole', 'manage_sales_order'])->group(function () {
        Route::get('orders-to-approve', 'index');
        Route::get('acceptOrder-{id}', 'acceptOrder');
        Route::post('regect-order-{id}', 'regectOrder');
    });

Route::controller(StoreController::class)
    ->middleware([])->group(function () {
        Route::get('fromTelegramAcceptOrder/{id}/{chat_id}/{token}/{rfn}', 'telegramAcceptOrder');
        Route::get('fromTelegramRejectOrder/{id}/{chat_id}/{token}/{rfn}', 'telegramRejectOrder');
    });

Route::controller(ItemTransferController::class)
    ->middleware(['auth', 'verified', 'isSetRole', 'manage_sales_order'])->group(function () {
        Route::get('transfer-requisition', 'requisites');
        Route::post('requisition', 'store');
        Route::get('approve-requisition', 'approveRequisition');
        Route::get('approveRequisition/{id}/{user}', 'approve');
        Route::get('requisition-issue', 'issueRequisition');
        Route::post('issueRequisition/{id}', 'issueRequisitionSave');
        Route::get('delete-requisition-{id}', 'deleteRequisition');
        Route::get('transfer-print-{id}', 'printRequisition');
    });

Route::controller(IssuingController::class)
    ->middleware(['auth', 'verified', 'isSetRole', 'store_issue'])->group(function () {
        Route::get('issuing-item', 'index');
        Route::post('add-issuing-item', 'addIssuing');
        Route::get("issue-{id}", 'printIssue');
        Route::get('delete-issuing-{id}', 'deleteIssuing');
        Route::post('getItemOwnerBalance', 'getItemOwnerBalance');
        Route::post('getItemForIssue', 'getItemForIssue');
        Route::post('add-issuing-{id}', 'addOrderIssuing');
        Route::get('returnIssue-{id}', 'returnIssue');
    });

Route::controller(UserController::class)
    ->middleware(['auth', 'verified', 'isSetRole', 'manage_user'])->group(function () {
        Route::get('users', 'index');
        Route::post('add-user', 'addUser');
        Route::post('editUser-{id}', 'editUser');
        Route::get('delete-user-{id}', 'deleteUser');
    });


Route::controller(ItemReturnController::class)
    ->middleware(['auth', 'verified', 'isSetRole'])->group(function () {
        Route::get('sales-return-{id}', 'index');
        Route::post('customReturn-{id}', 'customReturn');
    });

Route::controller(RoleController::class)
    ->middleware(['auth', 'verified', 'isSetRole'])->group(function () {
        Route::post('add-role', 'AddRole');
        Route::post('edit-role-{id}', 'editRole');
        Route::get('delete-role-{id}', 'deleteRole');
        Route::post('set-role-{id}', 'setRole');
    });

Route::controller(ReportController::class)
    ->middleware(['auth', 'verified', 'isSetRole'])->group(function () {
        Route::get('inventory-reports', 'index');
        Route::get('stock_reports', 'stockReport');
        Route::get('shopStock_reports', 'shopStockReport');
        // Route::match(['get', 'post'], 'daily-sales-report', 'dailySalesReport')->name('reports.dailySales');

        Route::get('transfer_shop_reports', 'transferShopReport')->name('reports.transferShop');
        Route::get('transfer_warehouse_reports', 'transferWarehouseReport')->name('reports.transferWarehouse');

        Route::get('daily-customer-report', 'dailyCustomerReport');
        Route::post('daily-customer-report', 'dailyCustomerReportByDate');


        Route::get('customerPerformance', 'customerPerformance');
        Route::post('customerPerformance', 'customerPerformanceByDate');
    });



Route::match(['get', 'post'], 'daily-sales-report', [ReportController::class, 'dailySalesReport'])
    ->middleware(['auth', 'verified', 'isSetRole'])
    ->name('reports.dailySales');

Route::match(['get', 'post'], 'good_receiving_report', [ReportController::class, 'goodReceivingReport'])
    ->middleware(['auth', 'verified', 'isSetRole'])
    ->name('reports.goodReceiving');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

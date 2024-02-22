<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::group([
    'middleware' => [
        'auth',
        'can:admin',
    ],
], function () {

    Route::get('/tokens/create', function (Request $request) {
        $token = $request->user()->createToken('pbx');
        return ['token' => $token->plainTextToken];
    });

    //export
    Route::get('/export/material', [App\Http\Controllers\MaterialController::class, 'export'])->name('material.export');
    Route::get('/export/packaging', [App\Http\Controllers\PackagingController::class, 'export'])->name('packaging.export');
    Route::get('/export/product', [App\Http\Controllers\ProductController::class, 'export'])->name('product.export');
    Route::get('/export/supply', [App\Http\Controllers\SupplyController::class, 'export'])->name('supply.export');

    //master
    Route::get('/user', [App\Http\Controllers\UserController::class, 'list'])->name('user');
    Route::get('/employee', [App\Http\Controllers\EmployeeController::class, 'list'])->name('employee');
    Route::get('/material', [App\Http\Controllers\MaterialController::class, 'list'])->name('material');
    Route::get('/category', [App\Http\Controllers\CategoryController::class, 'list'])->name('category');
    Route::get('/company', [App\Http\Controllers\CompanyController::class, 'list'])->name('company');
    Route::get('/packaging', [App\Http\Controllers\PackagingController::class, 'list'])->name('package');
    Route::get('/role', [App\Http\Controllers\RoleController::class, 'list'])->name('role');
    Route::get('/supply', [App\Http\Controllers\SupplyController::class, 'list'])->name('supply');
    Route::get('/inspect-topic', [\App\Http\Controllers\InspectTopicController::class, "list"])->name('inspect.topic');
    Route::get('/inspect-template', [\App\Http\Controllers\InspectTemplateController::class, "list"])->name('inspect.template');
    Route::get('/inspect-template-details', [\App\Http\Controllers\InspectTemplateDetailController::class, "list"])->name('inspect.template.details');
    Route::get('/inspect-template-details/{id}', [\App\Http\Controllers\InspectTemplateController::class, "viewInspectTemplateDetail"])->name('inspect.template.detail.id');
    Route::get('/vehicle', [App\Http\Controllers\VehicleController::class, 'list'])->name('vehicle');
    Route::get('/view-vendor', [App\Http\Controllers\VendorController::class, 'list'])->name('vendor');
    Route::get('/material-unit', [App\Http\Controllers\MaterialUnitController::class, 'list'])->name('material.unit');
    Route::get('/product-unit', [App\Http\Controllers\ProductUnitController::class, 'list'])->name('product.unit');
    Route::get('/packaging-type', [App\Http\Controllers\PackagingUnitController::class, 'list'])->name('packaging.type');
    Route::get('/unit', [App\Http\Controllers\UnitController::class, 'list'])->name('unit');
    Route::get('/prefix', [App\Http\Controllers\PrefixController::class, 'list'])->name('prefix');
    Route::get('/product', [App\Http\Controllers\ProductController::class, 'list'])->name('product');
    Route::get('/cosmetics', [App\Http\Controllers\CosmeticsController::class, 'list'])->name('cosmetics');
    Route::get('/supplement', [App\Http\Controllers\SupplementController::class, 'list'])->name('supplement');

    //--รับเข้าวัตถุดิบ
    Route::get('/material/receive', [App\Http\Controllers\ReceiveMaterialController::class, 'viewStock'])->name('stock');
    Route::get('/material/receive/create', [\App\Http\Controllers\ReceiveMaterialController::class, 'viewCreateReceiveMaterial'])->name('receive.material.create');
    Route::get('/material/receive/edit/{id}', [\App\Http\Controllers\ReceiveMaterialController::class, 'viewEditReceiveMaterial'])->name('receive.material.edit');
    Route::get('/material/receive/history/{id}', [\App\Http\Controllers\ReceiveMaterialController::class, 'viewHistoryEditReceiveMaterial'])->name('receive.material.history');
    Route::get('/material/inspect/receive', [App\Http\Controllers\ReceiveMaterialController::class, 'checkImportStock'])->name('check.import.material.stock');
    Route::get('/material/inspect/receive/quality/view/{id}', [\App\Http\Controllers\ReceiveMaterialController::class, 'viewCheckMaterial'])->name('receive.material.view.check.material');
    Route::get('/material/inspect/receive/transport/view/{id}', [\App\Http\Controllers\ReceiveMaterialController::class, 'viewCheckVehicle'])->name('receive.material.view.check.vehicle');
    Route::post('/material/inspect/receive/save', [\App\Http\Controllers\MaterialInspectController::class, 'saveData'])->name('receive.material.check.save');
    Route::get('/material/receive/master', [App\Http\Controllers\ReceiveMaterialController::class, 'viewMasterReceiveMaterial'])->name('receive.material.master');
    Route::get('/material/update/lot-no-pm', [App\Http\Controllers\ReceiveMaterialController::class, 'viewLotNoPMReceiveMaterial'])->name('receive.material.lot.no.pm');
    Route::get('/material/pending/receive', [App\Http\Controllers\ReceiveMaterialController::class, 'viewSendtoReceiveMaterial'])->name('send.to.receive.material');
    Route::get('/material/receive/print', [App\Http\Controllers\ReceiveMaterialController::class, 'print'])->name('print.receive.material');
    Route::get('/material/lot-no-pm/print', [App\Http\Controllers\ReceiveMaterialController::class, 'printGenLot'])->name('print.lot.no.pm.material');

    //--เบิกวัตถุดิบ
    Route::get('/material/requsition', [\App\Http\Controllers\RequsitionMaterialController::class, 'listViewRequsitionMaterial'])->name('requsition.material');
    Route::get('/material/requsition/create', [\App\Http\Controllers\RequsitionMaterialController::class, 'viewCreateRequsitionMaterial'])->name('requsition.material.create');
    Route::get('/material/requsition/edit/{id}', [\App\Http\Controllers\RequsitionMaterialController::class, 'viewEditRequsitionMaterial'])->name('requsition.material.edit');
    Route::get('/material/requsition/history/{id}', [\App\Http\Controllers\RequsitionMaterialController::class, 'viewHistoryRequsitionMaterial'])->name('requsition.material.history');
    Route::get('/material/inspect/requsition', [App\Http\Controllers\RequsitionMaterialController::class, 'viewListInspectRequsitionMaterial'])->name('check.requsition.product.stock');
    Route::get('/material/inspect/return/requsition/material', [App\Http\Controllers\RequsitionMaterialController::class, 'viewInspectReturnRequsitionMaterial'])->name('check.requsition.return.material');
    Route::get('/material/history/requsition', [App\Http\Controllers\RequsitionMaterialController::class, 'viewHistoryMasterRequsitionMaterial'])->name('history.requsition.material');
    Route::get('/material/pending/requsition', [\App\Http\Controllers\RequsitionMaterialController::class, 'listPendingRequsitionMaterial'])->name('pending.requsition.material');

    //--คืนวัตถุดิบ
    Route::get('/material/return', [\App\Http\Controllers\RequsitionMaterialController::class, 'viewReturnRequsitionMaterial'])->name('requsition.material.return');
    Route::get('/material/return/create/{id}', [\App\Http\Controllers\RequsitionMaterialController::class, 'viewCreateReturnMaterial'])->name('requsition.material.return.create');
    Route::get('/material/pending/return/requsition', [\App\Http\Controllers\RequsitionMaterialController::class, 'listPendingReturnRequsitionMaterial'])->name('pending.requsition.return.material');

    //--รับเข้าบรรจุภัณฑ์
    Route::get('/packaging/receive', [\App\Http\Controllers\ReceivePackagingController::class, 'viewListPackaging'])->name('packaging');
    Route::get('/packaging/receive/create', [\App\Http\Controllers\ReceivePackagingController::class, 'viewCreate'])->name('receive.packaging.create');
    Route::get('/packaging/receive/edit/{id}', [\App\Http\Controllers\ReceivePackagingController::class, 'viewEditReceivePackaging'])->name('receive.packaging.edit');
    Route::get('/packaging/receive/history/{id}', [\App\Http\Controllers\ReceivePackagingController::class, 'viewHistoryEditReceivePackaging'])->name('receive.packaging.history');
    Route::get('/packaging/inspect/receive', [App\Http\Controllers\ReceivePackagingController::class, 'checkReceivePackaging'])->name('check.import.packaging.stock');
    Route::get('/packaging/inspect/receive/quality/view/{id}', [\App\Http\Controllers\ReceivePackagingController::class, 'viewCheckVehicle'])->name('receive.packaging.view.check.vehicle');
    Route::get('/packaging/inspect/receive/transport/view/{id}', [\App\Http\Controllers\ReceivePackagingController::class, 'viewCheckPackaging'])->name('receive.packaging.view.check.packaging');
    Route::post('/packaging/inspect/receive/save', [\App\Http\Controllers\PackagingInspectController::class, 'saveData'])->name('receive.packaging.check.save');
    Route::get('/packaging/update/lot-no-pm', [App\Http\Controllers\ReceivePackagingController::class, 'viewLotNoPMReceivePackaging'])->name('receive.packaging.lot.no.pm');
    Route::get('/packaging/pending/receive', [\App\Http\Controllers\ReceivePackagingController::class, 'viewPendingReceivePackaging'])->name('packaging.pending');
    Route::get('/packaging/history/receive', [\App\Http\Controllers\ReceivePackagingController::class, 'viewHistoryReceivePackaging'])->name('packaging.history');

    //--เบิกบรรจุภัณฑ์
    Route::get('/packaging/requsition', [\App\Http\Controllers\RequsitionPackagingController::class, 'listViewRequsitionPackaging'])->name('requsition.packaging');
    Route::get('/packaging/requsition/create', [\App\Http\Controllers\RequsitionPackagingController::class, 'viewCreateRequsitionPackaging'])->name('requsition.packaging.create');
    Route::get('/packaging/requsition/edit/{id}', [\App\Http\Controllers\RequsitionPackagingController::class, 'viewEditRequsitionPackaging'])->name('requsition.packaging.edit');
    Route::get('/packaging/requsition/history/{id}', [\App\Http\Controllers\RequsitionPackagingController::class, 'viewHistoryRequsitionPackaging'])->name('requsition.packaging.history');
    Route::get('/packaging/inspect/requsition', [App\Http\Controllers\RequsitionPackagingController::class, 'viewcheckRequsitionPackaging'])->name('check.requsition.packaging.stock');
    Route::get('/packaging/pending/requsition', [\App\Http\Controllers\RequsitionPackagingController::class, 'listPendingRequsitionPackaging'])->name('pending.requsition.packaging');

    //--คืนบรรจุภัณฑ์
    Route::get('/packaging/claim', [App\Http\Controllers\RequsitionPackagingController::class, 'viewclaimRequsitionPackaging'])->name('view.requsition.packaging.claim');
    Route::get('/packaging/return', [App\Http\Controllers\RequsitionPackagingController::class, 'viewReturnRequsitionPackaging'])->name('check.requsition.packaging.stock');
    Route::get('/packaging/inspect/return/requsition/packaging', [App\Http\Controllers\RequsitionPackagingController::class, 'viewInspectReturnRequsitionPackaging'])->name('check.requsition.return.packaging');
    Route::get('/packaging/history/requsition', [App\Http\Controllers\RequsitionPackagingController::class, 'viewHistoryMasterRequsitionPackaging'])->name('history.requsition.packaging');
    Route::get('/packaging/return/create/{id}', [App\Http\Controllers\RequsitionPackagingController::class, 'viewCreateReturnPackaging'])->name('requsition.packaging.return.create');
    Route::get('/packaging/pending/return/requsition', [\App\Http\Controllers\RequsitionPackagingController::class, 'listPendingReturnRequsitionPackaging'])->name('pending.requsition.return.packaging');


    //--รับเข้าสินค้าสำเร็จรูป
    Route::get('/product/receive', [\App\Http\Controllers\ReceiveProductController::class, 'viewListProduct'])->name('receive.product');
    Route::get('/product/receive/create', [\App\Http\Controllers\ReceiveProductController::class, 'viewCreateReceiveProduct'])->name('receive.product.create');
    Route::get('/product/receive/edit/{id}', [\App\Http\Controllers\ReceiveProductController::class, 'viewEditReceiveProduct'])->name('receive.product.edit');
    Route::get('/product/receive/history/{id}', [\App\Http\Controllers\ReceiveProductController::class, 'viewHistoryEditReceiveProduct'])->name('receive.product.history');
    Route::get('/product/pending/receive', [\App\Http\Controllers\ReceiveProductController::class, 'viewPendingReceiveProduct'])->name('receive.product.pending');
    Route::get('/product/history/receive', [\App\Http\Controllers\ReceiveProductController::class, 'viewHistoryReceiveProduct'])->name('list.history.receive.product');
    Route::get('/product/inspect/receive', [App\Http\Controllers\ReceiveProductController::class, 'checkReceiveProduct'])->name('check.import.product.stock');
    Route::get('/product/inspect/receive/quality/view/{id}', [\App\Http\Controllers\ReceiveProductController::class, 'viewCheckProduct'])->name('receive.product.view.check.product');
    Route::post('/product/inspect/receive/save', [\App\Http\Controllers\ProductInspectController::class, 'saveData'])->name('receive.product.check.save');

    //--ส่งออกสินค้าสำเร็จรูป
    Route::get('/product/requsition', [App\Http\Controllers\RequsitionProductController::class, 'viewListRequsitionProduct'])->name('list.requsition.product');
    Route::get('/product/inspect/requsition', [App\Http\Controllers\RequsitionProductController::class, 'viewListRequsitionInspectProduct'])->name('list.requsition.product.inspect');
    Route::get('/product/pending/requsition', [App\Http\Controllers\RequsitionProductController::class, 'viewListRequsitionPendingProduct'])->name('list.requsition.product.pending');
    Route::get('/product/history/requsition', [App\Http\Controllers\RequsitionProductController::class, 'viewListRequsitionHistoryProduct'])->name('list.requsition.product.history');
    Route::get('/product/requsition/create', [\App\Http\Controllers\RequsitionProductController::class, 'viewCreateRequsitionProduct'])->name('requsition.product.create');
    Route::get('/product/requsition/edit/{id}', [\App\Http\Controllers\RequsitionProductController::class, 'viewEditRequsitionProduct'])->name('requsition.product.edit');
    // Route::get('/product/history/requsition', [App\Http\Controllers\RequsitionProductController::class, 'viewListHistoryRequsitionProduct'])->name('list.history.requsition.product');
    Route::get('/product/requsition/history/{id}', [\App\Http\Controllers\RequsitionProductController::class, 'viewHistoryEditRequsitionProduct'])->name('requsition.product.history');


    // รับเข้าวัสดุสิ้นเปลือง
    Route::get('/supply/receive', [App\Http\Controllers\ReceiveSupplyController::class, 'viewListReceiveSupply'])->name('list.receive.supply');
    Route::get('/supply/receive/create', [\App\Http\Controllers\ReceiveSupplyController::class, 'viewCreateReceiveSupply'])->name('receive.supply.create');
    Route::get('/supply/receive/edit/{id}', [\App\Http\Controllers\ReceiveSupplyController::class, 'viewEditReceiveSupply'])->name('receive.supply.edit');
    Route::get('/supply/receive/history/{id}', [\App\Http\Controllers\ReceiveSupplyController::class, 'viewHistoryEditReceiveSupply'])->name('receive.supply.history');
    Route::get('/supply/pending', [App\Http\Controllers\ReceiveSupplyController::class, 'viewListPendingReceiveSupply'])->name('list.pending.receive.supply');
    Route::get('/supply/history/receive', [App\Http\Controllers\ReceiveSupplyController::class, 'viewListHistoryReceiveSupply'])->name('list.history.receive.supply');

    // เบิกวัสดุสิ้นเปลือง
    Route::get('/supply/requsition', [App\Http\Controllers\RequsitionSupplyController::class, 'viewListRequsitionSupply'])->name('list.requsition.supply');
    Route::get('/supply/history/requsition', [App\Http\Controllers\RequsitionSupplyController::class, 'viewListHistoryRequsitionSupply'])->name('list.history.requsition.supply');
    Route::get('/supply/requsition/create', [\App\Http\Controllers\RequsitionSupplyController::class, 'viewCreateRequsitionSupply'])->name('requsition.supply.create');
    Route::get('/supply/requsition/edit/{id}', [\App\Http\Controllers\RequsitionSupplyController::class, 'viewEditRequsitionSupply'])->name('requsition.supply.edit');
    Route::get('/supply/requsition/history/{id}', [\App\Http\Controllers\RequsitionSupplyController::class, 'viewHistoryEditRequsitionSupply'])->name('requsition.supply.history');

    // รายการคงคลัง
    Route::get('/inventory/material/list', [App\Http\Controllers\InventoryController::class, 'inventoryMaterial'])->name('inventory.material');
    Route::post('/inventory/material/chart', [App\Http\Controllers\InventoryController::class, 'inventoryMaterialChart'])->name('inventory.meterial.chart');
    Route::get('/inventory/packaging/list', [App\Http\Controllers\InventoryController::class, 'inventoryPackaging'])->name('inventory.packaging');
    Route::post('/inventory/packaging/chart', [App\Http\Controllers\InventoryController::class, 'inventoryPackagingChart'])->name('inventory.packaging.chart');
    Route::get('/inventory/product/list', [App\Http\Controllers\InventoryController::class, 'inventoryProduct'])->name('inventory.product');
    Route::post('/inventory/product/chart', [App\Http\Controllers\InventoryController::class, 'inventoryProductChart'])->name('inventory.product.chart');
    Route::get('/inventory/supply/list', [App\Http\Controllers\InventoryController::class, 'inventorySupply'])->name('inventory.supply');
    Route::post('/inventory/supply/chart', [App\Http\Controllers\InventoryController::class, 'inventorySupplyChart'])->name('inventory.supply.chart');

    Route::get('/inventory/material/test', [App\Http\Controllers\InventoryController::class, 'inventoryMaterialTest'])->name('inventory.material.test');
    Route::get('/inventory/packaging/test', [App\Http\Controllers\InventoryController::class, 'inventoryPackagingTest'])->name('inventory.packaging.test');
    Route::get('/inventory/product/test', [App\Http\Controllers\InventoryController::class, 'inventoryProductTest'])->name('inventory.product.test');
    Route::get('/inventory/supply/test', [App\Http\Controllers\InventoryController::class, 'inventorySupplyTest'])->name('inventory.supply.test');

    //report receive
    Route::get('/report/receive/material/list', [App\Http\Controllers\ReportController::class, 'reportReceiveMaterial'])->name('report.receive.material');
    Route::post('/report/receive/material/pdf', [App\Http\Controllers\ReportController::class, 'reportReceiveMaterialPDF'])->name('report.receive.material.pdf');
    Route::get('/report/receive/material/pdf/{id}', [App\Http\Controllers\ReportController::class, 'reportReceiveMaterialPdfOther'])->name('report.receive.material.pdf.other');

    Route::get('/report/receive/packaging/list', [App\Http\Controllers\ReportController::class, 'reportReceivePackaging'])->name('report.receive.packaging');
    Route::post('/report/receive/packaging/pdf', [App\Http\Controllers\ReportController::class, 'reportReceivePackagingPDF'])->name('report.receive.packaging.pdf');
    Route::get('/report/receive/packaging/pdf/{id}', [App\Http\Controllers\ReportController::class, 'reportReceivePackagingPdfOther'])->name('report.receive.packaging.pdf.other');

    Route::get('/report/receive/product/list', [App\Http\Controllers\ReportController::class, 'reportReceiveProduct'])->name('report.receive.product');
    Route::post('/report/receive/product/pdf', [App\Http\Controllers\ReportController::class, 'reportReceiveProductPDF'])->name('report.receive.product.pdf');
    Route::get('/report/receive/product/pdf/{id}', [App\Http\Controllers\ReportController::class, 'reportReceiveProductPdfOther'])->name('report.receive.product.pdf.other');

    Route::get('/report/receive/supply/list', [App\Http\Controllers\ReportController::class, 'reportReceiveSupply'])->name('report.receive.supply');
    Route::post('/report/receive/supply/pdf', [App\Http\Controllers\ReportController::class, 'reportReceiveSupplyPDF'])->name('report.receive.supply.pdf');
    Route::get('/report/receive/supply/pdf/{id}', [App\Http\Controllers\ReportController::class, 'reportReceiveSupplyPdfOther'])->name('report.receive.supply.pdf.other');

    //report requsition
    Route::get('/report/requsition/material/list', [App\Http\Controllers\ReportController::class, 'reportRequsitionMaterial'])->name('report.requsition.material');
    Route::post('/report/requsition/material/pdf/all', [App\Http\Controllers\ReportController::class, 'reportRequsitionMaterialPDF'])->name('report.requsition.material.pdf');
    Route::get('/report/requsition/material/pdf/{id}', [App\Http\Controllers\ReportController::class, 'reportRequsitionMaterialPdfOther'])->name('report.requsition.material.pdf.other');

    Route::get('/report/requsition/packaging/list', [App\Http\Controllers\ReportController::class, 'reportRequsitionPackaging'])->name('report.requsition.packaging');
    Route::post('/report/requsition/packaging/pdf/all', [App\Http\Controllers\ReportController::class, 'reportRequsitionPackagingPDF'])->name('report.requsition.packaging.pdf');
    Route::get('/report/requsition/packaging/pdf/{id}', [App\Http\Controllers\ReportController::class, 'reportRequsitionPackagingPdfOther'])->name('report.requsition.packaging.pdf.other');

    Route::get('/report/requsition/product/list', [App\Http\Controllers\ReportController::class, 'reportRequsitionProduct'])->name('report.requsition.product');
    Route::post('/report/requsition/product/pdf/all', [App\Http\Controllers\ReportController::class, 'reportRequsitionProductPDF'])->name('report.requsition.product.pdf');
    Route::get('/report/requsition/product/pdf/{id}', [App\Http\Controllers\ReportController::class, 'reportRequsitionProductPdfOther'])->name('report.requsition.product.pdf.other');

    Route::get('/report/requsition/supply/list', [App\Http\Controllers\ReportController::class, 'reportRequsitionSupply'])->name('report.requsition.supply');
    Route::post('/report/requsition/supply/pdf/all', [App\Http\Controllers\ReportController::class, 'reportRequsitionSupplyPDF'])->name('report.requsition.supply.pdf');
    Route::get('/report/requsition/supply/pdf/{id}', [App\Http\Controllers\ReportController::class, 'reportRequsitionSupplyPdfOther'])->name('report.requsition.supply.pdf.other');
});

Route::group([
    'middleware' => [
        'auth',
        'can:material',
    ],
], function () {
    //--รับเข้าวัตถุดิบ
    Route::get('/material/receive', [App\Http\Controllers\ReceiveMaterialController::class, 'viewStock'])->name('stock');
    Route::get('/material/receive/create', [\App\Http\Controllers\ReceiveMaterialController::class, 'viewCreateReceiveMaterial'])->name('receive.material.create');
    Route::get('/material/receive/edit/{id}', [\App\Http\Controllers\ReceiveMaterialController::class, 'viewEditReceiveMaterial'])->name('receive.material.edit');
    Route::get('/material/receive/history/{id}', [\App\Http\Controllers\ReceiveMaterialController::class, 'viewHistoryEditReceiveMaterial'])->name('receive.material.history');
    Route::get('/material/inspect/receive', [App\Http\Controllers\ReceiveMaterialController::class, 'checkImportStock'])->name('check.import.material.stock');
    Route::get('/material/inspect/receive/quality/view/{id}', [\App\Http\Controllers\ReceiveMaterialController::class, 'viewCheckMaterial'])->name('receive.material.view.check.material');
    Route::get('/material/inspect/receive/transport/view/{id}', [\App\Http\Controllers\ReceiveMaterialController::class, 'viewCheckVehicle'])->name('receive.material.view.check.vehicle');
    Route::post('/material/inspect/receive/save', [\App\Http\Controllers\MaterialInspectController::class, 'saveData'])->name('receive.material.check.save');
    Route::get('/material/receive/master', [App\Http\Controllers\ReceiveMaterialController::class, 'viewMasterReceiveMaterial'])->name('receive.material.master');
    Route::get('/material/update/lot-no-pm', [App\Http\Controllers\ReceiveMaterialController::class, 'viewLotNoPMReceiveMaterial'])->name('receive.material.lot.no.pm');
    Route::get('/material/pending/receive', [App\Http\Controllers\ReceiveMaterialController::class, 'viewSendtoReceiveMaterial'])->name('send.to.receive.material');

    //--เบิกวัตถุดิบ
    Route::get('/material/requsition', [\App\Http\Controllers\RequsitionMaterialController::class, 'listViewRequsitionMaterial'])->name('requsition.material');
    Route::get('/material/requsition/create', [\App\Http\Controllers\RequsitionMaterialController::class, 'viewCreateRequsitionMaterial'])->name('requsition.material.create');
    Route::get('/material/requsition/edit/{id}', [\App\Http\Controllers\RequsitionMaterialController::class, 'viewEditRequsitionMaterial'])->name('requsition.material.edit');
    Route::get('/material/requsition/history/{id}', [\App\Http\Controllers\RequsitionMaterialController::class, 'viewHistoryRequsitionMaterial'])->name('requsition.material.history');
    Route::get('/material/inspect/requsition', [App\Http\Controllers\RequsitionMaterialController::class, 'viewListInspectRequsitionMaterial'])->name('check.requsition.product.stock');
    Route::get('/material/inspect/return/requsition/material', [App\Http\Controllers\RequsitionMaterialController::class, 'viewInspectReturnRequsitionMaterial'])->name('check.requsition.return.material');
    Route::get('/material/history/requsition', [App\Http\Controllers\RequsitionMaterialController::class, 'viewHistoryMasterRequsitionMaterial'])->name('history.requsition.material');
    Route::get('/material/pending/requsition', [\App\Http\Controllers\RequsitionMaterialController::class, 'listPendingRequsitionMaterial'])->name('pending.requsition.material');

    //--คืนวัตถุดิบ
    Route::get('/material/return', [\App\Http\Controllers\RequsitionMaterialController::class, 'viewReturnRequsitionMaterial'])->name('requsition.material.return');
    Route::get('/material/return/create/{id}', [\App\Http\Controllers\RequsitionMaterialController::class, 'viewCreateReturnMaterial'])->name('requsition.material.return.create');
    Route::get('/material/pending/return/requsition', [\App\Http\Controllers\RequsitionMaterialController::class, 'listPendingReturnRequsitionMaterial'])->name('pending.requsition.return.material');
});

Route::group([
    'middleware' => [
        'auth',
        'can:packagingsupply',
    ],
], function () {
    //--รับเข้าบรรจุภัณฑ์
    Route::get('/packaging/receive', [\App\Http\Controllers\ReceivePackagingController::class, 'viewListPackaging'])->name('packaging');
    Route::get('/packaging/receive/create', [\App\Http\Controllers\ReceivePackagingController::class, 'viewCreate'])->name('receive.packaging.create');
    Route::get('/packaging/receive/edit/{id}', [\App\Http\Controllers\ReceivePackagingController::class, 'viewEditReceivePackaging'])->name('receive.packaging.edit');
    Route::get('/packaging/receive/history/{id}', [\App\Http\Controllers\ReceivePackagingController::class, 'viewHistoryEditReceivePackaging'])->name('receive.packaging.history');
    Route::get('/packaging/inspect/receive', [App\Http\Controllers\ReceivePackagingController::class, 'checkReceivePackaging'])->name('check.import.packaging.stock');
    Route::get('/packaging/inspect/receive/quality/view/{id}', [\App\Http\Controllers\ReceivePackagingController::class, 'viewCheckVehicle'])->name('receive.packaging.view.check.vehicle');
    Route::get('/packaging/inspect/receive/transport/view/{id}', [\App\Http\Controllers\ReceivePackagingController::class, 'viewCheckPackaging'])->name('receive.packaging.view.check.packaging');
    Route::post('/packaging/inspect/receive/save', [\App\Http\Controllers\PackagingInspectController::class, 'saveData'])->name('receive.packaging.check.save');
    Route::get('/packaging/update/lot-no-pm', [App\Http\Controllers\ReceivePackagingController::class, 'viewLotNoPMReceivePackaging'])->name('receive.packaging.lot.no.pm');
    Route::get('/packaging/pending/receive', [\App\Http\Controllers\ReceivePackagingController::class, 'viewPendingReceivePackaging'])->name('packaging.pending');
    Route::get('/packaging/history/receive', [\App\Http\Controllers\ReceivePackagingController::class, 'viewHistoryReceivePackaging'])->name('packaging.history');

    //--เบิกบรรจุภัณฑ์
    Route::get('/packaging/requsition', [\App\Http\Controllers\RequsitionPackagingController::class, 'listViewRequsitionPackaging'])->name('requsition.packaging');
    Route::get('/packaging/requsition/create', [\App\Http\Controllers\RequsitionPackagingController::class, 'viewCreateRequsitionPackaging'])->name('requsition.packaging.create');
    Route::get('/packaging/requsition/edit/{id}', [\App\Http\Controllers\RequsitionPackagingController::class, 'viewEditRequsitionPackaging'])->name('requsition.packaging.edit');
    Route::get('/packaging/requsition/history/{id}', [\App\Http\Controllers\RequsitionPackagingController::class, 'viewHistoryRequsitionPackaging'])->name('requsition.packaging.history');
    Route::get('/packaging/inspect/requsition', [App\Http\Controllers\RequsitionPackagingController::class, 'viewcheckRequsitionPackaging'])->name('check.requsition.packaging.stock');
    Route::get('/packaging/pending/requsition', [\App\Http\Controllers\RequsitionPackagingController::class, 'listPendingRequsitionPackaging'])->name('pending.requsition.packaging');

    //--คืนบรรจุภัณฑ์
    Route::get('/packaging/claim', [App\Http\Controllers\RequsitionPackagingController::class, 'viewclaimRequsitionPackaging'])->name('view.requsition.packaging.claim');
    Route::get('/packaging/return', [App\Http\Controllers\RequsitionPackagingController::class, 'viewReturnRequsitionPackaging'])->name('check.requsition.packaging.stock');
    Route::get('/packaging/inspect/return/requsition/packaging', [App\Http\Controllers\RequsitionPackagingController::class, 'viewInspectReturnRequsitionPackaging'])->name('check.requsition.return.packaging');
    Route::get('/packaging/history/requsition', [App\Http\Controllers\RequsitionPackagingController::class, 'viewHistoryMasterRequsitionPackaging'])->name('history.requsition.packaging');
    Route::get('/packaging/return/create/{id}', [App\Http\Controllers\RequsitionPackagingController::class, 'viewCreateReturnPackaging'])->name('requsition.packaging.return.create');
    Route::get('/packaging/pending/return/requsition', [\App\Http\Controllers\RequsitionPackagingController::class, 'listPendingReturnRequsitionPackaging'])->name('pending.requsition.return.packaging');

    // รับเข้าวัสดุสิ้นเปลือง
    Route::get('/supply/receive', [App\Http\Controllers\ReceiveSupplyController::class, 'viewListReceiveSupply'])->name('list.receive.supply');
    Route::get('/supply/receive/create', [\App\Http\Controllers\ReceiveSupplyController::class, 'viewCreateReceiveSupply'])->name('receive.supply.create');
    Route::get('/supply/receive/edit/{id}', [\App\Http\Controllers\ReceiveSupplyController::class, 'viewEditReceiveSupply'])->name('receive.supply.edit');
    Route::get('/supply/receive/history/{id}', [\App\Http\Controllers\ReceiveSupplyController::class, 'viewHistoryEditReceiveSupply'])->name('receive.supply.history');
    Route::get('/supply/pending', [App\Http\Controllers\ReceiveSupplyController::class, 'viewListPendingReceiveSupply'])->name('list.pending.receive.supply');
    Route::get('/supply/history/receive', [App\Http\Controllers\ReceiveSupplyController::class, 'viewListHistoryReceiveSupply'])->name('list.history.receive.supply');

    // เบิกวัสดุสิ้นเปลือง
    Route::get('/supply/requsition', [App\Http\Controllers\RequsitionSupplyController::class, 'viewListRequsitionSupply'])->name('list.requsition.supply');
    Route::get('/supply/history/requsition', [App\Http\Controllers\RequsitionSupplyController::class, 'viewListHistoryRequsitionSupply'])->name('list.history.requsition.supply');
    Route::get('/supply/requsition/create', [\App\Http\Controllers\RequsitionSupplyController::class, 'viewCreateRequsitionSupply'])->name('requsition.supply.create');
    Route::get('/supply/requsition/edit/{id}', [\App\Http\Controllers\RequsitionSupplyController::class, 'viewEditRequsitionSupply'])->name('requsition.supply.edit');
    Route::get('/supply/requsition/history/{id}', [\App\Http\Controllers\RequsitionSupplyController::class, 'viewHistoryEditRequsitionSupply'])->name('requsition.supply.history');
});

Route::group([
    'middleware' => [
        'auth',
        'can:finishproduct',
    ],
], function () {
    //--รับเข้าสินค้าสำเร็จรูป
    Route::get('/product/receive', [\App\Http\Controllers\ReceiveProductController::class, 'viewListProduct'])->name('receive.product');
    Route::get('/product/receive/create', [\App\Http\Controllers\ReceiveProductController::class, 'viewCreateReceiveProduct'])->name('receive.product.create');
    Route::get('/product/receive/edit/{id}', [\App\Http\Controllers\ReceiveProductController::class, 'viewEditReceiveProduct'])->name('receive.product.edit');
    Route::get('/product/receive/history/{id}', [\App\Http\Controllers\ReceiveProductController::class, 'viewHistoryEditReceiveProduct'])->name('receive.product.history');
    Route::get('/product/pending/receive', [\App\Http\Controllers\ReceiveProductController::class, 'viewPendingReceiveProduct'])->name('receive.product.pending');
    Route::get('/product/history/receive', [\App\Http\Controllers\ReceiveProductController::class, 'viewHistoryReceiveProduct'])->name('list.history.receive.product');
    Route::get('/product/inspect/receive', [App\Http\Controllers\ReceiveProductController::class, 'checkReceiveProduct'])->name('check.import.product.stock');
    Route::get('/product/inspect/receive/quality/view/{id}', [\App\Http\Controllers\ReceiveProductController::class, 'viewCheckProduct'])->name('receive.product.view.check.product');
    Route::post('/product/inspect/receive/save', [\App\Http\Controllers\ProductInspectController::class, 'saveData'])->name('receive.product.check.save');

    //--ส่งออกสินค้าสำเร็จรูป
    Route::get('/product/requsition', [App\Http\Controllers\RequsitionProductController::class, 'viewListRequsitionProduct'])->name('list.requsition.product');
    Route::get('/product/inspect/requsition', [App\Http\Controllers\RequsitionProductController::class, 'viewListRequsitionInspectProduct'])->name('list.requsition.product.inspect');
    Route::get('/product/pending/requsition', [App\Http\Controllers\RequsitionProductController::class, 'viewListRequsitionPendingProduct'])->name('list.requsition.product.pending');
    Route::get('/product/history/requsition', [App\Http\Controllers\RequsitionProductController::class, 'viewListRequsitionHistoryProduct'])->name('list.requsition.product.history');
    Route::get('/product/requsition/create', [\App\Http\Controllers\RequsitionProductController::class, 'viewCreateRequsitionProduct'])->name('requsition.product.create');
    Route::get('/product/requsition/edit/{id}', [\App\Http\Controllers\RequsitionProductController::class, 'viewEditRequsitionProduct'])->name('requsition.product.edit');
    // Route::get('/product/history/requsition', [App\Http\Controllers\RequsitionProductController::class, 'viewListHistoryRequsitionProduct'])->name('list.history.requsition.product');
    Route::get('/product/requsition/history/{id}', [\App\Http\Controllers\RequsitionProductController::class, 'viewHistoryEditRequsitionProduct'])->name('requsition.product.history');
});

Route::group([
    'middleware' => [
        'auth',
        'can:stockviewer',
    ],
], function () {
    // รายการคงคลัง
    Route::get('/inventory/material/list', [App\Http\Controllers\InventoryController::class, 'inventoryMaterial'])->name('inventory.material');
    Route::post('/inventory/material/chart', [App\Http\Controllers\InventoryController::class, 'inventoryMaterialChart'])->name('inventory.meterial.chart');

    // รายการคงคลัง
    Route::get('/inventory/packaging/list', [App\Http\Controllers\InventoryController::class, 'inventoryPackaging'])->name('inventory.packaging');
    Route::post('/inventory/packaging/chart', [App\Http\Controllers\InventoryController::class, 'inventoryPackagingChart'])->name('inventory.packaging.chart');

    // สินค้า
    Route::get('/inventory/product/list', [App\Http\Controllers\InventoryController::class, 'inventoryProduct'])->name('inventory.product');
    Route::post('/inventory/product/chart', [App\Http\Controllers\InventoryController::class, 'inventoryProductChart'])->name('inventory.product.chart');

    // วัสดุสิ้นเปลือง
    Route::get('/inventory/supply/list', [App\Http\Controllers\InventoryController::class, 'inventorySupply'])->name('inventory.supply');
    Route::post('/inventory/supply/chart', [App\Http\Controllers\InventoryController::class, 'inventorySupplyChart'])->name('inventory.supply.chart');
});

Route::group([
    'middleware' => [
        'auth',
        'can:qcmaterial',
    ],
], function () {
    // รับวัตถุดิบ
    Route::get('/material/inspect/receive', [App\Http\Controllers\ReceiveMaterialController::class, 'checkImportStock'])->name('check.import.material.stock');
    Route::get('/material/receive/master', [App\Http\Controllers\ReceiveMaterialController::class, 'viewMasterReceiveMaterial'])->name('receive.material.master');
    Route::get('/material/inspect/receive/quality/view/{id}', [\App\Http\Controllers\ReceiveMaterialController::class, 'viewCheckMaterial'])->name('receive.material.view.check.material');
    Route::get('/material/inspect/receive/transport/view/{id}', [\App\Http\Controllers\ReceiveMaterialController::class, 'viewCheckVehicle'])->name('receive.material.view.check.vehicle');
    // เบิกวัตถุดิบ
    // Route::get('/material/inspect/requsition', [App\Http\Controllers\RequsitionMaterialController::class, 'viewListInspectRequsitionMaterial'])->name('check.requsition.product.stock');
    // Route::get('/material/inspect/return/requsition/material', [App\Http\Controllers\RequsitionMaterialController::class, 'viewInspectReturnRequsitionMaterial'])->name('check.requsition.return.material');
    // Route::get('/material/history/requsition', [App\Http\Controllers\RequsitionMaterialController::class, 'viewHistoryMasterRequsitionMaterial'])->name('history.requsition.material');
});

Route::group([
    'middleware' => [
        'auth',
        'can:qcpackaging',
    ],
], function () {
    // รับวัตถุดิบ
    Route::get('/packaging/inspect/receive', [App\Http\Controllers\ReceivePackagingController::class, 'checkReceivePackaging'])->name('check.import.packaging.stock');
    Route::get('/packaging/history/receive', [\App\Http\Controllers\ReceivePackagingController::class, 'viewHistoryReceivePackaging'])->name('packaging.history');
    Route::get('/packaging/inspect/receive/quality/view/{id}', [\App\Http\Controllers\ReceivePackagingController::class, 'viewCheckVehicle'])->name('receive.packaging.view.check.vehicle');
    Route::get('/packaging/inspect/receive/transport/view/{id}', [\App\Http\Controllers\ReceivePackagingController::class, 'viewCheckPackaging'])->name('receive.packaging.view.check.packaging');

    // เบิกวัตถุดิบ
    // Route::get('/packaging/inspect/requsition', [App\Http\Controllers\RequsitionPackagingController::class, 'viewcheckRequsitionPackaging'])->name('check.requsition.packaging.stock');
    // Route::get('/packaging/inspect/return/requsition/packaging', [App\Http\Controllers\RequsitionPackagingController::class, 'viewInspectReturnRequsitionPackaging'])->name('check.requsition.return.packaging');
    // Route::get('/packaging/history/requsition', [App\Http\Controllers\RequsitionPackagingController::class, 'viewHistoryMasterRequsitionPackaging'])->name('history.requsition.packaging');
});

Route::group([
    'middleware' => [
        'auth',
        'can:stockmaterial',
    ],
], function () {
    //--รับเข้าวัตถุดิบ
    Route::get('/material/receive', [App\Http\Controllers\ReceiveMaterialController::class, 'viewStock'])->name('stock');
    Route::get('/material/receive/create', [\App\Http\Controllers\ReceiveMaterialController::class, 'viewCreateReceiveMaterial'])->name('receive.material.create');
    Route::get('/material/receive/edit/{id}', [\App\Http\Controllers\ReceiveMaterialController::class, 'viewEditReceiveMaterial'])->name('receive.material.edit');
    Route::get('/material/receive/history/{id}', [\App\Http\Controllers\ReceiveMaterialController::class, 'viewHistoryEditReceiveMaterial'])->name('receive.material.history');
    Route::get('/material/inspect/receive', [App\Http\Controllers\ReceiveMaterialController::class, 'checkImportStock'])->name('check.import.material.stock');
    Route::get('/material/inspect/receive/quality/view/{id}', [\App\Http\Controllers\ReceiveMaterialController::class, 'viewCheckMaterial'])->name('receive.material.view.check.material');
    Route::get('/material/inspect/receive/transport/view/{id}', [\App\Http\Controllers\ReceiveMaterialController::class, 'viewCheckVehicle'])->name('receive.material.view.check.vehicle');
    Route::post('/material/inspect/receive/save', [\App\Http\Controllers\MaterialInspectController::class, 'saveData'])->name('receive.material.check.save');
    Route::get('/material/receive/master', [App\Http\Controllers\ReceiveMaterialController::class, 'viewMasterReceiveMaterial'])->name('receive.material.master');
    Route::get('/material/update/lot-no-pm', [App\Http\Controllers\ReceiveMaterialController::class, 'viewLotNoPMReceiveMaterial'])->name('receive.material.lot.no.pm');
    Route::get('/material/pending/receive', [App\Http\Controllers\ReceiveMaterialController::class, 'viewSendtoReceiveMaterial'])->name('send.to.receive.material');

    //--เบิกวัตถุดิบ
    Route::get('/material/requsition', [\App\Http\Controllers\RequsitionMaterialController::class, 'listViewRequsitionMaterial'])->name('requsition.material');
    Route::get('/material/requsition/create', [\App\Http\Controllers\RequsitionMaterialController::class, 'viewCreateRequsitionMaterial'])->name('requsition.material.create');
    Route::get('/material/requsition/edit/{id}', [\App\Http\Controllers\RequsitionMaterialController::class, 'viewEditRequsitionMaterial'])->name('requsition.material.edit');
    Route::get('/material/requsition/history/{id}', [\App\Http\Controllers\RequsitionMaterialController::class, 'viewHistoryRequsitionMaterial'])->name('requsition.material.history');
    Route::get('/material/inspect/requsition', [App\Http\Controllers\RequsitionMaterialController::class, 'viewListInspectRequsitionMaterial'])->name('check.requsition.product.stock');
    Route::get('/material/inspect/return/requsition/material', [App\Http\Controllers\RequsitionMaterialController::class, 'viewInspectReturnRequsitionMaterial'])->name('check.requsition.return.material');
    Route::get('/material/history/requsition', [App\Http\Controllers\RequsitionMaterialController::class, 'viewHistoryMasterRequsitionMaterial'])->name('history.requsition.material');
    Route::get('/material/pending/requsition', [\App\Http\Controllers\RequsitionMaterialController::class, 'listPendingRequsitionMaterial'])->name('pending.requsition.material');

    //--คืนวัตถุดิบ
    Route::get('/material/return', [\App\Http\Controllers\RequsitionMaterialController::class, 'viewReturnRequsitionMaterial'])->name('requsition.material.return');
    Route::get('/material/return/create/{id}', [\App\Http\Controllers\RequsitionMaterialController::class, 'viewCreateReturnMaterial'])->name('requsition.material.return.create');
    Route::get('/material/pending/return/requsition', [\App\Http\Controllers\RequsitionMaterialController::class, 'listPendingReturnRequsitionMaterial'])->name('pending.requsition.return.material');
});

Route::group([
    'middleware' => [
        'auth',
        'can:stockpackaging',
    ],
], function () {
    //--รับเข้าบรรจุภัณฑ์
    Route::get('/packaging/receive', [\App\Http\Controllers\ReceivePackagingController::class, 'viewListPackaging'])->name('packaging');
    Route::get('/packaging/receive/create', [\App\Http\Controllers\ReceivePackagingController::class, 'viewCreate'])->name('receive.packaging.create');
    Route::get('/packaging/receive/edit/{id}', [\App\Http\Controllers\ReceivePackagingController::class, 'viewEditReceivePackaging'])->name('receive.packaging.edit');
    Route::get('/packaging/receive/history/{id}', [\App\Http\Controllers\ReceivePackagingController::class, 'viewHistoryEditReceivePackaging'])->name('receive.packaging.history');
    Route::get('/packaging/inspect/receive', [App\Http\Controllers\ReceivePackagingController::class, 'checkReceivePackaging'])->name('check.import.packaging.stock');
    Route::get('/packaging/inspect/receive/quality/view/{id}', [\App\Http\Controllers\ReceivePackagingController::class, 'viewCheckVehicle'])->name('receive.packaging.view.check.vehicle');
    Route::get('/packaging/inspect/receive/transport/view/{id}', [\App\Http\Controllers\ReceivePackagingController::class, 'viewCheckPackaging'])->name('receive.packaging.view.check.packaging');
    Route::post('/packaging/inspect/receive/save', [\App\Http\Controllers\PackagingInspectController::class, 'saveData'])->name('receive.packaging.check.save');
    Route::get('/packaging/update/lot-no-pm', [App\Http\Controllers\ReceivePackagingController::class, 'viewLotNoPMReceivePackaging'])->name('receive.packaging.lot.no.pm');
    Route::get('/packaging/pending/receive', [\App\Http\Controllers\ReceivePackagingController::class, 'viewPendingReceivePackaging'])->name('packaging.pending');
    Route::get('/packaging/history/receive', [\App\Http\Controllers\ReceivePackagingController::class, 'viewHistoryReceivePackaging'])->name('packaging.history');

    //--เบิกบรรจุภัณฑ์
    Route::get('/packaging/requsition', [\App\Http\Controllers\RequsitionPackagingController::class, 'listViewRequsitionPackaging'])->name('requsition.packaging');
    Route::get('/packaging/requsition/create', [\App\Http\Controllers\RequsitionPackagingController::class, 'viewCreateRequsitionPackaging'])->name('requsition.packaging.create');
    Route::get('/packaging/requsition/edit/{id}', [\App\Http\Controllers\RequsitionPackagingController::class, 'viewEditRequsitionPackaging'])->name('requsition.packaging.edit');
    Route::get('/packaging/requsition/history/{id}', [\App\Http\Controllers\RequsitionPackagingController::class, 'viewHistoryRequsitionPackaging'])->name('requsition.packaging.history');
    Route::get('/packaging/inspect/requsition', [App\Http\Controllers\RequsitionPackagingController::class, 'viewcheckRequsitionPackaging'])->name('check.requsition.packaging.stock');
    Route::get('/packaging/pending/requsition', [\App\Http\Controllers\RequsitionPackagingController::class, 'listPendingRequsitionPackaging'])->name('pending.requsition.packaging');

    //--คืนบรรจุภัณฑ์
    Route::get('/packaging/claim', [App\Http\Controllers\RequsitionPackagingController::class, 'viewclaimRequsitionPackaging'])->name('view.requsition.packaging.claim');
    Route::get('/packaging/return', [App\Http\Controllers\RequsitionPackagingController::class, 'viewReturnRequsitionPackaging'])->name('check.requsition.packaging.stock');
    Route::get('/packaging/inspect/return/requsition/packaging', [App\Http\Controllers\RequsitionPackagingController::class, 'viewInspectReturnRequsitionPackaging'])->name('check.requsition.return.packaging');
    Route::get('/packaging/history/requsition', [App\Http\Controllers\RequsitionPackagingController::class, 'viewHistoryMasterRequsitionPackaging'])->name('history.requsition.packaging');
    Route::get('/packaging/return/create/{id}', [App\Http\Controllers\RequsitionPackagingController::class, 'viewCreateReturnPackaging'])->name('requsition.packaging.return.create');
    Route::get('/packaging/pending/return/requsition', [\App\Http\Controllers\RequsitionPackagingController::class, 'listPendingReturnRequsitionPackaging'])->name('pending.requsition.return.packaging');
});

Route::group([
    'middleware' => [
        'auth',
    ],
], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/set_plan', [App\Http\Controllers\SetPlanController::class, 'list'])->name('set_plan.list');
    Route::get('/set_plan/list', [App\Http\Controllers\SetPlanController::class, 'listData'])->name('set_plan.list.data');
    Route::post('/set_plan/crud', [App\Http\Controllers\SetPlanController::class, 'crudData'])->name('set_plan.crud.data');
    Route::post('/consumables/chart', [App\Http\Controllers\SupplyController::class, 'supplyChart'])->name('consumables.chart');



    // //--รับเข้าวัตถุดิบ
    // Route::get('/material/receive', [App\Http\Controllers\ReceiveMaterialController::class, 'viewStock'])->name('stock');
    // Route::get('/material/receive/create',[\App\Http\Controllers\ReceiveMaterialController::class,'viewCreateReceiveMaterial'])->name('receive.material.create');
    // Route::get('/material/receive/edit/{id}',[\App\Http\Controllers\ReceiveMaterialController::class,'viewEditReceiveMaterial'])->name('receive.material.edit');
    // Route::get('/material/receive/history/{id}',[\App\Http\Controllers\ReceiveMaterialController::class,'viewHistoryEditReceiveMaterial'])->name('receive.material.history');
    // Route::get('/material/inspect/receive', [App\Http\Controllers\ReceiveMaterialController::class, 'checkImportStock'])->name('check.import.material.stock');
    // Route::get('/material/inspect/receive/quality/view/{id}',[\App\Http\Controllers\ReceiveMaterialController::class,'viewCheckMaterial'])->name('receive.material.view.check.material');
    // Route::get('/material/inspect/receive/transport/view/{id}',[\App\Http\Controllers\ReceiveMaterialController::class,'viewCheckVehicle'])->name('receive.material.view.check.vehicle');
    // Route::post('/material/inspect/receive/save',[\App\Http\Controllers\MaterialInspectController::class,'saveData'])->name('receive.material.check.save');
    // Route::get('/material/receive/master', [App\Http\Controllers\ReceiveMaterialController::class, 'viewMasterReceiveMaterial'])->name('receive.material.master');
    // Route::get('/material/update/lot-no-pm', [App\Http\Controllers\ReceiveMaterialController::class, 'viewLotNoPMReceiveMaterial'])->name('receive.material.lot.no.pm');
    // Route::get('/material/pending/receive', [App\Http\Controllers\ReceiveMaterialController::class, 'viewSendtoReceiveMaterial'])->name('send.to.receive.material');

    // //--เบิกวัตถุดิบ
    // Route::get('/material/requsition',[\App\Http\Controllers\RequsitionMaterialController::class,'listViewRequsitionMaterial'])->name('requsition.material');
    // Route::get('/material/requsition/create',[\App\Http\Controllers\RequsitionMaterialController::class,'viewCreateRequsitionMaterial'])->name('requsition.material.create');
    // Route::get('/material/requsition/edit/{id}',[\App\Http\Controllers\RequsitionMaterialController::class,'viewEditRequsitionMaterial'])->name('requsition.material.edit');
    // Route::get('/material/requsition/history/{id}',[\App\Http\Controllers\RequsitionMaterialController::class,'viewHistoryRequsitionMaterial'])->name('requsition.material.history');
    // Route::get('/material/inspect/requsition', [App\Http\Controllers\RequsitionMaterialController::class, 'viewListInspectRequsitionMaterial'])->name('check.requsition.product.stock');
    // Route::get('/material/inspect/return/requsition/material', [App\Http\Controllers\RequsitionMaterialController::class, 'viewInspectReturnRequsitionMaterial'])->name('check.requsition.return.material');
    // Route::get('/material/history/requsition', [App\Http\Controllers\RequsitionMaterialController::class, 'viewHistoryMasterRequsitionMaterial'])->name('history.requsition.material');
    // Route::get('/material/pending/requsition',[\App\Http\Controllers\RequsitionMaterialController::class,'listPendingRequsitionMaterial'])->name('pending.requsition.material');

    // //--คืนวัตถุดิบ
    // Route::get('/material/return',[\App\Http\Controllers\RequsitionMaterialController::class,'viewReturnRequsitionMaterial'])->name('requsition.material.return');
    // Route::get('/material/return/create/{id}',[\App\Http\Controllers\RequsitionMaterialController::class,'viewCreateReturnMaterial'])->name('requsition.material.return.create');
    // Route::get('/material/pending/return/requsition',[\App\Http\Controllers\RequsitionMaterialController::class,'listPendingReturnRequsitionMaterial'])->name('pending.requsition.return.material');

    // //--รับเข้าบรรจุภัณฑ์
    // Route::get('/packaging/receive',[\App\Http\Controllers\ReceivePackagingController::class,'viewListPackaging'])->name('packaging');
    // Route::get('/packaging/receive/create',[\App\Http\Controllers\ReceivePackagingController::class,'viewCreate'])->name('receive.packaging.create');
    // Route::get('/packaging/receive/edit/{id}',[\App\Http\Controllers\ReceivePackagingController::class,'viewEditReceivePackaging'])->name('receive.packaging.edit');
    // Route::get('/packaging/receive/history/{id}',[\App\Http\Controllers\ReceivePackagingController::class,'viewHistoryEditReceivePackaging'])->name('receive.packaging.history');
    // Route::get('/packaging/inspect/receive', [App\Http\Controllers\ReceivePackagingController::class, 'checkReceivePackaging'])->name('check.import.packaging.stock');
    // Route::get('/packaging/inspect/receive/quality/view/{id}',[\App\Http\Controllers\ReceivePackagingController::class,'viewCheckVehicle'])->name('receive.packaging.view.check.vehicle');
    // Route::get('/packaging/inspect/receive/transport/view/{id}',[\App\Http\Controllers\ReceivePackagingController::class,'viewCheckPackaging'])->name('receive.packaging.view.check.packaging');
    // Route::post('/packaging/inspect/receive/save',[\App\Http\Controllers\PackagingInspectController::class,'saveData'])->name('receive.packaging.check.save');
    // Route::get('/packaging/update/lot-no-pm', [App\Http\Controllers\ReceivePackagingController::class, 'viewLotNoPMReceivePackaging'])->name('receive.packaging.lot.no.pm');
    // Route::get('/packaging/pending/receive',[\App\Http\Controllers\ReceivePackagingController::class,'viewPendingReceivePackaging'])->name('packaging.pending');
    // Route::get('/packaging/history/receive',[\App\Http\Controllers\ReceivePackagingController::class,'viewHistoryReceivePackaging'])->name('packaging.history');

    // //--เบิกบรรจุภัณฑ์
    // Route::get('/packaging/requsition',[\App\Http\Controllers\RequsitionPackagingController::class,'listViewRequsitionPackaging'])->name('requsition.packaging');
    // Route::get('/packaging/requsition/create',[\App\Http\Controllers\RequsitionPackagingController::class,'viewCreateRequsitionPackaging'])->name('requsition.packaging.create');
    // Route::get('/packaging/requsition/edit/{id}',[\App\Http\Controllers\RequsitionPackagingController::class,'viewEditRequsitionPackaging'])->name('requsition.packaging.edit');
    // Route::get('/packaging/requsition/history/{id}',[\App\Http\Controllers\RequsitionPackagingController::class,'viewHistoryRequsitionPackaging'])->name('requsition.packaging.history');
    // Route::get('/packaging/inspect/requsition', [App\Http\Controllers\RequsitionPackagingController::class, 'viewcheckRequsitionPackaging'])->name('check.requsition.packaging.stock');
    // Route::get('/packaging/pending/requsition',[\App\Http\Controllers\RequsitionPackagingController::class,'listPendingRequsitionPackaging'])->name('pending.requsition.packaging');

    // //--คืนบรรจุภัณฑ์
    // Route::get('/packaging/claim', [App\Http\Controllers\RequsitionPackagingController::class, 'viewclaimRequsitionPackaging'])->name('view.requsition.packaging.claim');
    // Route::get('/packaging/return', [App\Http\Controllers\RequsitionPackagingController::class, 'viewReturnRequsitionPackaging'])->name('check.requsition.packaging.stock');
    // Route::get('/packaging/inspect/return/requsition/packaging', [App\Http\Controllers\RequsitionPackagingController::class, 'viewInspectReturnRequsitionPackaging'])->name('check.requsition.return.packaging');
    // Route::get('/packaging/history/requsition', [App\Http\Controllers\RequsitionPackagingController::class, 'viewHistoryMasterRequsitionPackaging'])->name('history.requsition.packaging');
    // Route::get('/packaging/return/create/{id}', [App\Http\Controllers\RequsitionPackagingController::class, 'viewCreateReturnPackaging'])->name('requsition.packaging.return.create');
    // Route::get('/packaging/pending/return/requsition',[\App\Http\Controllers\RequsitionPackagingController::class,'listPendingReturnRequsitionPackaging'])->name('pending.requsition.return.packaging');


    // //--รับเข้าสินค้าสำเร็จรูป
    // Route::get('/product/receive',[\App\Http\Controllers\ReceiveProductController::class,'viewListProduct'])->name('receive.product');
    // Route::get('/product/receive/create',[\App\Http\Controllers\ReceiveProductController::class,'viewCreateReceiveProduct'])->name('receive.product.create');
    // Route::get('/product/receive/edit/{id}',[\App\Http\Controllers\ReceiveProductController::class,'viewEditReceiveProduct'])->name('receive.product.edit');
    // Route::get('/product/receive/history/{id}',[\App\Http\Controllers\ReceiveProductController::class,'viewHistoryEditReceiveProduct'])->name('receive.product.history');
    // Route::get('/product/pending/receive',[\App\Http\Controllers\ReceiveProductController::class,'viewPendingReceiveProduct'])->name('receive.product.pending');
    // Route::get('/product/history/receive',[\App\Http\Controllers\ReceiveProductController::class,'viewHistoryReceiveProduct'])->name('list.history.receive.product');
    // Route::get('/product/inspect/receive', [App\Http\Controllers\ReceiveProductController::class, 'checkReceiveProduct'])->name('check.import.product.stock');
    // Route::get('/product/inspect/receive/quality/view/{id}',[\App\Http\Controllers\ReceiveProductController::class,'viewCheckProduct'])->name('receive.product.view.check.product');
    // Route::post('/product/inspect/receive/save',[\App\Http\Controllers\ProductInspectController::class,'saveData'])->name('receive.product.check.save');

    // //--ส่งออกสินค้าสำเร็จรูป
    // Route::get('/product/requsition', [App\Http\Controllers\RequsitionProductController::class, 'viewListRequsitionProduct'])->name('list.requsition.product');
    // Route::get('/product/inspect/requsition', [App\Http\Controllers\RequsitionProductController::class, 'viewListRequsitionInspectProduct'])->name('list.requsition.product.inspect');
    // Route::get('/product/pending/requsition', [App\Http\Controllers\RequsitionProductController::class, 'viewListRequsitionPendingProduct'])->name('list.requsition.product.pending');
    // Route::get('/product/history/requsition', [App\Http\Controllers\RequsitionProductController::class, 'viewListRequsitionHistoryProduct'])->name('list.requsition.product.history');
    // Route::get('/product/requsition/create',[\App\Http\Controllers\RequsitionProductController::class,'viewCreateRequsitionProduct'])->name('requsition.product.create');
    // Route::get('/product/requsition/edit/{id}',[\App\Http\Controllers\RequsitionProductController::class,'viewEditRequsitionProduct'])->name('requsition.product.edit');
    // // Route::get('/product/history/requsition', [App\Http\Controllers\RequsitionProductController::class, 'viewListHistoryRequsitionProduct'])->name('list.history.requsition.product');
    // Route::get('/product/requsition/history/{id}',[\App\Http\Controllers\RequsitionProductController::class,'viewHistoryEditRequsitionProduct'])->name('requsition.product.history');


    // // รับเข้าวัสดุสิ้นเปลือง
    // Route::get('/supply/receive', [App\Http\Controllers\ReceiveSupplyController::class, 'viewListReceiveSupply'])->name('list.receive.supply');
    // Route::get('/supply/receive/create',[\App\Http\Controllers\ReceiveSupplyController::class,'viewCreateReceiveSupply'])->name('receive.supply.create');
    // Route::get('/supply/receive/edit/{id}',[\App\Http\Controllers\ReceiveSupplyController::class,'viewEditReceiveSupply'])->name('receive.supply.edit');
    // Route::get('/supply/receive/history/{id}',[\App\Http\Controllers\ReceiveSupplyController::class,'viewHistoryEditReceiveSupply'])->name('receive.supply.history');
    // Route::get('/supply/pending', [App\Http\Controllers\ReceiveSupplyController::class, 'viewListPendingReceiveSupply'])->name('list.pending.receive.supply');
    // Route::get('/supply/history/receive', [App\Http\Controllers\ReceiveSupplyController::class, 'viewListHistoryReceiveSupply'])->name('list.history.receive.supply');

    // // เบิกวัสดุสิ้นเปลือง
    // Route::get('/supply/requsition', [App\Http\Controllers\RequsitionSupplyController::class, 'viewListRequsitionSupply'])->name('list.requsition.supply');
    // Route::get('/supply/history/requsition', [App\Http\Controllers\RequsitionSupplyController::class, 'viewListHistoryRequsitionSupply'])->name('list.history.requsition.supply');
    // Route::get('/supply/requsition/create',[\App\Http\Controllers\RequsitionSupplyController::class,'viewCreateRequsitionSupply'])->name('requsition.supply.create');
    // Route::get('/supply/requsition/edit/{id}',[\App\Http\Controllers\RequsitionSupplyController::class,'viewEditRequsitionSupply'])->name('requsition.supply.edit');
    // Route::get('/supply/requsition/history/{id}',[\App\Http\Controllers\RequsitionSupplyController::class,'viewHistoryEditRequsitionSupply'])->name('requsition.supply.history');

    // // รายการคงคลัง
    // Route::get('/inventory/material/list', [App\Http\Controllers\InventoryController::class, 'inventoryMaterial'])->name('inventory.material');
    // Route::post('/inventory/material/chart', [App\Http\Controllers\InventoryController::class, 'inventoryMaterialChart'])->name('inventory.meterial.chart');

    // // รายการคงคลัง
    // Route::get('/inventory/packaging/list', [App\Http\Controllers\InventoryController::class, 'inventoryPackaging'])->name('inventory.packaging');
    // Route::post('/inventory/packaging/chart', [App\Http\Controllers\InventoryController::class, 'inventoryPackagingChart'])->name('inventory.packaging.chart');

    // // สินค้า
    // Route::get('/inventory/product/list', [App\Http\Controllers\InventoryController::class, 'inventoryProduct'])->name('inventory.product');
    // Route::post('/inventory/product/chart', [App\Http\Controllers\InventoryController::class, 'inventoryProductChart'])->name('inventory.product.chart');

    // // วัสดุสิ้นเปลือง
    // Route::get('/inventory/supply/list', [App\Http\Controllers\InventoryController::class, 'inventorySupply'])->name('inventory.supply');
    // Route::post('/inventory/supply/chart', [App\Http\Controllers\InventoryController::class, 'inventorySupplyChart'])->name('inventory.supply.chart');

    // //report receive
    // Route::get('/report/receive/material/list', [App\Http\Controllers\ReportController::class, 'reportReceiveMaterial'])->name('report.receive.material');
    // Route::post('/report/receive/material/pdf', [App\Http\Controllers\ReportController::class, 'reportReceiveMaterialPDF'])->name('report.receive.material.pdf');
    // Route::get('/report/receive/material/pdf/{id}', [App\Http\Controllers\ReportController::class, 'reportReceiveMaterialPdfOther'])->name('report.receive.material.pdf.other');

    // Route::get('/report/receive/packaging/list', [App\Http\Controllers\ReportController::class, 'reportReceivePackaging'])->name('report.receive.packaging');
    // Route::post('/report/receive/packaging/pdf', [App\Http\Controllers\ReportController::class, 'reportReceivePackagingPDF'])->name('report.receive.packaging.pdf');
    // Route::get('/report/receive/packaging/pdf/{id}', [App\Http\Controllers\ReportController::class, 'reportReceivePackagingPdfOther'])->name('report.receive.packaging.pdf.other');

    // Route::get('/report/receive/product/list', [App\Http\Controllers\ReportController::class, 'reportReceiveProduct'])->name('report.receive.product');
    // Route::post('/report/receive/product/pdf', [App\Http\Controllers\ReportController::class, 'reportReceiveProductPDF'])->name('report.receive.product.pdf');
    // Route::get('/report/receive/product/pdf/{id}', [App\Http\Controllers\ReportController::class, 'reportReceiveProductPdfOther'])->name('report.receive.product.pdf.other');

    // Route::get('/report/receive/supply/list', [App\Http\Controllers\ReportController::class, 'reportReceiveSupply'])->name('report.receive.supply');
    // Route::post('/report/receive/supply/pdf', [App\Http\Controllers\ReportController::class, 'reportReceiveSupplyPDF'])->name('report.receive.supply.pdf');
    // Route::get('/report/receive/supply/pdf/{id}', [App\Http\Controllers\ReportController::class, 'reportReceiveSupplyPdfOther'])->name('report.receive.supply.pdf.other');

    // //report requsition
    // Route::get('/report/requsition/material/list', [App\Http\Controllers\ReportController::class, 'reportRequsitionMaterial'])->name('report.requsition.material');
    // Route::post('/report/requsition/material/pdf/all', [App\Http\Controllers\ReportController::class, 'reportRequsitionMaterialPDF'])->name('report.requsition.material.pdf');
    // Route::get('/report/requsition/material/pdf/{id}', [App\Http\Controllers\ReportController::class, 'reportRequsitionMaterialPdfOther'])->name('report.requsition.material.pdf.other');

    // Route::get('/report/requsition/packaging/list', [App\Http\Controllers\ReportController::class, 'reportRequsitionPackaging'])->name('report.requsition.packaging');
    // Route::post('/report/requsition/packaging/pdf/all', [App\Http\Controllers\ReportController::class, 'reportRequsitionPackagingPDF'])->name('report.requsition.packaging.pdf');
    // Route::get('/report/requsition/packaging/pdf/{id}', [App\Http\Controllers\ReportController::class, 'reportRequsitionPackagingPdfOther'])->name('report.requsition.packaging.pdf.other');

    // Route::get('/report/requsition/product/list', [App\Http\Controllers\ReportController::class, 'reportRequsitionProduct'])->name('report.requsition.product');
    // Route::post('/report/requsition/product/pdf/all', [App\Http\Controllers\ReportController::class, 'reportRequsitionProductPDF'])->name('report.requsition.product.pdf');
    // Route::get('/report/requsition/product/pdf/{id}', [App\Http\Controllers\ReportController::class, 'reportRequsitionProductPdfOther'])->name('report.requsition.product.pdf.other');

    // Route::get('/report/requsition/supply/list', [App\Http\Controllers\ReportController::class, 'reportRequsitionSupply'])->name('report.requsition.supply');
    // Route::post('/report/requsition/supply/pdf/all', [App\Http\Controllers\ReportController::class, 'reportRequsitionSupplyPDF'])->name('report.requsition.supply.pdf');
    // Route::get('/report/requsition/supply/pdf/{id}', [App\Http\Controllers\ReportController::class, 'reportRequsitionSupplyPdfOther'])->name('report.requsition.supply.pdf.other');




});

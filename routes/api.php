<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(
    ['prefix' => 'v1', 'as' => 'api.v1.'],
    function () {
        Route::group(['middleware' => 'auth:sanctum'], function () {
            // new stock api here
            Route::post('/companies', [\App\Http\Controllers\APIs\CompanyController::class, "companiesList"])->name('companies.list');
            Route::post('/suppliers', [\App\Http\Controllers\APIs\VendorController::class, "suppliersList"])->name('suppliers.list');
            Route::post('/units', [\App\Http\Controllers\APIs\UnitController::class, "unitsList"])->name('unitrs.list');
            Route::post('/materials', [\App\Http\Controllers\APIs\MaterialController::class, "materialsList"])->name('materials.list');
            Route::post('/materials/balance', [\App\Http\Controllers\APIs\RequsitionMaterialController::class, "getMaterialBalance"])->name('materials.balance');
            Route::post('/test/materials/balance', [\App\Http\Controllers\APIs\RequsitionMaterialController::class, "getMaterialBalance"])->name('test.materials.balance');
            Route::post('/packagings', [\App\Http\Controllers\APIs\PackagingController::class, "packagingsList"])->name('packagings.list');
            Route::post('/packagings/balance', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "getPackagingLotAndPackagingCut"])->name('packagings.balance');
            Route::post('/products', [\App\Http\Controllers\APIs\ProductController::class, "productsList"])->name('products.list');
            Route::post('/products/balance', [\App\Http\Controllers\APIs\RequsitionProductController::class, "getProductLotAndProductsCut"])->name('products.balance');
            Route::post('/supplies', [\App\Http\Controllers\APIs\SupplyController::class, "suppliesList"])->name('supplies.list');
            Route::post('/supplies/balance', [\App\Http\Controllers\APIs\RequsitionSupplyController::class, "getSupplyLotAndSupplyCut"])->name('supplies.balance');
        });
        // คงคลัง

        Route::post('/cosmetics/select', [\App\Http\Controllers\APIs\CosmeticsController::class, "select"])->name('cosmetics.select');
        Route::post('/cosmetics/list', [\App\Http\Controllers\APIs\CosmeticsController::class, "list"])->name('cosmetics.list');
        Route::post("/cosmetics/create", [\App\Http\Controllers\APIs\CosmeticsController::class, "create"])->name('cosmetics.create');
        Route::post("/cosmetics/validate", [\App\Http\Controllers\APIs\CosmeticsController::class, "validateCheck"])->name('cosmetics.validate');
        Route::post('/cosmetics/view/edit', [\App\Http\Controllers\APIs\CosmeticsController::class, "viewEdit"])->name('cosmetics.view.edit');
        Route::post('/cosmetics/edit', [\App\Http\Controllers\APIs\CosmeticsController::class, "edit"])->name('cosmetics.edit');
        Route::post('/cosmetics/delete', [\App\Http\Controllers\APIs\CosmeticsController::class, "delete"])->name('cosmetics.delete');

        Route::post('/supplement/select', [\App\Http\Controllers\APIs\SupplementController::class, "select"])->name('supplement.select');
        Route::post('/supplement/list', [\App\Http\Controllers\APIs\SupplementController::class, "list"])->name('supplement.list');
        Route::post("/supplement/create", [\App\Http\Controllers\APIs\SupplementController::class, "create"])->name('supplement.create');
        Route::post("/supplement/validate", [\App\Http\Controllers\APIs\SupplementController::class, "validateCheck"])->name('supplement.validate');
        Route::post('/supplement/view/edit', [\App\Http\Controllers\APIs\SupplementController::class, "viewEdit"])->name('supplement.view.edit');
        Route::post('/supplement/edit', [\App\Http\Controllers\APIs\SupplementController::class, "edit"])->name('supplement.edit');
        Route::post('/supplement/delete', [\App\Http\Controllers\APIs\SupplementController::class, "delete"])->name('supplement.delete');


        Route::post("/inventory/material/list", [\App\Http\Controllers\APIs\InventoryController::class, "materialList"])->name('inventory.material.list');
        Route::post("/inventory/packaging/list", [\App\Http\Controllers\APIs\InventoryController::class, "packagingList"])->name('inventory.packaging.list');
        Route::post("/inventory/product/list", [\App\Http\Controllers\APIs\InventoryController::class, "productList"])->name('inventory.product.list');
        Route::post("/inventory/supply/list", [\App\Http\Controllers\APIs\InventoryController::class, "supplyList"])->name('inventory.supply.list');

        Route::post("/report/receive/material/list", [\App\Http\Controllers\APIs\ReportController::class, "reportReceiveMaterialList"])->name('report.receive.material.list');
        Route::post("/report/receive/packaging/list", [\App\Http\Controllers\APIs\ReportController::class, "reportReceivePackagingList"])->name('report.receive.packaging.list');
        Route::post("/report/receive/product/list", [\App\Http\Controllers\APIs\ReportController::class, "reportReceiveProductList"])->name('report.receive.product.list');
        Route::post("/report/receive/supply/list", [\App\Http\Controllers\APIs\ReportController::class, "reportReceiveSupplyList"])->name('report.receive.supply.list');

        Route::post("/report/requsition/material/list", [\App\Http\Controllers\APIs\ReportController::class, "reportRequsitionMaterialList"])->name('report.requsition.material.list');
        Route::post("/report/requsition/packaging/list", [\App\Http\Controllers\APIs\ReportController::class, "reportRequsitionPackagingList"])->name('report.requsition.packaging.list');
        Route::post("/report/requsition/product/list", [\App\Http\Controllers\APIs\ReportController::class, "reportRequsitionProductList"])->name('report.requsition.product.list');
        Route::post("/report/requsition/supply/list", [\App\Http\Controllers\APIs\ReportController::class, "reportRequsitionSupplyList"])->name('report.requsition.supply.list');

        Route::post("/brand/create", [\App\Http\Controllers\APIs\FdaBrandController::class, "create"])->name('brand.create');

        Route::post("/category/list", [\App\Http\Controllers\APIs\CategoryController::class, "list"])->name('category.list');
        Route::post("/category/create", [\App\Http\Controllers\APIs\CategoryController::class, "create"])->name('category.create');
        Route::post("/category/validate", [\App\Http\Controllers\APIs\CategoryController::class, "validateCheck"])->name('category.validate');
        Route::post('/category/view/edit', [\App\Http\Controllers\APIs\CategoryController::class, "viewEdit"])->name('category.view.edit');
        Route::post('/category/edit', [\App\Http\Controllers\APIs\CategoryController::class, "edit"])->name('category.edit');
        Route::post('/category/delete', [\App\Http\Controllers\APIs\CategoryController::class, "delete"])->name('category.delete');

        Route::post('/material/list', [\App\Http\Controllers\APIs\MaterialController::class, "list"])->name('material.list');
        Route::post('/material/list/category/id', [\App\Http\Controllers\APIs\MaterialController::class, "listByCategoryId"])->name('material.list.category.id');
        Route::post('/material/create', [\App\Http\Controllers\APIs\MaterialController::class, "create"])->name('material.create');
        Route::post('/material/validate', [\App\Http\Controllers\APIs\MaterialController::class, "validateCheck"])->name('material.validate');
        Route::post('/material/view/edit', [\App\Http\Controllers\APIs\MaterialController::class, "viewEdit"])->name('material.view.edit');
        Route::post('/material/edit', [\App\Http\Controllers\APIs\MaterialController::class, "edit"])->name('material.edit');
        Route::post('/material/delete', [\App\Http\Controllers\APIs\MaterialController::class, "delete"])->name('material.delete');

        Route::post('/packaging/list', [\App\Http\Controllers\APIs\PackagingController::class, "list"])->name('packaging.list');
        Route::post('/packaging/create', [\App\Http\Controllers\APIs\PackagingController::class, "create"])->name('packaging.create');
        Route::post('/packaging/edit', [\App\Http\Controllers\APIs\PackagingController::class, "edit"])->name('packaging.edit');
        Route::post('/packaging/view/edit', [\App\Http\Controllers\APIs\PackagingController::class, "viewEdit"])->name('packaging.view.edit');
        Route::post('/packaging/delete', [\App\Http\Controllers\APIs\PackagingController::class, "delete"])->name('packaging.delete');
        Route::post('/packaging/validate', [\App\Http\Controllers\APIs\PackagingController::class, "validateCheck"])->name('packaging.validate');

        Route::post('/product/list', [\App\Http\Controllers\APIs\ProductController::class, "list"])->name('product.list');
        Route::post('/product/create', [\App\Http\Controllers\APIs\ProductController::class, "create"])->name('product.create');
        Route::post('/product/validate', [\App\Http\Controllers\APIs\ProductController::class, "validateCheck"])->name('product.validate');
        Route::post('/product/view/edit', [\App\Http\Controllers\APIs\ProductController::class, "viewEdit"])->name('product.view.edit');
        Route::post('/product/edit', [\App\Http\Controllers\APIs\ProductController::class, "edit"])->name('product.edit');
        Route::post('/product/delete', [\App\Http\Controllers\APIs\ProductController::class, "delete"])->name('product.delete');

        Route::post('/company/list', [\App\Http\Controllers\APIs\CompanyController::class, "list"])->name('company.list');
        Route::post('/company/create', [\App\Http\Controllers\APIs\CompanyController::class, "create"])->name('company.create');
        Route::post('/company/edit', [\App\Http\Controllers\APIs\CompanyController::class, "edit"])->name('company.edit');
        Route::post('/company/view/edit', [\App\Http\Controllers\APIs\CompanyController::class, "viewEdit"])->name('company.view.edit');
        Route::post('/company/delete', [\App\Http\Controllers\APIs\CompanyController::class, "delete"])->name('company.delete');
        Route::post('/company/validate', [\App\Http\Controllers\APIs\CompanyController::class, "validateCheck"])->name('company.validate');

        Route::post('/vehicle/list', [\App\Http\Controllers\APIs\VehicleController::class, "list"])->name('vehicle.list');
        Route::post('/vehicle/create', [\App\Http\Controllers\APIs\VehicleController::class, "create"])->name('vehicle.create');
        Route::post('/vehicle/edit', [\App\Http\Controllers\APIs\VehicleController::class, "edit"])->name('vehicle.edit');
        Route::post('/vehicle/delete', [\App\Http\Controllers\APIs\VehicleController::class, "delete"])->name('vehicle.delete');
        Route::post('/vehicle/validate', [\App\Http\Controllers\APIs\VehicleController::class, "validateCheck"])->name('vehicle.validate');
        Route::post('/vehicle/view/edit', [\App\Http\Controllers\APIs\VehicleController::class, "viewEdit"])->name('vehicle.view.edit');

        Route::post('/supply/list', [\App\Http\Controllers\APIs\SupplyController::class, "list"])->name('supply.list');
        Route::post('/supply/create', [\App\Http\Controllers\APIs\SupplyController::class, "create"])->name('supply.create');
        Route::post('/supply/edit', [\App\Http\Controllers\APIs\SupplyController::class, "edit"])->name('supply.edit');
        Route::post('/supply/delete', [\App\Http\Controllers\APIs\SupplyController::class, "delete"])->name('supply.delete');
        Route::post('/supply/validate', [\App\Http\Controllers\APIs\SupplyController::class, "validateCheck"])->name('supply.validate');
        Route::post('/supply/view/edit', [\App\Http\Controllers\APIs\SupplyController::class, "viewEdit"])->name('supply.view.edit');

        Route::post('/role/list', [\App\Http\Controllers\APIs\RoleController::class, "list"])->name('role.list');
        Route::post('/role/create', [\App\Http\Controllers\APIs\RoleController::class, "create"])->name('role.create');
        Route::post('/role/edit', [\App\Http\Controllers\APIs\RoleController::class, "edit"])->name('role.edit');
        Route::post('/role/delete', [\App\Http\Controllers\APIs\RoleController::class, "delete"])->name('role.delete');
        Route::post('/role/validate', [\App\Http\Controllers\APIs\RoleController::class, "validateCheck"])->name('role.validate');
        Route::post('/role/view/edit', [\App\Http\Controllers\APIs\RoleController::class, "viewEdit"])->name('role.view.edit');

        Route::post('/inspect-topic/list', [\App\Http\Controllers\APIs\InspectTopicController::class, "list"])->name('inspect.topic.list');
        Route::post('/inspect-topic/create', [\App\Http\Controllers\APIs\InspectTopicController::class, "create"])->name('inspect.topic.create');
        Route::post('/inspect-topic/edit', [\App\Http\Controllers\APIs\InspectTopicController::class, "edit"])->name('inspect.topic.edit');
        Route::post('/inspect-topic/delete', [\App\Http\Controllers\APIs\InspectTopicController::class, "delete"])->name('inspect.topic.delete');
        Route::post('/inspect-topic/validate', [\App\Http\Controllers\APIs\InspectTopicController::class, "validateCheck"])->name('inspect.topic.validate');
        Route::post('/inspect-topic/view/edit', [\App\Http\Controllers\APIs\InspectTopicController::class, "viewEdit"])->name('inspect.topic.view.edit');

        Route::post('/inspect-template/list', [\App\Http\Controllers\APIs\InspectTemplateController::class, "list"])->name('inspect.template.list');
        Route::post('/inspect-template/create', [\App\Http\Controllers\APIs\InspectTemplateController::class, "create"])->name('inspect.template.create');
        Route::post('/inspect-template/edit', [\App\Http\Controllers\APIs\InspectTemplateController::class, "edit"])->name('inspect.template.edit');
        Route::post('/inspect-template/delete', [\App\Http\Controllers\APIs\InspectTemplateController::class, "delete"])->name('inspect.template.delete');
        Route::post('/inspect-template/validate', [\App\Http\Controllers\APIs\InspectTemplateController::class, "validateCheck"])->name('inspect.template.validate');
        Route::post('/inspect-template/view/edit', [\App\Http\Controllers\APIs\InspectTemplateController::class, "viewEdit"])->name('inspect.template.view.edit');
        Route::post('/inspect-template/find/inspect-topic', [\App\Http\Controllers\APIs\InspectTemplateController::class, "getInspectTopic"])->name('inspect.template.find.inspect.topic');
        Route::post('/inspect-template/get/inspect-template', [\App\Http\Controllers\APIs\InspectTemplateController::class, "getTemplate"])->name('inspect.template.get.template');
        Route::post('/inspect-template/get/inspect-template-detail', [\App\Http\Controllers\APIs\InspectTemplateController::class, "getTemplateDetail"])->name('inspect.template.get.template.detail');

        Route::post('/inspect-template-detail/list', [\App\Http\Controllers\APIs\InspectTemplateDetailController::class, "list"])->name('inspect.template.detail.list');
        Route::post('/inspect-template-detail/create', [\App\Http\Controllers\APIs\InspectTemplateDetailController::class, "create"])->name('inspect.template.detail.create');
        Route::post('/inspect-template-detail/edit', [\App\Http\Controllers\APIs\InspectTemplateDetailController::class, "edit"])->name('inspect.template.detail.edit');
        Route::post('/inspect-template-detail/delete', [\App\Http\Controllers\APIs\InspectTemplateDetailController::class, "delete"])->name('inspect.template.detail.delete');
        Route::post('/inspect-template-detail/validate', [\App\Http\Controllers\APIs\InspectTemplateDetailController::class, "validateCheck"])->name('inspect.template.detail.validate');
        Route::post('/inspect-template-detail/view/edit', [\App\Http\Controllers\APIs\InspectTemplateDetailController::class, "viewEdit"])->name('inspect.template.detail.view.edit');

        Route::post('/vendor/list', [\App\Http\Controllers\APIs\VendorController::class, "list"])->name('vendor.list');
        Route::post('/vendor/create', [\App\Http\Controllers\APIs\VendorController::class, "create"])->name('vendor.create');
        Route::post('/vendor/edit', [\App\Http\Controllers\APIs\VendorController::class, "edit"])->name('vendor.edit');
        Route::post('/vendor/delete', [\App\Http\Controllers\APIs\VendorController::class, "delete"])->name('vendor.delete');
        Route::post('/vendor/validate', [\App\Http\Controllers\APIs\VendorController::class, "validateCheck"])->name('vendor.validate');
        Route::post('/vendor/view/edit', [\App\Http\Controllers\APIs\VendorController::class, "viewEdit"])->name('vendor.view.edit');

        Route::post('/material-unit/list', [\App\Http\Controllers\APIs\MaterialUnitController::class, "list"])->name('material.unit.list');
        Route::post('/material-unit/list/id', [\App\Http\Controllers\APIs\MaterialUnitController::class, "listById"])->name('material.unit.list.id');
        Route::post('/material-unit/create', [\App\Http\Controllers\APIs\MaterialUnitController::class, "create"])->name('material.unit.create');
        Route::post('/material-unit/edit', [\App\Http\Controllers\APIs\MaterialUnitController::class, "edit"])->name('material.unit.edit');
        Route::post('/material-unit/delete', [\App\Http\Controllers\APIs\MaterialUnitController::class, "delete"])->name('material.unit.delete');
        Route::post('/material-unit/validate', [\App\Http\Controllers\APIs\MaterialUnitController::class, "validateCheck"])->name('material.unit.validate');
        Route::post('/material-unit/view/edit', [\App\Http\Controllers\APIs\MaterialUnitController::class, "viewEdit"])->name('material.unit.view.edit');

        Route::post('/product-unit/list', [\App\Http\Controllers\APIs\ProductUnitController::class, "list"])->name('product.unit.list');
        Route::post('/product-unit/create', [\App\Http\Controllers\APIs\ProductUnitController::class, "create"])->name('product.unit.create');
        Route::post('/product-unit/edit', [\App\Http\Controllers\APIs\ProductUnitController::class, "edit"])->name('product.unit.edit');
        Route::post('/product-unit/delete', [\App\Http\Controllers\APIs\ProductUnitController::class, "delete"])->name('product.unit.delete');
        Route::post('/product-unit/validate', [\App\Http\Controllers\APIs\ProductUnitController::class, "validateCheck"])->name('product.unit.validate');
        Route::post('/product-unit/view/edit', [\App\Http\Controllers\APIs\ProductUnitController::class, "viewEdit"])->name('product.unit.view.edit');

        Route::post('/packaging-unit/list', [\App\Http\Controllers\APIs\PackagingUnitController::class, "list"])->name('packaging.unit.list');
        Route::post('/packaging-unit/create', [\App\Http\Controllers\APIs\PackagingUnitController::class, "create"])->name('packaging.unit.create');
        Route::post('/packaging-unit/edit', [\App\Http\Controllers\APIs\PackagingUnitController::class, "edit"])->name('packaging.unit.edit');
        Route::post('/packaging-unit/delete', [\App\Http\Controllers\APIs\PackagingUnitController::class, "delete"])->name('packaging.unit.delete');
        Route::post('/packaging-unit/validate', [\App\Http\Controllers\APIs\PackagingUnitController::class, "validateCheck"])->name('packaging.unit.validate');
        Route::post('/packaging-unit/view/edit', [\App\Http\Controllers\APIs\PackagingUnitController::class, "viewEdit"])->name('packaging.unit.view.edit');

        Route::post('/unit/list', [\App\Http\Controllers\APIs\UnitController::class, "list"])->name('unit.list');
        Route::post('/unit/create', [\App\Http\Controllers\APIs\UnitController::class, "create"])->name('unit.create');
        Route::post('/unit/edit', [\App\Http\Controllers\APIs\UnitController::class, "edit"])->name('unit.edit');
        Route::post('/unit/delete', [\App\Http\Controllers\APIs\UnitController::class, "delete"])->name('unit.delete');
        Route::post('/unit/validate', [\App\Http\Controllers\APIs\UnitController::class, "validateCheck"])->name('unit.validate');
        Route::post('/unit/view/edit', [\App\Http\Controllers\APIs\UnitController::class, "viewEdit"])->name('unit.view.edit');

        Route::post('/user/list', [\App\Http\Controllers\APIs\UserController::class, "list"])->name('user.list');
        Route::post('/user/create', [\App\Http\Controllers\APIs\UserController::class, "create"])->name('user.create');
        Route::post('/user/edit', [\App\Http\Controllers\APIs\UserController::class, "edit"])->name('user.edit');
        Route::post('/user/delete', [\App\Http\Controllers\APIs\UserController::class, "delete"])->name('user.delete');
        Route::post('/user/validate', [\App\Http\Controllers\APIs\UserController::class, "validateCheck"])->name('user.validate');
        Route::post('/user/view/edit', [\App\Http\Controllers\APIs\UserController::class, "viewEdit"])->name('user.view.edit');

        Route::post('/employee/list', [\App\Http\Controllers\APIs\EmployeeController::class, "list"])->name('employee.list');
        Route::post('/employee/create', [\App\Http\Controllers\APIs\EmployeeController::class, "create"])->name('employee.create');
        Route::post('/employee/edit', [\App\Http\Controllers\APIs\EmployeeController::class, "edit"])->name('employee.edit');
        Route::post('/employee/delete', [\App\Http\Controllers\APIs\EmployeeController::class, "delete"])->name('employee.delete');
        Route::post('/employee/validate', [\App\Http\Controllers\APIs\EmployeeController::class, "validateCheck"])->name('employee.validate');
        Route::post('/employee/view/edit', [\App\Http\Controllers\APIs\EmployeeController::class, "viewEdit"])->name('employee.view.edit');

        Route::post('/prefix/list', [\App\Http\Controllers\APIs\PrefixController::class, "list"])->name('prefix.list');
        Route::post('/prefix/create', [\App\Http\Controllers\APIs\PrefixController::class, "create"])->name('prefix.create');
        Route::post('/prefix/edit', [\App\Http\Controllers\APIs\PrefixController::class, "edit"])->name('prefix.edit');
        Route::post('/prefix/delete', [\App\Http\Controllers\APIs\PrefixController::class, "delete"])->name('prefix.delete');
        Route::post('/prefix/validate', [\App\Http\Controllers\APIs\PrefixController::class, "validateCheck"])->name('prefix.validate');
        Route::post('/prefix/view/edit', [\App\Http\Controllers\APIs\PrefixController::class, "viewEdit"])->name('prefix.view.edit');

        Route::post('/receive-material/list', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "list"])->name('receive.material.list');
        Route::post('/receive-material/print', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "printMaterials"])->name('receive.material.print');
        Route::post('/receive-material/delete', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "delete"])->name('receive.material.delete');
        Route::post('/receive-material/view/edit', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "viewEdit"])->name('receive.material.view.edit');
        Route::post('/receive-materiual/validate', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "validateCheck"])->name('receive.material.validate');
        Route::post('/receive-materiual/validate-receive', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "validateCheckReceive"])->name('receive.material.validate.receive');
        Route::post('/receive-material/create', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "createReceiveMaterial"])->name('receive.material.create');
        Route::post('/receive-material/create-material-lot', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "createMaterialLot"])->name('receive.material.create.lot');
        Route::post('/receive-material/find/company', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "findCompanyById"])->name('receive.material.find.company');
        Route::post('/receive-material/find/material', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "findMaterialById"])->name('receive.material.find.material');
        Route::post('/receive-material/list/view/edit', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "listViewEditReceiveMaterial"])->name('receive.material.list.view.edit');
        Route::post('/receive-material/list/material-lot', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "listMaterialLot"])->name('receive.material.list.material.lot');
        Route::post('/receive-materil/edit/', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "editReceiveMaterial"])->name('receive.material.edit');
        Route::post('/receive-material/history', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "historyReceiveMaterial"])->name('receive.material.history');
        Route::post('/receive-material/edit/inspect_ready', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "editInspect_ready"])->name('receive.material.edit.inspect.ready');
        Route::post('/receive-material/list/history', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "listMasterReceiveMaterial"])->name('receive.material.list.history.master');

        Route::post('/receive-material/check/list', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "listCheckReceiveMaterial"])->name('receive.material.check.list');
        Route::post('/receive-material/view/check', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "viewCheckReceiveMaterial"])->name('receive.material.check.view');
        Route::post("/receive-material/transport/validate", [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "validateConfirmTransportCheck"])->name('receive.material.validate.transport.confirm.check');
        Route::post('/receive-material/transport/confirmCheck', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "confirmTransportCheck"])->name('receive.material.transport.confirm.check');
        Route::post("/receive-material/lot-no-pm/change", [\App\Http\Controllers\APIs\MaterialLotController::class, "updateLotNoPM"])->name('receive.material.lot.no.pm.change');
        Route::post('/receive-material/quality/get/template/detail', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "getTemplateDetail"])->name('receive.material.get.template.detail');
        Route::post('/receive-material/quality/getInspectDetailByMaterialLotID', [\App\Http\Controllers\APIs\MaterialInspectController::class, "getInspectDetail"])->name('receive.material.quality.check.detail');
        Route::post('/receive-material/check/list/lot-no-pm', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "listCheckReceiveMaterialLotNoPm"])->name('receive.material.check.list.lot.no.pm');
        Route::post('/receive-material/set/stepBackToReceive', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "stepBackToReceive"])->name('receive.material.step.back.to.receive');
        Route::post('/receive-material/set/stepToLotNoPM', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "stepToLotNoPM"])->name('receive.material.step.lotnopm');
        Route::post('/receive-material/set/stepBackToInspect', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "stepBackToInspect"])->name('receive.material.step.back.to.inspect');
        Route::post('/receive-material/set/stepToPending', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "stepToPending"])->name('receive.material.step.pending');
        Route::post('/receive-material/set/stepToHistory', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "stepToHistory"])->name('receive.material.step.history');
        Route::post('/receive-material/reject', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "rejectReceiveMaterial"])->name('receive.material.reject');
        Route::post('/receive-material/pending/list', [\App\Http\Controllers\APIs\ReceiveMaterialController::class, "listPendingReceiveMaterial"])->name('receive.material.pending.list');
        Route::get('/receive-material/list/lot', [\App\Http\Controllers\APIs\MaterialLotController::class, "lotDatetime"])->name('material.list.lot');


        Route::post('/receive-packaging/list', [\App\Http\Controllers\APIs\ReceivePackagingController::class, "list"])->name('receive.packaging.list');
        Route::post('/receive-packaging/delete', [\App\Http\Controllers\APIs\ReceivePackagingController::class, "delete"])->name('receive.packaging.delete');
        Route::post('/receive-packaging/inspect/list', [\App\Http\Controllers\APIs\ReceivePackagingController::class, "listInspectReceivePackaging"])->name('receive.packaging.inspect.list');
        Route::post('/receive-packaging/lot-no-pm/list', [\App\Http\Controllers\APIs\ReceivePackagingController::class, "listReceivePackagingLotNoPm"])->name('receive.packaging.lot.no.pm.list');
        Route::post('/receive-packaging/create', [\App\Http\Controllers\APIs\ReceivePackagingController::class, "createReceivePackaging"])->name('receive.packaging.create');
        Route::post('/receive-packaging/list/view/edit', [\App\Http\Controllers\APIs\ReceivePackagingController::class, "listViewEditReceivePackaging"])->name('receive.packaging.list.view.edit');
        Route::post('/receive-packaging/list/packaging-lot', [\App\Http\Controllers\APIs\ReceivePackagingController::class, "listPackagingLot"])->name('receive.packaging.list.packaging.lot');
        Route::post('/receive-packaging/edit', [\App\Http\Controllers\APIs\ReceivePackagingController::class, "editReceivePackaging"])->name('receive.packaging.edit');
        Route::post('/receive-packaging/history', [\App\Http\Controllers\APIs\ReceivePackagingController::class, "historyReceivePackagings"])->name('receive.packaging.history');
        Route::post("/receive-packaging/lot-no-pm/change", [\App\Http\Controllers\APIs\PackagingLotController::class, "updateLotNoPM"])->name('receive.packaging.lot.no.pm.change');
        Route::post('/receive-packaging/transport/confirmCheck', [\App\Http\Controllers\APIs\ReceivePackagingController::class, "confirmTransportCheck"])->name('receive.packaging.transport.confirm.check');
        Route::post('/receive-packaging/quality/getInspectDetailByPackaingLotID', [\App\Http\Controllers\APIs\PackagingInspectController::class, "getInspectDetail"])->name('receive.packaging.quality.check.detail');
        Route::post('/receive-packaging/quality/get/template/detail', [\App\Http\Controllers\APIs\ReceivePackagingController::class, "getTemplateDetail"])->name('receive.packaging.get.template.detail');
        Route::post('/receive-packaging/edit/inspect_ready', [\App\Http\Controllers\APIs\ReceivePackagingController::class, "editInspect_ready"])->name('receive.packaging.edit.inspect.ready');
        Route::post('/receive-packaging/set/stepBackToReceive', [\App\Http\Controllers\APIs\ReceivePackagingController::class, "stepBackToReceive"])->name('receive.packaging.step.back.to.receive');
        Route::post('/receive-packaging/set/stepToLotNoPM', [\App\Http\Controllers\APIs\ReceivePackagingController::class, "stepToLotNoPM"])->name('receive.packaging.step.lotnopm');
        Route::post('/receive-packaging/set/stepBackToInspect', [\App\Http\Controllers\APIs\ReceivePackagingController::class, "stepBackToInspect"])->name('receive.packaging.step.back.to.inspect');
        Route::post('/receive-packaging/set/stepToPending', [\App\Http\Controllers\APIs\ReceivePackagingController::class, "stepToPending"])->name('receive.packaging.step.pending');
        Route::post('/receive-packaging/set/stepToHistory', [\App\Http\Controllers\APIs\ReceivePackagingController::class, "stepToHistory"])->name('receive.packaging.step.history');
        Route::post('/receive-packaging/reject', [\App\Http\Controllers\APIs\ReceivePackagingController::class, "rejectReceivePackaging"])->name('receive.packaging.reject');
        Route::post('/receive-packaging/pending/list', [\App\Http\Controllers\APIs\ReceivePackagingController::class, "listPendingReceivePackaging"])->name('receive.packaging.pending.list');
        Route::post('/receive-packaging/list/history', [\App\Http\Controllers\APIs\ReceivePackagingController::class, "listMasterReceivePackaging"])->name('receive.packaging.list.history.master');


        Route::post('/receive-product/list', [\App\Http\Controllers\APIs\ReceiveProductController::class, "list"])->name('receive.product.list');
        Route::post('/receive-product/delete', [\App\Http\Controllers\APIs\ReceiveProductController::class, "delete"])->name('receive.product.delete');
        Route::post('/receive-product/check/list', [\App\Http\Controllers\APIs\ReceiveProductController::class, "listCheckReceiveProduct"])->name('receive.product.check.list');
        Route::post('/receive-product/create', [\App\Http\Controllers\APIs\ReceiveProductController::class, "createReceiveProduct"])->name('receive.product.create');
        Route::post('/receive-product/edit', [\App\Http\Controllers\APIs\ReceiveProductController::class, "editReceiveProduct"])->name('receive.product.edit');
        Route::post('/receive-prodcut/history', [\App\Http\Controllers\APIs\ReceiveProductController::class, "historyReceiveProducts"])->name('receive.product.history');
        Route::post('/receive-product/list/product-lot', [\App\Http\Controllers\APIs\ReceiveProductController::class, "listProductLot"])->name('receive.product.list.product.lot');
        Route::post('/receive-product/quality/getInspectDetailByProductLotID', [\App\Http\Controllers\APIs\ProductInspectController::class, "getInspectDetail"])->name('receive.product.quality.check.detail');
        Route::post('/receive-product/quality/get/template/detail', [\App\Http\Controllers\APIs\ReceiveProductController::class, "getTemplateDetail"])->name('receive.product.get.template.detail');
        Route::post('/receive-product/pending/list', [\App\Http\Controllers\APIs\ReceiveProductController::class, "listPendingReceiveProduct"])->name('receive.product.pending.list');
        Route::post('/receive-product/list/history', [\App\Http\Controllers\APIs\ReceiveProductController::class, "listMasterReceiveProduct"])->name('receive.product.list.history.master');
        Route::post('/receive-product/edit/inspect_ready', [\App\Http\Controllers\APIs\ReceiveProductController::class, "editInspect_ready"])->name('receive.product.edit.inspect.ready');
        Route::post('/receive-product/set/stepBackToInspect', [\App\Http\Controllers\APIs\ReceiveProductController::class, "stepBackToInspect"])->name('receive.product.step.back.to.inspect');
        Route::post('/receive-product/set/stepToPending', [\App\Http\Controllers\APIs\ReceiveProductController::class, "stepToPending"])->name('receive.product.step.pending');
        Route::post('/receive-product/set/stepToHistory', [\App\Http\Controllers\APIs\ReceiveProductController::class, "stepToHistory"])->name('receive.product.step.history');
        Route::post('/receive-product/set/stepBackToReceive', [\App\Http\Controllers\APIs\ReceiveProductController::class, "stepBackToReceive"])->name('receive.product.step.back.to.receive');

        Route::post('/receive-supply/list', [\App\Http\Controllers\APIs\ReceiveSupplyController::class, "list"])->name('receive.supply.list');
        Route::post('/receive-supply/delete', [\App\Http\Controllers\APIs\ReceiveSupplyController::class, "delete"])->name('receive.supply.delete');
        Route::post('/receive-supply/create', [\App\Http\Controllers\APIs\ReceiveSupplyController::class, "createReceiveSupply"])->name('receive.supply.create');
        Route::post('/receive-supply/view/edit', [\App\Http\Controllers\APIs\ReceiveSupplyController::class, "listViewEditReceiveSupply"])->name('receive.supply.view.edit');
        Route::post('/receive-supply/list/supply-lot', [\App\Http\Controllers\APIs\ReceiveSupplyController::class, "listSupplyLot"])->name('receive.supply.list.supply.lot');
        Route::post('/receive-supply/edit', [\App\Http\Controllers\APIs\ReceiveSupplyController::class, "editReceiveSupply"])->name('receive.supply.edit');
        Route::post('/receive-supply/view/history', [\App\Http\Controllers\APIs\ReceiveSupplyController::class, "historyReceiveSupply"])->name('receive.supply.history');
        Route::post('/receive-supply/pending/list', [\App\Http\Controllers\APIs\ReceiveSupplyController::class, "listPendingReceiveSupply"])->name('receive.supply.pending.list');
        Route::post('/receive-supply/list/history-page', [\App\Http\Controllers\APIs\ReceiveSupplyController::class, "listMasterReceiveSupply"])->name('receive.supply.list.history.master');
        Route::post('/receive-supply/set/stepToPending', [\App\Http\Controllers\APIs\ReceiveSupplyController::class, "stepToPending"])->name('receive.supply.step.pending');
        Route::post('/receive-supply/set/stepToHistory', [\App\Http\Controllers\APIs\ReceiveSupplyController::class, "stepToHistory"])->name('receive.supply.step.history');
        Route::post('/receive-supply/set/stepBackToReceive', [\App\Http\Controllers\APIs\ReceiveSupplyController::class, "stepBackToReceive"])->name('receive.supply.step.back.to.receive');
        Route::post('/receive-supply/reject', [\App\Http\Controllers\APIs\ReceiveSupplyController::class, "rejectReceiveSupply"])->name('receive.supply.reject');
        Route::post('/receive-supply/set/stepBackToReceive', [\App\Http\Controllers\APIs\ReceiveSupplyController::class, "stepBackToReceive"])->name('receive.supply.step.back.to.receive');

        Route::post('/requsition-material/list/material-lot', [\App\Http\Controllers\APIs\RequsitionMaterialController::class, "getMaterialLotByMaterialsId"])->name('requsition.list.material.lot');
        Route::post('/requsition-material/create', [\App\Http\Controllers\APIs\RequsitionMaterialController::class, "createRequsitionMaterial"])->name('requsition.material.create');
        Route::post('/requsition-material/list', [\App\Http\Controllers\APIs\RequsitionMaterialController::class, "list"])->name('requsition.material.list');
        Route::post('/requsition-material/delete', [\App\Http\Controllers\APIs\RequsitionMaterialController::class, "delete"])->name('requsition.material.delete');
        Route::post('/requsition-material/inspect/cut-material/list', [\App\Http\Controllers\APIs\RequsitionMaterialController::class, "listInspectCut"])->name('requsition.inspect.material.cut.list');
        Route::post('/requsition-material/cut-material/lot', [\App\Http\Controllers\APIs\RequsitionMaterialController::class, "getRequsitionMaterialLotByID"])->name('requsition.material.cut.lot');
        Route::post('/requsition-material/edit', [\App\Http\Controllers\APIs\RequsitionMaterialController::class, "editRequsitionMaterial"])->name('requsition.material.edit');
        Route::post('/requsition-material/history', [\App\Http\Controllers\APIs\RequsitionMaterialController::class, "getHistoryRequsitionMaterialByID"])->name('requsition.material.history');
        Route::post('/requsition-material/return-material/list', [\App\Http\Controllers\APIs\RequsitionMaterialController::class, "listReturnMaterial"])->name('requsition.material.return.list');
        Route::post('/requsition-material/return-material/create', [\App\Http\Controllers\APIs\RequsitionMaterialController::class, "createReturnMaterial"])->name('requsition.material.return.create');
        Route::post('/requsition-material/inspect/return-material/list', [\App\Http\Controllers\APIs\RequsitionMaterialController::class, "listInspectReturn"])->name('requsition.inspect.material.return.list');
        Route::post('/requsition-material/history/list', [\App\Http\Controllers\APIs\RequsitionMaterialController::class, "listHistoryRequsitionMaterial"])->name('requsition.material.history.list');
        Route::post('/requsition-material/set/stepToInspectCut', [\App\Http\Controllers\APIs\RequsitionMaterialController::class, "stepToInspectCut"])->name('requsition.material.step.to.inspect.cut');
        Route::post('/requsition-material/set/stepBackToCut', [\App\Http\Controllers\APIs\RequsitionMaterialController::class, "stepBackToCut"])->name('requsition.material.step.back.to.cut');
        Route::post('/requsition-material/set/stepToPending', [\App\Http\Controllers\APIs\RequsitionMaterialController::class, "stepToPendingCut"])->name('requsition.material.step.to.pending');
        Route::post('/requsition-material/set/stepToPendingReturn', [\App\Http\Controllers\APIs\RequsitionMaterialController::class, "stepToPendingReturn"])->name('requsition.material.step.to.pending.return');
        Route::post('/requsition-material/set/stepToReturn', [\App\Http\Controllers\APIs\RequsitionMaterialController::class, "stepToReturn"])->name('requsition.material.step.to.return');
        Route::post('/requsition-material/set/stepToInspectReturn', [\App\Http\Controllers\APIs\RequsitionMaterialController::class, "stepToInspectReturn"])->name('requsition.material.step.to.inspect.return');
        Route::post('/requsition-material/set/stepBackToReturn', [\App\Http\Controllers\APIs\RequsitionMaterialController::class, "stepBackToReturn"])->name('requsition.material.step.back.to.return');
        Route::post('/requsition-material/set/stepToHistory', [\App\Http\Controllers\APIs\RequsitionMaterialController::class, "stepToHistory"])->name('requsition.material.step.to.history');
        Route::post('/requsition-material/pending/list', [\App\Http\Controllers\APIs\RequsitionMaterialController::class, "listPendingRequsitionMaterial"])->name('requsition.material.pending.list');
        Route::post('/requsition-material/pending/return/list', [\App\Http\Controllers\APIs\RequsitionMaterialController::class, "listPendingReturnRequsitionMaterial"])->name('requsition.material.pending.return.list');


        Route::post('/requsition-packaging/claim/packaging/list', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "listClaimPackaging"])->name('requsition.packaging.claim.list');
        Route::post('/requsition-packaging/claim/packaging/return', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "returnClaimPackaging"])->name('requsition.packaging.return.claim');
        Route::post('/requsition-packaging/claim/packaging/claim', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "cancelClaimPackaging"])->name('requsition.packaging.cancel.claim');

        Route::post('/requsition-packaging/list', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "list"])->name('requsition.packaging.list');
        Route::post('/requsition-packaging/delete', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "delete"])->name('requsition.packaging.delete');
        Route::post('/requsition-packaging/inspect-cut/packaging/list', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "listInspectRequsitionPackaging"])->name('requsition.packaging.inspect.cut.list');
        Route::post('/requsition-packaging/return/packaging/list', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "listReturnPackaging"])->name('requsition.packaging.return.list');
        Route::post('/requsition-packaging/return/inspect/packaging/list', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "listInspectReturnPackaging"])->name('requsition.packaging.inspect.return.list');
        Route::post('/requsition-packaging/list/packaging-lot', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "getPackagingLotByPackagingId"])->name('requsition.list.packaging.lot');
        Route::post('/requsition-packaging/create', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "createRequsitionPackaging"])->name('requsition.packaging.create');
        Route::post('/requsition-packaging/packaging-cut/lot', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "getRequsitionPackagingLotByID"])->name('requsition.packaging.cut.lot');
        Route::post('/requsition-packaging/edit', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "editRequsitionPackaging"])->name('requsition.packaging.edit');
        Route::post('/requsition-packaging/history', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "getHistoryRequsitionPackagingByID"])->name('requsition.packaging.history');
        Route::post('/requsition-packaging/inspect/return-packaging/list', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "listInspectReturn"])->name('requsition.inspect.packaging.return.list');
        Route::post('/requsition-packaging/return-packaging/create', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "createReturnPackaging"])->name('requsition.packaging.return.create');
        Route::post('/requsition-packaging/history-packaging', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "listHistoryReturnPackaging"])->name('requsition.packaging.list.history');
        Route::post('/requsition-packaging/set/stepToInspectCut', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "stepToInspectCut"])->name('requsition.packaging.step.to.inspect.cut');
        Route::post('/requsition-packaging/set/stepBackToCut', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "stepBackToCut"])->name('requsition.packaging.step.back.to.cut');
        Route::post('/requsition-packaging/set/stepToPending', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "stepToPending"])->name('requsition.packaging.step.to.pending');
        Route::post('/requsition-packaging/set/stepToPending/return', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "stepToPendingReturn"])->name('requsition.packaging.step.to.pending.return');
        Route::post('/requsition-packaging/set/stepToReturn', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "stepToReturn"])->name('requsition.packaging.step.to.return');
        Route::post('/requsition-packaging/set/stepToInspectReturn', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "stepToInspectReturn"])->name('requsition.packaging.step.to.inspect.return');
        Route::post('/requsition-packaging/set/stepBackToReturn', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "stepBackToReturn"])->name('requsition.packaging.step.back.to.return');
        Route::post('/requsition-packaging/set/stepToHistory', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "stepToHistory"])->name('requsition.packaging.step.to.history');
        Route::post('/requsition-packaging/pending/list', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "listPendingRequsitionPackaging"])->name('requsition.packaging.pending.list');
        Route::post('/requsition-packaging/pending/return/list', [\App\Http\Controllers\APIs\RequsitionPackagingController::class, "listPendingReturnRequsitionPackaging"])->name('requsition.packaging.pending.return.list');

        Route::post('/requsition-supply/list', [\App\Http\Controllers\APIs\RequsitionSupplyController::class, "list"])->name('requsition.supply.list');
        Route::post('/requsition-supply/delete', [\App\Http\Controllers\APIs\RequsitionSupplyController::class, "delete"])->name('requsition.supply.delete');
        Route::post('/requsition-supply/set/stepToHistory', [\App\Http\Controllers\APIs\RequsitionSupplyController::class, "stepToHistory"])->name('requsition.supply.step.to.history');
        Route::post('/requsition-supply/history', [\App\Http\Controllers\APIs\RequsitionSupplyController::class, "listHistory"])->name('requsition.supply.list.history');
        Route::post('/requsition-supply/list/supply-lot', [\App\Http\Controllers\APIs\RequsitionSupplyController::class, "getSupplyLotBySupplyId"])->name('requsition.list.supply.lot');
        Route::post('/requsition-supply/create', [\App\Http\Controllers\APIs\RequsitionSupplyController::class, "createRequsitionSupply"])->name('requsition.supply.create');
        Route::post('/requsition-supply/cut-supply/lot', [\App\Http\Controllers\APIs\RequsitionSupplyController::class, "getRequsitionSupplyLotByID"])->name('requsition.supply.cut.lot');
        Route::post('/requsition-supply/edit', [\App\Http\Controllers\APIs\RequsitionSupplyController::class, "editRequsitionSupply"])->name('requsition.supply.edit');
        Route::post('/requsition-supply/view/history', [\App\Http\Controllers\APIs\RequsitionSupplyController::class, "historyRequsitionSupply"])->name('requsition.supply.history');

        Route::post('/requsition-product/list', [\App\Http\Controllers\APIs\RequsitionProductController::class, "list"])->name('requsition.product.list');
        Route::post('/requsition-product/delete', [\App\Http\Controllers\APIs\RequsitionProductController::class, "delete"])->name('requsition.product.delete');
        Route::post('/requsition-product/inspect/list', [\App\Http\Controllers\APIs\RequsitionProductController::class, "listInspect"])->name('requsition.product.inspect.list');
        Route::post('/requsition-product/pending/list', [\App\Http\Controllers\APIs\RequsitionProductController::class, "listPending"])->name('requsition.product.pending.list');
        Route::post('/requsition-product/history/list', [\App\Http\Controllers\APIs\RequsitionProductController::class, "listHistory"])->name('requsition.product.history.list');
        Route::post('/requsition-product/set/stepToHistory', [\App\Http\Controllers\APIs\RequsitionProductController::class, "stepToHistory"])->name('requsition.product.step.to.history');
        Route::post('/requsition-product/list/product-lot', [\App\Http\Controllers\APIs\RequsitionProductController::class, "getProductLotByProductId"])->name('requsition.list.product.lot');
        Route::post('/requsition-product/create', [\App\Http\Controllers\APIs\RequsitionProductController::class, "createRequsitionProduct"])->name('requsition.product.create');
        Route::post('/requsition-product/cut-product/lot', [\App\Http\Controllers\APIs\RequsitionProductController::class, "getRequsitionProductLotByID"])->name('requsition.product.cut.lot');
        Route::post('/requsition-product/edit', [\App\Http\Controllers\APIs\RequsitionProductController::class, "editRequsitionProduct"])->name('requsition.product.edit');
        Route::post('/requsition-product/view/history', [\App\Http\Controllers\APIs\RequsitionProductController::class, "historyRequsitionProduct"])->name('requsition.product.history');
        Route::post('/requsition-product/set/stepToInspect', [\App\Http\Controllers\APIs\RequsitionProductController::class, "stepToInspect"])->name('requsition.product.step.to.inspect');
        Route::post('/requsition-product/set/stepToPending', [\App\Http\Controllers\APIs\RequsitionProductController::class, "stepToPending"])->name('requsition.product.step.to.pending');
        Route::post('/requsition-product/set/stepReject', [\App\Http\Controllers\APIs\RequsitionProductController::class, "stepReject"])->name('requsition.product.step.reject');
        Route::post('/requsition-product/set/stepToHistory', [\App\Http\Controllers\APIs\RequsitionProductController::class, "stepToHistory"])->name('requsition.product.step.to.history');
    }
);

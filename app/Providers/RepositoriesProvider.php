<?php

namespace App\Providers;

use App\Models\HistoryPackagingLot;
use Illuminate\Support\ServiceProvider;

//Master Interface
use App\Repositories\BaseInterface;
use App\Repositories\CategoryInterface;
use App\Repositories\CompanyInterface;
use App\Repositories\EmployeeInterface;
use App\Repositories\HistoryReceiveMaterialInterface;
use App\Repositories\HistoryReceivePackagingInterface;
use App\Repositories\HistoryReceiveProductInterface;
use App\Repositories\HistoryReceiveSupplyInterface;
use App\Repositories\HistoryRequsitionMaterialInterface;
use App\Repositories\HistoryRequsitionPackagingInterface;
use App\Repositories\HistoryRequsitionProductInterface;
use App\Repositories\HistoryRequsitionSupplyInterface;
use App\Repositories\MaterialInterface;
use App\Repositories\MaterialTypeInterface;
use App\Repositories\PackagingInterface;
use App\Repositories\ReceiveMaterialInterface;
use App\Repositories\RoleInterface;
use App\Repositories\VehicleInterface;
use App\Repositories\VendorInterface;
use App\Repositories\InspectTopicTypeInterface;
use App\Repositories\ProductTypeInterface;
use App\Repositories\UnitInterface;
use App\Repositories\ProductUnitInterface;
use App\Repositories\PrefixInterface;
use App\Repositories\InspectTemplateInterface;
use App\Repositories\InspectTopicInterface;
use App\Repositories\InspectTemplateDetailInterface;
use App\Repositories\CosmeticsInterface;
use App\Repositories\SupplementInterface;
use App\Repositories\PackagingUnitInterface;
use App\Repositories\FdaBrandInterface;
use App\Repositories\MaterialUnitInterface;
use App\Repositories\TransportPicInterface;

//Master Repository
use App\Repositories\Impl\BaseRepository;
use App\Repositories\Impl\CategoryRepository;
use App\Repositories\Impl\CompanyRepository;
use App\Repositories\Impl\EmployeeRepository;
use App\Repositories\Impl\HistoryReceiveMaterialRepository;
use App\Repositories\Impl\HistoryReceivePackagingRepository;
use App\Repositories\Impl\HistoryReceiveProductRepository;
use App\Repositories\Impl\HistoryReceiveSupplyRepository;
use App\Repositories\Impl\HistoryRequsitionMaterialRepository;
use App\Repositories\Impl\HistoryRequsitionPackagingRepository;
use App\Repositories\Impl\HistoryRequsitionProductRepository;
use App\Repositories\Impl\HistoryRequsitionSupplyRepository;
use App\Repositories\Impl\InspectTemplateDetailRepository;
use App\Repositories\Impl\InspectTemplateRepository;
use App\Repositories\Impl\InspectTopicRepository;
use App\Repositories\Impl\InspectTopicTypeRepository;
use App\Repositories\Impl\MaterialCutReturnRepository;
use App\Repositories\Impl\MaterialInspectDetailRepository;
use App\Repositories\Impl\MaterialInspectRepository;
use App\Repositories\Impl\MaterialLotRepository;
use App\Repositories\Impl\MaterialRepository;
use App\Repositories\Impl\MaterialReturnCutRepository;
use App\Repositories\Impl\MaterialTypeRepository;
use App\Repositories\Impl\PackagingCutReturnRepository;
use App\Repositories\Impl\PackagingInspectDetailRepository;
use App\Repositories\Impl\PackagingInspectRepository;
use App\Repositories\Impl\PackagingLotRepository;
use App\Repositories\Impl\PackagingRepository;
use App\Repositories\Impl\PrefixRepository;
use App\Repositories\Impl\ProductCutRepository;
use App\Repositories\Impl\ProductInspectDetailRepository;
use App\Repositories\Impl\ProductInspectRepository;
use App\Repositories\Impl\ProductLotRepository;
use App\Repositories\Impl\ProductRepository;
use App\Repositories\Impl\ProductTypeRepository;
use App\Repositories\Impl\ProductUnitRepository;
use App\Repositories\Impl\ReceiveMaterialRepository;
use App\Repositories\Impl\ReceivePackagingRepository;
use App\Repositories\Impl\ReceiveProductRepository;
use App\Repositories\Impl\ReceiveSupplyRepository;
use App\Repositories\Impl\RequsitionMaterialRepository;
use App\Repositories\Impl\RequsitionPackagingRepository;
use App\Repositories\Impl\RequsitionProductRepository;
use App\Repositories\Impl\RequsitionSupplyRepository;
use App\Repositories\Impl\RoleRepository;
use App\Repositories\Impl\SetPlanRepository;
use App\Repositories\Impl\SupplyCutRepository;
use App\Repositories\Impl\SupplyLotRepository;
use App\Repositories\Impl\SupplyRepository;
use App\Repositories\Impl\UnitRepository;
use App\Repositories\Impl\UserCompanyRepository;
use App\Repositories\Impl\UserRepository;
use App\Repositories\Impl\VehicleRepository;
use App\Repositories\Impl\VendorRepository;
use App\Repositories\Impl\CosmeticsRepository;
use App\Repositories\Impl\SupplementRepository;
use App\Repositories\Impl\PackagingUnitRepository;
use App\Repositories\Impl\FdaBrandRepository;
use App\Repositories\Impl\MaterialUnitRepository;
use App\Repositories\Impl\TransportPicRepository;

use App\Repositories\MaterialCutReturnInterface;
use App\Repositories\MaterialInspectDetailInterface;
use App\Repositories\MaterialInspectInterface;
use App\Repositories\MaterialLotInterface;
use App\Repositories\PackagingInspectDetailInterface;
use App\Repositories\MaterialReturnCutInterface;
use App\Repositories\PackagingCutReturnInterface;
use App\Repositories\PackagingInspectInterface;
use App\Repositories\PackagingLotInterface;
use App\Repositories\ProductCutInterface;
use App\Repositories\ProductInspectDetailInterface;
use App\Repositories\ProductInspectInterface;
use App\Repositories\ProductInterface;
use App\Repositories\ProductLotInterface;
use App\Repositories\ReceivePackagingInterface;
use App\Repositories\ReceiveProductInterface;
use App\Repositories\ReceiveSupplyInterface;
use App\Repositories\RequsitionMaterialInterface;
use App\Repositories\RequsitionPackagingInterface;
use App\Repositories\RequsitionProductInterface;
use App\Repositories\RequsitionSupplyInterface;
use App\Repositories\SetPlanInterface;
use App\Repositories\SupplyCutInterface;
use App\Repositories\SupplyInterface;
use App\Repositories\SupplyLotInterface;
use App\Repositories\UserCompanyInterface;
use App\Repositories\UserInterface;

class RepositoriesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BaseInterface::class, BaseRepository::class);
        $this->app->bind(MaterialTypeInterface::class, MaterialTypeRepository::class);
        $this->app->bind(MaterialInterface::class, MaterialRepository::class);
        $this->app->bind(PackagingInterface::class, PackagingRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(SupplyInterface::class, SupplyRepository::class);
        $this->app->bind(CompanyInterface::class, CompanyRepository::class);
        $this->app->bind(VehicleInterface::class, VehicleRepository::class);
        $this->app->bind(ReceiveMaterialInterface::class, ReceiveMaterialRepository::class);
        $this->app->bind(VendorInterface::class, VendorRepository::class);
        $this->app->bind(RoleInterface::class, RoleRepository::class);
        $this->app->bind(InspectTopicTypeInterface::class, InspectTopicTypeRepository::class);
        $this->app->bind(ProductTypeInterface::class, ProductTypeRepository::class);
        $this->app->bind(ProductUnitInterface::class, ProductUnitRepository::class);
        $this->app->bind(UnitInterface::class, UnitRepository::class);
        $this->app->bind(PrefixInterface::class, PrefixRepository::class);
        $this->app->bind(InspectTopicInterface::class, InspectTopicRepository::class);
        $this->app->bind(InspectTemplateInterface::class, InspectTemplateRepository::class);
        $this->app->bind(InspectTemplateDetailInterface::class, InspectTemplateDetailRepository::class);
        $this->app->bind(MaterialLotInterface::class, MaterialLotRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(ReceivePackagingInterface::class, ReceivePackagingRepository::class);
        $this->app->bind(PackagingLotInterface::class, PackagingLotRepository::class);
        $this->app->bind(HistoryReceiveMaterialInterface::class, HistoryReceiveMaterialRepository::class);
        $this->app->bind(HistoryReceivePackagingInterface::class, HistoryReceivePackagingRepository::class);
        $this->app->bind(MaterialInspectInterface::class, MaterialInspectRepository::class);
        $this->app->bind(MaterialInspectDetailInterface::class, MaterialInspectDetailRepository::class);
        $this->app->bind(ReceiveProductInterface::class, ReceiveProductRepository::class);
        $this->app->bind(ProductLotInterface::class, ProductLotRepository::class);
        $this->app->bind(HistoryReceiveProductInterface::class, HistoryReceiveProductRepository::class);
        $this->app->bind(PackagingInspectInterface::class, PackagingInspectRepository::class);
        $this->app->bind(PackagingInspectDetailInterface::class, PackagingInspectDetailRepository::class);
        $this->app->bind(RequsitionMaterialInterface::class, RequsitionMaterialRepository::class);
        $this->app->bind(MaterialCutReturnInterface::class, MaterialCutReturnRepository::class);
        $this->app->bind(HistoryRequsitionMaterialInterface::class, HistoryRequsitionMaterialRepository::class);
        $this->app->bind(PackagingCutReturnInterface::class, PackagingCutReturnRepository::class);
        $this->app->bind(RequsitionPackagingInterface::class, RequsitionPackagingRepository::class);
        $this->app->bind(HistoryRequsitionPackagingInterface::class, HistoryRequsitionPackagingRepository::class);
        $this->app->bind(ProductInspectInterface::class, ProductInspectRepository::class);
        $this->app->bind(ProductInspectDetailInterface::class, ProductInspectDetailRepository::class);
        $this->app->bind(UserCompanyInterface::class, UserCompanyRepository::class);
        $this->app->bind(ReceiveSupplyInterface::class, ReceiveSupplyRepository::class);
        $this->app->bind(SupplyLotInterface::class, SupplyLotRepository::class);
        $this->app->bind(SupplyCutInterface::class, SupplyCutRepository::class);
        $this->app->bind(HistoryReceiveSupplyInterface::class, HistoryReceiveSupplyRepository::class);
        $this->app->bind(RequsitionSupplyInterface::class, RequsitionSupplyRepository::class);
        $this->app->bind(HistoryRequsitionSupplyInterface::class, HistoryRequsitionSupplyRepository::class);
        $this->app->bind(SetPlanInterface::class, SetPlanRepository::class);
        $this->app->bind(RequsitionProductInterface::class, RequsitionProductRepository::class);
        $this->app->bind(ProductCutInterface::class, ProductCutRepository::class);
        $this->app->bind(HistoryRequsitionProductInterface::class, HistoryRequsitionProductRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(EmployeeInterface::class, EmployeeRepository::class);
        $this->app->bind(CosmeticsInterface::class, CosmeticsRepository::class);
        $this->app->bind(SupplementInterface::class, SupplementRepository::class);
        $this->app->bind(PackagingUnitInterface::class, PackagingUnitRepository::class);
        $this->app->bind(FdaBrandInterface::class, FdaBrandRepository::class);
        $this->app->bind(MaterialUnitInterface::class, MaterialUnitRepository::class);
        $this->app->bind(TransportPicInterface::class, TransportPicRepository::class);
    }
    

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

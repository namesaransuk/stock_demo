<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(CompanySeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(PrefixSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductUnitSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(PackagingSeeder::class);
        $this->call(MaterialSeeder::class);
        $this->call(VendorSeeder::class);
        $this->call(VehicleSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UserRoleSeeder::class);
        $this->call(UserCompanySeeder::class);
        $this->call(InspectTopicSeeder::class);
        $this->call(InspectTemplateSeeder::class);
        $this->call(InspectTemplateDetailSeeder::class);
        $this->call(ReceivePackagingSeeder::class);
        $this->call(ReceiveMaterialSeeder::class);
        $this->call(ReceiveProductSeeder::class);
        $this->call(PackagingLotSeeder::class);
        $this->call(MaterialLotSeeder::class);
        $this->call(MaterialInspectSeeder::class);
        $this->call(MaterialInspectDetailSeeder::class);
        $this->call(ProductLotSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(SupplySeeder::class);
        $this->call(ReceiveSupplySeeder::class);
        $this->call(SupplyLotSeeder::class);
        $this->call(RequsitionSupplySeeder::class);
        $this->call(SupplyCutSeeder::class);
    }
}

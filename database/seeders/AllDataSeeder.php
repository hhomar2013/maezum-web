<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\mysettings;
use App\Models\Taxes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class AllDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        Permission::create(['name' => 'AdminDashboard']);
        Permission::create(['name' => 'AddUsers']);
        Permission::create(['name' => 'UpdateUsers']);
        Permission::create(['name' => 'DeleteUsers']);

        $role = Role::findByName('admin');
        $role->givePermissionTo(['AdminDashboard', 'AddUsers', 'UpdateUsers', 'DeleteUsers']);

        mysettings::create([
            'app_name' => ['en' => 'Talabety', 'ar' => 'طلبيتي'],
            'app_logo' => '',
            'app_favicon' => '',
            'app_email' => 'info@email.com',
            'app_phone' => '01121593101',
            'app_country' => 'السعوديه',
            'app_mobile_link'=>"",
            'current_currency' => 'ريال',
        ]);



    }
}

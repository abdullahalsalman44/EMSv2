<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole=Role::create(['name'=>'admin']);
        $clientRole=Role::create(['name'=>'client']);
        $superAdminRole=Role::create(['name'=>'superAdmin']);

        $userPermissions=[
           'getsalonusingprovince','salon_index','salon_show'
           ,'food_index',
           'client_logout','index_event',
           'salon_event_food_index',
           'user_informations','delete_user_account',
           'search_salon',
           'dress_index','dress_show',
           'add_reservation','get_bill','update_reservation','delete_reservation','get_all_reservations',
           'get_client_reservations'
           ,'favorates_services',
            'show_discounts',
            'add_report','show_report'
        ];

        $adminPermissions=[
            'admin_logout',
            'store_event','index_event','delete_event',
            'salon_event_store','salon_show',
            'salon_event_food_index',
            'store_image_salon','delete_image_salon',
            'user_informations','update_salon',
            'get_bill','get_all_reservations',
            'create_discount','delete_discount','update_discount','show_discounts'
        ];

        $superAdminPermissions=[
            'storFood','food_index','food_delete','update_food',
            'salon_create','salon_delete','salon_index','salon_show',
            'dress_create','dress_delete','dress_update','dress_show','dress_index',
            'create_image_dress','delete_image_dress',
            'show_report','show_report_number'
        ];


        foreach($userPermissions as $permission){
            Permission::findOrCreate($permission,guardName:'web');
        }


        foreach($adminPermissions as $permission){
            Permission::findOrCreate($permission,guardName:'web');
        }

        foreach($superAdminPermissions as $permission){
            Permission::findOrCreate($permission,guardName:'web');
        }


        $adminRole->syncPermissions($adminPermissions);
        $clientRole->syncPermissions($userPermissions);
        $superAdminRole->syncPermissions($superAdminPermissions);

        $adminUser = User::create([
            'name'=>'abdullah',
            'email'=>'abd@gmail.com',
            'password'=>bcrypt('password')
        ]);
        $adminUser['email_verified_at'] = date("y-m-d",time());
        $adminUser->save();

        $adminUser->assignRole($adminRole);
        $permissions=$adminRole->permissions()->pluck('name')->toArray();
        $adminUser->givePermissionTo($permissions);

        $clientUser = User::create([
            'name'=>'ali',
            'email'=>'ali@gmail.com',
            'password'=>bcrypt('password')
        ]);

        $clientUser->assignRole($clientRole);
        $permissions=$clientRole->permissions()->pluck('name')->toArray();
        $clientUser->givePermissionTo($permissions);


        $superAdmin = User::query()->create([
            'name'=>'ahmad',
            'email'=>'ahmad@gmail.com',
            'password'=>bcrypt('password')
        ]);
        $superAdmin['email_verified_at']=date("y-m-d",time());
        $superAdmin->save();
        $superAdmin->assignRole($superAdminRole);
        $permissions=$superAdminRole->permissions()->pluck('name')->toArray();
        $superAdmin->givePermissionTo($superAdminPermissions);
    }


}

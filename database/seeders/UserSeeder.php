<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user = User::create([
            'name' => 'Pronoy',
            'email' => 'pronoy@gmail.com',
            'mobile' => '01685010517',
            'password' => Hash::make('12345678'),
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Role::create(['name' => 'Super Admin']);

        $user->assignRole('Super Admin');

        $permissions = [
            ['name' => 'user create', 'guard_name' => 'web'],
            ['name' => 'user edit', 'guard_name' => 'web'],
            ['name' => 'user delete', 'guard_name' => 'web']
        ];
        Permission::insert($permissions);

        $permissionForRole = ['user create', 'user edit', 'user delete'];
        $role = Role::findByName('Super Admin');
        $role->givePermissionTo($permissionForRole);
    }
}

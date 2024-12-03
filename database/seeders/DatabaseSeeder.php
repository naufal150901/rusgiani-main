<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $permissions = [
            'incoming-item-list',
            'incoming-item-create',
            'incoming-item-edit',
            'incoming-item-delete',
            'incoming-item-download',
            'outgoing-item-list',
            'outgoing-item-create',
            'outgoing-item-edit',
            'outgoing-item-delete',
            'outgoing-item-download',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'role-download',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'user-download',
            'transaction-list',
            'transaction-create',
            'transaction-edit',
            'transaction-delete',
            'transaction-download',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $user = User::create([
            'name' => 'Lord Daud',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12344321'),
            'email_verified_at' => now(),
        ]);

        $role = Role::create(['name' => 'Admin']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}

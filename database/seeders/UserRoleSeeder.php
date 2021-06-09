<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = Role::create(['name' => 'superadmin']);
        $admin = Role::create(['name' => 'admin']);
        $manager = Role::create(['name' => 'manager']);
        $sekertaris = Role::create(['name' => 'sekertaris']);
        $user_superadmin = User::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now()
        ]);
        $user_superadmin->assignRole('superadmin');
        $user_admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now()
        ]);
        $user_admin->assignRole('admin');
        $user_manager = User::create([
            'name' => 'Manager',
            'email' => 'manager@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now()
        ]);
        $user_manager->assignRole('manager');
        $user_sekertaris = User::create([
            'name' => 'Sekertaris',
            'email' => 'sekertaris@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now()
        ]);
        $user_sekertaris->assignRole('sekertaris');
    }
}

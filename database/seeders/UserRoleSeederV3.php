<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserRoleSeederV3 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $karyawan = Role::create(['name' => 'karyawan']);
        $user_karyawan = User::create([
            'name' => 'karyawan',
            'username' => 'karyawan',
            'email' => 'karyawan@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now()
        ]);
        $user_karyawan->assignRole($karyawan);

    }
}

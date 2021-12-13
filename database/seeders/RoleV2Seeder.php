<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleV2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $wakilpimpinan = Role::create(['name' => 'wakilpimpinan']);
        $kabid = Role::create(['name' => 'kabid']);
        $user_wakilpimpinan1 = User::create([
            'name' => 'wadir1',
            'username' => 'wadir1',
            'email' => 'wadir1@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now()
        ]);
        $user_wakilpimpinan1->assignRole($wakilpimpinan);
        $user_wakilpimpinan2 = User::create([
            'name' => 'wadir2',
            'username' => 'wadir2',
            'email' => 'wadir2@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now()
        ]);
        $user_wakilpimpinan2->assignRole($wakilpimpinan);
        $user_kabid = User::create([
            'name' => 'kabid',
            'username' => 'kabid',
            'email' => 'kabid@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now()
        ]);
        $user_kabid->assignRole($kabid);
        $user_kabid2 = User::create([
            'name' => 'kabid2',
            'username' => 'kabid2',
            'email' => 'kabid2@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now()
        ]);
        $user_kabid2->assignRole($kabid);
    }
}

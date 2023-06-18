<?php

namespace Database\Seeders;

use App\Models\User;
use App\Library\RoleTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::insert(
            [
                [
                    'name' => 'Admin',
                    'email' => 'admin_one@example.com',
                    'password' => bcrypt('1111aaaa'),
                ],
                [
                    'name' => 'Super Admin',
                    'email' => 'super_admin@example.com',
                    'password' => bcrypt('1111aaaa'),
                ],
                [
                    'name' => 'User',
                    'email' => 'user_one@example.com',
                    'password' => bcrypt('1111aaaa'),
                ],
                [
                    'name' => 'User Two',
                    'email' => 'user_two@example.com',
                    'password' => bcrypt('1111aaaa'),
                ],
            ]
        );

        User::find(1)->assignRole(RoleTag::ADMIN);
        User::find(2)->assignRole(RoleTag::SUPERADMIN);
        User::find(3)->assignRole(RoleTag::USER);
        User::find(4)->assignRole(RoleTag::USER);
    }
}

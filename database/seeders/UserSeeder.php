<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Carbon;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = [
            [
                'first_name' => 'Admin',
                'username' => 'superadmin',
                'password' => Hash::make('admin'),
                'role_id' =>'superadmin',
                'remember_token' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Accountant',
                'username' => 'accountant',
                'password' => Hash::make('accountant'),
                'role_id' =>'accountant',
                'remember_token' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Employee',
                'username' => 'employee',
                'password' => Hash::make('employee'),
                'role_id' =>'employee',
                'remember_token' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        User::insert($users);
    }
}

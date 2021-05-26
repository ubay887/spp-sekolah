<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::create([
            'name'  => 'Admin',
            'username'  => 'admin',
            'email' => 'admin@admin.com',
            'password'  => bcrypt('password'),
            'status'  => true,
        ]);
        $user = $user->assignRole('admin');

        $user = \App\User::create([
            'name'  => 'Isengoding',
            'username'  => 'isengoding',
            'email' => 'isengoding@isengoding.my.id',
            'password'  => bcrypt('password'),
            'status'  => true,
        ]);
        $user = $user->assignRole('admin');

    }
}

<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'SuperAdmin',
            'description' => 'Dashboard Crud Complete',
        ]);
        Role::create([
            'name' => 'Admin',
            'description' => 'Dashboard Read Only (demo admin)',
        ]);
        Role::create([
            'name' => 'User',
            'description' => 'Website Only with account features',
        ]);
    }
}

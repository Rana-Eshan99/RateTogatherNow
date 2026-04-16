<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (empty(Role::where('name','Admin')->first())) {
            Role::create([
                'name' => 'Admin',
            ]);
        }
        if (empty(Role::where('name','User')->first())) {
            Role::create([
                'name' => 'User',
            ]);
        }
    }
}

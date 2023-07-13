<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
//Añadir OJO
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //[] con cada tabla que quiero que ponga
        DB::table('roles')->insert([
            ['name' => 'admin'],
            ['name' => 'user']
        ]);
    }
}

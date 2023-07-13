<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //MARA  ojoo lanzar
        $this->call([
            RoleSeeder::class
        ]);
        \App\Models\User::factory
        (10)->create();
        \App\Models\Service::factory(4)->create();

        \App\Models\Appointment::factory(3)->state(new Sequence(['patient_id'=>2, 'dentist_id'=>3, 'service_id'=>1], ['patient_id'=>1, 'dentist_id'=>2, 'service_id'=>4]))->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

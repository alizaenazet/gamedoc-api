<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Doctor;
use App\Models\Gamer;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::factory()
            ->count(3)
            ->state(function ()  {
                return ['role' => 'gamer'];
            })
            ->has(Gamer::factory()->count(1),"gamer")
            ->create();
        User::factory()
            ->count(3)
            ->state(function ()  {
                return ['role' => 'doctor'];
            })
            ->has(Doctor::factory()->count(1),"doctor")
            ->create();
        
        
        
    }
}

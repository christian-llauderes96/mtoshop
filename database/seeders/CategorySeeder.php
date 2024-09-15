<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            // Motorcycle Parts
            ['name' => 'Motorcycle Engine', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Motorcycle Exhaust', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Motorcycle Brakes', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Motorcycle Suspension', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Motorcycle Tires', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Motorcycle Lighting', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Motorcycle Electrical Components', 'created_at' => now(), 'updated_at' => now()],

            // Car Parts
            ['name' => 'Car Engine', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Car Transmission', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Car Brakes', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Car Suspension', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Car Tires', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Car Interior Components', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Car Exterior Components', 'created_at' => now(), 'updated_at' => now()],

            // Accessories
            ['name' => 'Helmets', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Protective Gear', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Decals', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tools', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fluids', 'created_at' => now(), 'updated_at' => now()],

            // General Maintenance
            ['name' => 'Filters', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Spark Plugs', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Batteries', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Belts', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fuses', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

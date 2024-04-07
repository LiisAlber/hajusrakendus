<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            ['name' => 'Product 1', 'description' => 'Description for product 1', 'price' => 100],
            ['name' => 'Product 2', 'description' => 'Description for product 2', 'price' => 150],
            ['name' => 'Product 3', 'description' => 'Description for product 3', 'price' => 200],
            ['name' => 'Product 4', 'description' => 'Description for product 4', 'price' => 250],
            ['name' => 'Product 5', 'description' => 'Description for product 5', 'price' => 300],
            ['name' => 'Product 6', 'description' => 'Description for product 6', 'price' => 350],
            ['name' => 'Product 7', 'description' => 'Description for product 7', 'price' => 400],
            ['name' => 'Product 8', 'description' => 'Description for product 8', 'price' => 450],
            ['name' => 'Product 9', 'description' => 'Description for product 9', 'price' => 500],
        ]);
    }
}

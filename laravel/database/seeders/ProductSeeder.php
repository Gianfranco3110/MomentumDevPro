<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'title' => 'Zapatos Negros Adidas',
            'description' => 'Zapatos negros marca Adidas, Originales, tallas(40-42)',
            'product_type' => 'Sport',
            'applies_to_date' => date('d-m-y'),
            'image' => 'shoes.jpg',
            'users_id' => 1,
            'status_id' => 3,            
        ]);
    }
}

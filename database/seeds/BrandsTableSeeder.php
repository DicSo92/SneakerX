<?php

use App\Brand;
use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Brand::create([
            'name' => 'Adidas',
            'description' => 'This is the Adidas brand',
            'banner' => null,
            'image' => null,
        ]);
        Brand::create([
            'name' => 'Puma',
            'description' => 'This is the Puma brand',
            'banner' => null,
            'image' => null,
        ]);
    }
}

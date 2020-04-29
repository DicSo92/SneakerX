<?php

use App\Product;
use App\Brand;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use JD\Cloudder\Facades\Cloudder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/productsSeeder.json");
        $products = json_decode($json);

        foreach ($products as $product ) {
            $brandName = Brand::findOrFail($product->brand_id)->name;

            Cloudder::upload(storage_path('seedImages/products/'.$brandName.'/'.$product->image), null, array('folder' => 'SneakerX/Products/'.$brandName));
            $image = Cloudder::getResult();

            Product::create([
                'name' => $product->name,
                'slug' => Str::slug($product->name, '-'),
                'description' => $product->description,
                'image' => $image['url'],
                'price' => $product->price,
                'brand_id' => $product->brand_id,
            ]);
        }
    }
}

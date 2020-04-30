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

        foreach ($products as $product) {
            $brandName = Brand::find($product->brand_id)->name;
            $slug = Str::slug($product->name, '-');

            Cloudder::upload(storage_path('seedImages/products/'.$brandName.'/'.$product->image), null, array('folder' => 'SneakerX/Products/'.$brandName.'/'.$slug));
            $uploadImage = Cloudder::getResult();

            $imagesTable = array();
            foreach ($product->images as $image) {
                Cloudder::upload(storage_path('seedImages/products/'.$brandName.'/'.$image), null, array('folder' => 'SneakerX/Products/'.$brandName.'/'.$slug));
                $uploadImages = Cloudder::getResult();
                array_push($imagesTable, $uploadImages['url']);
            }

            Product::create([
                'name' => $product->name,
                'slug' => $slug,
                'description' => $product->description,
                'image' => $uploadImage['url'],
                'images' => $imagesTable,
                'price' => $product->price,
                'brand_id' => $product->brand_id,
            ]);
        }
    }
}

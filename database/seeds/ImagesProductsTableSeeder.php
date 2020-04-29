<?php

use App\Brand;
use App\ImagesProduct;

use App\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;
use JD\Cloudder\Facades\Cloudder;

class ImagesProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/imagesProductsSeeder.json");
        $imagesProducts = json_decode($json);

        foreach ($imagesProducts as $product ) {
            $brandId = Product::findOrFail($product->product_id)->brand_id;
            $brandName = Brand::findOrFail($brandId)->name;

            $imagesTable = array();
            foreach ($product->images as $image) {
                Cloudder::upload(storage_path('seedImages/products/'.$brandName.'/'.$image), null, array('folder' => 'SneakerX/Products/'.$brandName));
                $uploadImage = Cloudder::getResult();
                array_push($imagesTable, $uploadImage['url']);
            }

            ImagesProduct::create([
                'product_id' => $product->product_id,
                'images' => $imagesTable
            ]);
        }
    }
}

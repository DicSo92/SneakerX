<?php

use App\Brand;
use Illuminate\Database\Seeder;
use JD\Cloudder\Facades\Cloudder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cloudder::upload(storage_path('seedImages/brands/adidas_banner.png'), null, array("folder" => "SneakerX/Brands/"));
        $adidas_banner = Cloudder::getResult();
        Cloudder::upload(storage_path('seedImages/brands/adidas_logo.png'), null, array("folder" => "SneakerX/Brands/"));
        $adidas_logo = Cloudder::getResult();

        Cloudder::upload(storage_path('seedImages/brands/puma_banner.jpg'), null, array("folder" => "SneakerX/Brands/"));
        $puma_banner = Cloudder::getResult();
        Cloudder::upload(storage_path('seedImages/brands/puma_logo.png'), null, array("folder" => "SneakerX/Brands/"));
        $puma_logo = Cloudder::getResult();

        Cloudder::upload(storage_path('seedImages/brands/reebok_banner.jpg'), null, array("folder" => "SneakerX/Brands/"));
        $reebok_banner = Cloudder::getResult();
        Cloudder::upload(storage_path('seedImages/brands/reebok_logo.jpg'), null, array("folder" => "SneakerX/Brands/"));
        $reebok_logo = Cloudder::getResult();


        Brand::create([
            'name' => 'Adidas',
            'description' => 'Adidas (anciennement Dassler Schuhfabrik) est une firme allemande fondée en 1949 par Adolf Dassler, spécialisée dans la fabrication d\'articles de sport, basée à Herzogenaurach en Allemagne.',
            'banner' => $adidas_banner['url'],
            'image' => $adidas_logo['url'],
        ]);
        Brand::create([
            'name' => 'Puma',
            'description' => 'Puma SE est une entreprise allemande spécialisée dans la fabrication d\'articles de sport fondée en 1948 par Rudolf Dassler, frère aîné d\'Adolf Dassler fondateur d\'Adidas, et basée à Herzogenaurach en Bavière, filiale jusqu\'en 2018 du groupe français Kering.',
            'banner' => $puma_banner['url'],
            'image' => $puma_logo['url'],
        ]);
        Brand::create([
            'name' => 'Reebok',
            'description' => 'Reebok est un équipementier sportif américain d\'origine anglaise fondé en 1958 à Bolton dans le Grand Manchester, filiale du groupe allemand Adidas depuis 2005.',
            'banner' => $reebok_banner['url'],
            'image' => $reebok_logo['url'],
        ]);
    }
}

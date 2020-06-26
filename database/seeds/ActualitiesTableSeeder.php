<?php

use App\Actuality;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use JD\Cloudder\Facades\Cloudder;

class ActualitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/actualitiesSeeder.json");
        $actualities = json_decode($json);

        foreach ($actualities as $actuality) {
            $slug = Str::slug($actuality->title, '-');

            $faker = Faker\Factory::create();
            $published_date = $actuality->published ? $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now') : null;

            Cloudder::upload(storage_path('seedImages/news/'.$actuality->image), null, array('folder' => env('CLOUDINARY_MAIN_FOLDER').'/Actualities/'));
            $uploadImage = Cloudder::getResult();

            Actuality::create([
                'title' => $actuality->title,
                'subtitle' => $actuality->subtitle,
                'slug' => $slug,
                'content' => $actuality->content,
                'image' => $uploadImage['url'],
                'published' => $actuality->published,
                'published_date' => $published_date,
                'refLink' => $actuality->refLink,
                'user_id' => $actuality->user_id,
            ]);
        }
    }
}

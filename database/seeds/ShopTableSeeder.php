<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Hideyo\Models\Shop as Shop;

class ShopTableSeeder extends Seeder
{
    public function run()
    {
        $shop = new Shop;

        DB::table($shop->getTable())->delete();

        $shop->title = 'hideyo';
        $shop->url = config()->get('app.url');
        $shop->secret_key = 'RQlqvrjpGWPVqY1gPerKstoO4X6xhGGE';
        $shop->active = 1;
        $shop->description = "description";
        $shop->currency_code = "EUR";
        $shop->thumbnail_widescreen_sizes = "100x100,200x200,500x500,800x800";
        $shop->thumbnail_square_sizes = "100x100,200x200,500x500,800x800"; 
        $shop->meta_title = "Hideyo - laravel e-commerce platform";
        $shop->meta_description = "Clean Laravel e-commerce platform for building your custom and unique webshop";     
        $shop->save();    
    }
}
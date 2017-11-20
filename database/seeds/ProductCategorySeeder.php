<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Hideyo\Models\Shop as Shop;
use Hideyo\Models\ProductCategory as ProductCategory;

class ProductCategoryTableSeeder extends Seeder
{
    public function run()
    {
        $productCategory = new ProductCategory;

        DB::table($productCategory->getTable())->delete();
        $shop = Shop::where('title', '=', 'hideyo')->first();

        $productCategory->active = 1;
        $productCategory->title = 'Pants';
        $productCategory->short_description = 'Great pants';
        $productCategory->description = 'Great pants';
        $productCategory->meta_title = 'Pants';
        $productCategory->meta_description = 'Great pants';          
        $productCategory->shop_id = $shop->id;

        if (! $productCategory->save()) {
            Log::info('Unable to create category '.$productCategory->title, (array)$productCategory->errors());
        } else {
            Log::info('Created category "'.$productCategory->title.'" <'.$productCategory->title.'>');
        }

        $productCategory2 = new ProductCategory;
        $productCategory2->active = 1;
        $productCategory2->title = 'T-shirts';
        $productCategory2->short_description = 'Soft t-shirts';
        $productCategory2->description = 'Soft t-shirts';
        $productCategory2->meta_title = 'T-shirts';
        $productCategory2->meta_description = 'Soft t-shirts';         
        $productCategory2->shop_id = $shop->id;

        if (! $productCategory2->save()) {
            Log::info('Unable to create category '.$productCategory2->title, (array)$productCategory2->errors());
        } else {
            Log::info('Created category "'.$productCategory2->title.'" <'.$productCategory2->title.'>');
        }

        $productCategory3 = new ProductCategory;
        $productCategory3->active = 1;
        $productCategory3->title = 'Underwear';
        $productCategory3->short_description = 'Good underwear';
        $productCategory3->description = 'Good underwear';   
        $productCategory3->meta_title = 'Underwear';
        $productCategory3->meta_description = 'Good underwear';             
        $productCategory3->shop_id = $shop->id;


        if (! $productCategory3->save()) {
            Log::info('Unable to create category '.$productCategory3->title, (array)$productCategory3->errors());
        } else {
            Log::info('Created category "'.$productCategory3->title.'" <'.$productCategory3->title.'>');
        }


        $productCategory4 = new ProductCategory;
        $productCategory4->active = 1;
        $productCategory4->title = 'Dresses';
        $productCategory4->short_description = 'Lovely dresses';
        $productCategory4->description = 'Lovely dresses';    
        $productCategory4->meta_title = 'Dresses';
        $productCategory4->meta_description = 'Lovely dresses';
        $productCategory4->shop_id = $shop->id;


        if (! $productCategory4->save()) {
            Log::info('Unable to create category '.$productCategory4->title, (array)$productCategory4->errors());
        } else {
            Log::info('Created category "'.$productCategory4->title.'" <'.$productCategory3->title.'>');
        }


        $productCategory5 = new ProductCategory;
        $productCategory5->active = 1;
        $productCategory5->title = 'Hats';
        $productCategory5->short_description = 'Nice hats';
        $productCategory5->description = 'Nice hats';         
        $productCategory5->meta_title = 'Hats';
        $productCategory5->meta_description = 'Nice hats';
        $productCategory5->shop_id = $shop->id;

        if (! $productCategory5->save()) {
            Log::info('Unable to create category '.$productCategory5->title, (array)$productCategory5->errors());
        } else {
            Log::info('Created category "'.$productCategory5->title.'" <'.$productCategory3->title.'>');
        }

        $productCategory6 = new ProductCategory;
        $productCategory6->active = 1;
        $productCategory6->title = 'Shoes';
        $productCategory6->short_description = 'Leather shoes';
        $productCategory6->description = 'Leather shoes';         
        $productCategory6->meta_title = 'Shoes';
        $productCategory6->meta_description = 'Leather shoes';
        $productCategory6->shop_id = $shop->id;
        $productCategory6->parent_id = $productCategory5->id;

        if (! $productCategory6->save()) {
            Log::info('Unable to create category '.$productCategory6->title, (array)$productCategory6->errors());
        } else {
            Log::info('Created category "'.$productCategory6->title.'" <'.$productCategory3->title.'>');
        }
    }
}

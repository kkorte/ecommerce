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
        $productCategory->title = 'Fruit';
        $productCategory->short_description = 'Delicious fresh fruit';
        $productCategory->description = 'Delicious fresh fruit';
        $productCategory->meta_title = 'Fruit';
        $productCategory->meta_description = 'Delicious fresh fruit';          
        $productCategory->shop_id = $shop->id;


        if (! $productCategory->save()) {
            Log::info('Unable to create category '.$productCategory->title, (array)$productCategory->errors());
        } else {
            Log::info('Created category "'.$productCategory->title.'" <'.$productCategory->title.'>');
        }

        $productCategory2 = new ProductCategory;
        $productCategory2->active = 1;
        $productCategory2->title = 'Vegetables';
        $productCategory2->short_description = 'Healthy vegetables';
        $productCategory2->description = 'Healthy vegetables';
        $productCategory2->meta_title = 'Vegetables';
        $productCategory2->meta_description = 'Healthy vegetables';         
        $productCategory2->shop_id = $shop->id;


        if (! $productCategory2->save()) {
            Log::info('Unable to create category '.$productCategory2->title, (array)$productCategory2->errors());
        } else {
            Log::info('Created category "'.$productCategory2->title.'" <'.$productCategory2->title.'>');
        }


        $productCategory3 = new ProductCategory;
        $productCategory3->active = 1;
        $productCategory3->title = 'Bread';
        $productCategory3->short_description = 'Fresh healthy bread';
        $productCategory3->description = 'Fresh healthy bread';   
        $productCategory3->meta_title = 'Bread';
        $productCategory3->meta_description = 'Fresh healthy bread';             
        $productCategory3->shop_id = $shop->id;


        if (! $productCategory3->save()) {
            Log::info('Unable to create category '.$productCategory3->title, (array)$productCategory3->errors());
        } else {
            Log::info('Created category "'.$productCategory3->title.'" <'.$productCategory3->title.'>');
        }


        $productCategory4 = new ProductCategory;
        $productCategory4->active = 1;
        $productCategory4->title = 'Candy';
        $productCategory4->short_description = 'Unhealthy addicting candy';
        $productCategory4->description = 'Unhealthy addicting candy';    
        $productCategory4->meta_title = 'Candy';
        $productCategory4->meta_description = 'Unhealthy addicting candy';
        $productCategory4->shop_id = $shop->id;


        if (! $productCategory4->save()) {
            Log::info('Unable to create category '.$productCategory4->title, (array)$productCategory4->errors());
        } else {
            Log::info('Created category "'.$productCategory4->title.'" <'.$productCategory3->title.'>');
        }


        $productCategory5 = new ProductCategory;
        $productCategory5->active = 1;
        $productCategory5->title = 'Drinks';
        $productCategory5->short_description = 'Nice drinks';
        $productCategory5->description = 'Nice drinks';         
        $productCategory5->meta_title = 'Drinks';
        $productCategory5->meta_description = 'Nice drinks';
        $productCategory5->shop_id = $shop->id;

        if (! $productCategory5->save()) {
            Log::info('Unable to create category '.$productCategory5->title, (array)$productCategory5->errors());
        } else {
            Log::info('Created category "'.$productCategory5->title.'" <'.$productCategory3->title.'>');
        }



        $productCategory6 = new ProductCategory;
        $productCategory6->active = 1;
        $productCategory6->title = 'Soda';
        $productCategory6->short_description = 'Nice soda drinks';
        $productCategory6->description = 'Nice soda drinks';         
        $productCategory6->meta_title = 'Soda';
        $productCategory6->meta_description = 'Nice soda drinks';
        $productCategory6->shop_id = $shop->id;
        $productCategory6->parent_id = $productCategory5->id;

        if (! $productCategory6->save()) {
            Log::info('Unable to create category '.$productCategory6->title, (array)$productCategory6->errors());
        } else {
            Log::info('Created category "'.$productCategory6->title.'" <'.$productCategory3->title.'>');
        }


        $productCategory7 = new ProductCategory;
        $productCategory7->active = 1;
        $productCategory7->title = 'Coffee & thea';
        $productCategory7->short_description = 'Coffee & thea';
        $productCategory7->description = 'Coffee & thea';         
        $productCategory7->meta_title = 'Coffee & thea';
        $productCategory7->meta_description = 'Coffee & thea';
        $productCategory7->shop_id = $shop->id;
        $productCategory7->parent_id = $productCategory5->id;

        if (! $productCategory7->save()) {
            Log::info('Unable to create category '.$productCategory7->title, (array)$productCategory7->errors());
        } else {
            Log::info('Created category "'.$productCategory7->title.'" <'.$productCategory7->title.'>');
        }








    }
}

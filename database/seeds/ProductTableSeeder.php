<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Hideyo\Models\Shop as Shop;
use Hideyo\Models\Product as Product;
use Hideyo\Models\ProductCategory as ProductCategory;
use Hideyo\Models\TaxRate as TaxRate;
class ProductTableSeeder extends Seeder
{
    public function run()
    {
        $productCategory = ProductCategory::where('title', '=', 'Fruit')->first();
        $taxRate = TaxRate::where('title', '=', '6%')->first();

        $product = new Product;

        DB::table($product->getTable())->delete();
        $shop = Shop::where('title', '=', 'hideyo')->first();

        $product->active = 1;
        $product->title = 'Green apple';
        $product->short_description = 'Tasty green apple';
        $product->description = 'Tasty green apple';
        $product->meta_title = 'Green apple';
        $product->meta_description = 'Tasty green apple';   
        $product->price = '0.20';
        $product->reference_code = '12343443';        
        $product->shop_id = $shop->id;
        $product->product_category_id = $productCategory->id;
        $product->tax_rate_id = $taxRate->id;

        if (! $product->save()) {
            Log::info('Unable to create product '.$product->title, (array)$product->errors());
        } else {
            Log::info('Created product "'.$product->title.'" <'.$product->title.'>');
        }

        $product2 = new Product;
        $product2->active = 1;
        $product2->title = 'Red apple';
        $product2->short_description = 'Tasty red apple';
        $product2->description = 'Tasty red apple';
        $product2->meta_title = 'Red apple';
        $product2->meta_description = 'Tasty red apple';   
        $product2->price = '0.10'; 
        $product2->reference_code = '12343445';       
        $product2->shop_id = $shop->id;
        $product2->product_category_id = $productCategory->id;
        $product2->tax_rate_id = $taxRate->id;

        if (! $product2->save()) {
            Log::info('Unable to create product '.$product2->title, (array)$product2->errors());
        } else {
            Log::info('Created product "'.$product2->title.'" <'.$product2->title.'>');
        }
    }
}

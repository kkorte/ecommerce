<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Hideyo\Models\Shop as Shop;
use Hideyo\Models\Product as Product;
use Hideyo\Models\ProductTagGroup as ProductTagGroup;
use Hideyo\Models\TaxRate as TaxRate;

class ProductTagGroupTableSeeder extends Seeder
{
    public function run()
    {
        $products = Product::all();
        $tagGroup = new ProductTagGroup;
        DB::table($tagGroup->getTable())->delete();

        $shop = Shop::where('title', '=', 'hideyo')->first();

        $productIds = array();
        foreach ($products as $product) {
            $productIds[] = $product->id;
        }

        $tagGroup->active = 1;
        $tagGroup->tag = 'home-populair';
        $tagGroup->shop_id = $shop->id;
        $tagGroup->save();

        if ($productIds) {
            $tagGroup->relatedProducts()->sync(array_slice($productIds, 0, 4));
        }

    }
}
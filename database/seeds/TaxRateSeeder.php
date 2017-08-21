<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Hideyo\Models\Shop as Shop;
use Hideyo\Models\TaxRate as TaxRate;
use Hideyo\Models\ProductCategory as ProductCategory;

class TaxRateTableSeeder extends Seeder
{
    public function run()
    {
        $taxRate = new TaxRate;

        DB::table($taxRate->getTable())->delete();
        $shop = Shop::where('title', '=', 'hideyo')->first();


        $taxRate->title = '21%';
        $taxRate->rate = '21';     
        $taxRate->shop_id = $shop->id;

        if (! $taxRate->save()) {
            Log::info('Unable to create tax rate '.$taxRate->title, (array)$taxRate->errors());
        } else {
            Log::info('Created tax rate "'.$taxRate->title.'" <'.$taxRate->title.'>');     
        }



        $taxRate2 = new TaxRate;
        $taxRate2->title = '6%';
        $taxRate2->rate = '6';     
        $taxRate2->shop_id = $shop->id;

        if (! $taxRate2->save()) {
            Log::info('Unable to create tax rate '.$taxRate2->title, (array)$taxRate2->errors());
        } else {
            Log::info('Created tax rate "'.$taxRate2->title.'" <'.$taxRate2->title.'>');     
        }








    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Hideyo\Models\Shop as Shop;
use Hideyo\Models\SendingMethod as SendingMethod;
use Hideyo\Models\TaxRate as TaxRate;

class SendingMethodTableSeeder extends Seeder
{
    public function run()
    {
        $taxRate = TaxRate::where('title', '=', '21%')->first();
        $sendingMethod = new SendingMethod;

        DB::table($sendingMethod->getTable())->delete();
        $shop = Shop::where('title', '=', 'hideyo')->first();

        $sendingMethod->active = 1;
        $sendingMethod->title = 'China';
        $sendingMethod->tax_rate_id = $taxRate->id; 
        $sendingMethod->price = '10';  
        $sendingMethod->shop_id = $shop->id;

        if (! $sendingMethod->save()) {
            Log::info('Unable to create tax rate '.$sendingMethod->title, (array)$sendingMethod->errors());
        } else {
            Log::info('Created tax rate "'.$sendingMethod->title.'" <'.$sendingMethod->title.'>');     
        }

        $sendingMethod2 = new SendingMethod;

       	$sendingMethod2->active = 1;
        $sendingMethod2->title = 'Netherlands';
        $sendingMethod2->tax_rate_id = $taxRate->id; 
        $sendingMethod2->price = '30'; 
        $sendingMethod2->shop_id = $shop->id;

        if (! $sendingMethod2->save()) {
            Log::info('Unable to create tax rate '.$sendingMethod2->title, (array)$sendingMethod2->errors());
        } else {
            Log::info('Created tax rate "'.$sendingMethod2->title.'" <'.$sendingMethod2->title.'>');     
        }
    }
}

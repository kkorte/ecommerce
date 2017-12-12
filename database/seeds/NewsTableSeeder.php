<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Hideyo\Models\Shop as Shop;
use Hideyo\Models\News as News;

class NewsTableSeeder extends Seeder
{
    public function run()
    {
        $news = new News;

        DB::table($news->getTable())->delete();
        $shop = Shop::where('title', '=', 'hideyo')->first();

        $news->title = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit';
        $news->content = '
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer fermentum venenatis tempus. Suspendisse scelerisque urna bibendum pretium consectetur. Fusce eu enim tempus odio imperdiet pharetra. Ut varius nunc eget condimentum auctor. Morbi lacinia augue est, id tristique augue faucibus a.
            </p>';     
        $news->shop_id = $shop->id;
        $news->save();

        $news2 = new News;
        $news2->title = 'Integer fermentum venenatis tempus';
        $news->content = '
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer fermentum venenatis tempus. Suspendisse scelerisque urna bibendum pretium consectetur. Fusce eu enim tempus odio imperdiet pharetra. Ut varius nunc eget condimentum auctor. Morbi lacinia augue est, id tristique augue faucibus a.
            </p>';      
        $news2->shop_id = $shop->id;
        $news2->save();
    }
}

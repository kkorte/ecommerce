<?php

namespace App\Helpers;

use Hideyo\Repositories\HtmlBlockRepositoryInterface;
use Config;
use App\HtmlBlock;
use DbView;

class HtmlBlockHelper
{





    public static function findByPosition($position)
    {


        $htmlBlock = new HtmlBlock();

        $result = $htmlBlock->where('shop_id', '=', Config::get('app.shop_id'))->where('active', '=', 1)->where('position', '=', $position)->first();
        
        if ($result) {
            return DbView::make($result)->with($result->toArray())->render();
        } else {
            return false;
        }
        ;
    }
}

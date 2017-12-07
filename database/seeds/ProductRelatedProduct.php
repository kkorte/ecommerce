<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Hideyo\Models\Shop as Shop;
use Hideyo\Models\ProductRelatedProduct as ProductRelatedProduct;

class ProductRelatedProductTableSeeder extends Seeder
{
    public function run()
    {
        $productRelatedProduct = new ProductRelatedProduct;

        DB::table($productRelatedProduct->getTable())->delete();


        for ($x = 1; $x <= 10; $x++) {
	        $productRelatedProduct = new ProductRelatedProduct;
	        $productRelatedProduct->product_id = $x;
	        $productRelatedProduct->related_product_id = $x + 1;

	        if (! $productRelatedProduct->save()) {
	            Log::info('Unable to html block '.$productRelatedProduct->id, (array)$productRelatedProduct->errors());
	        } else {
	            Log::info('Created html block "'.$productRelatedProduct->id.'" <'.$productRelatedProduct->id.'>');     
	        }
	    }


        for ($x = 2; $x <= 10; $x++) {
	        $productRelatedProduct = new ProductRelatedProduct;
	        $productRelatedProduct->product_id = $x;
	        $productRelatedProduct->related_product_id = $x + 1;

	        if (! $productRelatedProduct->save()) {
	            Log::info('Unable to html block '.$productRelatedProduct->id, (array)$productRelatedProduct->errors());
	        } else {
	            Log::info('Created html block "'.$productRelatedProduct->id.'" <'.$productRelatedProduct->id.'>');     
	        }
	    }

        for ($x = 3; $x <= 10; $x++) {
	        $productRelatedProduct = new ProductRelatedProduct;
	        $productRelatedProduct->product_id = $x;
	        $productRelatedProduct->related_product_id = $x + 1;

	        if (! $productRelatedProduct->save()) {
	            Log::info('Unable to html block '.$productRelatedProduct->id, (array)$productRelatedProduct->errors());
	        } else {
	            Log::info('Created html block "'.$productRelatedProduct->id.'" <'.$productRelatedProduct->id.'>');     
	        }
	    }


        for ($x = 4; $x <= 10; $x++) {
	        $productRelatedProduct = new ProductRelatedProduct;
	        $productRelatedProduct->product_id = $x;
	        $productRelatedProduct->related_product_id = $x + 1;

	        if (! $productRelatedProduct->save()) {
	            Log::info('Unable to html block '.$productRelatedProduct->id, (array)$productRelatedProduct->errors());
	        } else {
	            Log::info('Created html block "'.$productRelatedProduct->id.'" <'.$productRelatedProduct->id.'>');     
	        }
	    }






    }
}

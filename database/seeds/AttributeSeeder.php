<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Hideyo\Models\Shop as Shop;
use Hideyo\Models\Attribute as Attribute;
use Hideyo\Models\AttributeGroup as AttributeGroup;
use Hideyo\Models\ProductCategory as ProductCategory;

class AttributeTableSeeder extends Seeder
{
    public function run()
    {
        $attributeGroup = new AttributeGroup;

        DB::table($attributeGroup->getTable())->delete();
        $shop = Shop::where('title', '=', 'hideyo')->first();

        $attributeGroup->title = 'Size';   
        $attributeGroup->shop_id = $shop->id;

        if (! $attributeGroup->save()) {
            Log::info('Unable to create attribute group '.$attributeGroup->title, (array)$attributeGroup->errors());
        } else {
            Log::info('Created attribute group "'.$attributeGroup->title.'" <'.$attributeGroup->title.'>');     
        }

        $attribute = new Attribute;
        $attribute->value = 'S';   
        $attribute->attribute_group_id = $attributeGroup->id;


        if (! $attribute->save()) {
            Log::info('Unable to create attribute  '.$attribute->value, (array)$attribute->errors());
        } else {
            Log::info('Created attribute  "'.$attribute->value.'" <'.$attribute->value.'>');     
        }

        $attribute2 = new Attribute;
        $attribute2->value = 'M';   
        $attribute2->attribute_group_id = $attributeGroup->id;


        if (! $attribute2->save()) {
            Log::info('Unable to create attribute  '.$attribute2->value, (array)$attribute2->errors());
        } else {
            Log::info('Created attribute  "'.$attribute2->value.'" <'.$attribute2->value.'>');     
        }

        $attribute3 = new Attribute;
        $attribute3->value = 'L';   
        $attribute3->attribute_group_id = $attributeGroup->id;


        if (! $attribute3->save()) {
            Log::info('Unable to create attribute  '.$attribute3->value, (array)$attribute3->errors());
        } else {
            Log::info('Created attribute  "'.$attribute3->value.'" <'.$attribute3->value.'>');     
        }


        $attribute4 = new Attribute;
        $attribute4->value = 'XL';   
        $attribute4->attribute_group_id = $attributeGroup->id;


        if (! $attribute4->save()) {
            Log::info('Unable to create attribute  '.$attribute4->value, (array)$attribute4->errors());
        } else {
            Log::info('Created attribute  "'.$attribute4->value.'" <'.$attribute4->value.'>');     
        }


        $attributeGroup2 = new AttributeGroup;
        $attributeGroup2->title = 'Color';   
        $attributeGroup2->shop_id = $shop->id;

        if (! $attributeGroup2->save()) {
            Log::info('Unable to create attribute group '.$attributeGroup2->title, (array)$attributeGroup2->errors());
        } else {
            Log::info('Created attribute group "'.$attributeGroup2->title.'" <'.$attributeGroup2->title.'>');     
        }

        $attribute = new Attribute;
        $attribute->value = 'Blue';   
        $attribute->attribute_group_id = $attributeGroup2->id;


        if (! $attribute->save()) {
            Log::info('Unable to create attribute  '.$attribute->value, (array)$attribute->errors());
        } else {
            Log::info('Created attribute  "'.$attribute->value.'" <'.$attribute->value.'>');     
        }

        $attribute = new Attribute;
        $attribute->value = 'Black';   
        $attribute->attribute_group_id = $attributeGroup2->id;


        if (! $attribute->save()) {
            Log::info('Unable to create attribute  '.$attribute->value, (array)$attribute->errors());
        } else {
            Log::info('Created attribute  "'.$attribute->value.'" <'.$attribute->value.'>');     
        }

        $attribute = new Attribute;
        $attribute->value = 'White';   
        $attribute->attribute_group_id = $attributeGroup2->id;


        if (! $attribute->save()) {
            Log::info('Unable to create attribute  '.$attribute->value, (array)$attribute->errors());
        } else {
            Log::info('Created attribute  "'.$attribute->value.'" <'.$attribute->value.'>');     
        }

        $attribute = new Attribute;
        $attribute->value = 'Yellow';   
        $attribute->attribute_group_id = $attributeGroup2->id;


        if (! $attribute->save()) {
            Log::info('Unable to create attribute  '.$attribute->value, (array)$attribute->errors());
        } else {
            Log::info('Created attribute  "'.$attribute->value.'" <'.$attribute->value.'>');     
        }



    }
}

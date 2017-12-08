<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Hideyo\Models\Shop as Shop;
use Hideyo\Models\Attribute as Attribute;
use Hideyo\Models\AttributeGroup as AttributeGroup;
use Hideyo\Models\ProductAttribute as ProductAttribute;
use Hideyo\Models\ProductAttributeCombination as ProductAttributeCombination;
use Hideyo\Models\Product as Product;
use Hideyo\Models\TaxRate as TaxRate;
use Hideyo\Models\ProductCategory as ProductCategory;

class ProductAttributeTableSeeder extends Seeder
{
    public function run()
    {

        $productAttribute = new ProductAttribute;
        DB::table($productAttribute->getTable())->delete();
        $shop = Shop::where('title', '=', 'hideyo')->first();

        for ($x = 0; $x <= 10; $x++) {

            $productAttribute = new ProductAttribute;
            $product = Product::where('title', '=', 'Cotton pants '.$x)->first();

            $taxRate = TaxRate::where('title', '=', '21%')->first();

            $productAttribute->product_id = $product->id;   
            $productAttribute->price = '199.50';
            $productAttribute->tax_rate_id = $taxRate->id;
            $productAttribute->amount = 20;
            $productAttribute->reference_code = '22343443';    
            $productAttribute->save();

            $productAttributeCombination = new ProductAttributeCombination;  
            $productAttributeCombination->product_attribute_id = $productAttribute->id; 
            $attribute = Attribute::where('value', '=', 'S')->first();
            $productAttributeCombination->attribute_id = $attribute->id; 
            $productAttributeCombination->save();

            $productAttributeCombination2 = new ProductAttributeCombination;  
            $productAttributeCombination2->product_attribute_id = $productAttribute->id; 
            $attribute = Attribute::where('value', '=', 'Black')->first();
            $productAttributeCombination2->attribute_id = $attribute->id; 
            $productAttributeCombination2->save();

            $productAttribute2 = new ProductAttribute;
            $productAttribute2->product_id = $product->id;   
            $productAttribute2->price = '199.50';
            $productAttribute2->tax_rate_id = $taxRate->id;
            $productAttribute2->amount = 20;
            $productAttribute2->reference_code = '22343443';    
            $productAttribute2->save();

            $productAttributeCombination = new ProductAttributeCombination;  
            $productAttributeCombination->product_attribute_id = $productAttribute2->id; 
            $attribute = Attribute::where('value', '=', 'M')->first();
            $productAttributeCombination->attribute_id = $attribute->id; 
            $productAttributeCombination->save();

            $productAttributeCombination2 = new ProductAttributeCombination;  
            $productAttributeCombination2->product_attribute_id = $productAttribute2->id; 
            $attribute = Attribute::where('value', '=', 'White')->first();
            $productAttributeCombination2->attribute_id = $attribute->id; 
            $productAttributeCombination2->save();

            $productAttribute2 = new ProductAttribute;
            $productAttribute2->product_id = $product->id;   
            $productAttribute2->price = '299.50';
            $productAttribute2->tax_rate_id = $taxRate->id;
            $productAttribute2->amount = 20;
            $productAttribute2->reference_code = '232343443';    
            $productAttribute2->save();

            $productAttributeCombination = new ProductAttributeCombination;  
            $productAttributeCombination->product_attribute_id = $productAttribute2->id; 
            $attribute = Attribute::where('value', '=', 'M')->first();
            $productAttributeCombination->attribute_id = $attribute->id; 
            $productAttributeCombination->save();

            $productAttributeCombination2 = new ProductAttributeCombination;  
            $productAttributeCombination2->product_attribute_id = $productAttribute2->id; 
            $attribute = Attribute::where('value', '=', 'Black')->first();
            $productAttributeCombination2->attribute_id = $attribute->id; 
            $productAttributeCombination2->save();

            $product->leading_atrribute_group_id = $attribute->attributeGroup->id;
            $product->save();
        }
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Hideyo\Models\ProductAttributeCombination;
use Hideyo\Models\ProductAttribute;
use Hideyo\Repositories\ProductRepositoryInterface;

use Hideyo\Repositories\ProductCategoryRepositoryInterface;
use Illuminate\Http\Request;
use BrowserDetect;
use Notification;

class ProductController extends Controller
{

    public function __construct(ProductRepositoryInterface $product, ProductCategoryRepositoryInterface $productCategory)
    {
        $this->product = $product;
        $this->productCategory = $productCategory;
    }

    public function getIndex(Request $request, $categorySlug, $productId, $productSlug, $productAttributeId = false)
    {     
        $product = $this->product->selectOneByShopIdAndId(config()->get('app.shop_id'), $productId, $request->get('combination_id'));
        
        if ($product) {

            if ($product->slug != $productSlug or $product->productCategory->slug != $categorySlug) {
                return redirect()->route('product.item', array('productCategorySlug' => $product->productCategory->slug, 'productId' => $product->id, 'slug' => $product->slug));
            }

            if ($product->ProductCategory and $product->ProductCategory->parent()->count()) {
                $productCategories = $this->productCategory->selectCategoriesByParentId(config()->get('app.shop_id'), $product->ProductCategory->parent()->first()->id, 'widescreen');
            } else {
                $productCategories = $this->productCategory->selectRootCategories(false, array('from_stock'));
            }

            if ($product->attributes->count()) {
                $check = false;
                if ($product->attributeGroup) {
                    $attributeLeadingGroup = $product->attributeGroup;
                } else {
                    $attributeLeadingGroup = $product->attributes->first()->combinations->first()->attribute->attributeGroup;
                }

                $productAttributeResult = $this->product->generatePulldowns($product, $productAttributeId, $attributeLeadingGroup);
                $allPulldownOptions = $productAttributeResult['newPullDowns'];
                $productAttributeId = $productAttributeResult['productAttributeId']; 
                $defaultOption = $productAttributeResult['defaultOption'];      
                $defaultLeadingAttributeId = $productAttributeId;       
                $resultDuplicate2 = $this->product->mergingPulldowns($attributeLeadingGroup, $defaultOption, $allPulldownOptions, $defaultOption);
                $newPullDowns = $resultDuplicate2['newPullDowns'];            
                $productAttribute = $this->product->getProductAttribute($product, $productAttributeId)->first();
                $priceDetails = $productAttribute->getPriceDetails();
                $productImages = $this->product->ajaxProductImages($product, $productAttribute->combinations->pluck('attribute_id')->toArray(), $productAttributeId);       
                
                $template = 'frontend.product.combinations';

                if (BrowserDetect::isMobile() OR BrowserDetect::deviceModel() == 'iPhone') {
                    $template = 'frontend.product.combinations-mobile';
                } 

                return view($template)->with(
                    array(
                        'newPullDowns' => $newPullDowns,
                        'productImages' => $productImages,    
                        'leadAttributeId' => $defaultLeadingAttributeId,
                        'productAttributeId' => $productAttributeId,
                        'productAttribute' => $productAttribute,
                        'firstPulldown' => key($newPullDowns),
                        'priceDetails' => $priceDetails,
                        'childrenProductCategories' => $productCategories,                        
                        'product' => $product        
                    )
                );
            }

            $productImages = $product->productImages;
  
            if (isset($product['ancestors'])) {
                $request->session()->put('category_id', $product['ancestors'][0]['id']);
            }

            $template = 'frontend.product.index';

            if (BrowserDetect::isMobile() OR BrowserDetect::deviceModel() == 'iPhone') {
                $template = 'frontend.product.index-mobile';
            } 

            return view($template)->with(
                array(
                    'priceDetails' => $product->getPriceDetails(),
                    'childrenProductCategories' => $productCategories,
                    'product' => $product,
                    'productImages' => $productImages        
                )
            );            
        }
        
        abort(404);
    }  

    public function getSelectLeadingPulldown($productId, $leadingAttributeId, $secondAttributeId = false)
    {
        $product = $this->product->selectOneByIdAndAttributeId($productId, $leadingAttributeId);
     
        if ($product) {
            if ($product->attributes->count()) {      

                $productAttributeResult = $this->product->generatePulldowns($product, $leadingAttributeId);
                $newPullDowns = $productAttributeResult['newPullDowns'];
                if ($leadingAttributeId) { 
                    $defaultOption = $productAttributeResult['defaultOption'];
                }

                $defaultLeadingAttributeId = $leadingAttributeId;      
                $resultDuplicate2 = $this->product->mergingPulldowns($product->attributeGroup, $defaultOption, $newPullDowns);      
                $newPullDowns = $resultDuplicate2['newPullDowns'];
                $priceDetails = $product->getPriceDetails();
                $productAttribute = $this->product->getProductAttribute($product, $leadingAttributeId, $secondAttributeId)->first();
                $priceDetails = $productAttribute->getPriceDetails();
                $productAttributeId = $productAttribute->id;
                
                $productImages = $this->product->ajaxProductImages($product, $productAttribute->combinations->pluck('attribute_id')->toArray(), $productAttributeId);
                
                $typeTemplate = "";

                if (BrowserDetect::isMobile()) {   
                    $typeTemplate = '-mobile';
                }    

                return view('frontend.product.ajax'.$typeTemplate)->with(array(
                    'newPullDowns' => $newPullDowns,
                    'productImages' => $productImages,            
                    'leadAttributeId' => $leadingAttributeId,
                    'productAttributeId' => $productAttributeId,
                    'firstPulldown' => key($newPullDowns),
                    'secondAttributeId' => $secondAttributeId,
                    'priceDetails' => $priceDetails,
                    'product' => $product
                ));  
            }
        }
    }
}
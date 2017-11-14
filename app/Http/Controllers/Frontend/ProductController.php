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
                if ($product->attributeGroup) {
                    $attributeGroup = $product->attributeGroup;
                } else {
                    $attributeGroup = $product->attributes->first()->combinations->first()->attribute->attributeGroup;
                }

                foreach ($product->attributes as $row) {
                    if ($row['combinations']) {
                        foreach ($row['combinations'] as $key => $value) {
                            $newPullDowns[$value->attribute->attributeGroup->title][$value->attribute->id] = $value->attribute->value;
                        }
                    }
                }

                if ($productAttributeId) {
                    $productAttributeResultWithAttributeId =  ProductAttribute::where('product_attribute.product_id', '=', $product->id)->where('product_attribute.amount', '!=', 0)
                    ->whereHas('combinations', function ($query) use ($productAttributeId) {
                        if ($productAttributeId) {
                            $query->where('attribute_id', '=', $productAttributeId);
                        }
                    })
                    ->with(array('combinations' => function ($query) use ($productAttributeId) {
                        $query->with(array('attribute' => function ($query) {
                            $query->with(array('attributeGroup'));
                        }));
                    }));

                    if ($productAttributeResultWithAttributeId->get()->first()) {
                        foreach ($productAttributeResultWithAttributeId->get()->first()->combinations as $combination) {
                            $defaultOption[$combination->attribute->attributeGroup->title][$combination->attribute->id] = $combination->attribute->value;
                        }
                    } else {
                        $productAttributeId = false;
                    }

                    $productAttributeResultWithAttributeId = $productAttributeResultWithAttributeId->get();

                    if ($productAttributeResultWithAttributeId) {
                        foreach ($productAttributeResultWithAttributeId as $row) {
                            if ($row['combinations']) {
                                foreach ($row['combinations'] as $key => $value) {
                                    $check[$value->attribute->attributeGroup->title][$value->attribute->id] = $value->attribute->value;
                                }
                            }
                        }
                    }
                }

                if (!isset($defaultOption)) {
                    $first = $product->attributes->first();

                    foreach ($first->combinations as $combination) {
                        $defaultOption[$combination->attribute->attributeGroup->title][$combination->attribute->id] = $combination->attribute->value;
                    }

                    $productAttributeId = key($defaultOption[$attributeGroup->title]);
                }

                $defaultLeadingAttributeId = $productAttributeId;

                if ($product->attributeGroup and isset($defaultOption[$product->attributeGroup->title])) {
                    if (!isset($check)) {
                        $productAttributeResultWithAttributeId =  ProductAttribute::where('product_attribute.product_id', '=', $product->id)->where('product_attribute.amount', '!=', 0)
                        ->whereHas('combinations', function ($query) use ($productAttributeId) {
                            if ($productAttributeId) {
                                $query->where('attribute_id', '=', $productAttributeId);
                            }
                        })
                        ->with(array('combinations' => function ($query) use ($productAttributeId) {
                            $query->with(array('attribute' => function ($query) {
                                $query->with(array('attributeGroup'));
                            }));
                        }))->get();

                        if ($productAttributeResultWithAttributeId) {
                            foreach ($productAttributeResultWithAttributeId as $row) {
                                if ($row['combinations']) {
                                    foreach ($row['combinations'] as $key => $value) {
                                        $check[$value->attribute->attributeGroup->title][$value->attribute->id] = $value->attribute->value;
                                    }
                                }
                            }
                        }
                    }
                }

                if (isset($newPullDowns[$attributeGroup->title])) {
                    $check[$attributeGroup->title] = $newPullDowns[$attributeGroup->title];
                    $newPullDowns = $check;
                }

                if (isset($defaultOption[$attributeGroup->title])) {
                    $defaultPulldown = $newPullDowns[$attributeGroup->title];
                    $defaultPulldownFirstKey = key($newPullDowns[$attributeGroup->title]);
                    unset($newPullDowns[$attributeGroup->title]);
                    $newPullDowns = array_merge(array($attributeGroup->title => $defaultPulldown), $newPullDowns);
                }

                if ($productAttributeId) {
                    $productAttribute =  ProductAttributeCombination::select('product_attribute.*')->leftJoin('product_attribute', 'product_attribute_combination.product_attribute_id', '=', 'product_attribute.id')->where('product_attribute.product_id', '=', $product->id)->where('product_attribute_combination.attribute_id', '=', $productAttributeId)->first();
                    $productAttribute =  ProductAttribute::where('product_attribute.id', '=', $productAttribute->id)->first();
                    $priceDetails = $productAttribute->getPriceDetails();
                }

                $productAttributeId = $productAttribute->id;
                $productImages = $this->product->ajaxProductImages($product, $productAttribute->combinations->pluck('attribute_id')->toArray(), $productAttributeId);       
                $template = 'frontend.product.combinations';

                if (BrowserDetect::isMobile() OR BrowserDetect::deviceModel() == 'iPhone') {
                    $template = 'frontend.product.combinations-mobile';
                } 

                return view($template)->with(
                    array(
                        'newPullDowns' => $newPullDowns,
                        'productImages' => $productImages,
                        'countPullDowns' => count($newPullDowns),
                        'pullDownsCount' => count($newPullDowns),
                        'leadAttributeId' => $productAttributeId,
                        'productAttributeId' => $productAttributeId,
                        'productAttribute' => $productAttribute,
                        'firstPulldown' => key($newPullDowns),
                        'priceDetails' => $priceDetails,
                        'childrenProductCategories' => $productCategories,
                        'product' => $product        
                    )
                );

            } else {
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
        } else {
            abort(404);
        }
    }  
}

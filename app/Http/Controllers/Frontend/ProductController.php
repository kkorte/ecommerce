<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\ProductAttributeCombination;
use App\ProductAttribute;
use Dutchbridge\Repositories\ProductRepositoryInterface;
use Dutchbridge\Repositories\ProductWaitingListRepositoryInterface;
use Dutchbridge\Repositories\ProductCategoryRepositoryInterface;
use Illuminate\Http\Request;
use BrowserDetect;
use OpenGraph;
use GoogleTagManager;
use Notification;

class ProductController extends Controller
{

    public function __construct(ProductRepositoryInterface $product, ProductWaitingListRepositoryInterface $productWaitingList, ProductCategoryRepositoryInterface $productCategory)
    {
        $this->product = $product;
        $this->productWaitingList = $productWaitingList;
        $this->productCategory = $productCategory;
        $this->shopId = config()->get('app.shop_id');
    }

    public function getOverViewSaleItems()
    {
        $products = $this->product->selectAllByShopIdAndDiscountPromotion($this->shopId);

        if ($products) {
            return view('frontend.product.sale-items')->with(array('products' => $products));
        }
    }

    public function getOverViewNewItems()
    {
        $products = $this->product->selectAllNewItemsByShopId($this->shopId, 25);

        if ($products) {
            return view('frontend.product.new-items')->with(array('products' => $products));
        }
    }

    public function waitingList(Request $request, $productId, $productAttributeId = false)
    {

          $product = $this->product->selectOneByShopIdAndId($this->shopId, $productId, $request->get('combination_id'));
          return view('frontend.product.waiting-list')->with(array('product' => $product, 'productAttributeId' => $productAttributeId));
    }

    public function postWaitingList(Request $request)
    {
        $result = false;
        $input = $request->all();
        if ($input['email'] and $input['product_id']) {
            $result = $this->productWaitingList->insertEmail($input);
        }

        return response()->json(array('result' => $result));
    }


    public function buyDialog(Request $request, $productId, $leadingAttributeId = false, $secondAttributeId = false)
    {

        $product = $this->product->selectOneByShopIdAndId($this->shopId, $productId, $request->get('combination_id'));

        if ($product->ProductCategory->parent()->count()) {
            $productCategories = $this->productCategory->selectCategoriesByParentId($this->shopId, $product->ProductCategory->parent()->first()->id, 'widescreen');
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

            if ($leadingAttributeId) {
                $productAttributeResultWithAttributeId =  ProductAttribute::where('product_attribute.product_id', '=', $product->id)->where('product_attribute.amount', '!=', 0)
                ->whereHas('combinations', function ($query) use ($leadingAttributeId) {
                    if ($leadingAttributeId) {
                        $query->where('attribute_id', '=', $leadingAttributeId);
                    }
                })
                ->with(array('combinations' => function ($query) use ($leadingAttributeId) {
                    $query->with(array('attribute' => function ($query) {
                        $query->with(array('attributeGroup'));
                    }));
                }));

                if ($productAttributeResultWithAttributeId->get()->first()) {
                    foreach ($productAttributeResultWithAttributeId->get()->first()->combinations as $combination) {
                        $defaultOption[$combination->attribute->attributeGroup->title][$combination->attribute->id] = $combination->attribute->value;
                    }
                } else {
                    $leadingAttributeId = false;
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

                $leadingAttributeId = key($defaultOption[$attributeGroup->title]);
            }

            $defaultLeadingAttributeId = $leadingAttributeId;

            if ($product->attributeGroup and isset($defaultOption[$product->attributeGroup->title])) {
                if (!isset($check)) {
                    $productAttributeResultWithAttributeId =  ProductAttribute::where('product_attribute.product_id', '=', $product->id)->where('product_attribute.amount', '!=', 0)
                    ->whereHas('combinations', function ($query) use ($leadingAttributeId) {
                        if ($leadingAttributeId) {
                            $query->where('attribute_id', '=', $leadingAttributeId);
                        }
                    })
                    ->with(array('combinations' => function ($query) use ($leadingAttributeId) {
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

            $priceDetails = $product->getPriceDetails();


            if ($leadingAttributeId) {
                $productAttribute =  ProductAttributeCombination::select('product_attribute.*')->leftJoin('product_attribute', 'product_attribute_combination.product_attribute_id', '=', 'product_attribute.id')->where('product_attribute.product_id', '=', $product->id)->where('product_attribute_combination.attribute_id', '=', $leadingAttributeId)->first();
                $productAttribute =  ProductAttribute::where('product_attribute.id', '=', $productAttribute->id)->first();

                $priceDetails = $productAttribute->getPriceDetails();
            }


            $productAttributeId = $productAttribute->id;

            $productImages = $this->ajaxProductImages($product, $leadingAttributeId, false);

            return view('frontend.product.buy-dialog-combination')->with(
                array(
                'newPullDowns' => $newPullDowns,
                'productImages' => $productImages,
                'countPullDowns' => count($newPullDowns),
                'pullDownsCount' => count($newPullDowns),
                'leadAttributeId' => $leadingAttributeId,
                'productAttributeId' => $productAttributeId,
                'productAttribute' => $productAttribute,
                'firstPulldown' => key($newPullDowns),
                'secondAttributeId' => $secondAttributeId,
                'priceDetails' => $priceDetails,
                'childrenProductCategories' => $productCategories,
                'product' => $product
                )
            );
        } else {
            if ($product) {
                $productImages = $product->productImages;
                if (isset($product['ancestors'])) {
                    $request->session()->put('category_id', $product['ancestors'][0]['id']);
                }

                return view('frontend.product.buy-dialog-single')->with(
                    array(
                    'priceDetails' => $product->getPriceDetails(),
                    'childrenProductCategories' => $productCategories,
                    'product' => $product,
                    'productImages' => $productImages
                    )
                );
            } else {
                abort(404);
            }
        }
    }


    public function getSelectLeadingPulldownDialog($productId, $leadingAttributeId, $secondAttributeId = false)
    {
        $product = $this->product->selectOneByIdAndAttributeId($this->shopId, $productId, $leadingAttributeId);

        if ($product) {
            if ($product->attributes->count()) {
                if ($leadingAttributeId) {
                    $productAttributeResultWithAttributeId =  ProductAttribute::where('product_attribute.product_id', '=', $product->id)
                    ->whereHas('combinations', function ($query) use ($leadingAttributeId) {
                        if ($leadingAttributeId) {
                            $query->where('attribute_id', '=', $leadingAttributeId);
                        }
                    })
                    ->with(array('combinations' => function ($query) use ($leadingAttributeId) {
                        $query->with(array('attribute' => function ($query) {
                            $query->with(array('attributeGroup'));
                        }));
                    }));


                    if ($productAttributeResultWithAttributeId->get()->first()) {
                        foreach ($productAttributeResultWithAttributeId->get()->first()->combinations as $combination) {
                            $defaultOption[$combination->attribute->attributeGroup->title][$combination->attribute->id] = $combination->attribute->value;
                        }
                    } else {
                        $leadingAttributeId = false;
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

                $defaultLeadingAttributeId = $leadingAttributeId;

                foreach ($product->attributes as $row) {
                    if ($row['combinations']) {
                        foreach ($row['combinations'] as $key => $value) {
                            $newPullDowns[$value->attribute->attributeGroup->title][$value->attribute->id] = $value->attribute->value;
                        }
                    }
                }

                if ($product->attributeGroup and isset($newPullDowns[$product->attributeGroup->title])) {
                    $check[$product->attributeGroup->title] = $newPullDowns[$product->attributeGroup->title];
                    $newPullDowns = $check;
                }

                if ($product->attributeGroup and isset($defaultOption[$product->attributeGroup->title])) {
                    $defaultPulldown = $newPullDowns[$product->attributeGroup->title];
                    $defaultPulldownFirstKey = key($newPullDowns[$product->attributeGroup->title]);
                    unset($newPullDowns[$product->attributeGroup->title]);
                    $newPullDowns = array_merge(array($product->attributeGroup->title => $defaultPulldown), $newPullDowns);
                }

                $priceDetails = $product->getPriceDetails();

                if ($leadingAttributeId and $secondAttributeId) {
                    $productAttribute = ProductAttribute::where('product_id', '=', $product->id)
                    ->whereHas('combinations', function ($query) use ($leadingAttributeId, $secondAttributeId) {
                        if ($leadingAttributeId) {
                            $query->where('attribute_id', '=', $leadingAttributeId);
                        }
                    })
                    ->whereHas('combinations', function ($query) use ($secondAttributeId) {
                        if ($secondAttributeId) {
                            $query->where('attribute_id', '=', $secondAttributeId);
                        }
                    })
                    ->with(array('product'))
                    ->first();
                    if ($productAttribute->getPriceDetails()) {
                        $priceDetails = $productAttribute->getPriceDetails();
                    }
                } else {
                    $productAttribute =  ProductAttributeCombination::select('product_attribute.*')->leftJoin('product_attribute', 'product_attribute_combination.product_attribute_id', '=', 'product_attribute.id')->where('product_attribute.product_id', '=', $product->id)->where('product_attribute_combination.attribute_id', '=', $leadingAttributeId)->first();
               
                    $productAttribute = ProductAttribute::where('product_id', '=', $product->id)
                    ->whereHas('combinations', function ($query) use ($leadingAttributeId) {
                        if ($leadingAttributeId) {
                            $query->where('attribute_id', '=', $leadingAttributeId);
                        }
                    })

                    ->with(array('product'))
                    ->first();


         
                    if ($productAttribute->getPriceDetails()) {
                        $priceDetails = $productAttribute->getPriceDetails();
                    }
                }
     
                $productAttributeId = $productAttribute->id;

                $productImages = $this->ajaxProductImages($product, $leadingAttributeId, $productAttributeId);

                if (BrowserDetect::isMobile()) {
                    return view('frontend.product.buy-dialog-combination-mobile')->with(
                        array(
                        'newPullDowns' => $newPullDowns,
                        'productImages' => $productImages,
                        'pullDownsCount' => count($newPullDowns),
                        'leadAttributeId' => $leadingAttributeId,
                        'productAttributeId' => $productAttributeId,
                        'firstPulldown' => key($newPullDowns),
                        'secondAttributeId' => $secondAttributeId,
                        'priceDetails' => $priceDetails,
                        'product' => $product
                        )
                    );
                } else {
                    return view('frontend.product.buy-dialog-combination')->with(
                        array(
                        'newPullDowns' => $newPullDowns,
                        'productImages' => $productImages,
                        'pullDownsCount' => count($newPullDowns),
                        'leadAttributeId' => $leadingAttributeId,
                        'productAttributeId' => $productAttributeId,
                        'firstPulldown' => key($newPullDowns),
                        'secondAttributeId' => $secondAttributeId,
                        'priceDetails' => $priceDetails,
                        'product' => $product
                        )
                    );
                }
            }
        }
    }


    public function getSelectLeadingPulldown($productId, $leadingAttributeId, $secondAttributeId = false)
    {
        $product = $this->product->selectOneByIdAndAttributeId($this->shopId, $productId, $leadingAttributeId);

        if ($product) {
            if ($product->attributes->count()) {
                if ($leadingAttributeId) {
                    $productAttributeResultWithAttributeId =  ProductAttribute::where('product_attribute.product_id', '=', $product->id)
                    ->whereHas('combinations', function ($query) use ($leadingAttributeId) {
                        if ($leadingAttributeId) {
                            $query->where('attribute_id', '=', $leadingAttributeId);
                        }
                    })
                    ->with(array('combinations' => function ($query) use ($leadingAttributeId) {
                        $query->with(array('attribute' => function ($query) {
                            $query->with(array('attributeGroup'));
                        }));
                    }));


                    if ($productAttributeResultWithAttributeId->get()->first()) {
                        foreach ($productAttributeResultWithAttributeId->get()->first()->combinations as $combination) {
                            $defaultOption[$combination->attribute->attributeGroup->title][$combination->attribute->id] = $combination->attribute->value;
                        }
                    } else {
                        $leadingAttributeId = false;
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

                $defaultLeadingAttributeId = $leadingAttributeId;

                foreach ($product->attributes as $row) {
                    if ($row['combinations']) {
                        foreach ($row['combinations'] as $key => $value) {
                            $newPullDowns[$value->attribute->attributeGroup->title][$value->attribute->id] = $value->attribute->value;
                        }
                    }
                }

                if ($product->attributeGroup and isset($newPullDowns[$product->attributeGroup->title])) {
                    $check[$product->attributeGroup->title] = $newPullDowns[$product->attributeGroup->title];
                    $newPullDowns = $check;
                }

                if ($product->attributeGroup and isset($defaultOption[$product->attributeGroup->title])) {
                    $defaultPulldown = $newPullDowns[$product->attributeGroup->title];
                    $defaultPulldownFirstKey = key($newPullDowns[$product->attributeGroup->title]);
                    unset($newPullDowns[$product->attributeGroup->title]);
                    $newPullDowns = array_merge(array($product->attributeGroup->title => $defaultPulldown), $newPullDowns);
                }

                $priceDetails = $product->getPriceDetails();

                if ($leadingAttributeId and $secondAttributeId) {
                    $productAttribute = ProductAttribute::where('product_id', '=', $product->id)
                    ->whereHas('combinations', function ($query) use ($leadingAttributeId, $secondAttributeId) {
                        if ($leadingAttributeId) {
                            $query->where('attribute_id', '=', $leadingAttributeId);
                        }
                    })
                    ->whereHas('combinations', function ($query) use ($secondAttributeId) {
                        if ($secondAttributeId) {
                            $query->where('attribute_id', '=', $secondAttributeId);
                        }
                    })
                    ->with(array('product'))
                    ->first();
                    if ($productAttribute->getPriceDetails()) {
                        $priceDetails = $productAttribute->getPriceDetails();
                    }
                } else {
                    $productAttribute =  ProductAttributeCombination::select('product_attribute.*')->leftJoin('product_attribute', 'product_attribute_combination.product_attribute_id', '=', 'product_attribute.id')->where('product_attribute.product_id', '=', $product->id)->where('product_attribute_combination.attribute_id', '=', $leadingAttributeId)->first();
               
                    $productAttribute = ProductAttribute::where('product_id', '=', $product->id)
                    ->whereHas('combinations', function ($query) use ($leadingAttributeId) {
                        if ($leadingAttributeId) {
                            $query->where('attribute_id', '=', $leadingAttributeId);
                        }
                    })

                    ->with(array('product'))
                    ->first();


         
                    if ($productAttribute->getPriceDetails()) {
                        $priceDetails = $productAttribute->getPriceDetails();
                    }
                }
     
                $productAttributeId = $productAttribute->id;

                $productImages = $this->ajaxProductImages($product, $leadingAttributeId, $productAttributeId);
                if (BrowserDetect::isMobile()) {
                    return view('frontend.product.ajax-mobile')->with(array(
                    'newPullDowns' => $newPullDowns,
                    'productImages' => $productImages,
                    'pullDownsCount' => count($newPullDowns),
                    'leadAttributeId' => $leadingAttributeId,
                    'productAttributeId' => $productAttributeId,
                    'firstPulldown' => key($newPullDowns),
                    'secondAttributeId' => $secondAttributeId,
                    'priceDetails' => $priceDetails,
                    'product' => $product
                    ));
                } else {
                    return view('frontend.product.ajax')->with(array(
                    'newPullDowns' => $newPullDowns,
                    'productImages' => $productImages,
                    'pullDownsCount' => count($newPullDowns),
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

    public function ajaxProductImages($product, $leadingAttributeId, $productAttributeId = false)
    {
        $productImages = array();
        if ($product->productImages) {
            foreach ($product->productImages as $keyImage => $rowImage) {
                if ($rowImage->relatedAttributes->count() or $rowImage->relatedProductAttributes->count()) {
                    if ($rowImage->relatedAttributes->count()) {
                        foreach ($rowImage->relatedAttributes as $relatedAttribute) {
                            if ($relatedAttribute->pivot->attribute_id == $leadingAttributeId) {
                                $productImages[] = $rowImage;
                            }
                        }
                    }

                    if (isset($productAttributeId) and $rowImage->relatedProductAttributes) {
                        foreach ($rowImage->relatedProductAttributes as $relatedProductAttribute) {
                            if ($relatedProductAttribute->pivot->product_attribute_id == $productAttributeId) {
                                $productImages[] = $rowImage;
                            }
                        }
                    }
                } else {
                    $productImages[] = $rowImage;
                }
            }
        }

        return $productImages;
    }

    public function getIndex(Request $request, $categorySlug, $productId, $productSlug, $leadingAttributeId = false, $secondAttributeId = false)
    {

        $og = new OpenGraph();


        $product = $this->product->selectOneByShopIdAndId($this->shopId, $productId, $request->get('combination_id'));
        if ($product) {
            if ($product->slug != $productSlug or $product->productCategory->slug != $categorySlug) {
                   return redirect()->route('product.item', array('productCategorySlug' => $product->productCategory->slug, 'productId' => $product->id, 'slug' => $product->slug));
            }


            $og->title($product->title)
                ->type('product')
         
                ->description($product->short_description)
                ->url();


            if ($product->ProductCategory and $product->ProductCategory->parent()->count()) {
                $productCategories = $this->productCategory->selectCategoriesByParentId($this->shopId, $product->ProductCategory->parent()->first()->id, 'widescreen');
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

                if ($leadingAttributeId) {
                    $productAttributeResultWithAttributeId =  ProductAttribute::where('product_attribute.product_id', '=', $product->id)->where('product_attribute.amount', '!=', 0)
                    ->whereHas('combinations', function ($query) use ($leadingAttributeId) {
                        if ($leadingAttributeId) {
                            $query->where('attribute_id', '=', $leadingAttributeId);
                        }
                    })
                    ->with(array('combinations' => function ($query) use ($leadingAttributeId) {
                        $query->with(array('attribute' => function ($query) {
                            $query->with(array('attributeGroup'));
                        }));
                    }));

                    if ($productAttributeResultWithAttributeId->get()->first()) {
                        foreach ($productAttributeResultWithAttributeId->get()->first()->combinations as $combination) {
                            $defaultOption[$combination->attribute->attributeGroup->title][$combination->attribute->id] = $combination->attribute->value;
                        }
                    } else {
                        $leadingAttributeId = false;
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

                    $leadingAttributeId = key($defaultOption[$attributeGroup->title]);
                }

                $defaultLeadingAttributeId = $leadingAttributeId;

                if ($product->attributeGroup and isset($defaultOption[$product->attributeGroup->title])) {
                    if (!isset($check)) {
                        $productAttributeResultWithAttributeId =  ProductAttribute::where('product_attribute.product_id', '=', $product->id)->where('product_attribute.amount', '!=', 0)
                        ->whereHas('combinations', function ($query) use ($leadingAttributeId) {
                            if ($leadingAttributeId) {
                                $query->where('attribute_id', '=', $leadingAttributeId);
                            }
                        })
                        ->with(array('combinations' => function ($query) use ($leadingAttributeId) {
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



                if ($leadingAttributeId) {
                    $productAttribute =  ProductAttributeCombination::select('product_attribute.*')->leftJoin('product_attribute', 'product_attribute_combination.product_attribute_id', '=', 'product_attribute.id')->where('product_attribute.product_id', '=', $product->id)->where('product_attribute_combination.attribute_id', '=', $leadingAttributeId)->first();
                    $productAttribute =  ProductAttribute::where('product_attribute.id', '=', $productAttribute->id)->first();

                    $priceDetails = $productAttribute->getPriceDetails();
                }

                $productAttributeId = $productAttribute->id;

                $productImages = $this->ajaxProductImages($product, $leadingAttributeId, $productAttributeId);
                if (isset($productImages[0])) {
                    $og->image('/files/product/200x200/'.$product->id.'/'.$productImages[0]->file);
                }


                GoogleTagManager::set('ecommerce', [
                    'detail' => [
                        'products' => [ 'id' => $product->id, 'title' => $product->title,  'catergory' => $product->productCategory->title ]
                    ]
                ]);



                if (BrowserDetect::isMobile()) {
                    return view('frontend.product.combinations-mobile')->with(
                        array(
                        'newPullDowns' => $newPullDowns,
                        'productImages' => $productImages,
                        'countPullDowns' => count($newPullDowns),
                        'pullDownsCount' => count($newPullDowns),
                        'leadAttributeId' => $leadingAttributeId,
                        'productAttributeId' => $productAttributeId,
                        'productAttribute' => $productAttribute,
                        'firstPulldown' => key($newPullDowns),
                        'secondAttributeId' => $secondAttributeId,
                        'priceDetails' => $priceDetails,
                        'childrenProductCategories' => $productCategories,
                        'product' => $product,
                        'og'    => $og
                        )
                    );
                } else {
                    return view('frontend.product.combinations')->with(
                        array(
                        'newPullDowns' => $newPullDowns,
                        'productImages' => $productImages,
                        'countPullDowns' => count($newPullDowns),
                        'pullDownsCount' => count($newPullDowns),
                        'leadAttributeId' => $leadingAttributeId,
                        'productAttributeId' => $productAttributeId,
                        'productAttribute' => $productAttribute,
                        'firstPulldown' => key($newPullDowns),
                        'secondAttributeId' => $secondAttributeId,
                        'priceDetails' => $priceDetails,
                        'childrenProductCategories' => $productCategories,
                        'product' => $product,
                        'og'    => $og
                        )
                    );
                }
            } else {
                $productImages = $product->productImages;

                if (isset($productImages[0])) {
                    $og->image('/files/product/200x200/'.$product->id.'/'.$productImages[0]->file);
                }

                if (isset($product['ancestors'])) {
                    $request->session()->put('category_id', $product['ancestors'][0]['id']);
                }

                GoogleTagManager::set('ecommerce', [
                    'detail' => [
                        'products' => [ 'id' => $product->id, 'title' => $product->title,  'catergory' => $product->productCategory->title ]
                    ]
                ]);


                if (BrowserDetect::isMobile()) {
                    return view('frontend.product.index-mobile')->with(
                        array(
                        'priceDetails' => $product->getPriceDetails(),
                        'childrenProductCategories' => $productCategories,
                        'product' => $product,
                        'productImages' => $productImages,
                        'og' => $og
                        )
                    );
                } else {
                    return view('frontend.product.index')->with(
                        array(
                        'priceDetails' => $product->getPriceDetails(),
                        'childrenProductCategories' => $productCategories,
                        'product' => $product,
                        'productImages' => $productImages,
                        'og' => $og
                        )
                    );
                }
            }
        } else {
            abort(404);
        }
    }


    public function getExport()
    {
        return view('admin.product.export')->with(array());
    }

    public function postExport()
    {

        $result  =  $this->product->selectAllExport();
        Excel::create('export', function ($excel) use ($result) {

            $excel->sheet('Products', function ($sheet) use ($result) {
                $newArray = array();
                foreach ($result as $row) {
                    $category = "";
                    if ($row->productCategory) {
                        $category = $row->productCategory->title;
                    }

                    $priceDetails = $row->getPriceDetails();


                    $newArray[$row->id] = array(
                    'title' => $row->title,
                    'category' => $category,
                    'amount' => $row->amount,
                    'reference_code' => $row->reference_code,
                    'orginal_price_ex_tax_number_format' => $priceDetails['orginal_price_ex_tax_number_format'],
                    'orginal_price_inc_tax_number_format' => $priceDetails['orginal_price_inc_tax_number_format'],
                    'tax_rate' => $priceDetails['tax_rate'],
                    'currency' => $priceDetails['currency']

                    );


                    $images = array();
                    if ($row->productImages->count()) {
                        $i = 0;
                        foreach ($row->productImages as $image) {
                            $i++;
                            $newArray[$row->id]['image_'.$i] =  'https://www.brulo.nl/files/product/800x800/'.$row->id.'/'.$image->file;
                        }
                    }
                }

                $sheet->fromArray($newArray);
            });
        })->download('csv');


        Notification::success('The product export is completed.');
        return redirect()->route('admin.product.index');
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Hideyo\Repositories\ProductCategoryRepositoryInterface;
use Hideyo\Repositories\ProductRepositoryInterface;
use Hideyo\Repositories\ProductCombinationRepositoryInterface;
use Hideyo\Repositories\ProductExtraFieldValueRepositoryInterface;

use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function __construct(ProductCombinationRepositoryInterface $productAttribute, ProductCategoryRepositoryInterface $productCategory, ProductRepositoryInterface $product, ProductExtraFieldValueRepositoryInterface $productExtraFieldValue)
    {
        $this->productCategory = $productCategory;
        $this->product = $product;
        $this->productAttribute = $productAttribute;
        $this->productExtraFieldValue = $productExtraFieldValue;
        $this->shopId = config()->get('app.shop_id');
    }

    public function getBySlugAjax(Request $request, $slug)
    {
        $html = "";
        $inputFields = $request->all();

        if (isset($inputFields['currentPage'])) {
        }

        if (isset($inputFields['fromHash'])) {
            $json = base64_decode($inputFields['currentFilters']);

            $inputFields = (array) json_decode($json, true);
        }

        unset($inputFields['_token']);
        $page = $request->get('page', 1);

        $category = $this->productCategory->selectOneByShopIdAndSlug($this->shopId, $slug);

        if ($category) {
            if ($category->ancestors()->count()) {
                $request->session()->put('category_id', $category->ancestors()->first()->id);
            }

            $products = "";
            if ($category->id) {
                $products = $this->product->selectAllByShopIdAndProductCategoryId($this->shopId, $category['id'], $inputFields);
            }

            if ($category['ref_product_category']) {
                return redirect()->to('category/'.$category['ref_product_category']['slug']);
            }
            if ($category->isLeaf()) {
                $childrenProductCategories = $this->productCategory->selectCategoriesByParentId($this->shopId, $category->parent_id);
                $attributes = $this->productAttribute->selectAllByProductCategoryId($category->id, $this->shopId);
                $extraFields = $this->productExtraFieldValue->selectAllByProductCategoryId($category->id, $this->shopId);
                          
                $filterCombinations = array();

                if ($attributes->count()) {
                    foreach ($attributes as $row) {
                        foreach ($row->combinations as $combination) {
                            if ($combination->attribute->attributeGroup->filter) {
                                $filterCombinations[$combination->attribute->attributeGroup->title]['filter_type'] = $combination->attribute->attributeGroup->filter_type;
                                $filterCombinations[$combination->attribute->attributeGroup->title]['options'][$combination->attribute->id] = $combination->attribute->value;
                                ksort($filterCombinations[$combination->attribute->attributeGroup->title]['options']);
                            }
                        }
                    }
                }

                $extraFilterFields = array();

                if ($extraFields->count()) {
                    foreach ($extraFields as $row) {
                        if ($row->extraField->filterable) {
                            if ($row->value) {
                                $extraFilterFields[$row->extraField->title]['options'][$row->value] = $row->value;
                            } else {
                                $extraFilterFields[$row->extraField->title]['options'][$row->extraFieldDefaultValue->id] = $row->extraFieldDefaultValue->value;
                            }
                        }
                    }
                }


                $html = view('frontend.product_category.products-ajax')->with(
                    array(
                        'childrenProductCategories' => $childrenProductCategories,
                        'filterCombinations' => $filterCombinations,
                        'extraFilterFields' => $extraFilterFields,
                        'category' => $category,
                        'products' => $products,
                        'selectedPage' => $page,
                        'inputFields' => $inputFields
                        )
                )->render();
            }
        }

        if ($inputFields) {
            unset($inputFields['_token']);
            $json = json_encode($inputFields);
            $base64 = base64_encode($json);
            return response()->json(['hash' => $base64, 'html' => $html]);
        } else {
            return response()->json(['hash' => '', 'html' => $html]);
        }
    }


    public function getItem(Request $request, $slug)
    {
        $category = $this->productCategory->selectOneByShopIdAndSlug(config()->get('app.shop_id'), $slug);


        if ($category) {

            if ($category->ancestors()->count()) {
                $request->session()->put('category_id', $category->ancestors()->first()->id);
            }

            $products = "";
            if ($category->id) {
                $products = $this->product->selectAllByShopIdAndProductCategoryId($this->shopId, $category['id']);
            }

            if ($category->refProductCategory) {
                return redirect()->to($category->refProductCategory->slug);
            }
            if ($category->isLeaf()) {
                if ($category->isChild()) {
                    $childrenProductCategories = $this->productCategory->selectCategoriesByParentId($this->shopId, $category->parent_id);
                } else {
                    $childrenProductCategories = $this->productCategory->selectAllByShopIdAndRoot($this->shopId);
                }
                $attributes = $this->productAttribute->selectAllByProductCategoryId($category->id, $this->shopId);
                $extraFields = $this->productExtraFieldValue->selectAllByProductCategoryId($category->id, $this->shopId);
              
                $filterCombinations = array();

                if ($attributes->count()) {
                    foreach ($attributes as $row) {
                        foreach ($row->combinations as $combination) {
                            if ($combination->attribute->attributeGroup->filter) {
                                $filterCombinations[$combination->attribute->attributeGroup->title]['filter_type'] = $combination->attribute->attributeGroup->filter_type;
                                $filterCombinations[$combination->attribute->attributeGroup->title]['options'][$combination->attribute->id] = $combination->attribute->value;
                                ksort($filterCombinations[$combination->attribute->attributeGroup->title]['options']);
                            }
                        }
                    }
                }

                $extraFilterFields = array();

                if ($extraFields->count()) {
                    foreach ($extraFields as $row) {
                        if ($row->extraField->filterable) {
                            if ($row->value) {
                                $extraFilterFields[$row->extraField->title]['options'][$row->value] = $row->value;
                            } else {
                                $extraFilterFields[$row->extraField->title]['options'][$row->extraFieldDefaultValue->id] = $row->extraFieldDefaultValue->value;
                            }
                        }
                    }
                }

                return view('frontend.product_category.products')->with(
                    array(
                        'childrenProductCategories' => $childrenProductCategories,
                        'filterCombinations' => $filterCombinations,
                        'extraFilterFields' => $extraFilterFields,
                        'category' => $category,
                        'products' => $products,
                    )
                );
            } else {
                $childrenProductCategories = $this->productCategory->selectCategoriesByParentId($this->shopId, $category->id);
                return view('frontend.product_category.categories')->with(
                    array(
                        'category' => $category,
                        'childrenProductCategories' => $childrenProductCategories
                    )
                );
            }
        } else {
            abort(404);
        }
    }
}

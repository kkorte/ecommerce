<?php namespace Hideyo\Backend\Controllers;

/**
 * ProductController
 *
 * This is the controller of the product weight types of the shop
 * @author Matthijs Neijenhuijs <matthijs@hideyo.io>
 * @version 1.0
 */

use App\Http\Controllers\Controller;
use Hideyo\Backend\Repositories\ProductAmountSeriesRepositoryInterface;
use Hideyo\Backend\Repositories\ProductRepositoryInterface;
use Hideyo\Backend\Repositories\ExtraFieldRepositoryInterface;
use Hideyo\Backend\Repositories\AttributeGroupRepositoryInterface;
use Hideyo\Backend\Repositories\TaxRateRepositoryInterface;

use \Request;
use \Notification;
use \Redirect;
use \Response;

class ProductAmountSeriesController extends Controller
{
    public function __construct(
        ProductAmountSeriesRepositoryInterface $productAmountSeries,
        ProductRepositoryInterface $product,
        AttributeGroupRepositoryInterface $attributeGroup,
        TaxRateRepositoryInterface $taxRate
    ) {
        $this->productAmountSeries = $productAmountSeries;
        $this->product = $product;
        $this->attributeGroup = $attributeGroup;
        $this->taxRate = $taxRate;
    }

    public function index($productId)
    {
        $product = $this->product->find($productId);
        if (Request::wantsJson()) {


            $query = $this->productAmountSeries->getModel()->select(
                ['id', 'series_start', 'series_value', 'active','series_max']
            )->where('product_id', '=', $productId);
            
            $datatables = \Datatables::of($query)

            ->addColumn('active', function ($query) {
                if ($query->active) {
                    return '<a href="#" class="change-active" data-url="/admin/html-block/change-active/'.$query->id.'"><span class="glyphicon glyphicon-ok icon-green"></span></a>';
                } else {
                    return '<a href="#" class="change-active" data-url="/admin/html-block/change-active/'.$query->id.'"><span class="glyphicon glyphicon-remove icon-red"></span></a>';
                }
            })
            ->addColumn('action', function ($query) use ($productId) {
                $delete = \Form::deleteajax('/admin/product/'.$productId.'/product-amount-series/'. $query->id, 'Delete', '', array('class'=>'btn btn-default btn-sm btn-danger'));
                $link = '<a href="/admin/product/'.$productId.'/product-amount-series/'.$query->id.'/edit" class="btn btn-default btn-sm btn-success"><i class="entypo-pencil"></i>Edit</a>  '.$delete;
                
                return $link;
            });

            return $datatables->make(true);

        } else {
            return view('hideyo_backend::product-amount-series.index')->with(array('product' => $product, 'attributeGroups' => $this->attributeGroup->selectAll()->pluck('title', 'id')));
        }
    }

    public function create($productId)
    {
        $product = $this->product->find($productId);

        if (Request::wantsJson()) {
            $input = Request::all();
            $attributeGroup = $this->attributeGroup->find($input['attribute_group_id']);
            if ($attributeGroup->count()) {
                if ($attributeGroup->attributes()) {
                    return Response::json($attributeGroup->attributes);
                }
            }
        } else {
            return view('hideyo_backend::product-amount-series.create')->with(array('taxRates' => $this->taxRate->selectAll()->pluck('title', 'id'), 'product' => $product, 'attributeGroups' => $this->attributeGroup->selectAll()->pluck('title', 'id')));
        }
    }

    public function store($productId)
    {
        $result  = $this->productAmountSeries->create(Request::all(), $productId);
 
        if (isset($result->id)) {
            Notification::success('The product amount series is updated.');
            return Redirect::route('admin.product.{productId}.product-amount-series.index', $productId);
        }

        if ($result) {
            foreach ($result->errors()->all() as $error) {
                \Notification::error($error);
            }
        } else {
            \Notification::error('amount series already exist');
        }
        
        return \Redirect::back()->withInput();
    }

    public function edit($productId, $id)
    {
        $product = $this->product->find($productId);
        $productAmountSeries = $this->productAmountSeries->find($id);
        $selectedAttributes = array();
        $attributes = array();

        return view('hideyo_backend::product-amount-series.edit')->with(array('taxRates' => $this->taxRate->selectAll()->pluck('title', 'id'), 'selectedAttributes' => $selectedAttributes, 'attributes' => $attributes, 'productAmountSeries' => $productAmountSeries, 'product' => $product, 'attributeGroups' => $this->attributeGroup->selectAll()->pluck('title', 'id')));
    }

    public function update($productId, $id)
    {
        $result  = $this->productAmountSeries->updateById(Request::all(), $productId, $id);

        if (!$result->id) {
            return Redirect::back()->withInput()->withErrors($result->errors()->all());
        }
        
        Notification::success('The product amount series is updated.');
        return Redirect::route('admin.product.{productId}.product-amount-series.index', $productId);
    }

    public function destroy($productId, $id)
    {
        $result  = $this->productAmountSeries->destroy($id);

        if ($result) {
            Notification::success('The product amount series is deleted.');
            return Redirect::route('admin.product.{productId}.product-amount-series.index', $productId);
        }
    }
}

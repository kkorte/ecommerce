<?php namespace Hideyo\Backend\Controllers;


/**
 * CouponController
 *
 * This is the controller of the product group tags of the shop
 * @author Matthijs Neijenhuijs <matthijs@dutchbridge.nl>
 * @version 1.0
 */

use App\Http\Controllers\Controller;
use Hideyo\Backend\Repositories\ProductTagGroupRepositoryInterface;
use Hideyo\Backend\Repositories\ProductRepositoryInterface;

use Request;
use Notification;

class ProductTagGroupController extends Controller
{
    public function __construct(
        ProductTagGroupRepositoryInterface $productTagGroup,
        ProductRepositoryInterface $product
    ) {
        $this->product = $product;
        $this->productTagGroup = $productTagGroup;
    }

    public function index()
    {
        if (Request::wantsJson()) {

            $query = $this->productTagGroup->getModel()
            ->select([\DB::raw('@rownum  := @rownum  + 1 AS rownum'),'id','tag'])
            ->where('shop_id', '=', \Auth::guard('hideyobackend')->user()->selected_shop_id);
            
            $datatables = \Datatables::of($query)->addColumn('action', function ($query) {
                $delete = \Form::deleteajax('/admin/product-tag-group/'. $query->id, 'Delete', '', array('class'=>'btn btn-default btn-sm btn-danger'));
                $link = '<a href="/admin/product-tag-group/'.$query->id.'/edit" class="btn btn-default btn-sm btn-success"><i class="entypo-pencil"></i>Edit</a>  '.$delete;
            
                return $link;
            });

            return $datatables->make(true);


        } else {
            return view('hideyo_backend::product_tag_group.index')->with('productTagGroup', $this->productTagGroup->selectAll());
        }
    }

    public function create()
    {
        return view('hideyo_backend::product_tag_group.create')->with(array(
            'products' => $this->product->selectAll()->pluck('title', 'id')
        ));
    }

    public function store()
    {
        $result  = $this->productTagGroup->create(\Request::all());

        if (isset($result->id)) {
            Notification::success('The product group tag was inserted.');
            return redirect()->route('admin.product-tag-group.index');
        }
        
        foreach ($result->errors()->all() as $error) {
            Notification::error($error);
        }
        
        return redirect()->back()->withInput();
    }

    public function edit($id)
    {
    
        return view('hideyo_backend::product_tag_group.edit')->with(array(
            'products' => $this->product->selectAll()->pluck('title', 'id'),
            'productTagGroup' => $this->productTagGroup->find($id)
            ));
    }

    public function update($id)
    {
        $result  = $this->productTagGroup->updateById(\Request::all(), $id);

        if (isset($result->id)) {
            Notification::success('The product group tag was updated.');
            return redirect()->route('admin.product-tag-group.index');
        }
        
        foreach ($result->errors()->all() as $error) {
            Notification::error($error);
        }
        
        return redirect()->back()->withInput();
    }

    public function destroy($id)
    {
        $result  = $this->productTagGroup->destroy($id);

        if ($result) {
            Notification::success('The product group tag was deleted.');
            return redirect()->route('admin.product-tag-group.index');
        }
    }
}

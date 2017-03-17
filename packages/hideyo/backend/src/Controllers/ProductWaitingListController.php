<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Dutchbridge\Repositories\ProductWaitingListRepositoryInterface;

use \Request;
use \Redirect;
use Notification;

class ProductWaitingListController extends Controller
{

    public function __construct(ProductWaitingListRepositoryInterface $productWaitingList)
    {
        $this->productWaitingList = $productWaitingList;
    }

    public function index()
    {
        if (\Request::wantsJson()) {

            $query = $this->productWaitingList->getModel()->select(
                [
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'id', 'product_id', 'product_attribute_id',
                'email']
            )->with(array('product', 'productAttribute'));
            
            $datatables = \Datatables::of($query)

            ->addColumn('product', function ($query) {
                if ($query->product) {
                    return $query->product->title;
                } else {
                    return "";
                }
            })


            ->addColumn('action', function ($query) {
                $delete = \Form::deleteajax('/admin/product-waiting-list/'. $query->id, 'Delete', '', array('class'=>'btn btn-default btn-sm btn-danger'));
                $link = $delete;
            
                return $link;
            });

            return $datatables->make(true);

        } else {
            return view('admin.product-waiting-list.index')->with('productWaitingList', $this->productWaitingList->selectAll());
        }
    }

    public function create()
    {
        return view('admin.product-waiting-list.create')->with(array());
    }

    public function store()
    {
        $result  = $this->productWaitingList->create(Request::all());

        if (isset($result->id)) {
            Notification::success('The general setting was inserted.');
            return Redirect::route('admin.product-waiting-list.index');
        }
            
        foreach ($result->errors()->all() as $error) {
            \Notification::error($error);
        }
        return Redirect::back()->withInput();
    }

    public function edit($id)
    {
        return view('admin.product-waiting-list.edit')->with(array('productWaitingList' => $this->productWaitingList->find($id)));
    }

    public function update($id)
    {
        $result  = $this->productWaitingList->updateById(Request::all(), $id);

        if (isset($result->id)) {
            Notification::success('The general setting was updated.');
            return Redirect::route('admin.product-waiting-list.index');
        }
        
        foreach ($result->errors()->all() as $error) {
            \Notification::error($error);
        }
        return Redirect::back()->withInput();
    }

    public function destroy($id)
    {
        $result  = $this->productWaitingList->destroy($id);
        if ($result) {
            Notification::error('The general setting was deleted.');
            return Redirect::route('admin.product-waiting-list.index');
        }
    }
}

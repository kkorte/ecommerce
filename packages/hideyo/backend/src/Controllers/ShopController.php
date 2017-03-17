<?php namespace App\Http\Controllers\Admin;

/**
 * CouponController
 *
 * This is the controller of the sending methods of the shop
 * @author Matthijs Neijenhuijs <matthijs@dutchbridge.nl>
 * @version 1.0
 */

use App\Http\Controllers\Controller;
use Dutchbridge\Repositories\ShopRepositoryInterface;
use Illuminate\Http\Request;
use Notification;

class ShopController extends Controller
{
    public function __construct(
        Request $request, 
        ShopRepositoryInterface $shop)
    {
        $this->shop = $shop;
        $this->request = $request;
    }

    public function index()
    {
        if ($this->request->wantsJson()) {

            $query = $this->shop->getModel()
            ->select([\DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'id', 'title', 'logo_file_name']);

            $datatables = \Datatables::of($query)

            ->addColumn('action', function ($query) {
                $delete = \Form::deleteajax('/admin/shop/'. $query->id, 'Delete', '', array('class'=>'btn btn-default btn-sm btn-danger'));
                $link = '<a href="/admin/shop/'.$query->id.'/edit" class="btn btn-default btn-sm btn-success"><i class="entypo-pencil"></i>Edit</a>  '.$delete;
                return $link;
            })

            ->addColumn('image', function ($query) {
                if ($query->logo_file_name) {
                    return '<img src="http://shop.brulo.nl/files/'.$query->id.'/logo/'.$query->logo_file_name.'"  />';
                }
            });

            return $datatables->make(true);
        } else {
            return view('admin.shop.index')->with('shop', $this->shop->selectAll());
        }
    }

    public function create()
    {
        return view('admin.shop.create');
    }

    public function store()
    {
        $result  = $this->shop->create($this->request->all());

        if (isset($result->id)) {
            Notification::success('The shop was inserted.');
            return redirect()->route('admin.shop.index');
        }
        
        foreach ($result->errors()->all() as $error) {
            Notification::error($error);
        }
        
        return redirect()->back()->withInput();
    }

    public function edit($id)
    {
        return view('admin.shop.edit')->with(array('shop' => $this->shop->find($id)));
    }

    public function update($id)
    {
        $result  = $this->shop->updateById($this->request->all(), $id);

        if (isset($result->id)) {
            Notification::success('The shop was updated.');
            return redirect()->route('admin.shop.index');
        }
        
        foreach ($result->errors()->all() as $error) {
            Notification::error($error);
        }
        
        return redirect()->back()->withInput();
    }

    public function destroy($id)
    {
        $result  = $this->shop->destroy($id);

        if ($result) {
            Notification::success('The shop was deleted.');
            return redirect()->route('admin.shop.index');
        }
    }
}

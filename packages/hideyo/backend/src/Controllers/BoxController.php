<?php namespace App\Http\Controllers\Admin;

/**
 * CouponController
 *
 * This is the controller of the boxs of the shop
 * @author Matthijs Neijenhuijs <matthijs@dutchbridge.nl>
 * @version 1.0
 */

use App\Http\Controllers\Controller;
use Dutchbridge\Repositories\BoxRepositoryInterface;

use \Request;
use \Notification;
use \Redirect;

class BoxController extends Controller
{
    public function __construct(BoxRepositoryInterface $box)
    {
        $this->box = $box;
    }

    public function index()
    {
        if (Request::wantsJson()) {

            $query = $this->box->getModel()->select(
                [
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'box.id', 'box.active', 'box.vegetarian', 'box.processed', 'box.created_at',
                'box.name', 'box.email', 'box.payment_choice', 'account_number', 'account_name', 'company', 'payment_way']
            )->where('box.shop_id', '=', \Auth::guard('admin')->user()->selected_shop_id);
            
            $datatables = \Datatables::of($query)

            ->addColumn('created_at', function ($order) {
                return date('d F Y', strtotime($order->created_at));
            })
            ->addColumn('active', function ($query) {
                if ($query->active) {
                    return '<span class="glyphicon glyphicon-ok icon-green"></span>';
                } else {
                    return '<span class="glyphicon glyphicon-remove icon-red"></span>';
                }
            })
            ->addColumn('multivers', function ($query) {
                if ($query->multivers) {
                    return '<span class="glyphicon glyphicon-ok icon-green"></span>';
                } else {
                    return '<span class="glyphicon glyphicon-remove icon-red"></span>';
                }
            })
            ->addColumn('vegetarian', function ($query) {
                if ($query->vegetarian) {
                    return '<span class="glyphicon glyphicon-ok icon-green"></span>';
                } else {
                    return '<span class="glyphicon glyphicon-remove icon-red"></span>';
                }
            })
            ->addColumn('processed', function ($query) {
                if ($query->processed) {
                    return '<span class="glyphicon glyphicon-ok icon-green"></span>';
                } else {
                    return '<span class="glyphicon glyphicon-remove icon-red"></span>';
                }
            })
            ->addColumn('boxgroup', function ($box) {
                return $box->boxtitle;
            })
            ->addColumn('action', function ($query) {
                $delete = \Form::deleteajax('/admin/box/'. $query->id, 'Delete', '', array('class'=>'btn btn-default btn-sm btn-danger'));
                
                $download = '<a href="/admin/box/'.$query->id.'/download" class="btn btn-default btn-sm btn-info"><i class="entypo-pencil"></i>Download</a>  ';
                
                $link = '<a href="/admin/box/'.$query->id.'/edit" class="btn btn-default btn-sm btn-success"><i class="entypo-pencil"></i>Show</a>  '.$delete.' '.$download;
            
                return $link;
            });

            return $datatables->make(true);


        } else {
            return view('admin.box.index')->with('box', $this->box->selectAll());
        }
    }

    public function create()
    {
        return view('admin.box.create')->with(array());
    }

    public function download($id)
    {
        $box = $this->box->find($id);
        $pdf = \PDF::loadView('frontend.box.pdf', array('box' => $box));
        return $pdf->download('box-'.$box->id.'.pdf');
    }

    public function store()
    {
        $result  = $this->box->create(\Request::all());

        if (isset($result->id)) {
            \Notification::success('The box was inserted.');
            return \Redirect::route('admin.box.index');
        }
        
        foreach ($result->errors()->all() as $error) {
            \Notification::error($error);
        }
        
        return \Redirect::back()->withInput();
    }

    public function edit($id)
    {
        return view('admin.box.edit')->with(array('box' => $this->box->find($id)));
    }

    public function editSeo($id)
    {
        return view('admin.box.edit_seo')->with(array('box' => $this->box->find($id)));
    }

    public function update($boxId)
    {
        $result  = $this->box->updateById(Request::all(), $boxId);

        if (isset($result->id)) {
            if (Request::get('seo')) {
                Notification::success('Box seo was updated.');
                return Redirect::route('admin.box.edit_seo', $boxId);
            } elseif (Request::get('box-combination')) {
                Notification::success('Box combination leading attribute group was updated.');
                return Redirect::route('admin.box.{boxId}.box-combination.index', $boxId);
            } else {
                Notification::success('Box was updated.');
                return Redirect::route('admin.box.edit', $boxId);
            }
        }

        foreach ($result->errors()->all() as $error) {
            \Notification::error($error);
        }
        
       
        return Redirect::back()->withInput();
    }

    public function destroy($id)
    {
        $result  = $this->box->destroy($id);

        if ($result) {
            Notification::success('The box was deleted.');
            return Redirect::route('admin.box.index');
        }
    }
}
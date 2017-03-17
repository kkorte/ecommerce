<?php namespace App\Http\Controllers\Admin;

/**
 * OrderStatusController
 *
 * This is the controller of the order statuses of the shop
 * @author Matthijs Neijenhuijs <matthijs@dutchbridge.nl>
 * @version 1.0
 */

use App\Http\Controllers\Controller;
use Dutchbridge\Repositories\OrderStatusRepositoryInterface;
use Dutchbridge\Repositories\OrderStatusEmailTemplateRepositoryInterface;

use Illuminate\Http\Request;
use Auth;
use Notification;

class OrderStatusController extends Controller
{
    public function __construct(
        Request $request,
        OrderStatusRepositoryInterface $orderStatus,
        OrderStatusEmailTemplateRepositoryInterface $orderStatusEmailTemplate
    ) {
        $this->request = $request;
        $this->orderStatus = $orderStatus;
        $this->orderStatusEmailTemplate = $orderStatusEmailTemplate;
    }

    public function index()
    {
        if ($this->request->wantsJson()) {

            $query = $this->orderStatus->getModel()->select(
                [
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'id', 'color',
                'title']
            )->where('shop_id', '=', \Auth::guard('admin')->user()->selected_shop_id);
            
            $datatables = \Datatables::of($query)

            ->addColumn('title', function ($query) {
     
                if ($query->color) {
                    return '<span style="background-color:'.$query->color.'; padding: 10px; line-height:30px; text-align:center; color:white;">'.$query->title.'</span>';
                }
                    return $query->title;
            })


            ->addColumn('action', function ($query) {
                $delete = \Form::deleteajax('/admin/order-status/'. $query->id, 'Delete', '', array('class'=>'btn btn-default btn-sm btn-danger'));
                $link = '<a href="/admin/order-status/'.$query->id.'/edit" class="btn btn-default btn-sm btn-success"><i class="entypo-pencil"></i>Edit</a>  '.$delete;
            
                return $link;
            });

            return $datatables->make(true);


        } else {
            return view('admin.order-status.index')->with('content', $this->orderStatus->selectAll());
        }
    }

    public function create()
    {
        return view('admin.order-status.create')->with(array('templates' => $this->orderStatusEmailTemplate->selectAllByShopId(Auth::guard('admin')->user()->selected_shop_id)->lists('title', 'id')));
    }

    public function store()
    {
        $result  = $this->orderStatus->create($this->request->all());

        if (isset($result->id)) {
            Notification::success('The order status was inserted.');
            return redirect()->route('admin.order-status.index');
        }
            
        foreach ($result->errors()->all() as $error) {
            Notification::error($error);
        }
        return redirect()->back()->withInput();
    }

    public function edit($orderStatusId)
    {
        $orderStatus = $this->orderStatus->find($orderStatusId);

        $populatedData = array();
           
        return view('admin.order-status.edit')->with(
            array(
            'orderStatus' => $orderStatus,
            'populatedData' => $populatedData,
            'templates' => $this->orderStatusEmailTemplate->selectAllByShopId(Auth::guard('admin')->user()->selected_shop_id)->lists('title', 'id')
            )
        );
    }

    public function editSeo($id)
    {
        return view('admin.order-status.edit_seo')->with(array('content' => $this->orderStatus->find($id)));
    }

    public function update($orderStatusId)
    {
        $result  = $this->orderStatus->updateById($this->request->all(), $orderStatusId);

        if (isset($result->id)) {
            Notification::success('order status was updated.');
            return redirect()->route('admin.order-status.index');
        }

        foreach ($result->errors()->all() as $error) {
            Notification::error($error);
        }
        return redirect()->back()->withInput()->withErrors($result->errors()->all());
    }


    public function destroy($id)
    {
        $result  = $this->orderStatus->destroy($id);

        if ($result) {
            Notification::success('The order status was deleted.');
            return redirect()->route('admin.order-status.index');
        }
    }
}

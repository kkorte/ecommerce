<?php namespace App\Http\Controllers\Admin;

/**
 * PaymentMethodController
 *
 * This is the controller for the shop payment methods
 * @author Matthijs Neijenhuijs <matthijs@dutchbridge.nl>
 * @version 1.0
 */
use App\Http\Controllers\Controller;
use Hideyo\Backend\Repositories\PaymentMethodRepositoryInterface;
use Hideyo\Backend\Repositories\TaxRateRepositoryInterface;
use Hideyo\Backend\Repositories\OrderStatusRepositoryInterface;


use Illuminate\Http\Request;
use Notification;

class PaymentMethodController extends Controller
{
    public function __construct(
        Request $request, 
        PaymentMethodRepositoryInterface $paymentMethod,
        TaxRateRepositoryInterface $taxRate,
        OrderStatusRepositoryInterface $orderStatus
    ) {
        $this->request = $request;
        $this->taxRate = $taxRate;
        $this->paymentMethod = $paymentMethod;
        $this->orderStatus = $orderStatus;
    }

    public function index()
    {
        if ($this->request->wantsJson()) {

            $query = $this->paymentMethod->getModel()->select(
                [\DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'id', 'title', 'order_confirmed_order_status_id', 'payment_completed_order_status_id', 'payment_failed_order_status_id']
            )->where('shop_id', '=', \Auth::guard('admin')->user()->selected_shop_id)->with(array('orderConfirmedOrderStatus', 'orderPaymentCompletedOrderStatus', 'orderPaymentFailedOrderStatus'));
            
            $datatables = \Datatables::of($query)

            ->addColumn('orderconfirmed', function ($query) {
                if ($query->orderConfirmedOrderStatus) {
                    return $query->orderConfirmedOrderStatus->title;
                }
            })
            ->addColumn('paymentcompleted', function ($query) {
                if ($query->orderPaymentCompletedOrderStatus) {
                    return $query->orderPaymentCompletedOrderStatus->title;
                }
            })
            ->addColumn('paymentfailed', function ($query) {
                if ($query->orderPaymentFailedOrderStatus) {
                    return $query->orderPaymentFailedOrderStatus->title;
                }
            })
            ->addColumn('action', function ($query) {
                $delete = \Form::deleteajax('/admin/payment-method/'. $query->id, 'Delete', '', array('class'=>'btn btn-default btn-sm btn-danger'));
                $link = '<a href="/admin/payment-method/'.$query->id.'/edit" class="btn btn-default btn-sm btn-success"><i class="entypo-pencil"></i>Edit</a>  '.$delete;
            
                return $link;
            });

            return $datatables->make(true);
        } else {
            return view('admin.payment_method.index')->with('paymentMethod', $this->paymentMethod->selectAll());
        }
    }

    public function create()
    {
        return view('admin.payment_method.create')->with(
            array(
                'taxRates' => $this->taxRate->selectAll()->lists('title', 'id'),
                'orderStatuses' => $this->orderStatus->selectAll()->lists('title', 'id')                
            )
        );
    }

    public function store()
    {
        $result  = $this->paymentMethod->create($this->request->all());

        if (isset($result->id)) {
            \Notification::success('The payment method was inserted.');
            return redirect()->route('admin.payment-method.index');
        }
        
        foreach ($result->errors()->all() as $error) {
            \Notification::error($error);
        }
        
        return redirect()->back()->withInput();
    }

    public function edit($id)
    {
        return view('admin.payment_method.edit')->with(
            array(
                'paymentMethod' => $this->paymentMethod->find($id),
                'taxRates' => $this->taxRate->selectAll()->lists('title', 'id'),
                'orderStatuses' => $this->orderStatus->selectAll()->lists('title', 'id')
            )
        );
    }

    public function update($id)
    {
        $result  = $this->paymentMethod->updateById($this->request->all(), $id);

        if (isset($result->id)) {
            \Notification::success('The payment method was updated.');
            return redirect()->route('admin.payment-method.index');
        } else {
            foreach ($result->errors()->all() as $error) {
                \Notification::error($error);
            }
        }

        return redirect()->back()->withInput();
    }

    public function destroy($id)
    {
        $result  = $this->paymentMethod->destroy($id);

        if ($result) {
            Notification::success('The payment method was deleted.');
            return Redirect::route('admin.payment-method.index');
        }
    }
}

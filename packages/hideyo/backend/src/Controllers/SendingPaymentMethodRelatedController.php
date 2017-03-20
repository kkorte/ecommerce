<?php namespace Hideyo\Backend\Controllers;

/**
 * CouponController
 *
 * This is the controller of the sending methods of the shop
 * @author Matthijs Neijenhuijs <matthijs@dutchbridge.nl>
 * @version 1.0
 */
use App\Http\Controllers\Controller;
use Hideyo\Backend\Repositories\SendingPaymentMethodRelatedRepositoryInterface;
use Hideyo\Backend\Repositories\TaxRateRepositoryInterface;
use Hideyo\Backend\Repositories\PaymentMethodRepositoryInterface;
use DB;
use Request;

class SendingPaymentMethodRelatedController extends Controller
{
    public function __construct(SendingPaymentMethodRelatedRepositoryInterface $sendingPaymentMethodRelated)
    {
        $this->sendingPaymentMethodRelated = $sendingPaymentMethodRelated;
    }

    public function index()
    {
        if (Request::wantsJson()) {

            $query = DB::table('sending_payment_method_related')->join('sending_method', 'sending_payment_method_related.sending_method_id', '=', 'sending_method.id')->join('payment_method', 'sending_payment_method_related.payment_method_id', '=', 'payment_method.id')
                ->select(['payment_method.title as payment_method_title', 'sending_method.title as sending_method_title', 'sending_payment_method_related.id', 'sending_payment_method_related.pdf_text', 'sending_payment_method_related.payment_text', 'sending_payment_method_related.payment_confirmed_text', 'sending_payment_method_related.sending_method_id', 'sending_payment_method_related.payment_method_id'])
               ->where('sending_method.shop_id', '=', \Auth::guard('admin')->user()->selected_shop_id);


            $datatables = \Datatables::of($query)


            ->addColumn('payment_method', function ($query) {
                  return $query->payment_method_title;
            })
            ->addColumn('sending_method', function ($query) {
                  return $query->sending_method_title;
            })

            ->addColumn('pdf_text', function ($query) {
                
                $result = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';

                if ($query->pdf_text) {
                    $result = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                }

                return $result;
            })
            ->addColumn('payment_text', function ($query) {
                
                $result = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';

                if ($query->payment_text) {
                    $result = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                }

                return $result;
            })
            ->addColumn('payment_confirmed_text', function ($query) {
                
                $result = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';

                if ($query->payment_confirmed_text) {
                    $result = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                }

                return $result;
            })
            



            ->addColumn('action', function ($query) {
                $link = '<a href="/admin/sending-payment-method-related/'.$query->id.'/edit" class="btn btn-default btn-sm btn-success"><i class="entypo-pencil"></i>Edit</a>';
            
                return $link;
            });

            return $datatables->make(true);


        } else {
            return view('admin.sending_payment_method_related.index')->with('sendingMethod', $this->sendingPaymentMethodRelated->selectAll());
        }
    }

    public function edit($id)
    {
        return view('admin.sending_payment_method_related.edit')->with(array(
            'sendingPaymentMethodRelated' => $this->sendingPaymentMethodRelated->find($id)
            ));
    }

    public function update($id)
    {
        $result  = $this->sendingPaymentMethodRelated->updateById(Request::all(), $id);

        if (isset($result->id)) {
            \Notification::success('The order template was updated.');
            return \Redirect::route('admin.sending-payment-method-related.index');
        }
        
        \Notification::error($result->errors()->all());
        return \Redirect::back()->withInput();
    }
}

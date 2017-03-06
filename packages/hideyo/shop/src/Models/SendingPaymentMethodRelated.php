<?php 

namespace Hideyo\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class SendingPaymentMethodRelated extends Model
{

    public static $rules = array(

    );

    protected $table = 'sending_payment_method_related';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['email_order_subject', 'email_order_body', 'pdf_text', 'payment_text', 'payment_confirmed_text'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    public function sendingMethod()
    {
        return $this->belongsTo('Hideyo\Shop\Models\SendingMethod');
    }

    public function paymentMethod()
    {
        return $this->belongsTo('Hideyo\Shop\Models\PaymentMethod');
    }
}

<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPaymentMethod extends Model
{

    public static $rules = array(
        'order_id' => 'required',
        'title' => 'required'
    );

    protected $table = 'order_payment_method';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['order_id', 'payment_method_id', 'title', 'price_with_tax', 'price_without_tax', 'tax_rate', 'tax_rate_id', 'percent_of_total', 'payment_external'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function paymentMethod()
    {
        return $this->belongsTo('App\PaymentMethod');
    }

    public function getPriceWithTaxNumberFormat()
    {
        return number_format($this->price_with_tax, 2);
    }

    public function getPriceWithoutTaxNumberFormat()
    {
        return number_format($this->price_without_tax, 2);
    }
}

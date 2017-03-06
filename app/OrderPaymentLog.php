<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPaymentLog extends Model
{
    protected $table = 'order_payment_log';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['order_id', 'type', 'log'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}

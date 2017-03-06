<?php 

namespace Hideyo\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class OrderSendingMethod extends Model
{

    public static $rules = array(
        'order_id' => 'required',
        'title' => 'required'
    );

    protected $table = 'order_sending_method';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['order_id', 'sending_method_id', 'title', 'price_with_tax', 'price_without_tax', 'tax_rate', 'weight', 'tax_rate_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    public function order()
    {
        return $this->belongsTo('Hideyo\Shop\Models\Order');
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

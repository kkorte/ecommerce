<?php 

namespace Hideyo\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class ProductWaitingList extends Model
{
    protected $table = 'product_waiting_list';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['product_id', 'product_attribute_id', 'email'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }
    
    public function product()
    {
        return $this->belongsTo('Hideyo\Shop\Models\Product');
    }

    public function productAttribute()
    {
        return $this->belongsTo('Hideyo\Shop\Models\ProductAttribute');
    }
}

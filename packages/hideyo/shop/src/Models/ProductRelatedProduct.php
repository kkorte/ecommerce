<?php 

namespace Hideyo\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRelatedProduct extends Model
{

    public static $rules = array(
        'product_id' => 'required',
        'related_product_id' => 'required',
    );

    protected $table = 'product_related_product';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['product_id', 'related_product_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    public function product()
    {
        return $this->belongsTo('Hideyo\Shop\Models\Product', 'product_id');
    }

    public function relatedProduct()
    {
        return $this->belongsTo('Hideyo\Shop\Models\Product', 'related_product_id');
    }
}

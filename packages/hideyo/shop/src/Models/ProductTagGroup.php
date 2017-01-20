<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTagGroup extends Model
{

    public static $rules = array(
        'product_id' => 'required',
        'related_product_id' => 'required',
    );

    protected $table = 'product_tag_group';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['tag', 'active', 'shop_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }
    
    public function relatedProducts()
    {
        return $this->belongsToMany('App\Product', 'product_tag_group_related_product');
    }
}

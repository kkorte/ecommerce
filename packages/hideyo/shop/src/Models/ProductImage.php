<?php 

namespace Hideyo\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{

    public static $rules = array(
        'product_id'    => 'required',
        'file'          => 'required',
        'extension'     => 'required',
        'size'          => 'required',
    );
    protected $table = 'product_image';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['product_id', 'product_variation_id', 'file', 'extension', 'size', 'path', 'rank', 'tag', 'shop_id', 'modified_by_user_id',];

    public function __construct(array $attributes = array())
    {

        parent::__construct($attributes);
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function relatedProductAttributes()
    {
        return $this->belongsToMany('App\ProductAttribute', 'product_attribute_image', 'product_image_id', 'product_attribute_id');
    }

    public function relatedAttributes()
    {
        return $this->belongsToMany('App\Attribute', 'product_image_attribute', 'product_image_id', 'attribute_id');
    }
}

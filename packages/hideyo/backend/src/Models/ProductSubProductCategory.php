<?php 

namespace Hideyo\Shop\Models;

use LaravelBook\Ardent\Ardent;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProductSubProductCategory extends Model
{

    protected $table = 'product_sub_product_category';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['category_id', 'product_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    public function shop()
    {
        return $this->belongsTo('Hideyo\Shop\Models\Shop');
    }

    public function product()
    {
        return $this->belongsTo('Hideyo\Shop\Models\Product');
    }

    public function productCategory()
    {
        return $this->belongsTo('Hideyo\Shop\Models\ProductCategory');
    }
}

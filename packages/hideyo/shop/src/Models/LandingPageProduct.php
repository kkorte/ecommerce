<?php 

namespace Hideyo\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPageProduct extends Model
{

    public static $rules = array(
        'product_id' => 'required',
        'landing_page_id' => 'required',
    );

    protected $table = 'landing_page_product';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['product_id', 'landing_page_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }


    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
}

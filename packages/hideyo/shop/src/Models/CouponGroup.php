<?php 

namespace Hideyo\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class CouponGroup extends Model
{
    
    protected $table = 'coupon_group';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['id', 'title', 'shop_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }


    public function coupon()
    {
        return $this->hasMany('App\Coupon');
    }
}

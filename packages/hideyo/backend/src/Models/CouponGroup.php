<?php 

namespace Hideyo\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class CouponGroup extends Model
{
    
    protected $table = 'coupon_group';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['id', 'title', 'shop_id'];

    public function __construct(array $attributes = array())
    {
        $this->table = config()->get('hideyo.db_prefix').$this->table;
        parent::__construct($attributes);
    }

    public function coupon()
    {
        return $this->hasMany('Hideyo\Backend\Models\Coupon');
    }
}

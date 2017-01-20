<?php 

namespace Hideyo\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{

    public static $rules = array(
        'firstname' => 'required',
        'lastname' => 'required',
    );

    protected $table = 'order_address';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['company', 'phone', 'gender', 'initials', 'firstname', 'lastname', 'street', 'housenumber', 'housenumber_suffix', 'zipcode', 'city', 'country', 'order_id', 'modified_by_user_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}

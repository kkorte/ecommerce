<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{


    protected $table = 'box';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['active', 'multivers', 'vegetarian', 'pickup', 'paid', 'processed', 'newsletter', 'shop_id', 'email', 'company', 'name', 'street', 'city', 'zipcode', 'housenumber', 'housenumber_suffix', 'account_name', 'account_number', 'phone', 'modified_by_user_id', 'browser_detect'];


    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }
}

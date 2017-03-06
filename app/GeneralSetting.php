<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{


    protected $table = 'general_setting';


    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['id', 'name', 'value', 'text_value', 'shop_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }
}

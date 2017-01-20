<?php 

namespace Hideyo\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model  {

    public static $rules = array(
        'language' => 'required',
    );

    protected $table = 'language';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['language', 'shop_id', 'modified_by_user_id'];


    public function __construct(array $attributes = array()) {
        parent::__construct($attributes);
    }
}
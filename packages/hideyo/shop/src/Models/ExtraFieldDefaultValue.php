<?php 

namespace Hideyo\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class ExtraFieldDefaultValue extends Model
{

    protected $table = 'extra_field_default_value';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['value', 'extra_field_id', 'modified_by_user_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }
}

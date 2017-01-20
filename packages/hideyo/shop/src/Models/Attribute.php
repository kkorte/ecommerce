<?php 

namespace Hideyo\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{

    protected $table = 'attribute';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['value', 'attribute_group_id', 'modified_by_user_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    public function attributeGroup()
    {
        return $this->belongsTo('App\AttributeGroup');
    }
}

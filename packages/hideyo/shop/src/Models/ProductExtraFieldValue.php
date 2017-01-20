<?php 

namespace Hideyo\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class ProductExtraFieldValue extends Model
{

    public static $rules = array(
        'value' => 'required',
    );

    protected $table = 'product_extra_field_value';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['value', 'product_id', 'extra_field_id', 'extra_field_default_value_id', 'shop_id', 'modified_by_user_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            foreach ($model->toArray() as $key => $value) {
                    $model->{$key} = (empty($value) and $value != 0) ? null : $value;
            }

            return true;
        });
    }

    public function extraField()
    {
        return $this->belongsTo('App\ExtraField');
    }
    public function extraFieldDefaultValue()
    {
        return $this->belongsTo('App\ExtraFieldDefaultValue');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}

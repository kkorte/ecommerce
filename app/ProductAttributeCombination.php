<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeCombination extends Model
{

    public static $rules = array(
        'product_id' => 'required',
    );

    protected $table = 'product_attribute_combination';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['product_attribute_id', 'attribute_id',  'modified_by_user_id'];

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

    public function attribute()
    {
        return $this->belongsTo('App\Attribute');
    }

    public function productAttribute()
    {
        return $this->belongsTo('App\ProductAttribute');
    }
}

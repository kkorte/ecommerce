<?php 

namespace Hideyo\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class ExtraFieldRelatedProductCategory extends Model
{

    public static $rules = array(
        'extra_field_id' => 'required',
        'product_category_id' => 'required',
    );

    protected $table = 'extra_field_related_product_category';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['extra_field_id', 'product_category_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    public static function boot()
    {
        static::saving(function ($model) {
            foreach ($model->toArray() as $key => $value) {
                    $model->{$key} = empty($value) ? null : $value;
            }

            return true;
        });
    }

    public function extraField()
    {
        return $this->belongsTo('Hideyo\Backend\Models\ExtraField', 'extra_field_id');
    }

    public function relatedProductCategory()
    {
        return $this->belongsTo('Hideyo\Backend\Models\ProductCategory', 'product_category_id');
    }
}

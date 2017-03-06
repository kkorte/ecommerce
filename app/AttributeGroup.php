<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeGroup extends Model
{

    public static $rules = array(
        'title' => 'required',
    );

    protected $table = 'attribute_group';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['type', 'default_value', 'title', 'filter', 'shop_id', 'modified_by_user_id'];

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

    public function categories()
    {
        return $this->belongsToMany('ProductCategory', 'product_category_related_extra_field');
    }

    public function attributes()
    {
        return $this->hasMany('App\Attribute');
    }
}

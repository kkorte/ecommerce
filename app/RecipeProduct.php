<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class RecipeProduct extends Model
{

    public static $rules = array(
        'product_id' => 'required',
        'recipe_id' => 'required',
    );

    protected $table = 'recipe_product';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['product_id', 'recipe_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
}

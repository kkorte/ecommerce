<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Recipe extends Model implements SluggableInterface
{

    use SluggableTrait;

    protected $table = 'recipe';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['id', 'title', 'meta_title', 'meta_description', 'meta_keywords', 'shop_id'];

    protected $sluggable = array(
        'build_from'        => 'title',
        'save_to'           => 'slug',
        'on_update'         => true,
    );

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    public function recipeImages()
    {
        return $this->hasMany('App\RecipeImage');
    }

    public function recipeCourseMenu()
    {
        return $this->belongsTo('App\RecipeCourseMenu');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product', 'recipe_product', 'recipe_id', 'product_id');
    }


    public function relatedProductsActive()
    {
        return $this->belongsToMany('App\Product', 'recipe_product', 'recipe_id', 'product_id')->where('product.active', '=', '1');
    }
}

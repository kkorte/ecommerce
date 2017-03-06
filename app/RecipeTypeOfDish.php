<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class RecipeTypeOfDish extends Model implements SluggableInterface
{

    use SluggableTrait;

    protected $table = 'recipe_type_of_dish';

    protected $sluggable = array(
        'build_from'        => 'title',
        'save_to'           => 'slug',
        'on_update'         => true,
    );

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['id', 'title', 'shop_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }
}

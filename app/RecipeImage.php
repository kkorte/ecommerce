<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class RecipeImage extends Model
{

    protected $table = 'recipe_image';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['recipe_id', 'file', 'extension', 'size', 'path', 'rank', 'tag', 'modified_by_user_id',];

    public function __construct(array $attributes = array())
    {

        parent::__construct($attributes);
    }

    public function recipe()
    {
        return $this->belongsTo('App\Recipe');
    }
}

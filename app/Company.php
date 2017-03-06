<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Company extends Model implements SluggableInterface
{

    use SluggableTrait;

    public static $rules = array(
        'title' => 'required',
    );

    protected $table = 'company';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['active', 'title', 'slug', 'description'];


    protected $sluggable = array(
        'build_from'        => 'title',
        'save_to'           => 'slug',
        'on_update'         => true,
    );

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    public function beforeValidate()
    {
        $this->sluggify();
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            foreach ($model->toArray() as $key => $value) {
                    $model->{$key} = empty($value) ? null : $value;
            }

            return true;
        });
    }

    public function shops()
    {
        return $this->hasMany('App\Shop');
    }
}

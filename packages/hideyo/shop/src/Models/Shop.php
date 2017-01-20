<?php 

namespace Hideyo\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use \Auth;

class Shop extends Model implements SluggableInterface
{

    use SluggableTrait;

    public static $rules = array(
        'title' => 'required'
    );

    protected $table = 'shop';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['active', 'email', 'wholesale', 'currency_code', 'title', 'url', 'description', 'square_thumbnail_sizes', 'widescreen_thumbnail_sizes', 'meta_title', 'meta_description', 'meta_keywords', 'logo_file_name', 'logo_file_path'];

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



    public function shops()
    {
        return $this->hasMany('App\Shop');
    }
    
    public function categories()
    {
        return $this->hasMany('App\ProductCategory');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function setSquareThumbnailSizesAttribute($value = null)
    {
        $values  = explode(',', $value);

        $newValues = serialize($values);

        $this->attributes['square_thumbnail_sizes'] = $newValues;
    }

    public function getSquareThumbnailSizesAttribute($value = null)
    {
        if ($value) {
            $values = unserialize($value);

            $newValues  = implode(',', $values);

            return $newValues;
        }
    }

    public function setWidescreenThumbnailSizesAttribute($value = null)
    {
        $values  = explode(',', $value);

        $newValues = serialize($values);

        $this->attributes['widescreen_thumbnail_sizes'] = $newValues;
    }

    public function getWidescreenThumbnailSizesAttribute($value = null)
    {
        if ($value) {
            $values = unserialize($value);

            $newValues  = implode(',', $values);

            return $newValues;
        }
    }
}

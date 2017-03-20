<?php 

namespace Hideyo\Backend\Models;

use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Brand extends Model implements SluggableInterface
{

    use SluggableTrait;

    protected $table = 'brand';

    protected $scoped = array('shop_id');

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['active',  'title', 'short_description', 'description', 'rank', 'meta_title', 'meta_description', 'meta_keywords', 'shop_id', 'modified_by_user_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    protected $sluggable = array(
        'build_from'        => 'title',
        'save_to'           => 'slug',
        'on_update'         => true,
    );


    public function beforeValidate()
    {
        $this->sluggify();
    }


    public function products()
    {
        return $this->hasMany('Hideyo\Shop\Models\Product');
    }


    public function brandImages()
    {
        return $this->hasMany('Hideyo\Shop\Models\BrandImage');
    }

    public function shop()
    {
        return $this->belongsTo('Hideyo\Shop\Models\Shop');
    }
}

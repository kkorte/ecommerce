<?php 

namespace Hideyo\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class LandingPage extends Model implements SluggableInterface
{

    use SluggableTrait;

    protected $table = 'landing_page';

    protected $sluggable = array(
        'build_from'        => 'title',
        'save_to'           => 'slug',
        'on_update'         => true,
    );

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['id', 'active', 'title', 'short_description', 'description', 'meta_title', 'meta_description', 'meta_keywords', 'shop_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    public function products()
    {
        return $this->belongsToMany('App\Product', 'landing_page_product', 'landing_page_id', 'product_id');
    }

    public function productsActive()
    {
        return $this->belongsToMany('App\Product', 'landing_page_product', 'landing_page_id', 'product_id')->where('product.active', '=', '1');
    }
}

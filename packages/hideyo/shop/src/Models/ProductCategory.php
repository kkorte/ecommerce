<?php 

namespace Hideyo\Shop\Models;

use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

use Baum\Node;

class ProductCategory extends Node implements SluggableInterface
{

    use SluggableTrait;

    public static $rules = array(
        'title' => 'required|between:4,65|unique_with:product_category, shop_id',
    );

    protected $table = 'product_category';


    protected $scoped = array('shop_id');

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['active', 'parent_id', 'title', 'product_category_highlight_title', 'product_overview_title', 'product_overview_description', 'short_description', 'description', 'meta_title', 'meta_description', 'meta_keywords', 'slug', 'shop_id', 'redirect_product_category_id', 'modified_by_user_id'];

    protected $sluggable = array(
        'build_from'        => 'title',
        'save_to'           => 'slug',
        'on_update'         => true,
    );


    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    public function shop()
    {
        return $this->belongsTo('App\Shop');
    }

    protected function getExistingSlugs($slug)
    {
        $config = $this->getSluggableConfig();
        $save_to = $config['save_to'];
        $include_trashed = $config['include_trashed'];

        $instance = new static;

        $query = $instance->where($save_to, 'LIKE', $slug . '%');

        // @overriden - changed this to scope unique slugs per user
        $query = $query->where('shop_id', $this->shop_id);

        // include trashed models if required
        if ($include_trashed && $this->usesSoftDeleting()) {
            $query = $query->withTrashed();
        }

        // get a list of all matching slugs
        $list = $query->lists($save_to, $this->getKeyName())->toArray();

        // Laravel 5.0/5.1 check
        return $list instanceof Collection ? $list->all() : $list;
    }

    public function beforeValidate()
    {
        $this->sluggify();
    }

    public static function boot()
    {
        parent::boot();

        static::moving(function ($node) {
          // YOUR CODE HERE
        });

        static::moved(function ($node) {
          // YOUR CODE HERE
        });
    }

    public function refProductCategory()
    {
        return $this->belongsTo('App\ProductCategory', 'redirect_product_category_id');
    }

    public function productCategoryImages()
    {
        return $this->hasMany('App\ProductCategoryImage');
    }

    public function productCategoryHighlightProduct()
    {
        return $this->belongsToMany('App\Product', 'product_category_highlight_product', 'product_category_id', 'product_id');
    }

    public function productCategoryHighlightProductActive()
    {
        return $this->belongsToMany('App\Product', 'product_category_highlight_product', 'product_category_id', 'product_id')->where('active', '=', 1);
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }
}

<?php 

namespace Hideyo\Backend\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class NewsGroup extends Model implements SluggableInterface
{

    use SluggableTrait;

    protected $table = 'news_group';

    protected $sluggable = array(
        'build_from'        => 'title',
        'save_to'           => 'slug',
        'on_update'         => true,
    );

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['id', 'active', 'title', 'meta_title', 'meta_description', 'meta_keywords', 'shop_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    public function news()
    {
        return $this->hasMany('Hideyo\Backend\Models\News');
    }
}

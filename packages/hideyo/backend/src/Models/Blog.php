<?php 

namespace Hideyo\Backend\Models;

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Blog extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
    ];

    protected $table = 'blog';

    protected $fillable = array('active', 'title', 'intro', 'content', 'content_two', 'content_three', 'content_four', 'content_five', 'slug', 'meta_title', 'meta_description', 'modified_by_user_id');

    public function __construct(array $attributes = array())
    {
        $this->table = config()->get('hideyo.db_prefix').$this->table;
        
        parent::__construct($attributes);
    }

    public function blogImages()
    {
        return $this->hasMany('Hideyo\Shop\Models\BlogImage');
    }
}

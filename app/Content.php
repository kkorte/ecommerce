<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Content extends Model implements SluggableInterface
{

    use SluggableTrait;

    protected $table = 'content';

    protected $sluggable = array(
        'build_from'        => 'title',
        'save_to'           => 'slug',
        'on_update'         => true,
    );

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['id', 'active', 'content_group_id', 'title', 'content', 'meta_title', 'meta_description', 'meta_keywords', 'shop_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
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


    public function contentGroup()
    {
        return $this->belongsTo('App\ContentGroup');
    }

    public function contentImages()
    {
        return $this->hasMany('App\ContentImage');
    }


    public function setContentGroupIdAttribute($value)
    {
        if ($value) {
            $this->attributes['content_group_id'] = $value;
        } else {
            $this->attributes['content_group_id'] = null;
        }
    }
}

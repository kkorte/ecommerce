<?php 

namespace Hideyo\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Carbon\Carbon;

class News extends Model implements SluggableInterface
{

    use SluggableTrait;

    protected $table = 'news';

    protected $sluggable = array(
        'build_from'        => 'title',
        'save_to'           => 'slug',
        'on_update'         => true,
    );

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['id', 'news_group_id', 'title', 'short_description', 'content', 'published_at', 'meta_title', 'meta_description', 'meta_keywords', 'shop_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }
    
    public function setPublishedAtAttribute($value)
    {
        if ($value) {
            $date = explode('/', $value);
            if (isset($date[2])) {
                $value = Carbon::createFromDate($date[2], $date[1], $date[0])->toDateTimeString();
                $this->attributes['published_at'] = $value;
            } else {
                $this->attributes['published_at'] = $value;
            }
        } else {
            $this->attributes['published_at'] = null;
        }
    }

    public function getPublishedAtAttribute($value)
    {
        if ($value) {
            $date = explode('-', $value);
            return $date[2].'/'.$date[1].'/'.$date[0];
        } else {
            return null;
        }
    }

    public function newsImages()
    {
        return $this->hasMany('App\NewsImage');
    }

    public function newsGroup()
    {
        return $this->belongsTo('App\NewsGroup');
    }

    public function setNewsGroupIdAttribute($value)
    {
        if ($value) {
            $this->attributes['news_group_id'] = $value;
        } else {
            $this->attributes['news_group_id'] = null;
        }
    }
}

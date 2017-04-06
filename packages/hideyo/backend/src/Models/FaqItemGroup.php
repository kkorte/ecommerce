<?php 

namespace Hideyo\Backend\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class FaqItemGroup extends Model implements SluggableInterface
{

    use SluggableTrait;

    protected $table = 'faq_item_group';

    protected $sluggable = array(
        'build_from'        => 'title',
        'save_to'           => 'slug',
        'on_update'         => true,
    );

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['id', 'title', 'meta_title', 'meta_description', 'meta_keywords', 'shop_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    public function faqItems()
    {
        return $this->hasMany('Hideyo\Backend\Models\FaqItem');
    }
}

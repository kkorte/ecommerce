<?php 

namespace Hideyo\Backend\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class FaqItem extends Model implements SluggableInterface
{

    use SluggableTrait;

    protected $table = 'faq_item';

    protected $sluggable = array(
        'build_from'        => 'question',
        'save_to'           => 'slug',
        'on_update'         => true,
    );

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['id', 'faq_item_group_id', 'question', 'answer', 'slug', 'shop_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    public function faqItemGroup()
    {
        return $this->belongsTo('Hideyo\Shop\Models\faqItemGroup');
    }
}

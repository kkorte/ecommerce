<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class HtmlBlock extends Model implements SluggableInterface
{

    use SluggableTrait;

    protected $table = 'html_block';

    protected $sluggable = array(
        'build_from'        => 'title',
        'save_to'           => 'slug',
        'on_update'         => true,
    );

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['id', 'active', 'title', 'short_title', 'button_title', 'position', 'url', 'content', 'template', 'thumbnail_height', 'thumbnail_width', 'image_file_name', 'image_file_path', 'image_file_extension', 'image_file_size', 'shop_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }
}

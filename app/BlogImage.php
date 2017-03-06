<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogImage extends Model
{

    /**
     * Model: BlogImage
     * Note: please keep models thin. Put logic not in models,
     * Information about models in Laravel: http://laravel.com/docs/5.1/eloquent
     * @author     Matthijs Neijenhuijs <matthijs@dutchbridge.nl>
     * @copyright  DutchBridge - dont share/steel!
     */

    protected $table = 'blog_image';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['blog_id', 'file', 'extension', 'size', 'path', 'rank', 'tag', 'modified_by_user_id',];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    public function blog()
    {
        return $this->belongsTo('Blog');
    }
}

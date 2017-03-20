<?php 

namespace Hideyo\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class NewsImage extends Model
{

    public static $rules = array(
        'news_id'    => 'required',
        'file'          => 'required',
        'extension'     => 'required',
        'size'          => 'required',
    );
    protected $table = 'news_image';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['news_id', 'file', 'extension', 'size', 'path', 'rank', 'tag', 'modified_by_user_id',];

    public function __construct(array $attributes = array())
    {

        parent::__construct($attributes);
    }

    public function news()
    {
        return $this->belongsTo('Hideyo\Shop\Models\News');
    }
}

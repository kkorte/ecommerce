<?php 

namespace Hideyo\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class ContentImage extends Model
{

    public static $rules = array(
        'file'      => 'required|',
        'extension' => 'required',
        'size'      => 'required',
    );
    protected $table = 'content_image';

    protected $guarded =  array('file');

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['content_id', 'file', 'extension', 'size', 'path', 'rank', 'tag', 'modified_by_user_id',];

    public function __construct(array $attributes = array())
    {

        parent::__construct($attributes);
    }


    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            foreach ($model->toArray() as $key => $value) {
                    $model->{$key} = empty($value) ? null : $value;
            }

            return true;
        });
    }
}

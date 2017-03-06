<?php

use LaravelBook\Ardent\Ardent;

class UserLog extends Ardent
{

    public static $rules = array(
        'message' => 'required',
    );

    protected $table = 'user_log';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['message', 'type'];


    public function __construct(array $attributes = array())
    {
        $this->setModifiedByUserIdAttribute();
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

    public function setModifiedByUserIdAttribute()
    {
        if (isset(Auth::user()->id)) {
            $this->attributes['modified_by_user_id'] = Auth::user()->id;
        }
    }
}

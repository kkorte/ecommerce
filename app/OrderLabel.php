<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderLabel extends Model
{
    protected $table = 'order_label';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['id', 'order_id', 'data'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }


    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}

<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatusEmailTemplate extends Model
{

    protected $table = 'order_status_email_template';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['title', 'subject', 'content', 'shop_id', 'modified_by_user_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }
}

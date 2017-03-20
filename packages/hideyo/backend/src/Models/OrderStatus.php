<?php 

namespace Hideyo\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{

    protected $table = 'order_status';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['title', 'count_as_revenue', 'color', 'order_is_validated', 'order_is_paid', 'order_is_delivered', 'send_email_to_customer', 'attach_invoice_to_email', 'attach_order_to_email', 'order_status_email_template_id', 'send_email_copy_to', 'shop_id', 'modified_by_user_id'];


    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }


    public function orderStatusEmailTemplate()
    {
        return $this->belongsTo('Hideyo\Shop\Models\OrderStatusEmailTemplate');
    }
}

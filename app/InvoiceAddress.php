<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceAddress extends Model
{

    public static $rules = array(
        'firstname' => 'required',
        'lastname' => 'required',
    );

    protected $table = 'invoice_address';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['company', 'gender', 'initials', 'firstname', 'lastname', 'street', 'housenumber', 'housenumber_suffix', 'zipcode', 'city', 'country', 'invoice_id', 'modified_by_user_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    public function invoice()
    {
        return $this->belongsTo('Invoice');
    }
}

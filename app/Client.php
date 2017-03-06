<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{

    public static $rules = array(
        'email' => 'required',
    );

    protected $table = 'client';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['company', 'comments', 'vat_number', 'debtor_number', 'iban_number', 'chamber_of_commerce_number', 'type', 'old_password', 'newsletter', 'active', 'confirmation_code', 'confirmed', 'password', 'email', 'bill_client_address_id', 'delivery_client_address_id', 'shop_id', 'modified_by_user_id', 'account_created', 'new_password', 'new_email', 'browser_detect', 'last_login'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getReminderEmail()
    {
        return $this->email;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function shop()
    {
        return $this->belongsTo('App\Shop');
    }

    public function clientAddress()
    {
        return $this->hasMany('App\ClientAddress');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }


    public function clientDeliveryAddress()
    {
        return $this->hasOne('App\ClientAddress', 'id', 'delivery_client_address_id');
    }

    public function clientBillAddress()
    {
        return $this->hasOne('App\ClientAddress', 'id', 'bill_client_address_id');
    }

    public function token()
    {
        return $this->hasMany('App\ClientToken');
    }
}

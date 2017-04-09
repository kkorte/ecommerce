<?php 

namespace Hideyo\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */    
    protected $table = 'redirect';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['active', 'url', 'shop_id', 'redirect_url', 'clicks'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }
}

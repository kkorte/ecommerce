<?php 

namespace Hideyo\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class Exception extends Model
{


    protected $table = 'exception';


    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['id', 'class'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }
}

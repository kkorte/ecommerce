<?php 

namespace Hideyo\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class TaxRate extends Model
{

    protected $table = 'tax_rate';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['title', 'rate', 'shop_id', 'modified_by_user_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }
}

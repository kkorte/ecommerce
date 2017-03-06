<?php 

namespace Hideyo\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProductAmountSeries extends Model
{

    public static $rules = array(
        'product_id' => 'required',
    );

    protected $table = 'product_amount_series';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['active', 'product_id',  'series_value', 'series_start', 'series_max', 'modified_by_user_id'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    } 

    public function product()
    {
        return $this->belongsTo('Hideyo\Shop\Models\Product');
    }

    public function range()
    {

        $range = range($this->series_start, $this->series_max, $this->series_value);
        return array_combine(array_keys(array_flip($range)), $range);
    }
}

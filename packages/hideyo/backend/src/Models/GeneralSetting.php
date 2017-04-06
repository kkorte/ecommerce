<?php 

namespace Hideyo\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $table = 'general_setting';

	protected $fillable = ['id', 'name', 'value', 'text_value', 'shop_id'];

    public function __construct(array $attributes = array())
    {
        $this->table = config()->get('hideyo.db_prefix').$this->table;
        parent::__construct($attributes);
    }
}

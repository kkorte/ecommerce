<?php 

namespace Hideyo\Models;

use Hideyo\Models\BaseModel;

class ProductTagGroup extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */    
    protected $table = 'product_tag_group';

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['tag', 'active', 'shop_id'];

    public function relatedProducts()
    {
        return $this->belongsToMany('Hideyo\Models\Product', config()->get('hideyo.db_prefix').'product_tag_group_related_product');
    }
}
<?php
namespace Hideyo\Backend\Repositories;
 
use Hideyo\Backend\Models\AttributeGroup;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
 
class AttributeGroupRepository implements AttributeGroupRepositoryInterface
{
    protected $model;

    public function __construct(AttributeGroup $model)
    {
        $this->model = $model;
    }
  
    public function rules($id = false)
    {
        $rules = array(
            'title' => 'required|between:1,65|unique_with:attribute_group, shop_id'
        );
        
        if ($id) {
            $rules['title'] =   'required|between:1,65|unique_with:attribute_group, shop_id, '.$id.' = id';
        }

        return $rules;
    }

    public function create(array $attributes)
    {
        $attributes['shop_id'] = \Auth::guard('hideyobackend')->user()->selected_shop_id;
        $validator = \Validator::make($attributes, $this->rules());

        if ($validator->fails()) {
            return $validator;
        } else {
            $attributes['modified_by_user_id'] = \Auth::guard('hideyobackend')->user()->id;
            $this->model->fill($attributes);
            $this->model->save();
            return $this->model;
        }
    }

    public function updateById(array $attributes, $id)
    {
        $attributes['shop_id'] = \Auth::guard('hideyobackend')->user()->selected_shop_id;
        $validator = \Validator::make($attributes, $this->rules($id));
        if ($validator->fails()) {
            return $validator;
        } else {
            $this->model = $this->find($id);
            $attributes['modified_by_user_id'] = \Auth::guard('hideyobackend')->user()->id;
            return $this->updateEntity($attributes);
        }
    }

    public function updateEntity(array $attributes = array())
    {
        if (count($attributes) > 0) {
            $this->model->fill($attributes);
            $this->model->save();
        }

        return $this->model;
    }

    public function destroy($id)
    {
        $this->model = $this->find($id);
        $this->model->save();

        return $this->model->delete();
    }

    public function selectAllByAllProductsAndProductCategoryId($productCategoryId)
    {
        return $this->model
        ->select('extra_field.*')
        ->leftJoin('product_category_related_extra_field', 'extra_field.id', '=', 'product_category_related_extra_field.extra_field_id')
        ->where('all_products', '=', 1)
        ->orWhere('product_category_related_extra_field.product_category_id', '=', $productCategoryId)
        ->get();
    }

    public function selectAll()
    {
        return $this->model->where('shop_id', '=', \Auth::guard('hideyobackend')->user()->selected_shop_id)->get();
    }
    
    public function find($id)
    {
        return $this->model->find($id);
    }

    public function getModel()
    {
        return $this->model;
    }
    
}

<?php
namespace Hideyo\Backend\Repositories;
 
use App\ExtraFieldDefaultValue;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
 
class ExtraFieldDefaultValueRepository implements ExtraFieldDefaultValueRepositoryInterface
{

    protected $model;

    public function __construct(ExtraFieldDefaultValue $model)
    {
        $this->model = $model;
    }
  
    public function rules($id = false)
    {
        if ($id) {
            return [
                'value' => 'required|unique_with:extra_field_default_value,extra_field_id,'.$id,
            ];
        } else {
            return [
                'value' => 'required|unique_with:extra_field_default_value,extra_field_id'
            ];
        }
    }

    public function create(array $attributes, $extraFieldId)
    {
        $attributes['extra_field_id'] = $extraFieldId;
        $validator = \Validator::make($attributes, $this->rules());

        if ($validator->fails()) {
            return $validator;
        } else {
            $attributes['modified_by_user_id'] = \Auth::guard('admin')->user()->id;
            $this->model->fill($attributes);
            $this->model->save();
            return $this->model;
        }
    }

    public function updateById(array $attributes, $extraFieldId, $id)
    {
        $attributes['extra_field_id'] = $extraFieldId;
        $validator = \Validator::make($attributes, $this->rules($id));

        if ($validator->fails()) {
            return $validator;
        } else {
            $this->model = $this->find($id);
            $attributes['modified_by_user_id'] = \Auth::guard('admin')->user()->id;
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
        return $this->model->select('extra_field.*')->leftJoin('product_category_related_extra_field', 'extra_field.id', '=', 'product_category_related_extra_field.extra_field_id')->where('all_products', '=', 1)->orWhere('product_category_related_extra_field.product_category_id', '=', $productCategoryId)->get();
    }

    public function selectAll()
    {
        return $this->model->get();
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

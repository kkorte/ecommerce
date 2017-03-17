<?php
namespace Hideyo\Repositories;

use App\ExtraField;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExtraFieldRepository implements ExtraFieldRepositoryInterface
{

    protected $model;

    public function __construct(ExtraField $model)
    {
        $this->model = $model;
    }

    public function rules($id = false)
    {
        $rules = array(
            'title' => 'required|between:4,65|unique_with:extra_field, shop_id'

            );
        
        if ($id) {
            $rules['title'] =   'required|between:4,65|unique_with:extra_field, shop_id, '.$id.' = id';
        }

        return $rules;
    }


    public function create(array $attributes)
    {
        $attributes['shop_id'] = \Auth::guard('admin')->user()->selected_shop_id;
        $validator = \Validator::make($attributes, $this->rules());

        if ($validator->fails()) {
            return $validator;
        }
        $attributes['modified_by_user_id'] = \Auth::guard('admin')->user()->id;
        $this->model->fill($attributes);
        $this->model->save();

        if (isset($attributes['categories'])) {
            $this->model->categories()->sync($attributes['categories']);
        }
        
        return $this->model;
    }

    public function updateById(array $attributes, $id)
    {
        $this->model = $this->find($id);
        $attributes['shop_id'] = \Auth::guard('admin')->user()->selected_shop_id;
        $validator = \Validator::make($attributes, $this->rules($id));

        if ($validator->fails()) {
            return $validator;
        }
        $attributes['modified_by_user_id'] = \Auth::guard('admin')->user()->id;
        return $this->updateEntity($attributes);
    }

    public function updateEntity(array $attributes = array())
    {
        if (count($attributes) > 0) {
            $this->model->fill($attributes);


            if (isset($attributes['categories'])) {
                $this->model->categories()->sync($attributes['categories']);
            } else {
                $this->model->categories()->sync(array());
            }

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
        return $this->model->select('extra_field.*')
        ->leftJoin('product_category_related_extra_field', 'extra_field.id', '=', 'product_category_related_extra_field.extra_field_id')
        
        ->where(function ($query) use ($productCategoryId) {

            $query->where('all_products', '=', 1)
            ->orWhereHas('categories', function ($query) use ($productCategoryId) {

                $query->where('product_category_id', '=', $productCategoryId);
            });
        })

        ->where('shop_id', '=', \Auth::guard('admin')->user()->selected_shop_id)->get();
    }

    public function selectAll()
    {
        return $this->model->where('shop_id', '=', \Auth::guard('admin')->user()->selected_shop_id)->get();
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

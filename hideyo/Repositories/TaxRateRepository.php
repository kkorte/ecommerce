<?php
namespace Hideyo\Repositories;
 
use App\TaxRate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
 
class TaxRateRepository implements TaxRateRepositoryInterface
{

    protected $model;

    public function __construct(TaxRate $model)
    {
        $this->model = $model;
    }

    public function rules($id = false)
    {
        $rules = array(
            'title' => 'required|between:4,65|unique_with:tax_rate, shop_id'

        );
        
        if ($id) {
            $rules['title'] =   'required|between:4,65|unique_with:tax_rate, shop_id, '.$id.' = id';
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

    public function selectAll()
    {
        return $this->model->where('shop_id', '=', \Auth::guard('admin')->user()->selected_shop_id)->get();
    }

    public function selectAllOrder()
    {
        return $this->model->orderBy('title', 'desc')->where('shop_id', '=', \Auth::guard('admin')->user()->selected_shop_id)->get();
    }

    public function getModel() {
        return $this->model;
    }

    
    public function find($id)
    {
        return $this->model->find($id);
    }
}

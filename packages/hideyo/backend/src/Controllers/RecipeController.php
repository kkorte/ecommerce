<?php namespace App\Http\Controllers\Admin;

/**
 * CouponController
 *
 * This is the controller of the recipes of the shop
 * @author Matthijs Neijenhuijs <matthijs@dutchbridge.nl>
 * @version 1.0
 */

use App\Http\Controllers\Controller;
use Dutchbridge\Repositories\RecipeRepositoryInterface;
use Dutchbridge\Repositories\ProductRepositoryInterface;

use Illuminate\Http\Request;
use Notification;

class RecipeController extends Controller
{
    public function __construct(
        Request $request,
        RecipeRepositoryInterface $recipe,
        ProductRepositoryInterface $product
    ) {
        $this->request = $request;
        $this->recipe = $recipe;
        $this->product = $product;
    }

    public function index()
    {
        if ($this->request->wantsJson()) {
            $recipe = $this->recipe->getModel()->select(
                [
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'id',
                'title']
            )

            ->with(array( 'recipeImages'))
            ->where('shop_id', '=', \Auth::guard('admin')->user()->selected_shop_id);
            
            $datatables = \Datatables::of($recipe)

            ->addColumn('image', function ($recipe) {
                if ($recipe->recipeImages->count()) {
                    return '<img src="/files/recipe/100x100/'.$recipe->id.'/'.$recipe->recipeImages->first()->file.'"  />';
                }
            })


            ->addColumn('action', function ($recipe) {
                $delete = \Form::deleteajax('/admin/recipe/'. $recipe->id, 'Delete', '', array('class'=>'btn btn-default btn-sm btn-danger'), $recipe->title);
                $link = '<a href="/admin/recipe/'.$recipe->id.'/edit" class="btn btn-default btn-sm btn-success"><i class="entypo-pencil"></i>Edit</a>  '.$delete;
            
                return $link;
            });

            return $datatables->make(true);
        } else {
            return view('admin.recipe.index')->with('recipe', $this->recipe->selectAll());
        }
    }

    public function create()
    {
        $products = $this->product->selectAll()->lists('title', 'id');

        return view('admin.recipe.create')->with(array(
            'products' => $products,
            'courseMenus' => $this->recipe->selectAllCourses(\Auth::guard('admin')->user()->selected_shop_id)->lists('title', 'id'),
            'typeOfDishes' => $this->recipe->selectAllDishes(\Auth::guard('admin')->user()->selected_shop_id)->lists('title', 'id')
        ));
    }

    public function store()
    {
        $result  = $this->recipe->create($this->request->all());

        if (isset($result->id)) {
            Notification::success('The recipe was inserted.');
            return redirect()->route('admin.recipe.index');
        }
        
        foreach ($result->errors()->all() as $error) {
            Notification::error($error);
        }
        
        return redirect()->back()->withInput();
    }

    public function edit($id)
    {
        $products = $this->product->selectAll()->lists('title', 'id');

        return view('admin.recipe.edit')->with(array(
            'products' => $products,
            'courseMenus' => $this->recipe->selectAllCourses(\Auth::guard('admin')->user()->selected_shop_id)->lists('title', 'id'),
            'typeOfDishes' => $this->recipe->selectAllDishes(\Auth::guard('admin')->user()->selected_shop_id)->lists('title', 'id'),
            'recipe' => $this->recipe->find($id)
        ));
    }


    public function editSeo($id)
    {
        return view('admin.recipe.edit_seo')->with(array('recipe' => $this->recipe->find($id)));
    }

    public function reDirectoryAllImages()
    {
        $this->recipeImage->reDirectoryAllImagesByShopId(\Auth::guard('admin')->user()->selected_shop_id);
        return redirect()->route('admin.recipe.index');
    }

    public function refactorAllImages()
    {
        $this->recipeImage->refactorAllImagesByShopId(\Auth::guard('admin')->user()->selected_shop_id);

        return redirect()->route('admin.recipe.index');
    }

    public function update($recipeId)
    {
        $result  = $this->recipe->updateById($this->request->all(), $recipeId);

        if (isset($result->id)) {
            if ($this->request->get('seo')) {
                Notification::success('Recipe seo was updated.');
                return redirect()->route('admin.recipe.edit_seo', $recipeId);
            } elseif ($this->request->get('recipe-combination')) {
                Notification::success('Recipe combination leading attribute group was updated.');
                return redirect()->route('admin.recipe.{recipeId}.recipe-combination.index', $recipeId);
            } else {
                Notification::success('Recipe was updated.');
                return redirect()->route('admin.recipe.edit', $recipeId);
            }
        }

        foreach ($result->errors()->all() as $error) {
            Notification::error($error);
        }
        
       
        return redirect()->back()->withInput();
    }

    public function destroy($id)
    {
        $result  = $this->recipe->destroy($id);

        if ($result) {
            Notification::success('The recipe was deleted.');
            return redirect()->route('admin.recipe.index');
        }
    }
}

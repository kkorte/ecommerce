<?php namespace App\Http\Controllers\Admin;

/**
 * ProductController
 *
 * This is the controller of the product weight types of the shop
 * @author Matthijs Neijenhuijs <matthijs@dutchbridge.nl>
 * @version 1.0
 */

use App\Http\Controllers\Controller;

use Dutchbridge\Repositories\RecipeImageRepositoryInterface;
use Dutchbridge\Repositories\RecipeRepositoryInterface;

use Illuminate\Http\Request;
use Notification;

class RecipeImageController extends Controller
{
    public function __construct(Request $request, RecipeRepositoryInterface $recipe)
    {
        $this->request = $request;
        $this->recipe = $recipe;
    }

    public function index($recipeId)
    {
        $recipe = $this->recipe->find($recipeId);
        if ($this->request->wantsJson()) {

            $image = $this->recipe->getImageModel()->select(
                [
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'id',
                'file', 'recipe_id']
            )->where('recipe_id', '=', $recipeId);
            
            $datatables = \Datatables::of($image)

            ->addColumn('thumb', function ($image) use ($recipeId) {


                return '<img src="/files/recipe/100x100/'.$image->recipe_id.'/'.$image->file.'"  />';
            })


            ->addColumn('action', function ($image) use ($recipeId) {
                $delete = \Form::deleteajax('/admin/recipe/'.$recipeId.'/images/'. $image->id, 'Delete', '', array('class'=>'btn btn-default btn-sm btn-danger'));
                $link = '<a href="/admin/recipe/'.$recipeId.'/images/'.$image->id.'/edit" class="btn btn-default btn-sm btn-success"><i class="entypo-pencil"></i>Edit</a>  '.$delete;

                return $link;
            });

            return $datatables->make(true);

        } else {
            return view('admin.recipe_image.index')->with(array('recipe' => $recipe));
        }
    }

    public function create($recipeId)
    {
        $recipe = $this->recipe->find($recipeId);
        return view('admin.recipe_image.create')->with(array('recipe' => $recipe));
    }

    public function store($recipeId)
    {
        $result  = $this->recipe->createImage($this->request->all(), $recipeId);
 
        if (isset($result->id)) {
            Notification::success('The recipe image was inserted.');
            return redirect()->route('admin.recipe.{recipeId}.images.index', $recipeId);
        } else {
            foreach ($result->errors()->all() as $error) {
                Notification::error($error);
            }
            return redirect()->back()->withInput()->withErrors($result);
        }
    }

    public function edit($recipeId, $id)
    {
        $recipe = $this->recipe->find($recipeId);
        return view('admin.recipe_image.edit')->with(array('recipeImage' => $this->recipe->findImage($id), 'recipe' => $recipe));
    }

    public function update($recipeId, $id)
    {
        $result  = $this->recipe->updateImageById($this->request->all(), $recipeId, $id);

        if (isset($result->id)) {
            Notification::success('The recipe image was updated.');
            return redirect()->route('admin.recipe.{recipeId}.images.index', $recipeId);
        } else {
            foreach ($result->errors()->all() as $error) {
                Notification::error($error);
            }
            return redirect()->back()->withInput()->withErrors($result);
        }
    }

    public function destroy($recipeId, $id)
    {
        $result  = $this->recipe->destroyImage($id);

        if ($result) {
            Notification::success('The image was deleted.');
            return redirect()->route('admin.recipe.{recipeId}.images.index', $recipeId);
        }
    }
}

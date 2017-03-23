<?php namespace Hideyo\Backend\Controllers;

/**
 * ProductWeightTypeController
 *
 * This is the controller of the product weight types of the shop
 * @author Matthijs Neijenhuijs <matthijs@dutchbridge.nl>
 * @version 1.0
 */

use App\Http\Controllers\Controller;
use Hideyo\Backend\Repositories\AttributeGroupRepositoryInterface;
use Request;
use Notification;
use Redirect;
use DB;
use Auth;
use Datatables;
use Form;

class AttributeGroupController extends Controller
{
    public function __construct(AttributeGroupRepositoryInterface $attributeGroup)
    {
        $this->attributeGroup = $attributeGroup;
    }

    public function index()
    {
        if (Request::wantsJson()) {

            $query = $this->attributeGroup->getModel()
            ->select([DB::raw('@rownum  := @rownum  + 1 AS rownum'),'id','title'])
            ->where('shop_id', '=', Auth::guard('hideyobackend')->user()->selected_shop_id);
            
            $datatables = Datatables::of($query)->addColumn('action', function ($query) {
                $delete = Form::deleteajax('/admin/attribute-group/'. $query->id, 'Delete', '', array('class'=>'btn btn-default btn-sm btn-danger'));
                $link = '<a href="/admin/attribute-group/'.$query->id.'/attributes" class="btn btn-default btn-sm btn-info"><i class="entypo-pencil"></i>'.$query->attributes->count().' Attributes</a> <a href="/admin/attribute-group/'.$query->id.'/edit" class="btn btn-default btn-sm btn-success"><i class="entypo-pencil"></i>Edit</a> 
                '.$delete;
                return $link;
            });

            return $datatables->make(true);
        } else {
            return view('hideyo_backend::attribute-group.index')->with('attributeGroup', $this->attributeGroup->selectAll());
        }
    }

    public function create()
    {
        return view('hideyo_backend::attribute-group.create')->with(array());
    }

    public function store()
    {
        $result  = $this->attributeGroup->create(\Request::all());

        if (isset($result->id)) {
            \Notification::success('The extra field was inserted.');
            return \Redirect::route('admin.attribute-group.index');
        } else {
            foreach ($result->errors()->all() as $error) {
                \Notification::error($error);
            }
        }

        return \Redirect::back()->withInput();
    }

    public function edit($id)
    {
        return view('hideyo_backend::attribute-group.edit')->with(array('attributeGroup' => $this->attributeGroup->find($id)));
    }

    public function update($id)
    {
        $result  = $this->attributeGroup->updateById(\Request::all(), $id);

        if (isset($result->id)) {
            \Notification::success('The extra field was updated.');
            return \Redirect::route('admin.attribute-group.index');
        } else {
            foreach ($result->errors()->all() as $error) {
                \Notification::error($error);
            }
        }

        return \Redirect::back()->withInput();
    }

    public function destroy($id)
    {
        $result  = $this->attributeGroup->destroy($id);

        if ($result) {
            Notification::success('Extra field was deleted.');
            return Redirect::route('admin.attribute-group.index');
        }
    }
}

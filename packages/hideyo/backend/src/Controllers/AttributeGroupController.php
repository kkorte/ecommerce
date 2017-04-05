<?php namespace Hideyo\Backend\Controllers;

/**
 * ProductWeightTypeController
 *
 * This is the controller of the attributes groups used by products of the shop
 * @author Matthijs Neijenhuijs <matthijs@dutchbridge.nl>
 * @version 1.0
 */

use App\Http\Controllers\Controller;
use Hideyo\Backend\Repositories\AttributeGroupRepositoryInterface;
use Illuminate\Http\Request;
use Notification;
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

    public function index(Request $request)
    {
        if ($request->wantsJson()) {

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
            return view('hideyo_backend::attribute-group.index');
        }
    }

    public function create()
    {
        return view('hideyo_backend::attribute-group.create');
    }

    public function store(Request $request)
    {
        $result  = $this->attributeGroup->create($request->all());

        if (isset($result->id)) {
            Notification::success('The extra field was inserted.');
            return redirect()->route('hideyo.attribute-group.index');
        } else {
            foreach ($result->errors()->all() as $error) {
                Notification::error($error);
            }
        }

        return redirect()->back()->withInput();
    }

    public function edit($id)
    {
        return view('hideyo_backend::attribute-group.edit')->with(array('attributeGroup' => $this->attributeGroup->find($id)));
    }

    public function update($id)
    {
        $result  = $this->attributeGroup->updateById(\Request::all(), $id);

        if (isset($result->id)) {
            Notification::success('The extra field was updated.');
            return redirect()->route('hideyo.attribute-group.index');
        } else {
            foreach ($result->errors()->all() as $error) {
                Notification::error($error);
            }
        }

        return redirect()->back()->withInput();
    }

    public function destroy($id)
    {
        $result  = $this->attributeGroup->destroy($id);

        if ($result) {
            Notification::success('Extra field was deleted.');
            return Redirect::route('hideyo.attribute-group.index');
        }
    }
}

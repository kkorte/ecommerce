<?php namespace Hideyo\Backend\Controllers;


/**
 * AttributeController
 *
 * This is the controller of the attributes of a attribute group
 * @author Matthijs Neijenhuijs <matthijs@dutchbridge.nl>
 * @version 1.0
 */

use App\Http\Controllers\Controller;
use Hideyo\Backend\Repositories\AttributeRepositoryInterface;
use Hideyo\Backend\Repositories\AttributeGroupRepositoryInterface;

use Request;
use Notification;
use Redirect;

class AttributeController extends Controller
{
    public function __construct(AttributeRepositoryInterface $attribute, AttributeGroupRepositoryInterface $attributeGroup)
    {
        $this->attributeGroup = $attributeGroup;
        $this->attribute = $attribute;
    }

    public function index($attributeGroupId)
    {
        if (Request::wantsJson()) {

            $query = $this->attribute->getModel()
            ->select([\DB::raw('@rownum  := @rownum  + 1 AS rownum'),'id','value'])
            ->where('attribute_group_id', '=', $attributeGroupId);
            
            $datatables = \Datatables::of($query)->addColumn('action', function ($query) use ($attributeGroupId) {
                $delete = \Form::deleteajax('/admin/attribute-group/'.$attributeGroupId.'/attributes/'. $query->id, 'Delete', '', array('class'=>'btn btn-default btn-sm btn-danger'));
                $link = ' <a href="/admin/attribute-group/'.$attributeGroupId.'/attributes/'.$query->id.'/edit" class="btn btn-default btn-sm btn-success"><i class="entypo-pencil"></i>Edit</a>'.$delete;
            
                return $link;
            });

            return $datatables->make(true);

        } else {
            return view('hideyo_backend::attribute.index')->with('attributeGroup', $this->attributeGroup->find($attributeGroupId));
        }
    }

    public function create($attributeGroupId)
    {
        return view('hideyo_backend::attribute.create')->with(array('attributeGroup' =>  $this->attributeGroup->find($attributeGroupId)));
    }

    public function store($attributeGroupId)
    {
        $result  = $this->attribute->create(Request::all(), $attributeGroupId);

        if (isset($result->id)) {
            \Notification::success('The extra field was inserted.');
            return \Redirect::route('admin.attribute-group.{attributeGroupId}.attributes.index', $attributeGroupId);
        } else {
            foreach ($result->errors()->all() as $error) {
                \Notification::error($error);
            }
        }

        return \Redirect::back()->withInput();
    }

    public function edit($attributeGroupId, $id)
    {
        return view('hideyo_backend::attribute.edit')->with(array('attribute' => $this->attribute->find($id)));
    }

    public function update($attributeGroupId, $id)
    {
        $result  = $this->attribute->updateById(Request::all(), $attributeGroupId, $id);

        if (isset($result->id)) {
            \Notification::success('The extra field was updated.');
            return \Redirect::route('admin.attribute-group.{attributeGroupId}.attributes.index', $attributeGroupId);
        } else {
            foreach ($result->errors()->all() as $error) {
                \Notification::error($error);
            }
        }

        return \Redirect::back()->withInput();
    }

    public function destroy($attributeGroupId, $id)
    {
        $result  = $this->attribute->destroy($id);

        if ($result) {
            Notification::success('Extra field was deleted.');
            return Redirect::route('admin.attribute-group.{attributeGroupId}.attributes.index', $attributeGroupId);
        }
    }
}

<?php namespace Hideyo\Backend\Controllers;
/**
 * ProductWeightTypeController
 *
 * This is the controller of the product weight types of the shop
 * @author Matthijs Neijenhuijs <matthijs@dutchbridge.nl>
 * @version 1.0
 */

use App\Http\Controllers\Controller;
use Hideyo\Backend\Repositories\ExtraFieldDefaultValueRepositoryInterface;
use Hideyo\Backend\Repositories\ExtraFieldRepositoryInterface;

use \Request;
use \Notification;
use \Redirect;

class ExtraFieldDefaultValueController extends Controller
{
    public function __construct(ExtraFieldDefaultValueRepositoryInterface $extraFieldDefaultValue, ExtraFieldRepositoryInterface $extraField)
    {
        $this->extraField = $extraField;
        $this->extraFieldDefaultValue = $extraFieldDefaultValue;
    }

    public function index($extraFieldId)
    {
        if (Request::wantsJson()) {

            $query = $this->extraFieldDefaultValue->getModel()->select(
                [
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'id',
                'value']
            )->where('extra_field_id', '=', $extraFieldId);
            
            $datatables = \Datatables::of($query)->addColumn('action', function ($query) use ($extraFieldId) {
                $delete = \Form::deleteajax('/admin/extra-field/'.$extraFieldId.'/values/'. $query->id, 'Delete', '', array('class'=>'btn btn-default btn-sm btn-danger'));
                $link = ' <a href="/admin/extra-field/'.$extraFieldId.'/values/'.$query->id.'/edit" class="btn btn-default btn-sm btn-success"><i class="entypo-pencil"></i>Edit</a> 
                '.$delete;
            
                return $link;
            });

            return $datatables->make(true);

        } else {
            return view('hideyo_backend::extra-field-default-value.index')->with('extraField', $this->extraField->find($extraFieldId));
        }
    }

    public function create($extraFieldId)
    {
        return view('hideyo_backend::extra-field-default-value.create')->with(array('extraField' =>  $this->extraField->find($extraFieldId)));
    }

    public function store($extraFieldId)
    {
        $result  = $this->extraFieldDefaultValue->create(Request::all(), $extraFieldId);

        if (isset($result->id)) {
            \Notification::success('The extra field was inserted.');
            return \Redirect::route('admin.extra-field.{extraFieldId}.values.index', $extraFieldId);
        } else {
            foreach ($result->errors()->all() as $error) {
                \Notification::error($error);
            }
        }

        return \Redirect::back()->withInput();
    }

    public function edit($extraFieldId, $id)
    {
        return view('hideyo_backend::extra-field-default-value.edit')->with(array('extraFieldDefaultValue' => $this->extraFieldDefaultValue->find($id)));
    }

    public function update($extraFieldId, $id)
    {
        $result  = $this->extraFieldDefaultValue->updateById(Request::all(), $extraFieldId, $id);

        if (isset($result->id)) {
            \Notification::success('The extra field was updated.');
            return \Redirect::route('admin.extra-field.{extraFieldId}.values.index', $extraFieldId);
        } else {
            foreach ($result->errors()->all() as $error) {
                \Notification::error($error);
            }
        }

        return \Redirect::back()->withInput();
    }

    public function destroy($extraFieldId, $id)
    {
        $result  = $this->extraFieldDefaultValue->destroy($id);

        if ($result) {
            Notification::success('Extra field was deleted.');
            return Redirect::route('admin.extra-field.{extraFieldId}.values.index', $extraFieldId);
        }
    }
}

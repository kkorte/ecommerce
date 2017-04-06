<?php

use dutchbridge\validators\RoleValidator;
use Hideyo\Backend\Repositories\RoleRepositoryInterface;

class RoleController extends BaseController
{
    public function __construct(RoleRepositoryInterface $role)
    {
        $this->role = $role;
    }

    public function index()
    {
        $datatable =  new RoleDatatable();

        if (Request::wantsJson()) {
            return \Datatable::collection($this->role->selectAll())
                      ->showColumns('id', 'name')
                ->addColumn('actions', function ($model) {
                    $delete = \Form::deleteajax('/role/'. $model->id, 'Delete', '', array('class'=>'btn btn-default btn-sm btn-icon btn-danger'));
                    $link = '<a href="/role/'.$model->id.'/edit" class="btn btn-default btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Edit</a>  '.$delete;
                
                    return $link;
                })
                ->searchColumns('name')
                ->orderColumns('id', 'name')
                ->make();


        } else {
            return \View::make('role.index')->with('role', $this->role->selectAll());
        }
    }

    public function show($id)
    {
        return \View::make('role.show')->with('role', Role::find($id));
    }

    public function create()
    {
        $roles = DB::table('roles')->lists('name', 'id');

        return \View::make('role.create', array('roles' => $roles));
    }


    public function store()
    {
        $result  = $this->role->create(Request::all());
 
        if ($result->id) {
            Notification::success('The role was inserted.');
            return Redirect::route('role.index');
        } else {
            Notification::error('field are required');
        }

        return Redirect::back()->withInput()->withErrors($result->errors()->all());
    }

    public function edit($id)
    {
        $roles = DB::table('roles')->lists('name', 'id');
        return \View::make('role.edit')->with(array('role' => Role::find($id), 'roles' => $roles));
    }

    public function update($id)
    {
        $result  = $this->role->updateById(Request::all(), $id);

        if ($result->errors()->all()) {
            return Redirect::back()->withInput()->withErrors($result->errors()->all());
        } else {
            Notification::success('The role was updated.');
            return Redirect::route('role.index');
        }
    }

    public function destroy($id)
    {
        $result  = $this->role->destroy($id);

        if ($result) {
            Notification::success('The role was deleted.');
            return Redirect::route('role.index');
        }
    }
}

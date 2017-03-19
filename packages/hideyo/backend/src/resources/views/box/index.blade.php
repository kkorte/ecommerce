@extends('admin._layouts.default')

@section('main')

<div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
        <ul class="nav nav-sidebar">
            <li class="active"><a href="{{ URL::route('admin.box.index') }}">Overview <span class="sr-only">(current)</span></a></li>
            <li><a href="{{ URL::route('admin.box.create') }}">Create</a></li>
        </ul>
    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <ol class="breadcrumb">
            <li><a href="/admin">Dashboard</a></li>
            <li><a href="{{ URL::route('admin.box.index') }}">Box</a></li>  
            <li class="active">overview</li>
        </ol>

        <a href="{{ URL::route('admin.box.create') }}" class="btn btn-success pull-right" aria-label="Left Align"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create</a>

        <h2>Box <small>overview</small></h2>
        <hr/>
        {!! Notification::showAll() !!}

        <table id="datatable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="col-md-1">{{{ trans('table.id') }}}</th>
                    <th class="col-md-1">{{{ trans('table.created-at') }}}</th>
                    <th class="col-md-1">{{{ trans('table.active') }}}</th>
                    <th class="col-md-1">{{{ trans('table.processed') }}}</th>
                    <th class="col-md-1">{{{ trans('table.name') }}}</th>
                    <th class="col-md-1">{{{ trans('table.email') }}}</th>
                    <th class="col-md-1">{{{ trans('table.account-name') }}}</th>
                    <th class="col-md-1">{{{ trans('table.account-number') }}}</th>
                    <th class="col-md-2">{{{ trans('table.actions') }}}</th>
                </tr>
            </thead>
        </table>

        <script type="text/javascript">
        $(document).ready(function() {

            oTable = $('#datatable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "/admin/box",

                columns: [
                  {data: 'id', name: 'id', bSearchable: false},
                                        {data: 'created_at', name: 'created_at', bSearchable: false},
                {data: 'active', name: 'active'},
                {data: 'processed', name: 'processed'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'account_name', name: 'account_name'},

                {data: 'account_number', name: 'account_number'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                    aaSorting: [[1, 'desc']]
            });
        });
        </script>
        
    </div>
</div>   
@stop
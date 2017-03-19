@extends('admin._layouts.default')

@section('main')
<div class="row">
    <div class="col-sm-3 col-md-2 sidebar">

    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <ol class="breadcrumb">
            <li><a href="/admin">Dashboard</a></li>
            <li><a href="{{ URL::route('admin.box.index') }}">Box</a></li>  
            <li class="active">edit</li>
        </ol>

        <h2>Box <small>edit</small></h2>
        <hr/>
        {!! Notification::showAll() !!}

        {!! Form::model($box, array('method' => 'put', 'route' => array('admin.box.update', $box->id), 'files' => true, 'class' => 'form-horizontal form-groups-bordered validate')) !!}
        

        <div class="form-group">
            {!! Form::label('active', 'Active', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-5">
                {!! Form::select('active', array('0' => 'No', '1' => 'Yes'), null, array('class' => 'form-control')) !!}
            </div>
        </div>


        <div class="form-group">
            {!! Form::label('multivers', 'Multivers', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-5">
                {!! Form::select('multivers', array('0' => 'No', '1' => 'Yes'), null, array('class' => 'form-control')) !!}
            </div>
        </div>


        <div class="form-group">
            {!! Form::label('vegetarian', 'Vegetarian', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-5">
                {!! Form::select('vegetarian', array('0' => 'No', '1' => 'Yes'), null, array('class' => 'form-control')) !!}
            </div>
        </div>


        <div class="form-group">
            {!! Form::label('pickup', 'Pickup', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-5">
                {!! Form::select('pickup', array('0' => 'No', '1' => 'Yes'), null, array('class' => 'form-control')) !!}
            </div>
        </div>


        <div class="form-group">
            {!! Form::label('paid', 'Paid', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-5">
                {!! Form::select('paid', array('0' => 'No', '1' => 'Yes'), null, array('class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('processed', 'Processed', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-5">
                {!! Form::select('processed', array('0' => 'No', '1' => 'Yes'), null, array('class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('newsletter', 'Newsletter', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-5">
                {!! Form::select('newsletter', array('0' => 'No', '1' => 'Yes'), null, array('class' => 'form-control')) !!}
            </div>
        </div>


        <div class="form-group">   
            {!! Form::label('email', 'Email', array('class' => 'col-sm-3 control-label')) !!}

            <div class="col-sm-5">
                {!! Form::text('email', null, array('class' => 'form-control', 'data-validate' => 'required', 'data-message-required' => 'This is custom message for required field.', 'placeholder' => 'type a name')) !!}
            </div>
        </div>


        <div class="form-group">   
            {!! Form::label('name', 'Name', array('class' => 'col-sm-3 control-label')) !!}

            <div class="col-sm-5">
                {!! Form::text('name', null, array('class' => 'form-control', 'data-validate' => 'required', 'data-message-required' => 'This is custom message for required field.', 'placeholder' => 'type a name')) !!}
            </div>
        </div>


        <div class="form-group">
            {!! Form::label('street', 'Street', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-5">
                {!! Form::text('street', null, array('class' => 'form-control', 'data-validate' => 'required', 'data-message-required' => 'This is custom message for required field.')) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('housenumber', 'Housenumber', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-5">
                {!! Form::text('housenumber', null, array('class' => 'form-control', 'data-validate' => 'required', 'data-message-required' => 'This is custom message for required field.')) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('housenumber_suffix', 'Housenumber suffix', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-5">
                {!! Form::text('housenumber_suffix', null, array('class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('zipcode', 'Zipcode', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-5">
                {!! Form::text('zipcode', null, array('class' => 'form-control', 'data-validate' => 'required', 'data-message-required' => 'This is custom message for required field.')) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('city', 'City', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-5">
                {!! Form::text('city', null, array('class' => 'form-control', 'data-validate' => 'required', 'data-message-required' => 'This is custom message for required field.')) !!}
            </div>
        </div>   

        <div class="form-group">
            {!! Form::label('country', 'Country', array('class' => 'col-sm-3 control-label')) !!}
            <div class="col-sm-5">
                {!! Form::select('country', array('NL' => 'Netherlands', 'BE' => 'Belgium', 'DE' => 'Germany', 'GB' => 'United Kingdom'), null, array('class' => 'form-control')) !!}
            </div>
        </div>


        <div class="form-group">   
            {!! Form::label('account_name', 'Account name', array('class' => 'col-sm-3 control-label')) !!}

            <div class="col-sm-5">
                {!! Form::text('account_name', null, array('class' => 'form-control', 'data-validate' => 'required', 'data-message-required' => 'This is custom message for required field.', 'placeholder' => 'type a name')) !!}
            </div>
        </div>

        <div class="form-group">   
            {!! Form::label('account_number', 'Account number', array('class' => 'col-sm-3 control-label')) !!}

            <div class="col-sm-5">
                {!! Form::text('account_number', null, array('class' => 'form-control', 'data-validate' => 'required', 'data-message-required' => 'This is custom message for required field.', 'placeholder' => 'type a name')) !!}
            </div>
        </div>


        <div class="form-group">   
            {!! Form::label('company', 'Company', array('class' => 'col-sm-3 control-label')) !!}

            <div class="col-sm-5">
                {!! Form::text('company', null, array('class' => 'form-control', 'data-validate' => 'required', 'data-message-required' => 'This is custom message for required field.', 'placeholder' => 'type a name')) !!}
            </div>
        </div>


        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-5">
                {!! Form::submit('Save', array('class' => 'btn btn-default')) !!}
                <a href="{!! URL::route('admin.box.index') !!}" class="btn btn-large">Cancel</a>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop







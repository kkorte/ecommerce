@extends('hideyo_backend::_layouts.default')

@section('main')
<div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
        <ul class="nav nav-sidebar">
            <li><a href="{!! URL::route('hideyo.landing-page.index') !!}">Overview <span class="sr-only">(current)</span></a></li>
            <li class="active"><a href="{!! URL::route('hideyo.landing-page.create') !!}">Create</a></li>
        </ul>
    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <ol class="breadcrumb">
            <li><a href="/admin/dashboard">Dashboard</a></li>
            <li><a href="{!! URL::route('hideyo.landing-page.index') !!}">Landing page</a></li>  
            <li class="active">create</li>
        </ol>

        <h2>Landing page <small>create</small></h2>
        <hr/>
        {!! Notification::showAll() !!}

        {!! Form::open(array('route' => array('hideyo.landing-page.store'), 'files' => true, 'class' => 'form-horizontal')) !!}
            <input type="hidden" name="_token" value="{!! Session::getToken() !!}">

            <div class="form-group">
                {!! Form::label('active', 'Active', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-5">
                    {!! Form::select('active', array('0' => 'No', '1' => 'Yes'), null, array('class' => 'form-control')) !!}
                </div>
            </div>



            <div class="form-group">
                {!! Form::label('title', 'Title', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-5">
                    {!! Form::text('title', null, array('class' => 'form-control', 'data-validate' => 'required', 'data-message-required' => 'This is custom message for required field.')) !!}
                </div>
            </div>


            <div class="form-group">
                {!! Form::label('short_description', 'Short description', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-5">
                    {!! Form::text('short_description', null, array('class' => 'form-control', 'data-validate' => 'required', 'data-message-required' => 'This is custom message for required field.')) !!}
                </div>
            </div>



            <div class="form-group">
                {!! Form::label('description', 'Description', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
                    {!! Form::textarea('description', null, array('class' => 'form-control ckeditor', 'data-validate' => 'required', 'data-message-required' => 'This is custom message for required field.')) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('image', 'Image', array('class' => 'col-sm-3 control-label')) !!}

                <div class="col-sm-5">
                    {!! Form::file('image', null, array('class' => 'form-control', 'data-message-required' => 'This field is required.')) !!}
                </div>
            </div>

            @include('hideyo_backend::_fields.seo-fields')

            <div class="form-group">
                {!! Form::label('products', 'Products', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-5">
                    {!! Form::multiselect2('products[]', $products->toArray(), array()) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('javascript', 'Javascript', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
                    {!! Form::textarea('javascript', null, array('class' => 'form-control', 'data-validate' => 'required', 'data-message-required' => 'This is custom message for required field.')) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    {!! Form::submit('Save', array('class' => 'btn btn-default')) !!}
                    <a href="{!! URL::route('hideyo.landing-page.index') !!}" class="btn btn-large">Cancel</a>
                </div>
            </div> 


        {!! Form::close() !!}
    </div>
</div>
@stop




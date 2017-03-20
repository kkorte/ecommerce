@extends('admin._layouts.default')

@section('main')

<div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
        @include('admin._partials.brand-tabs', array('brandEditSeo' => true))
    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

        <ol class="breadcrumb">
            <li><a href="/admin">Dashboard</a></li>
            <li><a href="{!! URL::route('admin.brand.index') !!}">Brand</a></li>
            <li><a href="{!! URL::route('admin.brand.edit', $brand->id) !!}">edit</a></li>
            <li><a href="{!! URL::route('admin.brand.edit', $brand->id) !!}">{!! $brand->title !!}</a></li>
            <li class="active">seo</li>
        </ol>

        <h2>Brand <small>edit seo</small></h2>
        <hr/>
        {!! Notification::showAll() !!}

        {!! Form::model($brand, array('method' => 'put', 'route' => array('admin.brand.update', $brand->id), 'files' => true, 'class' => 'form-horizontal form-groups-bordered validate')) !!}
        <input type="hidden" name="_token" value="{!! Session::getToken() !!}">     
        {!! Form::hidden('seo', 1) !!}                      
            
        @include('admin._fields.seo-fields')

        @include('admin._fields.buttons', array('cancelRoute' => 'admin.brand.index'))

        {!! Form::close() !!}

    </div>

</div>
@stop
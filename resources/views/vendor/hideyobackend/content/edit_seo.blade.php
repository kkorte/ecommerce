@extends('admin._layouts.default')

@section('main')

<div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
        @include('admin._partials.content-tabs', array('contentEditSeo' => true))
    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

        <ol class="breadcrumb">
            <li><a href="/admin"><i class="entypo-folder"></i>Dashboard</a></li>
            <li><a href="{!! URL::route('admin.content.index') !!}">Content</a></li>
            <li><a href="{!! URL::route('admin.content.edit', $content->id) !!}">edit</a></li>
            <li><a href="{!! URL::route('admin.content.edit', $content->id) !!}">{!! $content->title !!}</a></li>
            <li class="active">seo</li>
        </ol>

        <h2>Content <small>edit seo</small></h2>
        <hr/>
        {!! Notification::showAll() !!}

        {!! Form::model($content, array('method' => 'put', 'route' => array('admin.content.update', $content->id), 'files' => true, 'class' => 'form-horizontal', 'data-toggle' => 'validator')) !!}
        <input type="hidden" name="_token" value="{!! Session::getToken() !!}">     
        {!! Form::hidden('seo', 1) !!}                      
            
        @include('admin._fields.seo-fields')

        @include('admin._fields.buttons', array('cancelRoute' => 'admin.content.index'))

        {!! Form::close() !!}

    </div>

</div>


@stop

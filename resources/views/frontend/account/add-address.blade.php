@extends('_layouts.default')

@section('main')

<ol class="breadcrumb">
  <li><a href="/">Home</a></li>
  <li><a href="/account">account</a></li>
</ol>

<div class="account-container">
    <div class="row">
    	<div class="col-lg-6">
    		<h1>Account</h1>
			<p>email: {!! $user->email !!}</p>
		</div>

        <div class="col-lg-6">
            <a href="/account" class="btn btn-success pull-right">terug naar overzicht</a>
            <h2>Adres toevoegen</h2>
            @if ($errors->address->has())
            <div class="alert alert-danger">
                @foreach ($errors->address->all() as $error)
                    {!! $error !!}<br>        
                @endforeach
            </div>
            @endif
            <div class="row">

                <div class="col-lg-12">
 					<?php echo Form::open(array('url' => '/account/add-address/account', 'class' => 'box login')); ?>


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {!! Form::label('firstname', 'Firstname') !!}
                                {!! Form::text('firstname', null, array('class' => 'form-control', 'data-validate' => 'required')) !!}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {!! Form::label('lastname', 'Lastname') !!}
                                {!! Form::text('lastname', null, array('class' => 'form-control', 'data-validate' => 'required')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('company', 'Company') !!}
                        {!! Form::text('company', null, array('class' => 'form-control', 'data-validate' => 'required')) !!}
                    </div>

                    <div class="row">
                        <div class="col-lg-5">
                            <div class="form-group">
                                {!! Form::label('zipcode', 'Zipcode') !!}
                                {!! Form::text('zipcode', null, array('class' => 'form-control', 'data-validate' => 'required')) !!}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('housenumber', 'Housenumber') !!}
                                {!! Form::text('housenumber', null, array('class' => 'form-control', 'data-validate' => 'required')) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('housenumber_suffix', 'Houseletter') !!}
                                {!! Form::text('housenumber_suffix', null, array('class' => 'form-control', 'data-validate' => 'required')) !!}
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        {!! Form::label('street', 'Street') !!}
                        {!! Form::text('street', null, array('class' => 'form-control', 'data-validate' => 'required')) !!}
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {!! Form::label('city', 'City') !!}
                                {!! Form::text('city', null, array('class' => 'form-control', 'data-validate' => 'required')) !!}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {!! Form::label('country', 'Country') !!}
                                {!! Form::select('country', array('nl' => 'Netherlands', 'be' => 'Belgium'), null, array('class' => 'form-control', 'data-validate' => 'required')) !!}
                            </div>
                        </div>
                    </div>      

                    <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                   
                </div>
            </div>      
        </div>
    </div>
</div>
@stop
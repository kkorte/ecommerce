@extends('frontend._layouts.default')

@section('main') 

<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/account">Account</a></li>
            <li><a href="#">Login</a></li>
        </ol>
    </div>
</div>


 <div class="account">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-5 login">
            <h1>Login</h1>

            @notification('foundation')

            <div class="block">


            	<?php echo Form::open(array('route' => 'account.login', 'class' => 'form', 'data-abide' => '', 'novalidate' => '')); ?>

					<div class="form-group">
						<label for="middle-label">{!! trans('form.email') !!}</label>
						{!! Form::email('email', null, array('required' => '', 'pattern' => 'email', 'class' => 'form-control')) !!}
					</div>


					<div class="form-group">
					    <label for="middle-label">{!! trans('form.password') !!}</label>
					    {!! Form::password('password', array('required' => '', 'class' => 'form-control')) !!}
					</div>

					<div class="form-group">
				        <a href="{!! URL::route('account.forgot.password') !!}" class="forgot-password-link">{!! trans('titles.forgot-password') !!}</a>
				        <button type="submit" class="btn btn-success">{!! trans('buttons.login') !!}</button>
					</div>
       
            	</form>

            </div>

        </div>


        <div class="col-sm-12 col-md-12 col-lg-5 login">
        	<h1>Register</h1>
			<a href="/account/register" class="btn btn-success">click here</a>

        </div>

    </div>
</div>
@stop
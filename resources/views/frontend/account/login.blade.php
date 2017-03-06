@extends('frontend._layouts.default')

@section('main') 



<div class="breadcrumb">
    <div class="row">
        <div class="small-15 medium-15 large-15 columns">
            <nav aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs">
                    <li><a href="/">Home</a></li>
                    <li><a href="/account">Account</a></li>
                    <li class="active"><a href="#">Inloggen</a></li>

                </ul>
            </nav>
        </div>
    </div>
</div>



<div class="account">
    <div class="row">
        <div class="small-15 medium-10 large-7 columns login">
            <h1>Inloggen</h1>

            <p>Vul hieronder uw e-mailadres en het wachtwoord dat u eerder heeft ontvangen van Foodelicious. 
                Heeft u nog geen account? Registreer <a href="{!! URL::route('account.register') !!}" class="">hier</a>.</p>
             @notification('foundation')

            <div class="block">


            {!! Form::open(array('route' => 'account.login', 'class' => 'form', 'data-abide' => '', 'novalidate' => '')) !!}

                <div class="row">

                    <div class="small-15 medium-12 large-12 columns">
                        <label for="middle-label">{!! trans('form.email') !!}</label>
                        {!! Form::email('email', null, array('required' => '', 'pattern' => 'email')) !!}
                        <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>

                    </div>

                </div>

                <div class="row">
                    <div class="small-15 medium-12 large-12 columns">
                        <label for="middle-label">{!! trans('form.password') !!}</label>
                        {!! Form::password('password', array('required' => '')) !!}
                      <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>                
                    </div>
                </div>
              
                <div class="row">
                    <div class="small-offset-3 small-12 columns text-right">
                        <a href="{!! URL::route('account.forgot.password') !!}" class="forgot-password-link">{!! trans('titles.forgot-password') !!}</a>
                        <button type="submit" class="button button-black">{!! trans('buttons.login') !!}</button>
                    </div>
                </div>
       
            
{!! Form::close() !!}

            </div>

        </div>

    </div>
</div>

@stop
@extends('frontend._layouts.default')

@section('main') 

<div class="breadcrumb">

    <div class="row">
        <div class="small-15 columns">
            <ul class="breadcrumbs">
                <li><a href="/">Home</a></li>
                <li><a href="/account">Account</a></li>
                <li class="active"><a href="#">{!! trans('titles.forgot-password') !!}</a></li>
            </ul>
        </div>
    </div>

</div>

 <div class="account">
    <div class="row">
        <div class="small-15 medium-7 large-5 columns login">
  
            <h1>{!! trans('titles.forgot-password') !!}</h1>

            <div class="block">

            @notification('foundation')
                <?php echo Form::open(array('route' => 'account.forgot.password', 'class' => 'form', 'data-abide' => '', 'novalidate' => '')); ?>

                <div class="row">
                    <div class="small-15 medium-15 large-15 columns">
                        <label for="middle-label">{!! trans('form.email') !!}</label>
                        {!! Form::email('email', null, array('required' => '', 'pattern' => 'email')) !!}
                        <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>

                    </div>
                </div>                 
             

                <div class="row">
                    <div class="small-15 medium-15 large-15 columns text-right">
                        <button type="submit" class="button button-black">{!! trans('buttons.request') !!}</button>
                    </div>
                </div>

                </form>
            </div>

        </div>

    </div>
</div>
@stop
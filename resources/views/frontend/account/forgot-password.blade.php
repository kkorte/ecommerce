@extends('frontend._layouts.default')

@section('main') 



<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/account">Account</a></li>
            <li class="active"><a href="#">forgot password</a></li>
        </ul>
    </div>
</div>


 <div class="account">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-7 login">
  
            <h1>{!! trans('titles.forgot-password') !!}</h1>

            <div class="block">

            @notification('foundation')
                <?php echo Form::open(array('route' => 'account.forgot.password', 'class' => 'form', 'data-abide' => '', 'novalidate' => '')); ?>

                <div class="form-block">
                        <label>{!! trans('form.email') !!}</label>
                        {!! Form::email('email', null, array('class' => 'form-control')) !!}
                </div>                 
             
                <div class="form-block">
   
                        <button type="submit" class="btn btn-success form">Request</button>
              
                </div>

                </form>
            </div>

        </div>

    </div>
</div>
@stop
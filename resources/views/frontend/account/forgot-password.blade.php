@extends('frontend._layouts.default')

@section('main') 

<div class="breadcrumb">

    <div class="row">
        <div class="small-15 columns">
            <ul class="breadcrumbs">
                <li><a href="/">Home</a></li>
                <li><a href="/account">Account</a></li>
                <li class="active"><a href="#">Wachtwoord vergeten</a></li>
            </ul>
        </div>
    </div>

</div>

 <div class="account">
    <div class="row">
        <div class="small-15 medium-7 large-7 columns login">
  
            <h1>Wachtwoord vergeten</h1>
            @notification('foundation')

            <div class="block">


                <?php echo Form::open(array('route' => 'account.forgot.password', 'class' => 'form', 'data-abide' => '', 'novalidate' => '')); ?>

                    <div class="row">
                        <div class="small-15 medium-15 large-15 columns">
                            <label for="middle-label">E-mailadres</label>
                            {!! Form::email('email', null, array('required' => '', 'pattern' => 'email')) !!}
                            <span class="form-error">
                                {!! trans('form.validation.required') !!}
                            </span>

                        </div>
                    </div>                 

                    <div class="row">
                        <div class="small-offset-3 small-12 columns text-right">
                            <button type="submit" class="button button-black">Aanvragen</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>

    </div>
</div>
@stop
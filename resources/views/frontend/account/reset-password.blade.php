@extends('frontend._layouts.default')

@section('main') 

<div class="breadcrumb">

    <div class="row">
        <div class="small-15 columns">
            <ul class="breadcrumbs">
                <li><a href="/">Home</a></li>
                <li><a href="/account">Account</a></li>
                <li class="active"><a href="#">wachtwoord veranderen</a></li>
            </ul>
        </div>
    </div>

</div>


<div class="account">
    <div class="row">
        <div class="small-15 medium-7 large-5 columns login">
  
            <h1>Wachtwoord veranderen</h1>

            <div class="block">


                <?php echo Form::open(array('url' => '/account/reset-password/'.$confirmationCode.'/'.$email, 'class' => 'form')); ?>

                <div class="row">
         
                    <div class="small-15 medium-12 large-15 columns">
                        <label for="middle-label">{!! trans('form.password') !!}</label>
                        {!! Form::password('password', array('required' => '')) !!}
                      <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>                
                    </div>
                </div>               

                <div class="row">
                    <div class="small-15 medium-15 large-15 columns text-right">
                            <button type="submit" class="button button-black">Verander</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>

    </div>
</div>





@stop


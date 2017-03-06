@extends('frontend._layouts.default')

@section('main')


<div class="breadcrumb">

    <div class="row">
        <div class="small-15 columns">
            <ul class="breadcrumbs">
                <li><a href="/">Home</a></li>
                <li><a href="/cart">Winkelwagen</a></li>
                <li><a href="#">Mijn gegevens</a></li>
            </ul>
        </div>
    </div>

</div>



<div class="main-cart-login">
    <div class="row">
    

        <div class="small-4 show-for-medium columns">
            @include('frontend.cart._summary')
        </div>      
    
        <div class="small-15 medium-4 large-4 columns large-offset-1">
       
            <h3>Bestaande klant</h3>  
            @if ($errors->login->has())
            @notification('foundation')
            @endif

            {!!  Form::open(array('url' => '/cart/checkout-login', 'class' => 'form', 'data-abide' => '', 'novalidate' => '')) !!}

                <div class="row">

          
                    <div class="small-15 medium-12 large-15 columns">
                        <label for="middle-label">{!! trans('form.email') !!}</label>
                        {!! Form::email('email', null, array('required' => '', 'pattern' => 'email')) !!}
                        <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>

                    </div>

                </div>

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
                    <div class="small-offset-3 small-12 columns text-right">
                        <a href="{!! URL::route('account.forgot.password') !!}" class="forgot-password-link">{!! trans('titles.forgot-password') !!}</a>
                        <button type="submit" class="button button-black">{!! trans('buttons.login') !!}</button>
                    </div>
                </div>



{!! Form::close() !!}
              
        </div>

        <div class="small-15 medium-6  large-offset-1 large-5 columns">
            <h3>Nieuwe klant</h3>  


            @if ($errors->register->has())
            @notification('foundation')
            @endif
        

            <?php echo Form::open(array('url' => '/cart/checkout-register', 'class' => 'form', 'data-abide' => '', 'novalidate' => '')); ?>

                <div class="row">        
                    <div class="small-15 medium-12 large-15 columns">
                        <label for="middle-label">{!! trans('form.email') !!}</label>
                        {!! Form::email('email', null, array('required' => '', 'pattern' => 'email')) !!}
                        <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>
                    </div>
                </div>


                <div class="row">        
                    <div class="small-15 medium-12 large-6 columns">
                        <label for="middle-label">{!! trans('form.firstname') !!}</label>
                        {!! Form::text('firstname', null, array('required' => '')) !!}
                   
                        <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>
                    </div>

                    <div class="small-15 medium-12 large-9 columns">
                        <label for="middle-label">{!! trans('form.lastname') !!}</label>
                                {!! Form::text('lastname', null, array('required' => '')) !!}
                   
                        <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>
                    </div>

                </div>

                <div class="row">        
                    <div class="small-15 medium-12 large-15 columns">
                        <label for="middle-label">{!! trans('form.phone') !!}</label>
                        {!! Form::text('phone', null, array('required' => '')) !!}
                        <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>
                    </div>
                </div>


                <div class="row">        
                    <div class="small-15 medium-12 large-15 columns">
                        <label for="middle-label">{!! trans('form.company') !!}</label>
                        {!! Form::text('company', null, array()) !!}
                        <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>
                    </div>
                </div>


                <div class="row">        
                    <div class="small-15 medium-12 large-5 columns">
                        <label for="middle-label">{!! trans('form.zipcode') !!}</label>
                        {!! Form::text('zipcode', null, array('class' => 'zipcode form-control checkzipcode', 'data-url' => '/account/check-zipcode', 'required' => '')) !!}
                        <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>
                    </div>

                    <div class="small-15 medium-12 large-5 columns">
                        <label for="middle-label">{!! trans('form.housenumber') !!}</label>
                        {!! Form::text('housenumber', null, array('class' => 'housenumber form-control checkhousenumber', 'data-url' => '/account/check-zipcode', 'required' => '')) !!}
                        <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>
                    </div>

                    <div class="small-15 medium-12 large-5 columns">
                        <label for="middle-label">{!! trans('form.houseletter') !!}</label>
                        {!! Form::text('housenumber_suffix', null, array()) !!}
                        <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>
                    </div>
                </div>

                <div class="row">        
                    <div class="small-15 medium-12 large-15 columns">
                        <label for="middle-label">{!! trans('form.street') !!}</label>
                        {!! Form::text('street', null, array('class' => 'fillstreet', 'required' => '')) !!}
                        <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>
                    </div>
                </div>

                <div class="row">        
                    <div class="small-15 medium-12 large-15 columns">
                        <label for="middle-label">{!! trans('form.city') !!}</label>
                        {!! Form::text('city', null, array('class' => 'fillcity', 'required' => '')) !!}
                        <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>
                    </div>
                </div>


                <div class="row">        
                    <div class="small-15 medium-12 large-15 columns">
                        <label for="middle-label">{!! trans('form.country') !!}</label>
                             {!! Form::select('country', array('nl' => 'Netherlands', 'be' => 'Belgium'), null, array('required' => '')) !!}
                   
                        <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>
                    </div>
                </div>               

                <h5>Account</h5>
                <p>Vul het wachtwoord alleen in als u een account wilt aanmaken. Deze kan je gebruiken voor een volgende bestelling.</p>

                <div class="row">        
                    <div class="small-15 medium-12 large-15 columns">
                        <label for="middle-label">{!! trans('form.password') !!}</label>
                        {!! Form::password('password', array('class' => 'form-control', 'placeholder' => 'wachtwoord', 'data-validation-error-msg' => trans('form.validation.required'))) !!}
           
                        <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>
                    </div>
                </div>


                <button type="submit" class="button btn-default">Verder</button>

            </form>
        </div>
    </div>
</div>




@stop



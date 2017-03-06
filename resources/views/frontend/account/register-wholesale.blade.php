@extends('frontend._layouts.default')

@section('main') 

<div class="breadcrumb">

    <div class="row">
        <div class="small-15 columns">
            <ul class="breadcrumbs">
                <li><a href="/">Home</a></li>
                <li><a href="/account">Account</a></li>
                <li class="active"><a href="#">Aanmelden</a></li>
            </ul>
        </div>
    </div>

</div>

<div class="account">
    <div class="row">


        <div class="small-10 columns register">
            <h1>Aanmelden</h1>

            <p>Meld je aan via dit formulier als je een nieuwe groothandel klant wilt worden. U registreert direct een account, de aanvraag voor het groothandel gedeelte verwerken wij zo snel mogelijk.</p>


            @notification('foundation')

            <div class="block">


               <?php echo Form::open(array('route' => 'account.register', 'class' => 'form', 'data-abide' => '', 'novalidate' => '')); ?>

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
                    <div class="small-15 medium-15 large-15 columns">
                        <label for="middle-label">Wachtwoord</label>
                        {!! Form::password('password', null, array('required' => '', 'pattern' => 'email')) !!}
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
                        {!! Form::text('company', null, array('required' => '')) !!}
                        <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>
                    </div>
                </div>

                <div class="row">        
                    <div class="small-15 medium-12 large-15 columns">
                        <label for="middle-label">{!! trans('form.vat_number') !!}</label>
                        {!! Form::text('vat_number', null, array('required' => '')) !!}
                        <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>
                    </div>
                </div>


                <div class="row">        
                    <div class="small-15 medium-12 large-15 columns">
                        <label for="middle-label">{!! trans('form.chamber_of_commerce_number') !!}</label>
                        {!! Form::text('chamber_of_commerce_number', null, array('required' => '')) !!}
                        <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>
                    </div>
                </div>


                <div class="row">        
                    <div class="small-15 medium-12 large-15 columns">
                        <label for="middle-label">{!! trans('form.iban_number') !!}</label>
                        {!! Form::text('iban_number', null, array()) !!}
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


                <div class="row">        
                    <div class="small-15 medium-12 large-15 columns">
                        <label for="middle-label">{!! trans('form.comments') !!}</label>
                        {!! Form::textarea('comments', null, array()) !!}
                        <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>
                    </div>
                </div>


	            <div class="row">
	                <div class="small-offset-3 small-12 columns text-right">
	                    <button type="submit" class="button button-black">{!! trans('buttons.register') !!}</button>
	                </div>
	            </div>

        </form>
    </div>

</div>

</div>

</div>


@stop
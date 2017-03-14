@extends('frontend._layouts.default')

@section('main') 

<div class="breadcrumb">
    <div class="row">
        <div class="small-15 medium-12 large-15 columns">
            <nav aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs">
                    <li><a href="/">Home</a></li>
                    <li><a href="/account">Account</a></li>
                    <li class="active"><a href="#">overzicht</a></li>

                </ul>
            </nav>
        </div>
    </div>
</div>

<div class="account">
    <div class="row">
        <div class="small-10 medium-10 large-5 columns">
            <div class="account-block">
                <h5>Account</h5>

                {!! Form::model($user, array('method' => 'post', 'url' => array('/account/edit-account'), 'class' => 'form', 'data-abide' => '', 'novalidate' => '')) !!}


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
                    <div class="small-15 medium-15 large-15 columns">
                        <label for="middle-label">{!! trans('form.password') !!}</label>
                        {!! Form::password('password', array('required' => '')) !!}
                      <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>                
                    </div>
                </div>


                <div class="row">
                    <div class="small-15 columns text-right">
                        <button type="submit" class="button button-black">{!! trans('buttons.edit') !!}</button>
                    </div>
                </div>


                </form> 

            </div>

        </div>

        <div class="small-10 medium-10 large-9 large-offset-1  columns">

            <div class="row">
                <div class="small-10 medium-10 large-7 columns">
                    <div class="address-block">
                        <h3>Factuuradres</h3>

                        <ul>
                            <li>{!! $user->clientBillAddress->firstname !!} {!! $user->clientBillAddress['lastname']  !!}</li>


                            <li>{!! $user->clientBillAddress['street']  !!} {!! $user->clientBillAddress['housenumber']  !!} {!! $user->clientBillAddress['housenumber_suffix']  !!}</li>
                            <li>{!! $user->clientBillAddress['zipcode']  !!} {!! $user->clientBillAddress['city']  !!}</li>
                            <li>
                                @if($user->clientBillAddress['country'] == 'nl')
                                Nederland
                                @elseif($user->clientBillAddress['country'] == 'be')
                                Belgie
                                @endif
                            </li>
                        </ul> 
                        <a href="/account/edit-address/bill" class="button button-simple">Wijzig factuuradres</a>        
         
                    </div>
                </div>

                <div class="small-10 medium-10 large-7 columns">
                    <div class="address-block">
                        <h3>Afleveradres</h3>
          
                        <ul>
                            <li>{!! $user->clientDeliveryAddress->firstname !!} {!! $user->clientDeliveryAddress['lastname']  !!}</li>


                            <li>{!! $user->clientDeliveryAddress['street']  !!} {!! $user->clientDeliveryAddress['housenumber']  !!} {!! $user->clientDeliveryAddress['housenumber_suffix']  !!}</li>
                            <li>{!! $user->clientDeliveryAddress['zipcode']  !!} {!! $user->clientDeliveryAddress['city']  !!}</li>
                            <li>
                                @if($user->clientDeliveryAddress['country'] == 'nl')
                                Nederland
                                @elseif($user->clientDeliveryAddress['country'] == 'be')
                                Belgie
                                @endif
                            </li>
                        </ul> 
                        <a href="/account/edit-address/delivery" class="button button-simple">Wijzig afleveradres</a>        
            
                    </div>
                </div>
            </div>

            
            @include('frontend.account._orders') 


        </div>



    </div>



    

</div>
@stop
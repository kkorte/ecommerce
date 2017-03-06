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

                <table>
                    <tbody>
                        <tr>
                            <td>Email:</td>
                            <td>{!! $user->email !!}</td>
                        </tr>
                        <tr>
                            <td>Wachtwoord:</td>
                            <td>*****</td>
                        </tr>
                    </tbody>
                </table>   

                <a href="/account/edit-account" class="button float-right button-simple">Wijzig gegevens</a>        
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
                            <li>{!! $user->clientBillAddress['phone']  !!}</li>
                        </ul> 
                        <a href="/account/edit-address/bill" class="button button-simple">Wijzig factuuradres</a>        
         
                    </div>
                </div>

                <div class="small-10 medium-10 large-7 columns">
                    <div class="address-block">
                        <h3>Afleveradres</h3>
          
                        @notification('foundation')
                        {!! Form::model($user->clientDeliveryAddress, array('method' => 'post', 'url' => array('/account/edit-address/delivery'), 'files' => true, 'class' => 'box login')) !!}

                        @include('frontend.cart._default_account_fields')       

                        <a href="/account" class="button button-grey">Annuleer</a>
                        <button type="submit" class="button btn-default">Wijzig</button>

                        {!! Form::close() !!}             
            
                    </div>
                </div>
            </div>

            
            @include('frontend.account._orders') 


        </div>



    </div>



    

</div>
@stop
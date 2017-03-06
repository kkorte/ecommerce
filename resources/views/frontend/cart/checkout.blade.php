@extends('frontend._layouts.default')

@section('main')


<div class="breadcrumb">

    <div class="row">
        <div class="small-15 columns">
            <ul class="breadcrumbs">
                <li><a href="/">Home</a></li>
                <li><a href="/cart">Winkelwagen</a></li>
                <li><a href="#">Bestelling plaatsen</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="main-cart main-cart-login">
    <div class="row">

        <div class="small-15 medium-5 large-4 columns">
            @include('frontend.cart._summary')
        </div>  

        <div class="small-15 medium-9 large-10 medium-offset-1 large-offset-1 columns">  
            <div class="confirm-page">     
                <div class="row">

                    <div class="small-15 medium-15 large-15 columns">
                        @notification('foundation')
                    </div>

                    <div class="confirm-address">
                        <div class="small-15 medium-15 large-7 columns">

                            <h3>Factuuradres</h3>
                            @if($user->clientBillAddress)             
                            <ul>
                                <li>{!! $user->clientBillAddress->firstname !!} {!! $user->clientBillAddress->lastname !!}</li>
                                <li>{!! $user->clientBillAddress->street !!} {!! $user->clientBillAddress->housenumber !!} {!! $user->clientBillAddress->housenumber_suffix !!}</li>
                                <li>{!! $user->clientBillAddress->zipcode !!} {!! $user->clientBillAddress->city !!}</li>
                                <li>
                                    @if($user->clientBillAddress->country == 'nl')
                                    Nederland
                                    @elseif($user->clientBillAddress->country == 'be')
                                    Belgie
                                    @endif
                                </li>
                                <li>{!! $user->clientBillAddress->phone  !!}</li>
                            </ul>
                            <a href="/cart/edit-address/bill" class="button button-simple">Wijzig factuuradres</a>
                            @endif

                        </div>

                        <div class="small-15 medium-15 large-7 columns">
                            @if($user->clientDeliveryAddress)
                            <h3>Afleveradres</h3>
                            <ul>
                                <li>{!! $user->clientDeliveryAddress->firstname !!} {!! $user->clientDeliveryAddress->lastname !!}</li>
                                <li>{!! $user->clientDeliveryAddress->street !!} {!! $user->clientDeliveryAddress->housenumber !!} {!! $user->clientDeliveryAddress->housenumber_suffix !!}</li>
                                <li>{!! $user->clientDeliveryAddress->zipcode !!} {!! $user->clientDeliveryAddress->city !!}</li>
                                <li>
                                    @if($user->clientDeliveryAddress->country == 'nl')
                                    Nederland
                                    @elseif($user->clientDeliveryAddress->country == 'be')
                                    Belgie
                                    @endif
                                </li>
                                <li>{!! $user->clientDeliveryAddress->phone  !!}</li>

                            </ul>
                            <a href="/cart/edit-address/delivery" class="button button-simple">Wijzig afleveradres</a>
                            @endif

                        </div>
                    </div>

                    @if($totals['present'])
                    <div class="present-block-content">

                        <div class="small-15 columns">
                            <hr/>
                            <h3>Cadeauservice</h3>
                            <p>Hieronder ziet u de gegevens van uw cadeau</p>
                            <table class="table">
                                <tr>
                                    <td width="150">
                                        <strong>Voor</strong>
                                    </td>
                                    <td>
                                        @if($totals['present']['gender'] == 'male')
                                        Man
                                        @else
                                        Vrouw
                                        @endif
                                     
                                    </td>

                                </tr>
                                <tr>

                                    <td>
                                        <strong>Gelegenheid</strong>
                                    </td>
                                    <td>
                                        {!! $totals['present']['occassion'] !!}
                                    </td>

                                </tr>

                                <tr>
                                    <td>
                                        <strong>Bericht</strong>
                                    </td>
                                    <td>
                                        {!! $totals['present']['message'] !!}
                                    </td>

                                </tr>

                            </table>
                        </div>
                    </div>


                    @endif



                    <div class="small-15 medium-15 large-15 columns">
                        <div class="paymentway">
                            <hr/>
                            <h3>Betaalmethode</h3>
                            <p>Selecteer hieronder waarmee je de bestelling veilig wilt betalen:</p>                              

                            <div  class="payment-clicks payment-method payment_method_row select">
                                <div class="row">
                                @foreach($paymentMethodsList->toArray() as $key => $value)
                                    <div class="small-15 medium-15 large-5 columns end">
                                        <label for="{!! $key !!}" class="@if($totals['payment_method_id'] == $key) active @endif">
                                        @if($totals['payment_method_id'] == $key)
                                        {!! Form::radio('payment_method_id', $key, true,array("id" => $key, "data-url" => "/cart/update-payment-method", "class" => "custom-selectbox selectpicker payment_method_id")) !!}  
                                        @else
                                        {!! Form::radio('payment_method_id', $key, false,array("id" => $key, "data-url" => "/cart/update-payment-method", "class" => "custom-selectbox selectpicker payment_method_id")) !!}  

                                        @endif
                                        
                                        @if($value == 'iDeal')
                                        <span class="paym paym-ideal"></span>
                                        @elseif($value
                                         == 'KBC/CBC')
                                        <span class="paym paym-kbc"></span>

                                        @elseif($value == 'Paypal')
                                        <span class="paym paym-paypal"></span>
                                        @elseif($value == 'V PAY')
                                        <span class="paym paym-vpay"></span>
                                        @elseif($value == 'SOFORT Banking')
                                        <span class="paym paym-sofort"></span>
                                        @elseif($value == 'Creditcard')
                                        <span class="paym paym-creditcard"></span>
                 
                                        @elseif($value == 'Vooruit betaling')
                                        <span class="paym paym-overboeking"></span>        

                                        @elseif($value == 'Belfius Direct Net')
                                        <span class="paym paym-belfius"></span>   

                                        @else
                                        <span class="paym paym-creditcard"></span>
                                        @endif

                                        <p>{!! $value !!}</p>
                    
                                 
                                        </label>

                         
                                    </div>
                                @endforeach
                                </div>

                            </div>               
               
                        </div>


                    </div>



                    {!! Form::open(array('route' => array('cart.complete'), 'class' => 'confirm-checkout form-horizontal form-groups-bordered validate', 'data-gtm-product' => GoogleTagManager::dump($dataLayer))) !!}
                       
                    <div class="small-15 columns">
                        <hr/>
                        <ul class="accordion" data-accordion data-allow-all-closed="true">
                            <li class="accordion-item" data-accordion-item>
                                <a href="#" class="accordion-title">Opmerking plaatsen</a>
                                <div class="accordion-content" data-tab-content>

                                    <p>Hieronder kunt u een eventuele opmerking plaatsen:</p>
                                    {!! Form::textarea('comments', null, array()) !!}  
                                </div>
                            </li>
                            <!-- ... -->
                        </ul>

                  
           
                    </div>


                    <div class="small-15 columns general-conditions text-right">
                      <hr/>
                      <p>Middels het bevestigen van de bestelling gaat u tevens akkoord met onze <a href="/text/algemene-voorwaarden" target="_blank">Algemene Voorwaarden</a>.</p>
                  </div>


                  <div class="small-15 large-15 columns text-right">
                      
                    <div class="button-group">
                      

                        <input type="hidden" name="_token" value="{!! Session::getToken() !!}">
                        @if($totals['payment_method']['payment_external']) 

                        {!! Form::submit('bevestig bestelling & betalen', array('class' => 'button confirm-checkout-button')) !!}  
                        @else 
                        {!! Form::submit('bevestig bestelling', array('class' => 'button confirm-checkout-button')) !!}  

                        @endif

                       
                        
                    </div>
                    
                </div> 
                {!! Form::close() !!}
            </div>
        </div>

    </div>

</div>
</div>
@stop
<tr class="subtotal-block">
    <td colspan="2" class="text-right">
        Subtotaal:
    </td>                      
    <td class="price" colspan="1" class="text-right">
        @if($shopFrontend->wholesale)
        &euro; <span class="sub_total_ex_tax">{!! $totals['sub_total_ex_tax_number_format'] !!}</span>
        @else
        &euro; <span class="sub_total_inc_tax">{!! $totals['sub_total_inc_tax_number_format'] !!}</span>
        
        @endif
    </td>                           
</tr>


@if($totals['present'])

<tr class="present-block present-block-mobile">

    <td colspan="3" class="present">
        <label>Cadeauservice</label>     
        <div class="input-group">

            <a href="#" class="button button-simple present-button" data-url="/cart/present">wijzigen</a>
            <a href="#" class="button button-simple present-button-delete" data-url="/cart/present/delete">verwijderen</a>
        </div>
    </td>



    <td class="title text-right" colspan="1">
         Extra kosten:  
    </td>

    <td colspan="1" class="text-right  total_price">
        &euro; 1.50

    </td>
</tr>


@endif


<tr class="discount-block discount-block-mobile">

    <td colspan="2" class="coupon">
        <label>Kortingscode</label>
        <div class="input-group">

            {!! Form::text('coupon_code', $totals['coupon_code'], array("data-url" => "/cart/update-coupon-code", "class" => "input-group-field coupon_code")) !!}
            <button class="input-group-field coupon_button button">invoeren</button> 

            @if($totals['coupon_code'] AND $totals['discount'] == 0)
            <small>De kortingscode is niet correct</small>

            @elseif($totals['coupon_code'] AND $totals['discount'] != 0 AND $totals['coupon']->title)
            <small>{!! $totals['coupon']->title !!}</small>

            
            @endif
        </div>
    </td>




</tr>


<tr class="no-line">

    <td colspan="3" class="text-right total_price">
        @if($totals['discount'] != 0) 
        @if($shopFrontend->wholesale)
        Korting <small>excl. BTW</small>:
        @else
        Korting:
        @endif

        @else 

        @endif    
        
        @if($totals['discount'] != 0) 

        @if($shopFrontend->wholesale)
        - &euro; {!! $totals['discount_ex_number_format'] !!}<br/>

        @else
        - &euro; {!! $totals['discount_number_format'] !!}<br/>

        @endif
        @endif


    </td>




</tr>

<tr class="sending-method">                  


    <td colspan="3" class="select">
        <label>Verzendwijze</label>
        <div class="sending_block">
            {!! Form::select('sending_method_id', $sendingMethodsList->lists('title', 'id')->toArray(), $totals['sending_method_id'], array("data-url" => "/cart/update-sending-method", "class" => "custom-selectbox selectpicker sending_method_id")) !!}
            <small class="sending_method_alert">
                @if($totals['sending_method']['total_price_discount_value'] > 0)
                @if($totals['sending_method']['total_price_discount_type'] == 'percent')   
                {!! number_format($totals['sending_method']['total_price_discount_value']) !!}% korting.
                @else
                {!! number_format($totals['sending_method']['total_price_discount_value']) !!} euro korting.
                @endif
                @elseif($totals['sending_method']['no_price_from'] > 0)
                gratis verzenden vanaf &euro; {!! $totals['sending_method']['no_price_from_number_format'] !!}.
                @endif
            </small>
        </div>
    </td>

</tr>

<tr class="no-line">

    <td colspan="3" class="text-right total_price">
        @if($shopFrontend->wholesale)
        Verzendkosten: &euro; <span class="sending_method_cost_ex_tax">{!! $totals['sending_method_cost_ex_tax_number_format'] !!}</span>
        @else
        Verzendkosten: &euro; <span class="sending_method_cost_inc_tax">{!! $totals['sending_method_cost_inc_tax_number_format'] !!}</span>
        
        @endif
    </td>

</tr>


<tr class="payment-method">         

    <td  colspan="3" class="payment_method_row select">
        <label>Betaalwijze</label>
        @if($paymentMethodsList)
            {!! Form::select('payment_method_id', $paymentMethodsList->toArray(), $totals['payment_method_id'], array("data-url" => "/cart/update-payment-method", "class" => "custom-selectbox selectpicker payment_method_id")) !!}
        @else
            {!! Form::select('payment_method_id', array('0' => '-- selecteer --'), null, array("disabled" => "disabled", "class" => "selectpicker custom-selectbox payment_method_id")) !!} 
        @endif
    </td>               


</tr>



<tr class="tr-total">
    <td class="title text-right" colspan="2">
        Totaal                             
    </td>

    <td class="price total_price">
        @if($shopFrontend->wholesale)
        &euro; <span class="total_ex_tax">{!! $totals['total_ex_tax_number_format'] !!}</span><br/>
        <small>btw &euro; <span class="total_tax">{!! $totals['total_tax_number_format'] !!}</span></small>
        @else
        &euro; <span class="total_inc_tax">{!! $totals['total_inc_tax_number_format'] !!}</span><br/>
        <small>btw &euro; <span class="total_tax">{!! $totals['total_tax_number_format'] !!}</span></small>
        @endif
   </td>                     
</tr>

<tr class="btw">
    <td class=" text-right" colspan="3">
    <small>btw &euro; <span class="total_tax">{!! $totals['total_tax_number_format'] !!}</span></small>                           
    </td>                                 
</tr>

<tr class="next-button">
    <td colspan="3" class="text-right">
      
        {!! Form::open(array('route' => array('cart.checkout'), 'class' => 'form-horizontal form-groups-bordered validate')) !!}
        <input type="hidden" name="_token" value="{!! Session::getToken() !!}">
        {!! Form::submit('Verder naar bestellen', array('class' => 'button btn-success')) !!}       
        {!! Form::close() !!}


    </td>
</tr>
<div class="order-summary">

    <h5>De bestelling</h5>
    @foreach ($products as $product)
    <div class="row product-row">     
       
            <div class="small-10 columns">
            
                <a href="/{{ $product['product_category_slug'] }}/{{ $product['id'] }}/{{ $product['slug'] }}" title="ga naar {!! $product['title'] !!}">               
                {!! $product['cart']['count'] !!}x {!! $product['title'] !!}
        
                @if(isset($product['product_combination_title']))
                <ul>
                @foreach($product['product_combination_title'] as $title => $value)
                    <li>{!! $title !!}: {!! $value !!}</li>
                @endforeach
                </ul>
                @endif



                @if(isset($product['plugin_option']) AND $product['plugin_option'])
                <ul>
                @foreach($product['plugin_option'] as $title => $value)
                    <li>{!! $title !!}: {!! $value !!}</li>
                @endforeach
                </ul>
                @endif
        
                </a>
        
            </div>
            <div  class="small-5 columns text-right">
                @if($shopFrontend->wholesale)
                &euro; <span class="total_price_ex_tax_{!! $product['id'] !!}">{!! $product['cart']['total_price_ex_tax_number_format'] !!}</span>
                @else
                &euro; <span class="total_price_inc_tax_{!! $product['id'] !!}">{!! $product['cart']['total_price_inc_tax_number_format'] !!}</span>
                @endif
            </div>  


    </div>

    @endforeach  
    <div class="totals">
        <div class="row">  
            <div class="small-10 columns">
                Subtotaal
            </div>

            <div class="small-5 columns text-right">
                @if($shopFrontend->wholesale)
                &euro; <span class="sub_total_inc_tax">{!! $totals['sub_total_ex_tax_number_format'] !!}</span>
                @else                
                &euro; <span class="sub_total_inc_tax">{!! $totals['sub_total_inc_tax_number_format'] !!}</span>
                @endif
            </div>  
        </div>

        @if($totals['discount']) 


        <div class="row">  
            <div class="small-10 columns">
                Korting<br/>

                @if($totals['coupon']) 
                Code: {!! $totals['coupon']['code'] !!}
                @endif
            </div>

            <div class="small-5 columns text-right">
                - &euro; <span>{!! $totals['discount_number_format'] !!}</span>
            </div>  
        </div>

        @endif



        <div class="row">  
            <div class="small-10 columns">
                <strong>Verzendkosten</strong><br/> {!! $totals['sending_method']['title'] !!}
            </div>
            <div class="small-5 columns text-right">
                @if($shopFrontend->wholesale)
                &euro; <span class="sending_method_cost_ex_tax">{!! $totals['sending_method_cost_ex_tax_number_format'] !!}</span>
                @else
                &euro; <span class="sending_method_cost_inc_tax">{!! $totals['sending_method_cost_inc_tax_number_format'] !!}</span>
                @endif
            </div>  
        </div>

        @if($totals['payment_method_cost_ex_tax_number_format'] != 0)
        <div class="row">  
            <div class="small-10 columns">
                <strong>Betaalkosten</strong><br/> {!! $totals['payment_method']['title'] !!}
            </div>
            <div class="small-5 columns text-right">
                @if($shopFrontend->wholesale)
                &euro; <span class="payment_method_cost_ex_tax">{!! $totals['payment_method_cost_ex_tax_number_format'] !!}</span>
                @else
                &euro; <span class="payment_method_cost_inc_tax">{!! $totals['payment_method_cost_inc_tax_number_format'] !!}</span>
                @endif


            </div>  
        </div>
        @endif

        @if($totals['present'])
        <div class="row">  
            <div class="small-10 columns">
                <strong>Cadeaukosten:</strong>
            </div>
            <div class="small-5 columns text-right">
                &euro; <span>{!! $totals['present']['cost_inc_tax_number_format'] !!}</span>


            </div>  
        </div>

        @endif



        @if($shopFrontend->wholesale)
        <div class="row">  
            <div class="small-10 columns">
                @if($user->clientBillAddress->country == 'be')
                Totaal
                @else
                Totaal ex BTW
                @endif
      
            </div>

            <div class="small-5 columns text-right">
                &euro; <span class="total_inc_tax">{!! $totals['total_ex_tax_number_format'] !!}</span><br/>
            </div>  
        </div>
        @endif


        @if($shopFrontend->wholesale AND $user->clientBillAddress->country != 'be')
        <div class="row">  
            <div class="small-10 columns">
                BTW
            </div>

            <div class="small-5 columns text-right">
                &euro; <span class="total_inc_tax">{!! $totals['total_tax_number_format'] !!}</span><br/>
            </div>  
        </div>
        @endif


        <div class="row">  
            <div class="small-10 columns">
                Te betalen
            </div>

            <div class="small-5 columns text-right">
                @if($shopFrontend->wholesale)
                    @if($user->clientBillAddress->country == 'be') 
                    &euro; <span class="payment_method_cost_ex_tax">{!! $totals['total_ex_tax_number_format'] !!}</span>
                    @else
                    &euro; <span class="payment_method_cost_ex_tax">{!! $totals['total_inc_tax_number_format'] !!}</span>
                    @endif
                @else
                &euro; <span class="payment_method_cost_inc_tax">{!! $totals['total_inc_tax_number_format'] !!}</span>
                @endif
            </div>  
        </div>

        <div class="row button-row">
              <div class="small-15 columns text-right">
      
                <a href="/cart" class="button button-simple">bestelling wijzigen</a>
            </div>
        </div>
    </div>
</div>
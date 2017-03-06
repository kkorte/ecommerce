<tr class="product-row">

    <td class="title">
        <a href="/{{ $product['product_category_slug'] }}/{{ $product['id'] }}/{{ $product['slug'] }}" title="terug naar product"> 
            <p>{!! $product['title'] !!}</p>
            <ul>
                <li>Artnr: {!! $product['reference_code'] !!}</li>
                @if(isset($product['product_combination_title']))                                        
                @foreach($product['product_combination_title'] as $title => $value)
                    <li>{!! $title !!}: {!! $value !!}</li>
                @endforeach                                        
                @endif
            </ul>
             <a href="/cart/delete-product/{!! $product['id'] !!}" class="delete-product button button-simple">verwijder product</a>
        </a>

        <div class="price show-for-medium">
            @if($shopFrontend->wholesale)
            @if($product['cart']['price_details']['discount_price_ex'])
            &euro; {!! $product['cart']['price_details']['discount_price_ex_number_format'] !!}
            @else
            &euro; {!! $product['cart']['price_details']['orginal_price_ex_tax_number_format'] !!}
            @endif
            @else
            @if($product['cart']['price_details']['discount_price_inc'])
            &euro; {!! $product['cart']['price_details']['discount_price_inc_number_format'] !!}
            @else
            &euro; {!! $product['cart']['price_details']['orginal_price_inc_tax_number_format'] !!}
            @endif
            @endif
        </div>
    </td>

    <td class="amount">   

        @if($product['product_amount_series'])  
        {!! Form::select('amount', $product['product_amount_series_range'], $product['cart']['count'], array('class' => 'update-amount', 'data-width' => 'auto', 'data-url' => '/cart/update-amount-product/'.$product['id'])) !!}
        @else                       
        {!! Form::select('amount', array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12'),  $product['cart']['count'], array('class' => 'update-amount', 'data-width' => 'auto', 'data-url' => '/cart/update-amount-product/'.$product['id'])) !!} 
        @endif
    </td>

    <td class="total_price"> 
        @if($shopFrontend->wholesale)
        &euro; <span class="total_price_ex_tax_{!! $product['id'] !!}">{!! $product['cart']['total_price_ex_tax_number_format'] !!}</span>
        @else
        &euro; <span class="total_price_inc_tax_{!! $product['id'] !!}">{!! $product['cart']['total_price_inc_tax_number_format'] !!}</span>
        @endif
    </td>
    

</tr>
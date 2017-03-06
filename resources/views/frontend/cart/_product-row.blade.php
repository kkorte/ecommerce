<tr class="product-row">

    <td class="image show-for-medium">   
        <a href="/{{ $product['product_category_slug'] }}/{{ $product['id'] }}/{{ $product['slug'] }}" title="terug naar product">   
            @if($product['product_images']) 
            <?php $image = $product['product_images'][0]; ?>
            <img src="/files/product/100x100/{!! $image['product_id'] !!}/{!! $image['file'] !!}" alt="">
            @else
            <img src="/images/product-thumb2.jpg" />
            @endif
        </a>
    </td>

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
        </a>
    </td>

    <td class="price show-for-medium">
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
    </td>

    <td class="amount">   

        @if($product['product_amount_series'])  
        {!! Form::select('amount', $product['product_amount_series_range'], $product['cart']['count'], array('class' => 'update-amount', 'data-width' => 'auto', 'data-url' => '/cart/update-amount-product/'.$product['id'])) !!}
        @else                       
        <input type="text" class="update-amount" value="{!! $product['cart']['count'] !!}" data-width="auto" data-url="/cart/update-amount-product/{!! $product['id'] !!}" />       
        @endif

    </td>

    <td class="total_price"> 
        @if($shopFrontend->wholesale)
        &euro; <span class="total_price_ex_tax_{!! $product['id'] !!}">{!! $product['cart']['total_price_ex_tax_number_format'] !!}</span>
        @else
        &euro; <span class="total_price_inc_tax_{!! $product['id'] !!}">{!! $product['cart']['total_price_inc_tax_number_format'] !!}</span>
        @endif
    </td>
    
    <td class="delete">             
        <a href="/cart/delete-product/{!! $product['id'] !!}" class="delete-product">X</a>
    </td>
</tr>
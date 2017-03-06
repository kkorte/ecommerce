<h3>Winkelwagen</h3>
@if ($products)
<table>
    <tbody>

        @foreach ($products as $product)
        <tr class="cart-product-row">
            <td class="amount">{!! $product['amount'] !!}x</td>
            <td class="image">
                <a href="/{{ $product['product_category_slug'] }}/{{ $product['id'] }}/{{ $product['slug'] }}">

                    @if($product['product_images']) 
                    <?php $image = $product['product_images'][0]; ?>
                    <img src="/files/product/100x100/{!! $image['product_id'] !!}/{!! $image['file'] !!}" alt="">
                    @else
                    <img src="/images/product-thumb2.jpg" />
                    @endif
                </a>

            </td>
            <td>
                <a href="/{{ $product['product_category_slug'] }}/{{ $product['id'] }}/{{ $product['slug'] }}">

                    {!! $product['title'] !!}
                    @if(isset($product['product_combination_title']))
                    <ul>
                        @foreach($product['product_combination_title'] as $title => $value)
                        <li>{!! $title !!}: {!! $value !!}</li>
                        @endforeach
                    </ul>
                    @endif
                    
                </a>
            </td>
            <td class="price">
                @if($shopFrontend->wholesale)
                &euro; <span class="total_price_ex_tax_{{ $product['id'] }}">{{ $product['cart']['total_price_ex_tax_number_format'] }}</span>
                @else
                &euro; <span class="total_price_inc_tax_{{ $product['id'] }}">{{ $product['cart']['total_price_inc_tax_number_format'] }}</span>
                @endif
          </td>
        </tr>
        @endforeach 

        <tr class="total">
            @if($shopFrontend->wholesale)
            <td colspan="4"><strong>Totaal: &euro; {!! $cartTotals['sub_total_ex_tax_number_format'] !!}</strong></td>
            @else
            <td colspan="4"><strong>Totaal: &euro; {!! $cartTotals['sub_total_inc_tax_number_format'] !!}</strong></td>
            @endif
        </tr>

    </tbody>    
</table>
<a href="/winkelwagen" class="button float-right button-black">Afronden</a>
@else 
<p>leeg</p>
@endif
<div class="row">
    <div class="small-15 medium-15 large-15 columns">
        <hr/>
        <div class="order-block">
            <h3>Bestellingen</h3>
            @if($user->orders->count()) 
            <table>

                <thead>
                    <tr>
                        <th>Datum</th>
                        <th class="title ">Nummer</th>
                        <th class="price show-for-medium">Prijs</th>
                        <th class="amount">Status</th>
                        <th>&nbsp;</th>

                </thead>

                <tbody>

                    @foreach($user->orders()->where('shop_id', '=', $user->shop->id)->orderBy('created_at', 'DESC')->get() as $order)
                    <tr>
                        <td>{!! date('d F Y', strtotime($order->created_at)) !!}</td>
                        <td>{!! $order->generated_custom_order_id !!}</td>
                        <td>&euro; {!! $order->price_with_tax !!}</td>

                        <td>@if($order->orderStatus) {!! $order->orderStatus->title !!} @else geen status @endif</td>
                        <td class="text-right">
                            <a href="/account/download-order/{!! $order->id !!}" class="button button-simple">download</a> 
                            <a href="/account/re-order/{!! $order->id !!}" class="button">herbestellen</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @else

            geen bestellingen.
            @endif
        </div>

    </div>

</div>

@if($orderProducts)
<div class="row">
    <div class="small-15 medium-15 large-15 columns">
        <hr/>
         <div class="re-order order-block">
            <h3>Favoriete producten</h3>
            @if($orderProducts->count())
            <p>Hieronder ziet u de laatste 10 bestelde producten. Voor een compleet overzicht klik <a href="/account/re-order-all">hier</a></p>
            
            <?php echo Form::open(array('route' => array('account.re.order.all'), 'class' => 'form', 'data-abide' => '', 'novalidate' => '')); ?>


            <table>

                <thead>
                    <tr>
                        <th>Hoeveelheid</th>
                        <th>Product</th>
                        <th>Op voorraad</th>

                        <th>In winkelwagen</th>
                    </tr>
                </thead>

                <tbody>


                    @foreach($orderProducts as $orderProduct)

                    <tr>
                        <td>
                            @if($orderProduct->product)                                       
                            


                                @if($orderProduct->product->amountSeries()->where('active', '=', '1')->count())
                                <input type="hidden" name="products[{!! $orderProduct->product_id !!}][product_amount_series]" value="1"> 
                                {!! Form::select('products['.$orderProduct->product_id.'][amount]', $orderProduct->product->amountSeries()->where('active', '=', '1')->first()->range(), null, array('class' => 'form-control')) !!}
                                @else
                                <input type="text" name="products[{!! $orderProduct->product_id !!}][amount]" size="5" value="{!! $orderProduct->amount !!} " />

                                @endif



                            @endif
                          
                        </td>
                        <td>{!! $orderProduct->title !!}</br>
                            {!! $orderProduct->product_attribute_title !!} 
                        </td>
                        <td>
                            @if($orderProduct->product AND $orderProduct->product->active AND $orderProduct->product->amount > 0)
                            ja
                            @else
                            nee
                            @endif

                        </td>
                        <td>

                            @if($orderProduct->product AND $orderProduct->product->active AND $orderProduct->product->amount > 0)
                            <input type="checkbox" name="products[{!! $orderProduct->product_id !!}][checked]"  checked="checked" />
                            <input type="hidden" name="products[{!! $orderProduct->product_id !!}][product_attribute_id]" value="{!! $orderProduct->product_attribute_id !!}" />
                            @else
                            
                            @endif

                            

                        </td>
                    </tr>


                    @endforeach

                </tbody>

            </table>


                    <div class="float-right">
                        <button type="submit" class="button btn-default">In winkelwagen plaatsen</button>
                    </div>

                </form>

                @else
                <p>Nog geen bestellingen gedaan</p>
                @endif

        </div>
    </div>

</div>
@endif


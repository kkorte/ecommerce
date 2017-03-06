@extends('frontend._layouts.default')

@section('main') 

<div class="breadcrumb">
    <div class="row">
        <div class="small-15 medium-12 large-15 columns">
            <nav aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs">
                    <li><a href="/">Home</a></li>
                    <li><a href="/account">Account</a></li>
                    <li class="active"><a href="#">Herbestellen</a></li>

                </ul>
            </nav>
        </div>
    </div>
</div>

<div class="account">
    <div class="row">
        <div class="small-15 medium-15 large-15  columns">
            <div class="re-order order-block">
                <h3>Herbestellen</h3>
                <p>Je kan hieronder nogmaals de bestelling in de winkwagen plaatsen.</p>
                <?php echo Form::open(array('route' => array('account.re.order', $order->id), 'class' => 'form', 'data-abide' => '', 'novalidate' => '')); ?>

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

                            @if($order->products)

                            @foreach($order->products as $product)
                            <tr>
                                <td>
                                    @if($product->product)                                       
                                    
 
                            
                                @if($product->product->amountSeries()->where('active', '=', '1')->count())
                                <input type="hidden" name="products[{!! $product->product_id !!}][product_amount_series]" value="1"> 
                                {!! Form::select('products['.$product->product_id.'][amount]', $product->product->amountSeries()->where('active', '=', '1')->first()->range(), null, array('class' => 'form-control')) !!}
                                @else
                                <input type="text" name="products[{!! $product->product_id !!}][amount]" size="5" value="{!! $product->amount !!} " />

                                @endif

                            

                                    @endif
                                  
                                </td>
                                <td>{!! $product->title !!}</br>
                                    {!! $product->product_attribute_title !!} 
                                </td>
                                <td>
                                    @if($product->product AND $product->product->active AND $product->product->amount > 0)
                                    ja
                                    @else
                                    nee
                                    @endif

                                </td>
                                <td>

                                    @if($product->product AND $product->product->active AND $product->product->amount > 0)
                                    <input type="checkbox" name="products[{!! $product->product_id !!}][checked]"  checked="checked" />
                                    <input type="hidden" name="products[{!! $product->product_id !!}][product_attribute_id]" value="{!! $product->product_attribute_id !!}" />
                                    @else
                                    
                                    @endif

                                    

                                </td>
                            </tr>
                            @endforeach

                            @endif
                        </tbody>
                </table>

                    <div class="float-right">
                        <a href="/account" class="button button-grey">Annuleer</a>
                        <button type="submit" class="button btn-default">In winkelwagen</button>
                    </div>
                </div>

</form>



            </div>



        </div>





    </div>
    @stop
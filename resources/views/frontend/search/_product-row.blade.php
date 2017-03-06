@if($product->productImages AND $product->productCategory)

<div class="small-15 medium-15 large-15 columns">
    <div class="product-block" data-equalizer-watch>

        <div class="row">

            <div class="small-4 medium-2 large-3 columns">
                <div class="image"> 
                    <a href="/{{ $product->productCategory->slug }}/{{ $product->id }}/{{ $product->slug }}" title="ga naar {{ $product->title }}">
                        @if($product->productImages->count())
                        <img src="/files/product/200x200/{!! $product->productImages->first()->product_id !!}/{!! $product->productImages->first()->file !!}" class="img-responsive main-photo" alt="" />
                        @endif
                        <div class="overlay"></div>
                    </a>
                </div>
            </div>

            <div class="small-10 medium-8 large-7 columns">
                <div class="text"> 
                    <a href="/{{ $product->productCategory->slug }}/{{ $product->id }}/{{ $product->slug }}" title="ga naar {{ $product->title }}">

                        <h3>{{ $product->title }}</h3>
                        <p>{!! $product->short_description !!}</p>
                    </a>
                </div>
            </div>

            <div class="small-5 show-for-medium  medium-5 large-5 columns text-right">


                <div class="order">

                    @if($shopFrontend->wholesale AND !Auth::guard('web')->check())
                    <a href="/{{ $product->productCategory->slug }}/{{ $product->id }}/{{ $product->slug }}" class="button">bekijk</a>

                    @else 

                    @if($shopFrontend->wholesale)
                    <p class="price">
                    @if($product->getPriceDetails()['discount_price_ex'])
                    <span>&euro; {!! $product->getPriceDetails()['orginal_price_ex_tax_number_format'] !!}</span>
                    &euro; {!! $product->getPriceDetails()['discount_price_ex_number_format'] !!}
                    @else 
                    &euro; {!! $product->getPriceDetails()['orginal_price_ex_tax_number_format'] !!}
                    @endif 
                    </p>

                    @else
                    <p class="price">
                    @if($product->getPriceDetails()['discount_price_inc'])
                    <span>&euro; {!! $product->getPriceDetails()['orginal_price_inc_tax_number_format'] !!}</span>
                    &euro; {!! $product->getPriceDetails()['discount_price_inc_number_format'] !!}
                    @else 
                    &euro; {!! $product->getPriceDetails()['orginal_price_inc_tax_number_format'] !!}
                    @endif 
                    </p>

                    @endif
                
                    @if($product->getPriceDetails()['amount'] <= 0)
                    <div class="button-group ">
                        <button type="button" class="button add-to-cart-button btn-blue btn-long" disabled="disabled">
                            Uitverkocht
                        </button>
                        <a href="/{{ $product->productCategory->slug }}/{{ $product->id }}/{{ $product->slug }}" class="button">bekijk</a>
                    </div>

                    @else

                    @if($product->attributes->count())
                    <div class="button-group ">
                     <button class="button add-to-cart-button-popup" data-url="/product/buy-dialog/{!! $product->id !!}">in winkelwagen</button> 
                     <a href="/{{ $product->productCategory->slug }}/{{ $product->id }}/{{ $product->slug }}" class="button">bekijk</a>
                    </div>

                     @else 
                     {!! Form::open(array('route' => array('cart.add.product', $product['id']), 'class' => 'add-product', 'data-gtm-product' => GoogleTagManager::dump(array('id' => $product->id, 'title' => $product->title)))) !!}

                    <input type="hidden" name="product_id" value="{!! $product['id'] !!}"> 

                    @if($product->amountSeries()->where('active', '=', '1')->count())
                    <input type="hidden" name="product_amount_series" value="1"> 

                    <input type="hidden" class="form-control"  name="amount" value="{!! key($product->amountSeries()->where('active', '=', '1')->first()->range()) !!}" size="2" maxlength="2" >

                    @else
                    <input type="hidden" class="form-control"  name="amount" value="1" size="2" maxlength="2" >

                    @endif

                     <div class="button-group ">
                        <button class="button add-to-cart-button" >in winkelwagen</button>
                        <a href="/{{ $product->productCategory->slug }}/{{ $product->id }}/{{ $product->slug }}" class="button">bekijk</a>
                    </div>

                    </form>

                    @endif
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>                  
</div>
@endif
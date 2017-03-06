<div class="small-5 medium-5 large-5 columns">
    @include('frontend.product._images')
</div>
<div class="columns large-offset-1 small-9 medium-9 large-9">
    <h1>{!! $product->title !!}</h1>
    <h3 class="price">
        @if($shopFrontend->wholesale)
        @if(Auth::guard('web')->check())
        @if($priceDetails['discount_price_ex'])                        
        &euro; {!! $priceDetails['discount_price_ex_number_format'] !!}
        <span>&euro; {!! $priceDetails['orginal_price_ex_tax_number_format'] !!}</span>

        @else 
        &euro; {!! $priceDetails['orginal_price_ex_tax_number_format'] !!}
        @endif 
        @endif

        @else
        @if($priceDetails['discount_price_inc'])                        
        &euro; {!! $priceDetails['discount_price_inc_number_format'] !!}
        <span>&euro; {!! $priceDetails['orginal_price_inc_tax_number_format'] !!}</span>
        @else 
        &euro; {!! $priceDetails['orginal_price_inc_tax_number_format'] !!}
        @endif 
        @endif 
                
    </h3>

    @if($shopFrontend->wholesale AND $priceDetails['commercial_price_number_format'] AND Auth::guard('web')->check())
    <h6 class="commercial_price">Adviesprijs: &euro; {!! $priceDetails['commercial_price_number_format'] !!}</h6>
    @endif

    <div class="description">

        <p>{!! $product->short_description !!}</p>
   
    </div>

    @if($shopFrontend->wholesale AND !Auth::guard('web')->check())
    <div class="wholesale-login">
    <a href="/account" class="button">inloggen</a>
    <p>u dient in te loggen om de prijzen te zien.</p>
    </div>
    <hr/>
    @else    

    <div class="row">
        <div class="columns small-15">

            <div class="order-block">
                <hr/>

                @if($productAttributeId)
                {!! Form::open(array('route' => array('cart.add.product', $product['id'], $productAttributeId), 'class' => 'add-product', 'data-gtm-product' => GoogleTagManager::dump(array('id' => $product->id, 'title' => $product->title)))) !!}
                @else
                {!! Form::open(array('route' => array('cart.add.product', $product['id']), 'class' => 'add-product', 'data-gtm-product' => GoogleTagManager::dump(array('id' => $product->id, 'title' => $product->title)))) !!}
                @endif
    
                <div class="variations">

                    @if($newPullDowns)
                    @foreach($newPullDowns as $key => $row)

                    @if($firstPulldown === $key)
                        <label>{!! $key !!}</label>        
                        {!! Form::select('first_pulldown['.$key.']', $row, $leadAttributeId, array("data-url" => "/product/select-leading-pulldown/".$product['id'], "class" => "leading-product-combination-select selectpicker pulldown-$key")) !!}
          
                    @else
                    <div class="row"> 
                        <div class="col-lg-12">
                            
                            @if($leadAttributeId)
                            {!! Form::select('pulldown['.$key.']', array('0' => 'selecteer een optie') + $row, $secondAttributeId, array("data-url" => "/product/select-second-pulldown/".$product['id']."/".$leadAttributeId, "class" => "selectpicker pulldown pulldown-$key")) !!}

                            @else 
                            {!! Form::select('pulldown['.$key.']', array('0' => 'selecteer een optie') + $row, $secondAttributeId, array("data-url" => "/product/select-second-pulldown/".$product['id'], "class" => "selectpicker pulldown pulldown-$key")) !!}
                            @endif
                            <label>{!! $key !!}</label>
                        </div>
                        
                    </div>                        
                    @endif
                    @endforeach
                    @endif

                </div>

                @if($priceDetails['amount'] <= 0)
               <div class="button-group">
                        <button type="button" class="button btn add-to-cart-button" disabled="disabled">
                        Uitverkocht
                        </button>
                        <a href="#" class="button button-simple out-of-stock" data-url="/product/waiting-list/{!! $product->id !!}/{!! $productAttributeId !!}">Wanneer op voorraad?</a>
                    </div>
                @else

                <input type="hidden" name="product_id" value="{!! $product['id'] !!}"> 
                
                @if($product->amountSeries()->where('active', '=', '1')->count())
                <input type="hidden" name="product_amount_series" value="1"> 
                {!! Form::select('amount', $product->amountSeries()->where('active', '=', '1')->first()->range(), null, array('class' => 'form-control')) !!}
                @else
                <input type="hidden" class="form-control"  name="amount" value="1" size="2" maxlength="2" >
                
                @endif

                @if($pullDownsCount === 1 OR $secondAttributeId)
                <button type="button" class="button add-to-cart-button">In winkelwagen</button>
                @else
                <span class="hint--right" data-hint="Selecteer hierboven eerst een {!! $key !!}">
                    <button type="button" class="button add-to-cart-button" disabled="disabled">In winkelwagen</button>
                </span>
                @endif
                @endif
                </form>

            </div>


        </div>

    </div>                 

    <hr/>

    @endif 
    
    <div class="description">

        {!! $product->description !!}
    </div>
    
    @if($product->ingredients)
    <div class="ingredients">
        <ul class="accordion" data-accordion data-allow-all-closed="true">
          <li class="accordion-item" data-accordion-item>
            <a href="#" class="accordion-title">Ingredienten</a>
            <div class="accordion-content" data-tab-content>
                 {!! $product->ingredients !!}
            </div>
          </li>
        </ul>
    </div>
    @endif

</div>
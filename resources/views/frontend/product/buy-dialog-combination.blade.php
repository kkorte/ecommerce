<div class="buy-dialog">


	 <div class="row product-container">

	 	<div class="large-5 columns">
	 		@if ($product->productImages)
	 		               <div class="photos photo-container">

	 			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-6">
	 				<a href="/files/product/800x800/{!! $product->productImages->first()->product_id !!}/{!! $product->productImages->first()->file !!}">
	 					<img src="/files/product/400x400/{!! $product->productImages->first()->product_id !!}/{!! $product->productImages->first()->file !!}" class="img-responsive main-photo" alt="" />
	 				</a>
	 			</div>  



	 		</div>
	 		@else
	 		<div class="row">
	 			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	 				<img src="{!! URL::asset('images/default-thumb.jpg') !!}" alt="no image" class="img-responsive">
	 			</div>
	 		</div>
	 		@endif
	 	</div>






	 	<div class="columns large-offset-1  large-9">
	 		<h1>{!! $product->title !!}</h1>
	 		<p>{!! $product->short_description !!}</p>


            <div class="row">
                <div class="columns small-7">

     
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
                            
                </div>

                <div class="columns small-8">




			 		<div class="order-block">

                    @if(BrowserDetect::isMobile() )
	 			@if($productAttributeId)
			 			{!! Form::open(array('route' => array('cart.add.product', $product['id'], $productAttributeId), 'class' => 'add-product add-product-mobile', 'data-gtm-product' => GoogleTagManager::dump(array('id' => $product->id, 'title' => $product->title)))) !!}
			 			@else
			 			{!! Form::open(array('route' => array('cart.add.product', $product['id']), 'class' => 'add-product add-product-mobile', 'data-gtm-product' => GoogleTagManager::dump(array('id' => $product->id, 'title' => $product->title)))) !!}
			 			@endif

                    @else
			 			@if($productAttributeId)
			 			{!! Form::open(array('route' => array('cart.add.product', $product['id'], $productAttributeId), 'class' => 'add-product', 'data-gtm-product' => GoogleTagManager::dump(array('id' => $product->id, 'title' => $product->title)))) !!}
			 			@else
			 			{!! Form::open(array('route' => array('cart.add.product', $product['id']), 'class' => 'add-product', 'data-gtm-product' => GoogleTagManager::dump(array('id' => $product->id, 'title' => $product->title)))) !!}
			 			@endif
			 			@endif



			 			<div class="variations">

			 				@if($newPullDowns)
			 				@foreach($newPullDowns as $key => $row)

			 				@if($firstPulldown === $key)
			 	
			 						<label>{!! $key !!}</label>
			 						{!! Form::select('first_pulldown['.$key.']', $row, $leadAttributeId, array("data-url" => "/product/select-leading-pulldown-dialog/".$product['id'], "class" => "leading-product-combination-select selectpicker pulldown-$key")) !!}
			 		
			 				@else
			 		
			 						<label>{!! $key !!}</label>
			 						@if($leadAttributeId)
			 						{!! Form::select('pulldown['.$key.']', array('0' => 'selecteer een optie') + $row, $secondAttributeId, array("data-url" => "/product/select-second-pulldown/".$product['id']."/".$leadAttributeId, "class" => "selectpicker pulldown pulldown-$key")) !!}

			 						@else 
			 						{!! Form::select('pulldown['.$key.']', array('0' => 'selecteer een optie') + $row, $secondAttributeId, array("data-url" => "/product/select-second-pulldown/".$product['id'], "class" => "selectpicker pulldown pulldown-$key")) !!}
			 						@endif
			 		                       
			 				@endif
			 				@endforeach
			 				@endif

			 			</div>

			 			@if($priceDetails['amount'] <= 0)
                            <div class="button-group">
                                <button type="button" class="button btn add-to-cart-button" disabled="disabled">
                                Uitverkocht
                                </button>
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
			 			<button type="button" class="button add-to-cart-button">
			 				<span class="icon icon-cart"></span> In winkelwagen
			 			</button>
			 			@else
			 			<span class="hint--right" data-hint="Selecteer hierboven eerst een {!! $key !!}">
			 				<button type="button" class="button add-to-cart-button" disabled="disabled">
			 					<span class="icon icon-cart"></span> In winkelwagen
			 				</button>
			 			</span>
			 			@endif
			 			@endif
			 			</form>

			 		</div>
			 	</div>

		</div>
	</div>

	 <button class="close-button" data-close aria-label="Close reveal" type="button">
	 	<span aria-hidden="true">&times;</span>
	 </button>
</div>
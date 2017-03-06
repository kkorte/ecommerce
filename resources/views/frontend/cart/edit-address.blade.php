@extends('frontend._layouts.default')

@section('main')

<div class="breadcrumb">

	<div class="row">
		<div class="small-15 columns">
			<ul class="breadcrumbs">
				<li><a href="/">Home</a></li>
				<li><a href="/cart">Winkelwagen</a></li>
				<li><a href="#">Bestelling plaatsen</a></li>
			</ul>
		</div>
	</div>
</div>

<div class="main-cart-login">
	<div class="row">

		<div class="small-15 medium-5 large-4 columns">
			@include('frontend.cart._summary')
		</div>  

		<div class="small-15 medium-9 large-10 medium-offset-1 large-offset-1 columns">  
			<div class="confirm-page">     
				<div class="row">
					<div class="small-15 medium-15 large-7 columns">
						{!! Notification::showAll() !!}
						<h3>Factuuradres</h3>

						@if($type == 'bill')
						@notification('foundation')
						{!! Form::model($user->clientBillAddress, array('method' => 'post', 'url' => array('/cart/edit-address/bill'), 'files' => true, 'class' => 'box login')) !!}

							@include('frontend.cart._default_account_fields')         

							<a href="/cart/checkout" class="button button-grey">Annuleer</a>
							<button type="submit" class="button btn-default">Wijzig</button>

						{!! Form::close() !!}

						@else

						@if($user->clientBillAddress)             
						<ul>
							<li>{!! $user->clientBillAddress->firstname !!} {!! $user->clientBillAddress->lastname !!}</li>
							<li>{!! $user->clientBillAddress->street !!} {!! $user->clientBillAddress->housenumber !!} {!! $user->clientBillAddress->housenumber_suffix !!}</li>
							<li>{!! $user->clientBillAddress->zipcode !!} {!! $user->clientBillAddress->city !!}</li>
							<li>
								@if($user->clientBillAddress->country == 'nl')
								Nederland
								@elseif($user->clientBillAddress->country == 'be')
								Belgie
								@endif
							</li>
							<li>{!! $user->clientBillAddress->phone  !!}</li>
						</ul>
						<a href="/cart/edit-address/bill" class="button button-simple">Wijzig factuuradres</a>
						@endif
						@endif

					</div>

					<div class="small-15 medium-15 large-7 columns">
						@if($user->clientDeliveryAddress)
						<h3>Afleveradres</h3>
						@if($type == 'delivery')
						@notification('foundation')
						{!! Form::model($user->clientDeliveryAddress, array('method' => 'post', 'url' => array('/cart/edit-address/delivery'), 'files' => true, 'class' => 'box login')) !!}

						@include('frontend.cart._default_account_fields')       

						<a href="/cart/checkout" class="button button-grey">Annuleer</a>
						<button type="submit" class="button btn-default">Wijzig</button>

						{!! Form::close() !!}

						@else

						<ul>
							<li>{!! $user->clientDeliveryAddress->firstname !!} {!! $user->clientDeliveryAddress->lastname !!}</li>
							<li>{!! $user->clientDeliveryAddress->street !!} {!! $user->clientDeliveryAddress->housenumber !!} {!! $user->clientDeliveryAddress->housenumber_suffix !!}</li>
							<li>{!! $user->clientDeliveryAddress->zipcode !!} {!! $user->clientDeliveryAddress->city !!}</li>
							<li>
								@if($user->clientDeliveryAddress->country == 'nl')
								Nederland
								@elseif($user->clientDeliveryAddress->country == 'be')
								Belgie
								@endif
							</li>
							<li>{!! $user->clientDeliveryAddress->phone  !!}</li>

						</ul>
						<a href="/cart/edit-address/delivery" class="button button-simple">Wijzig afleveradres</a>
						@endif
						@endif

					</div>


				</div>
			</div>

		</div>
	</div>
</div>
@stop
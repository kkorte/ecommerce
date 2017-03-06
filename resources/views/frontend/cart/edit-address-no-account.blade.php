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

<div class="main-cart main-cart-login">
	<div class="row">

		<div class="small-15 medium-5 large-4 columns">
			@include('frontend.cart._summary')
		</div>  

		<div class="small-15 medium-9 large-10 medium-offset-1 large-offset-1 columns">  
			<div class="confirm-page">   

				<div class="row">
					<div class="small-15 medium-15 large-7 columns">

						<h3>Factuuradres</h3>
						@if($type == 'bill')
						@notification('foundation')
						{!! Form::model($clientAddress, array('method' => 'post', 'url' => array('/cart/edit-address/bill'), 'files' => true, 'class' => 'box login')) !!}

						@include('frontend.cart._default_account_fields')     

						<a href="/cart/checkout" class="button button-grey">Annuleer</a>
						<button type="submit" class="button btn-default">Wijzig</button>

						{!! Form::close() !!}

						@else
				
						<ul>
							<li>{!! $noAccountUser['firstname'] !!} {!! $noAccountUser['lastname']  !!}</li>
							<li>{!! $noAccountUser['email']  !!}</li>
							<li>&nbsp;</li>
							<li>{!! $noAccountUser['street']  !!} {!! $noAccountUser['housenumber']  !!} {!! $noAccountUser['housenumber_suffix']  !!}</li>
							<li>{!! $noAccountUser['zipcode']  !!} {!! $noAccountUser['city']  !!}</li>
							<li>
								@if($noAccountUser['country'] == 'nl')
								Nederland
								@elseif($noAccountUser['country'] == 'be')
								Belgie
								@endif
							</li>
							<li>{!! $noAccountUser['phone']  !!}</li>
						</ul>
						<a href="/cart/edit-address/bill" class="button button-simple">Wijzig factuuradres</a>

				
						@endif

					</div>

					<div class="small-15 medium-15 large-7 columns">

						<h3>Afleveradres</h3>

						@if($type == 'delivery')
						@notification('foundation')
						{!! Form::model($clientAddress, array('method' => 'post', 'url' => array('/cart/edit-address/delivery'), 'files' => true, 'class' => 'box login')) !!}

						@include('frontend.cart._default_account_fields')     

						<a href="/cart/checkout" class="button button-grey">Annuleer</a>
						<button type="submit" class="button btn-default">Wijzig</button>

						{!! Form::close() !!}

						@else
						<ul>
							<li>{!! $noAccountUser['delivery']['firstname']  !!} {!! $noAccountUser['delivery']['lastname']  !!}</li>
							<li>{!! $noAccountUser['delivery']['email']  !!}</li>
							<li>&nbsp;</li>

							<li>{!! $noAccountUser['delivery']['street']  !!} {!! $noAccountUser['delivery']['housenumber']  !!} {!! $noAccountUser['delivery']['housenumber_suffix']  !!}</li>
							<li>{!! $noAccountUser['delivery']['zipcode']  !!} {!! $noAccountUser['delivery']['city']  !!}</li>

							<li>
								@if($noAccountUser['delivery']['country'] == 'nl')
								Nederland
								@elseif($noAccountUser['delivery']['country'] == 'be')
								Belgie
								@endif
							</li>
							<li>{!! $noAccountUser['delivery']['phone']  !!}</li>


						</ul>
						<a href="/cart/edit-address/delivery" class="button button-simple">Wijzig afleveradres</a>
						@endif

					</div>

				</div>
			</div>
		</div>
	</div>
</div>
@stop
@extends('frontend._layouts.default')

@section('main')

<div class="homepage-highlights">
	<div class="row">
		<div class="col-sm-3 col-md-3 col-lg-6">
			<a href="/pants" title="pants">
				<div class="highlight homepage-highlight-big">
					<h3>Pants</h3>
				</div>
			</a>
		</div>

		<div class="col-sm-3 col-md-3 col-lg-3">
			<a href="/dresses" title="dresses">
				<div class="highlight homepage-highlight-small">
					<h3>Dresses</h3>	
				</div>
			</a>
		</div>

		<div class="col-sm-3 col-md-3 col-lg-3">
			<a href="/hats" title="dresses">
				<div class="highlight homepage-highlight-small2">
					<h3>Hats</h3>
				</div>
			</a>
		</div>


	</div>
</div>

@if($populairProducts)
<h3>Populair products</h3>

@endif




@stop
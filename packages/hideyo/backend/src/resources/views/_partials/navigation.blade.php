<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Beheer</a>

		<ul class="nav navbar-nav">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{!! $this_user->shop->title !!} <span class="caret"></span></a>
				<ul class="dropdown-menu">

					@foreach($available_shops as $shop)

					<li><a href="{{ URL::route('change.language.profile', array('shopId' => $shop->id)) }}">{!! $shop->title !!}</a></li>
					@endforeach
				</ul>
			</li>

		</ul>
			
		</div>

	


		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="{{ URL::route('hideyo.shop.index') }}">Shops</a></li>
				<li><a href="{{ URL::route('hideyo.client.index') }}">Clients</a></li>     

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Orders <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="{{ URL::route('hideyo.order.index') }}">Overview</a></li>
		
						<li><a href="{{ URL::route('hideyo.order-status.index') }}">Statuses</a></li>
						<li><a href="{{ URL::route('hideyo.order-status-email-template.index') }}">Status email templates</a></li>
					</ul>
				</li>                        
		

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Coupons <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="/admin/coupon">Coupons</a></li>
						<li><a href="/admin/coupon-group">Groups</a></li>
					</ul>
				</li>


				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Catalog <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="{{ URL::route('hideyo.product.index') }}">Products</a></li>
						<li><a href="/admin/product-category">Categories</a></li>
						<li><a href="/admin/brand">Brands</a></li>
						<li><a href="/admin/product-tag-group">Product tag groups</a></li>
						<li><a href="/admin/extra-field">Extra fields</a></li>
						<li><a href="/admin/attribute-group">Attribute groups</a></li>
						<li><a href="/admin/product-waiting-list">Product waiting list</a></li>
					</ul>
				</li>


				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Content <span class="caret"></span></a>
					<ul class="dropdown-menu">
								<li><a href="/admin/news">News</a></li>
						<li><a href="/admin/news-group">News group</a></li>
						<li><a href="/admin/content">Static content</a></li>
						<li><a href="/admin/content-group">Static content groups</a></li>
						<li><a href="/admin/html-block">HTML blocks</a></li>
						<li><a href="/admin/faq">Faq items</a></li>
						<li><a href="/admin/landing-page">Landingpages</a></li>
					</ul>
				</li>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin settings <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="{{ URL::route('hideyo.tax-rate.index') }}">Tax rates</a></li>
						<li><a href="{{ URL::route('hideyo.sending-method.index') }}">Sending methods</a></li>
						<li><a href="{{ URL::route('hideyo.payment-method.index') }}">Payment methods</a></li>
						<li><a href="/admin/user">Users</a></li>
						<li><a href="{{ URL::route('hideyo.sending-payment-method-related.index') }}">Order templates</a></li>
						<li><a href="{{ URL::route('hideyo.general-setting.index') }}">General settings</a></li>
						<li><a href="/admin/error">Errors</a></li>
						<li><a href="/admin/redirect">Redirects</a></li>
					</ul>
				</li>
				<li><a href="/admin/security/logout">Log-out</a></li>
			</ul>

		</div>
	</div>
</nav>


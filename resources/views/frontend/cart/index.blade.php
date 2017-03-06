@extends('frontend._layouts.default')

@section('main')

<div class="breadcrumb">

    <div class="row">
        <div class="small-15 columns">
            <ul class="breadcrumbs">
                <li><a href="/">Home</a></li>
                <li><a href="/cart">Winkelwagen</a></li>
                <li><a href="#">overzicht</a></li>
            </ul>
        </div>
    </div>

</div>

<div class="main-cart">
    <div class="row">
        <div class="small-15 medium-15 large-15 columns">
            <h1>Winkelwagen</h1>
            @if (Auth::guard('web')->check())
            <p class="cart-intro">Klik <a href="/account/re-order-all">hier</a> om eerder bestelde producten toe te voegen aan de winkelwagen.</p>
            @endif
            @notification('foundation')

            @if ($products)
            <div class="cart-details">

                <table class="details">
                    <thead>
                        <tr>
                            <th class="show-for-medium">&nbsp;</th>
                            <th class="title ">Product</th>
                            <th class="price show-for-medium">Prijs</th>
                            <th class="amount">Aantal</th>
                            <th class="price text-right">Totaal</th>
                            <th>&nbsp;</th>               
                        </tr>
                    </thead>
                    <tbody class="cart-details-container">

                        @foreach ($products as $product)
                        @include('frontend.cart._product-row')                      
                        @endforeach

                        <tfoot class="cart-reload" data-url="/cart/total-reload" >
                        
                        @include('frontend.cart._totals')

                        </tfoot>

                    </tbody>

                </table>         

            </div>

            @else

            @if(HtmlBlockHelper::findByPosition("empty-cart-text"))  
            {!! HtmlBlockHelper::findByPosition("empty-cart-text") !!}
            @else 

            <p>Winkelwagen is leeg.</p>

            @endif


            @if($populairProducts)
            <div class="most-populair">
                <div class="row">
                    <div class="small-15 medium-15 large-15 columns ">

                        <h2>Bekijk onze populaire producten</h2>
                        
                        <div class="row">
                            @foreach($populairProducts as $product)
                            <div class="small-5 medium-3 large-3 columns ">
                                <div class="block">
                                    <a href="/{{ $product->productCategory->slug }}/{{ $product->id }}/{{ $product->slug }}">
                                        <div class="image"> 
                                            @if($product->productImages->count())
                                            <img src="/files/product/200x200/{!! $product->productImages->first()->product_id !!}/{!! $product->productImages->first()->file !!}" class="img-responsive main-photo" alt="" />
                                            @endif
                                            <div class="overlay"></div>                              
                                        </div>
                                        <h3>{!! $product->title !!}</h3>

                                        @if($shopFrontend->wholesale)
                                        <p class="price"><strong>&euro; {{ $product->getPriceDetails()['orginal_price_ex_tax_number_format'] }}</strong></p>
                                        @else
                                        <p class="price"><strong>&euro; {{ $product->getPriceDetails()['orginal_price_inc_tax_number_format'] }}</strong></p>
                                        
                                        @endif
                                    </a>
                                </div>
                            </div>
                            @endforeach
                           

                        </div>

                        

                    </div>

                </div>

            </div>

            @endif

            @endif
        </div>

    </div>
</div>
@stop
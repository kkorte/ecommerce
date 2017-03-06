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
            @notification('foundation')

            @if ($products)
            <div class="cart-details cart-details-mobile">
                <table class="details">

                    <tbody class="cart-details-container">
                        
                        @foreach ($products as $product)
                        @include('frontend.cart._product-row-mobile')  
                        @endforeach

                    </tbody>

                    <tfoot class="cart-reload" data-url="/cart/total-reload-mobile" >
                    
                    @include('frontend.cart._totals-mobile')

                    </tfoot>


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
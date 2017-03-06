@extends('frontend._layouts.default')

@section('main')

<div class="breadcrumb">
    <div class="row">
        <div class="small-15 medium-12 large-15 columns">
            <nav aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs">
                    <li><a href="/">Home</a></li>
                    <li><a href="#">Aanbiedingen</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<div class="products">

    <div class="row">

        <div class="small-15 medium-15  large-offset-4 large-11 columns">

            <div class="row">
                <div class="small-15 medium-8 large-8 columns">  

                    @if(HtmlBlockHelper::findByPosition("sale-products-text"))  
                    {!! HtmlBlockHelper::findByPosition("sale-products-text") !!}
                    @else 

                    <h1>Aanbiedingen</h1>
                    <p>tekst</p>

                    @endif

      
  
                </div>
                <div class="show-for-medium small-12 medium-6 medium-offset-1 large-offset-1 large-6 columns text-right">    

                </div>  
            </div>    

            @if (isset($products))
            <div class="row blocks" data-equalizer data-equalize-on="medium">
                @if( $products )

                @foreach ($products as $product)
                    @include('frontend.product_category._product-row')
                @endforeach

                @endif
            </div>
            @endif
        </div>
    </div>

    <div class="reveal" id="exampleModal1" data-reveal></div>


</div>
@stop
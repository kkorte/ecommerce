@extends('frontend._layouts.default')

@if($shopFrontend->wholesale)
@section('meta_title', 'Groothandel, importeur en distributeur van olijfolie, azijn en balsamico')
@section('meta_description', 'Foodelicious is groothandel, importeur en distributeur van olijfolie, azijn en balsamico en delicatessen uit Italië, Spanje en Griekenland')
@section('meta_keywords', '')

@else
@section('meta_title', 'Foodelicious.nl - Online shop')
@section('meta_description', 'De lekkerste en leukste online webwinkel op het gebied van OLIE EN AZIJN, DELICATESSEN')
@section('meta_keywords', '')

@endif



@section('main') 
<div class="homepage">
    <div class="highlights">
        <div class="row" >

            <div class="small-15 show-for-medium medium-7 large-7 columns">
                <div class="block large-block" >
                    @if(HtmlBlockHelper::findByPosition("homepage-highlight-1"))  
                    {!! HtmlBlockHelper::findByPosition("homepage-highlight-1") !!}
                    @else 
                    <a href="#">        
                        <div class="image"> 
                            <img src="/images/homepage-slider.jpg" />
                            <div class="overlay"></div>
                        </div>
                   
                        <h3>nu verkrijgbaar bij foodelicious: ontdek de nieuwe sauzen van Stokes!</h3>
                    </a>
                    @endif
                </div>
            </div>

            <div class="small-15 medium-4 show-for-medium large-4 columns text-center" >
                <div class="block" >  
                    @if(HtmlBlockHelper::findByPosition("homepage-highlight-2"))  
                    {!! HtmlBlockHelper::findByPosition("homepage-highlight-2") !!}
                    @else 
                    <a href="#">    
                        <div class="image"> 
                            <img src="/images/homepage-slider2.jpg" />
                            <div class="overlay"></div>
                        </div>
                        <h3>Aanbiedingen</h3>
                        <p>Iedere twee maanden een spannende foodbox gevuld met delicatessen. De exacte inhoud blijft een verrassing!</p>
                        <a href="/recepten" class="button">Bekijken</a>
                    </a>
                    @endif
                </div>
            </div>

            <div class="small-15 medium-4 large-4 show-for-medium columns text-center">
                <div class="block" > 
                    @if(HtmlBlockHelper::findByPosition("homepage-highlight-3"))  
                    {!! HtmlBlockHelper::findByPosition("homepage-highlight-3") !!}
                    @else 
                    <a href="/recepten">    
                        <div class="image"> 
                            <img src="/images/homepage-slider3.jpg" />
                            <div class="overlay"></div>
                        </div>
                        <h3>Onze recepten</h3>
                        <p>Iedere twee maanden een spannende foodbox gevuld met delicatessen. De exacte inhoud blijft een verrassing!</p>
                        <a href="/recepten" class="button">bekijken</a>
                    </a>
                    @endif

                </div>
            </div>

        </div>
    </div>

    <div class="categories-highlight">
        <div class="row">
            <div class="small-15 medium-10 large-10 columns">

                <h2 class="show-for-medium">Onze populaire producten</h2>
                <div class="widescreen-blocks">

                    <div class="row twelvecolumns">

                        <div class="small-12 medium-6 large-6 columns ">
                            <div class="block">

                                @if(HtmlBlockHelper::findByPosition("homepage-category-1"))  
                                {!! HtmlBlockHelper::findByPosition("homepage-category-1") !!}
                                @else 
                                <a href="#">
                                    <div class="image"> 
                                        <img src="/images/category-1.jpg" />
                                        <div class="overlay"></div>
                                    </div>
                                    <h3>Filotea Pasa</h3>
                                    <p>Heerlijke ambachtelijke pasta van Filotea uit Italie. Vanaf nu bij Foodelicious te bestellen en (...)   <strong>lees meer</strong></p>
                                </a>
                                @endif

                            </div>
                        </div>

                        <div class="small-12 medium-6 large-6 columns ">
                            <div class="block">

                                @if(HtmlBlockHelper::findByPosition("homepage-category-2"))  
                                {!! HtmlBlockHelper::findByPosition("homepage-category-2") !!}
                                @else 
                                <a href="#">
                                    <div class="image"> 
                                        <img src="/images/category-2.jpg" />
                                        <div class="overlay"></div>
                                    </div>
                                    <h3>Filotea Pasa</h3>
                                    <p>Heerlijke ambachtelijke pasta van Filotea uit Italie. Vanaf nu bij Foodelicious te bestellen en (...)   <strong>lees meer</strong></p>
                                </a>
                                @endif

                            </div>
                        </div>

                    </div>

                    <div class="row twelvecolumns">

                        <div class="small-12 medium-6 large-6 columns ">
                            <div class="block">

                                @if(HtmlBlockHelper::findByPosition("homepage-category-3"))  
                                {!! HtmlBlockHelper::findByPosition("homepage-category-3") !!}
                                @else 
                                <a href="#">
                                    <div class="image"> 
                                        <img src="/images/category-7.jpg" />
                                        <div class="overlay"></div>
                                    </div>
                                    <h3>Filotea Pasa</h3>
                                    <p>Heerlijke ambachtelijke pasta van Filotea uit Italie. Vanaf nu bij Foodelicious te bestellen en (...)   <strong>lees meer</strong></p>
                                </a>
                                @endif
                            
                            </div>
                        </div>

                        <div class="small-12 medium-6 large-6 columns ">
                            <div class="block">

                                @if(HtmlBlockHelper::findByPosition("homepage-category-4"))  
                                {!! HtmlBlockHelper::findByPosition("homepage-category-4") !!}
                                @else 
                                <a href="#">
                                    <div class="image"> 
                                        <img src="/images/category-4.jpg" />
                                        <div class="overlay"></div>
                                    </div>
                                    <h3>Filotea Pasa</h3>
                                    <p>Heerlijke ambachtelijke pasta van Filotea uit Italie. Vanaf nu bij Foodelicious te bestellen en (...)   <strong>lees meer</strong></p>
                                </a>
                                @endif

                            </div>
                        </div>

                    </div>

                    <div class="row twelvecolumns">

                        <div class="small-12 medium-6 large-6 columns ">
                            <div class="block">

                                @if(HtmlBlockHelper::findByPosition("homepage-category-5"))  
                                {!! HtmlBlockHelper::findByPosition("homepage-category-5") !!}
                                @else 
                                <a href="#">
                                    <div class="image"> 
                                        <img src="/images/category-5.jpg" />
                                        <div class="overlay"></div>
                                    </div>
                                    <h3>Filotea Pasa</h3>
                                    <p>Heerlijke ambachtelijke pasta van Filotea uit Italie. Vanaf nu bij Foodelicious te bestellen en (...)   <strong>lees meer</strong></p>
                                </a>
                                @endif

                            </div>
                        </div>

                        <div class="small-12 medium-6 large-6 columns ">
                            <div class="block">

                                @if(HtmlBlockHelper::findByPosition("homepage-category-6"))  
                                {!! HtmlBlockHelper::findByPosition("homepage-category-6") !!}
                                @else 
                                <a href="#">
                                    <div class="image"> 
                                        <img src="/images/category-6.jpg" />
                                        <div class="overlay"></div>
                                    </div>
                                    <h3>Filotea Pasa</h3>
                                    <p>Heerlijke ambachtelijke pasta van Filotea uit Italie. Vanaf nu bij Foodelicious te bestellen en (...)   <strong>lees meer</strong></p>
                                </a>
                                @endif

                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="small-15 medium-5 large-5 columns ">

                <h2>Uitgelicht</h2>

                <div class="two-blocks">

                    <div class="row">

                        <div class="small-15 medium-15 large-15 columns ">
                            <div class="block">

                                @if(HtmlBlockHelper::findByPosition("homepage-highlight-4"))  
                                {!! HtmlBlockHelper::findByPosition("homepage-highlight-4") !!}
                                @else 
                                <a href="">
                                    <div class="image"> 
                                        <img src="/images/category-3.jpg" />
                                        <div class="overlay"></div>
                                    </div>                            
                                    <h3>Rotterdamse producten!</h3>
                                </a>
                                @endif

                            </div>
                        </div>

                        <div class="small-15 medium-15 large-15 columns ">
                            <div class="block">

                                @if(HtmlBlockHelper::findByPosition("homepage-highlight-5"))  
                                {!! HtmlBlockHelper::findByPosition("homepage-highlight-5") !!}
                                @else 
                                <a href="">
                                    <div class="image"> 
                                        <img src="/images/twents.jpg" />
                                        <div class="overlay"></div>
                                    </div>                            
                                    <h3>Twents hout</h3>
                                </a>
                                @endif

                            </div>
                        </div>

                    </div>

                </div>


            </div>

        </div>

    </div>

    @if($populairProducts)
    <div class="most-populair">
        <div class="row">
            <div class="small-15 medium-15 large-15 columns ">

                <h2>Meest populair op dit moment</h2>
                
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
                                @if(Auth::guard('web')->check())
                                <p class="price"><strong>&euro; {{ $product->getPriceDetails()['orginal_price_ex_tax_number_format'] }}</strong></p>
                                @endif
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
</div>
@stop
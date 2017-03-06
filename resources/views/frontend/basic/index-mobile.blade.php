@extends('frontend._layouts.default')
@section('meta_title', 'Foodelicious.nl - Online shop')
@section('meta_description', 'De lekkerste en leukste online webwinkel op het gebied van OLIE EN AZIJN, DELICATESSEN')
@section('meta_keywords', '')
@section('main') 
<div class="homepage homepage-mobile">




   

    <div class="highlights">
        <div class="row" data-equalizer data-equalize-on="medium">

            <div class="small-15  large-7 columns">
                <div class="block large-block" data-equalizer-watch> 

                    @if(HtmlBlockHelper::findByPosition("homepage-highlight-mobile-1"))  
                    {!! HtmlBlockHelper::findByPosition("homepage-highlight-mobile-1") !!}
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

                                @if(HtmlBlockHelper::findByPosition("homepage-category-mobile-1"))  
                                {!! HtmlBlockHelper::findByPosition("homepage-category-mobile-1") !!}
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

                                @if(HtmlBlockHelper::findByPosition("homepage-category-mobile-2"))  
                                {!! HtmlBlockHelper::findByPosition("homepage-category-mobile-2") !!}
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

                                @if(HtmlBlockHelper::findByPosition("homepage-category-mobile-3"))  
                                {!! HtmlBlockHelper::findByPosition("homepage-category-mobile-3") !!}
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

                                @if(HtmlBlockHelper::findByPosition("homepage-category-mobile-4"))  
                                {!! HtmlBlockHelper::findByPosition("homepage-category-mobile-4") !!}
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

                                @if(HtmlBlockHelper::findByPosition("homepage-category-mobile-5"))  
                                {!! HtmlBlockHelper::findByPosition("homepage-category-mobile-5") !!}
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

                                @if(HtmlBlockHelper::findByPosition("homepage-category-mobile-6"))  
                                {!! HtmlBlockHelper::findByPosition("homepage-category-mobile-6") !!}
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

                                @if(HtmlBlockHelper::findByPosition("homepage-highlight-mobile-2"))  
                                {!! HtmlBlockHelper::findByPosition("homepage-highlight-mobile-2") !!}
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

                                @if(HtmlBlockHelper::findByPosition("homepage-highlight-mobile-3"))  
                                {!! HtmlBlockHelper::findByPosition("homepage-highlight-mobile-3") !!}
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
</div>
@stop
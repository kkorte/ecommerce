<div class="search-dialog dropdown-pane bottom"  id="search-dropdown">
    <div class="search-dialog-container">

    </div>
</div> 

 <div class="header" data-sticky-container>

    <div class="title-bar" data-sticky data-options="marginTop:0; marginBottom:30;"  style="width:100%">
        <div class="mobile-header">        
           <div class="row">
                <div class="columns small-8">
                    <div class="menu-button">
                        <button type="button" class="menu-icon" data-toggle="offCanvasLeft"></button>
                    </div>
                </div>

                <div class="columns small-7">

                    <div class="cart-mobile">
                        <p>
                            <a href="{!! URL::route('cart.index') !!}"  class="float-right">

                                @if($shopFrontend->wholesale)
                                <i class="fi-shopping-cart"></i> <span><span class="cart-count">{{ $cartCount }}</span> items | &euro; <span class="cart-total-price-ex">@if(isset($cartTotals)) {!! $cartTotals['sub_total_ex_tax_number_format'] !!} @else 0,00 @endif</span></span>
                                @else
                                <i class="fi-shopping-cart"></i> <span><span class="cart-count">{{ $cartCount }}</span> items | &euro; <span class="cart-total-price-inc">@if(isset($cartTotals)) {!! $cartTotals['sub_total_inc_tax_number_format'] !!} @else 0,00 @endif</span></span>
                                @endif
                                
                            </a>
                        </p>

                    </div>

                </div>
            </div>
        </div>

        <div class="main-header">
            
            <div class="row">

                <div class="small-12 medium-7 large-8 columns">
                    <div class="logo">
                        <a href="/" title="terug naar homepage">
                        @if($shopFrontend->wholesale)
                        <i class="wholesale"></i>
                        @else
                        <i></i>
                        @endif
                        </a>
                        
                    </div>     
                </div>         
     
                <div class="small-4 medium-8 large-4 columns text-right">
                    <ul class="small-menu menu">
                        @if(!$shopFrontend->wholesale)
                        <li><a href="https://groothandel.foodelicious.nl">Groothandel</a></li>
                        @elseif(!Auth::guard('web')->check())
                        <li><a href="/account">Inschrijven</a></li>
                        @endif


                       
                        <li><a href="/account">Account</a></li>
                        @if (Auth::guard('web')->check())
                        <li><a href="/account/logout">Uitloggen</a></li>
                        @endif
                    </ul>
                </div>
               <div class="small-4 medium-8 large-3 columns">
                    <div class="cart">
                        <p>
                            <a href="{!! URL::route('cart.index') !!}" data-toggle="example-dropdown" class="cart-button float-right cart-button-ajax">
                                @if($shopFrontend->wholesale)
                                <i class="fi-shopping-cart"></i> <span><span class="cart-count">{{ $cartCount }}</span> items | &euro; <span class="cart-total-price-ex">@if(isset($cartTotals)) {!! $cartTotals['sub_total_ex_tax_number_format'] !!} @else 0,00 @endif</span></span>
                                @else
                                <i class="fi-shopping-cart"></i> <span><span class="cart-count">{{ $cartCount }}</span> items | &euro; <span class="cart-total-price-inc">@if(isset($cartTotals)) {!! $cartTotals['sub_total_inc_tax_number_format'] !!} @else 0,00 @endif</span></span>
                                @endif
                            </a>
                        </p>
                        <div class="cart-dialog dropdown-pane bottom" id="example-dropdown"  data-url="/cart/dialog" data-dropdown data-hover="true" data-options="dataPositionClass:cartpopup;hoverDelay:500;closingTime:500;autoclose:true" data-hover-pane="true">

                       

                            <div class="cart-dialog-container">
                                <h3>Winkelwagen</h3>

                                @if (isset($cartProducts))
                                <table>
                                    <tbody>

                                        @foreach ($cartProducts as $product)

                                        <tr class="cart-product-row">
                                            <td class="amount">{!! $product['amount'] !!}x</td>
                                            <td class="image">
                                                <a href="/{{ $product['product_category_slug'] }}/{{ $product['id'] }}/{{ $product['slug'] }}">
                                                
                                                @if($product['product_images']) 
                                                <?php $image = $product['product_images'][0]; ?>
                                                <img src="/files/product/100x100/{!! $image['product_id'] !!}/{!! $image['file'] !!}" alt="">
                                                @else
                                                <img src="/images/product-thumb2.jpg" />
                                                @endif
                                                </a>

                                            </td>
                                            <td>
                                                <a href="/{{ $product['product_category_slug'] }}/{{ $product['id'] }}/{{ $product['slug'] }}">
                                                {!! $product['title'] !!}
                                                @if(isset($product['product_combination_title']))
                                                <ul>
                                                    @foreach($product['product_combination_title'] as $title => $value)
                                                    <li>{!! $title !!}: {!! $value !!}</li>
                                                    @endforeach
                                                </ul>
                                                @endif
                                            </a>


                                            </td>
                                            <td class="price">
                                                @if($shopFrontend->wholesale)
                                                &euro; <span class="total_price_ex_tax_{{ $product['id'] }}">{{ $product['cart']['total_price_ex_tax_number_format'] }}</span>
                                                @else
                                                &euro; <span class="total_price_inc_tax_{{ $product['id'] }}">{{ $product['cart']['total_price_inc_tax_number_format'] }}</span>
                                                @endif

                            

                                            </td>
                                        </tr>


                                        @endforeach 

                                        <tr class="total">
                                            <td colspan="4">
                                                @if($shopFrontend->wholesale)
                                                <strong>Totaalprijs: <span>&euro; {!! $cartTotals['sub_total_ex_tax_number_format'] !!}</span></strong>
                                                @else
                                                <strong>Totaalprijs: <span>&euro; {!! $cartTotals['sub_total_inc_tax_number_format'] !!}</span></strong>
                                                @endif
                                            </td>
                                        </tr>

                                    </tbody>    
                                </table>
                                <a href="/winkelwagen" class="button float-right button-black">Afronden</a>
                                @else 
                                <p>leeg</p>
                                @endif

                            </div>
                        </div>                    
                   
                    </div>

                </div>

            </div>

        </div>

        <div class="mainmenu ">

            <div class="row">

                <div class="small-12 medium-9 large-9 columns">
                    <ul class="menu">
                        @foreach($frontendProductCategories as $productCategory)
                        <li><a href="{!! URL::route('product-category', $productCategory->slug) !!}">{!! $productCategory->title !!}</a></li>
                        @endforeach

                        <li><a href="/merken-overzicht">merken</a><li> 
                    </ul>
                </div>

                <div class="small-15 medium-3 large-3 columns search-header">
        
                        <?php echo Form::open(array('route' => 'search.index', 'class' => 'form', 'method' => 'GET')); ?>
            <div class="search-container  float-right">
                    <ul class="menu search">
                
                        <li class="input-field"><input type="search" value="@if(isset($_GET['query'])){!! $_GET['query'] !!}@endif" name="query" data-url="/search/query" class="ajax-search" data-toggle="search-dropdown" placeholder="zoek product..."></li>
                        <li class="close-field"><button type="button" class="button"><i class="fa fa-search"></i></button></li>
                    </ul>
     </div>
                     </form>
               
                
                </div>

            </div>
        </div>
    </div>
</div>




<div class="searchfield search-mobile hide-for-large">

    <div class="row">
        <?php echo Form::open(array('route' => 'search.index', 'method' => 'GET')); ?>
            <div class="small-13 columns">
                <input type="search" data-url="/search/query" value="@if(isset($_GET['query'])) {!! $_GET['query'] !!} @endif" name="query"  class="ajax-search" data-toggle="search-dropdown" placeholder="zoek product...">
            </div>

            <div class="small-2 columns text-right">
                <button type="submit" class="button"><i class="fa fa-search"></i></button>
            </div>
         </form>          
    </div>
</div>


<div class="row">
    <div class="small-15 medium-15 large-15 columns">
        <div class="search-results search-results-home">

        </div>
    </div>
</div>




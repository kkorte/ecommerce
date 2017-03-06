@extends('frontend._layouts.default')
@if($product['meta_title'])
@section('meta_title', $product['meta_title'])
@else
@section('meta_title', $product->title.' | Foodelicious')
@endif

@if($product['meta_description'])
@section('meta_description', $product['meta_description'])
@else
@section('meta_description', $product->short_description)
@endif

@section('meta_keywords', $product['meta_keywords'])
@section('main')

<div class="breadcrumb">
    <div class="row">
        <div class="small-12 medium-12 large-15 columns">
            <nav aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs">

                    <li><a href="/{{ $product->productCategory->slug }}">Terug naar categorie</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<div class="product product-mobile">
    <div class="row">

        <div class="small-15 medium-15 large-11 large-offset-1 columns">

            <div class="row product-container">

                <div class="small-5 medium-5 large-5 columns">
                    @include('frontend.product._images')
                </div>

                <div class="columns large-offset-1 small-9 medium-9 large-9">

                    <h1>{!! $product->title !!}</h1>

                    <h3 class="price">
                        @if($shopFrontend->wholesale)
                        @if(Auth::guard('web')->check())
                        @if($priceDetails['discount_price_ex'])                        
                        &euro; {!! $priceDetails['discount_price_ex_number_format'] !!}
                        <span>&euro; {!! $priceDetails['orginal_price_ex_tax_number_format'] !!}</span>

                        @else 
                        &euro; {!! $priceDetails['orginal_price_ex_tax_number_format'] !!}
                        @endif 
                        @endif

                        @else
                        @if($priceDetails['discount_price_inc'])                        
                        &euro; {!! $priceDetails['discount_price_inc_number_format'] !!}
                        <span>&euro; {!! $priceDetails['orginal_price_inc_tax_number_format'] !!}</span>
                        @else 
                        &euro; {!! $priceDetails['orginal_price_inc_tax_number_format'] !!}
                        @endif 
                        @endif 
                                
                    </h3>

                    @if($shopFrontend->wholesale AND $priceDetails['commercial_price_number_format'] AND Auth::guard('web')->check())
                    <h6 class="commercial_price">Adviesprijs: &euro; {!! $priceDetails['commercial_price_number_format'] !!}</h6>
                    @endif
                    
                    <div class="description">

                        <p>{!! $product->short_description !!}</p>
                        <p class="weight-title">Inhoud: {!! $product->weight !!} {!! $product->weight_title !!}</p>
                    </div>
                    
                    @if($shopFrontend->wholesale AND !Auth::guard('web')->check())
                    <div class="wholesale-login">
                    <a href="/account" class="button">inloggen</a>
                    <p>u dient in te loggen om de prijzen te zien.</p>
                    </div>
                    <hr/>
                    @else 



                    <div class="order-block">
          <hr/>
                        @if($priceDetails['amount'] <= 0)
                        <div class="button-group">
                            <button type="button" class="button btn add-to-cart-button" disabled="disabled">
                            Uitverkocht
                            </button>
                            <a href="#" class="button button-simple out-of-stock" data-url="/product/waiting-list/{!! $product->id !!}">Wanneer op voorraad?</a>
                        </div>
                        @else
                        {!! Form::open(array('route' => array('cart.add.product', $product['id']), 'class' => 'add-product', 'data-gtm-product' => GoogleTagManager::dump(array('id' => $product->id, 'title' => $product->title)))) !!}

                        <input type="hidden" name="product_id" value="{!! $product['id'] !!}"> 
                        @if($product->amountSeries()->where('active', '=', '1')->count())
                        <input type="hidden" name="product_amount_series" value="1"> 
                        {!! Form::select('amount', $product->amountSeries()->where('active', '=', '1')->first()->range(), null, array('class' => 'form-control')) !!}
                        @else
                        <input type="hidden" class="form-control"  name="amount" value="1" size="2" maxlength="2" >
                        
                        @endif
                        <button type="button" class="button add-to-cart-button btn-blue btn-long">
                        <span class="icon icon-cart"></span> In winkelwagen
                        </button>
                        @endif
                        </form>

                    </div>

                    <hr/>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="small-15 columns">
                    <div class="description">
                        {!! $product->description !!}
                    </div>

                    @if($product->ingredients)
                    <div class="ingredients">
                        <ul class="accordion" data-accordion data-allow-all-closed="true">
                          <li class="accordion-item" data-accordion-item>
                            <a href="#" class="accordion-title">Ingredienten</a>
                            <div class="accordion-content" data-tab-content>
                                 {!! $product->ingredients !!}
                            </div>
                          </li>
                        </ul>
                    </div>
                    @endif
                    

                </div>
            </div>

            <div class="row product-details">
                <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
                    @if ($product['extra_fields'])
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Eigenschappen
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            @foreach ($product['extra_fields'] as $field)
                                            <tr>
                                                <td><strong>{!! $field['extra_field']['title'] !!}
                                                </strong></td>
                                                <td> 
                                                    @if($field['extra_field_default_value'])

                                                    {!! $field['extra_field_default_value']['value'] !!}
                                                    @else
                                                    {!! $field['value'] !!}
                                                    @endif
                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>


            </div>
        </div>
    </div>
</div>
@stop
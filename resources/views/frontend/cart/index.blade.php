@extends('frontend._layouts.default')

@section('main')

<h1>Shoppingcart</h1>

@notification('foundation')

@if (app('cart')->getContent()->count())


<div class="cart-details">

    <table class="table details">
        <thead>
            <tr>
                <th class="show-for-medium image">&nbsp;</th>
                <th class="title ">Product</th>
                <th class="price show-for-medium">Price</th>
                <th class="amount">Amount</th>
                <th class="price text-right">Total</th>
                <th>&nbsp;</th>               
            </tr>
        </thead>


        <tbody class="cart-details-container">

            @foreach (app('cart')->getContent()->sortBy('id') as $product)
            @include('frontend.cart._product-row')                      
            @endforeach

            <tfoot class="cart-reload" data-url="" >
                @include('frontend.cart._totals')
            </tfoot>

        </tbody>
    </table>

</div>



@endif

@stop
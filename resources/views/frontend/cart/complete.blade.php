@extends('frontend._layouts.default')

@section('main')


<div class="breadcrumb">

    <div class="row">
        <div class="small-15 columns">
            <ul class="breadcrumbs">
                <li><a href="/">Home</a></li>
                <li><a href="/cart">Winkelwagen</a></li>
                <li><a href="#">Bestelling is afgerond</a></li>
            </ul>
        </div>
    </div>

</div>


<div class="content">
    <div class="row">

        <div class="small=15 columns">
            <div class="content-text">



                <div class="row product-container">


                    <div class="columns  large-15">

                        <div class="description">

                            {!! $body !!}
                            
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

</div>



@stop
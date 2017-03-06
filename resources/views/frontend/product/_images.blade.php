@if ($product->productImages)
<div class="photos photo-container">
    <div class="row">

        @foreach ($product->productImages as $key => $image)
        @if ($key === 0)


        <div class="large-photo">    
            <div class="large-15 medium-15 small-15 columns">
                <a href="/files/product/800x800/{!! $image['product_id'] !!}/{!! $image['file'] !!}">
                    <img src="/files/product/400x400/{!! $image['product_id'] !!}/{!! $image['file'] !!}" class="img-responsive main-photo" alt="" />
                </a>
            </div>    

        </div>  

        @else

        <div class="small-photo">

            <div class="large-5 medium-5 small-5 columns">
                <a href="/files/product/800x800/{!! $image['product_id'] !!}/{!! $image['file'] !!}">
                    <img src="/files/product/100x100/{!! $image['product_id'] !!}/{!! $image['file'] !!}" class="img-responsive" alt="" />
                </a>
            </div>
        </div>
        @endif
        @endforeach
    </div>
</div>
@else
<div class="photos photo-container">
    <div class="row">
    
        <div class="large-photo">    
            <div class="large-15 medium-15 small-15 columns">
    			<img src="{!! URL::asset('images/default-thumb.jpg') !!}" alt="no image" class="img-responsive">
    
            </div>    

        </div> 

    </div>
</div>
@endif
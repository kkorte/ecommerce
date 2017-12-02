<div class="col-sm-3 col-md-3 col-lg-3">
    <a href="{!! URL::route('product.item', array('productCategorySlug' => $product->productCategory->slug, 'productId' => $product->id, 'productSlug' => $product->slug)) !!}" title="">
        <div class="product-col">

            @if(ProductHelper::getImage($product->id, array($product->attribute_id))) 
            <img src="/files/product/200x200/{!! $product->id !!}/{!! ProductHelper::getImage($product->id, array($product->attribute_id)) !!}" class="img-responsive" alt="{!! $product->title !!}">
            @else
            <img src="/images/product-thumb2.jpg" style="width:200px; height:200px;" />
            @endif

            <div>
                <h3>{{ $product->title }}</h3>
                <p>{!! $product->short_description !!}</p>
            </div>
        </div>
    </a>
</div>
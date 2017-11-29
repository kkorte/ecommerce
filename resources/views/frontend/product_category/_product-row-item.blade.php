<div class="col-sm-3 col-md-2 col-lg-2">
    <a href="{!! URL::route('product.item', array('productCategorySlug' => $product->productCategory->slug, 'productId' => $product->id, 'productSlug' => $product->slug)) !!}" title="">
        <div class="product-col">
            <img src="/images/default-product-thumb.png" style="width:200px;"  />
            <h3>{{ $product->title }}</h3>
            <p>{!! $product->short_description !!}</p>
        </div>
    </a>
</div>
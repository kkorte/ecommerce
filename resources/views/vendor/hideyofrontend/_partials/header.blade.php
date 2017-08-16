
<ul class="menu">
 <li><a href="{!! URL::route('hideyof.index') !!}">Home</a></li>
   
@if($hideyoFrontendProductCategories)

    @foreach($hideyoFrontendProductCategories as $productCategory)
    <li><a href="{!! URL::route('hideyof.product-category.item', $productCategory->slug) !!}">{!! $productCategory->title !!}</a></li>
    @endforeach

@endif

</ul>

@if($products)
<table>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td><a href="/{{ $product->productCategory->slug }}/{{ $product->id }}/{{ $product->slug }}">{!! $product->title !!}</a></td>
        </tr>
        @endforeach
    </tbody>    
</table>
@endif
<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
    <channel>
        <title><![CDATA[productfeed]]></title>
        <link></link>
@foreach($products as $product)
<item>
    <title><![CDATA[{!! $product->title !!}]]></title>
    <description><![CDATA[{!! $product->short_description !!}]]></description>
    <g:id>{!! $product->id !!}</g:id>
    <g:condition>new</g:condition>
    <g:availability>in stock</g:availability>
    @if($product->mpn_code) 
    <g:mpn>{!! $product->mpn_code !!}</g:mpn>
    @else
    <g:mpn>{!! $product->reference_code !!}</g:mpn>
    @endif
    @if($product->ean_code) 
    <g:gtin>{!! $product->ean_code !!}</g:gtin>
    @endif

    @if($product->brand)
    <g:brand><![CDATA[{!! $product->brand->title !!}]]></g:brand>
    @endif

    @if($shopFrontend->wholesale)
    <g:price>0</g:price>

    @else
    <g:price>{!! $product->getPriceDetails()['orginal_price_ex_tax_number_format'] !!} EUR</g:price>
    @endif 
    <g:google_product_category><![CDATA[Eten, drinken en tabak]]></g:google_product_category>
    <link>{!! $shopFrontend->url !!}/{{ $product->productCategory->slug }}/{{ $product->id }}/{{ $product->slug }}</link>
    @if($product->productImages->count())
    <g:image_link>{!! $shopFrontend->url !!}/files/product/200x200/{!! $product->productImages->first()->product_id !!}/{!! $product->productImages->first()->file !!}</g:image_link>
    @endif
    <g:shipping>
      <g:country>NL</g:country>
      <g:price>3.95 EUR</g:price>
    </g:shipping>
    <g:shipping>
      <g:country>BE</g:country>
      <g:price>6.05 EUR</g:price>
    </g:shipping>

    </item>
@endforeach
</channel>
</rss>



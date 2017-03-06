<div class="buy-dialog">


     <div class="row product-container">

        <div class="large-5 columns">
            @if ($product->productImages)
                           <div class="photos photo-container">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6">
                    <a href="/files/product/800x800/{!! $product->productImages->first()->product_id !!}/{!! $product->productImages->first()->file !!}">
                        <img src="/files/product/400x400/{!! $product->productImages->first()->product_id !!}/{!! $product->productImages->first()->file !!}" class="img-responsive main-photo" alt="" />
                    </a>
                </div>  



            </div>
            @else
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <img src="{!! URL::asset('images/default-thumb.jpg') !!}" alt="no image" class="img-responsive">
                </div>
            </div>
            @endif
        </div>


        <div class="columns large-offset-1  large-9">
            <h1>Wanneer op voorraad?</h1>
            <p>Helaas is het product {!! $product->title !!} niet op voorraad.</p><p> Laat je email achter en wij houden je op hoogte wanneer het weer beschikbaar is.</p>

                {!! Form::open(array('route' => array('product.waiting.list.add'), 'class' => 'add-product-waiting-list-subscription')) !!}                       
                    <input type="hidden" name="product_id" value="{!! $product->id !!}" />
                    <input type="hidden" name="product_attribute_id" value="{!! $productAttributeId !!}" />

                    <div class="callout alert waiting-list-alert">Email-adres komt al voor of is niet goed ingevuld.</div>

                    <div class="row">
                        <div class="small-15 medium-15 large-15 columns input-field">
                         <input type="text" name="email" id="newsletter-email" placeholder="Email-adres..."/>

                     </div>
                     <div class="small-15 medium-15 large-15 columns submit">
                        <input type="submit" id="button" class="button submit-button" value="Verzenden" />
                    </div>
                </div>


                 </form>

        </div>
    </div>

     <button class="close-button" data-close aria-label="Close reveal" type="button">
        <span aria-hidden="true">&times;</span>
     </button>
</div>
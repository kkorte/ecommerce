<div class="footer">
    <div class="row">

      <div class="small-15 medium-4 large-4 columns">
            <div class="block">
                <h5>Laatste nieuws</h5>
                @if($footerNews) 
                <ul>
                    @foreach($footerNews as $news)
                    <li><a href="{!! URL::route('news.item', array($news->newsGroup->slug, $news->slug)) !!}">{!! str_limit($news->title, 38) !!}</a></li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>

        <div class="small-15 medium-4 large-3 columns">
            <div class="block">

                @if(HtmlBlockHelper::findByPosition("footer-2"))  
                {!! HtmlBlockHelper::findByPosition("footer-2") !!}
                @else 
                <h5>Foodelicious</h5>
                <ul>
                    <li><a href="/text/de-winkel" title="de winkel">De winkel</a></li>
                    <li><a href="/text/groothandel-voorwaarden" title="Algemene voorwaarden">Algemene voorwaarden</a></li>
                    <li><a href="/text/privacy-statement" title="Privacy statement">Privacy statement</a></li>
                    <li><a href="/veelgestelde-vragen" title="veelgestelde vragen">Veelgestelde vragen</a></li>
                    <li><a href="/text/contact" title="Content en openingstijden">Content &amp; openingstijden</a></li>
                </ul>
                @endif
            </div>
        </div>
        
        <div class="show-for-large show-for-medium small-12 medium-4 large-3 columns">
            <div class="block">
                @if(HtmlBlockHelper::findByPosition("footer-3"))  
                {!! HtmlBlockHelper::findByPosition("footer-3") !!}
                @else 
                <h5>Veilig betalen</h5>
                <p>U kunt bij ons veilig betalen met Ideal en creditcard. Wij zijn daarnaast aangesloten bij het webshop keurmerk</p>
                <img src="/images/keurmerk.png" />
                @endif
            </div>
        </div>

        <div class="small-15 medium-4 large-3 columns">
            <div class="block newsletter">
                <h5>Nieuwsbrief</h5>
                <p>Wilt u op de hoogte blijven van eventuele proeverijen, aanbiedingen en nieuwe recepten? Meldt u dan hier aan voor onze nieuwsbrief.</p>
                
                {!! Form::open(array('route' => array('newsletter.add'), 'id' => 'newsletter-subscription')) !!}                       

                    <div class="row">
                        <div class="small-13 medium-13 large-13 columns input-field">
                         <input type="text" name="email" id="newsletter-email" placeholder="Email-adres..."/>
                     </div>
                     <div class="small-2 medium-2 large-2 columns submit">
                        <input type="submit" id="button" class="button submit-button" value="&raquo;" />
                    </div>
                </div>

                 </form>
            </div>
        </div>

        <div class="small-15 medium-4 large-2 columns">
            <div class="block">

                @if(HtmlBlockHelper::findByPosition("footer-5"))  
                {!! HtmlBlockHelper::findByPosition("footer-5") !!}
                @else 
                <h5>Contact</h5>
                <p>

                    Mariniersweg 47<br/>
                    3011 ND Rotterdam<br/>
                    010-41 30 111<br/>
                    @if(!$shopFrontend->wholesale)
                    <a href="">Openingstijden</a><br/>
                    @endif
                    <a href="">contactformulier</a>
                </p>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="reveal" id="exampleModal1" data-reveal></div>
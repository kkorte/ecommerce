<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 hidden-xs col-sm-4 col-md-4 col-lg-4">
                @if(HtmlBlockHelper::findByPosition("footer-about-us"))  
                {!! HtmlBlockHelper::findByPosition("footer-about-us") !!}
                @endif 
            </div>

            <div class="col-xs-12 hidden-xs col-sm-3 col-md-3 col-lg-offset-1 col-lg-4">
                <h5>News</h5>
                @if($footerNews) 
                <ul>
                    @foreach($footerNews as $news)
                    <li><a href="{!! URL::route('news.item', array($news->newsGroup->slug, $news->slug)) !!}" title="{!! $news->title !!}">{!! str_limit($news->title, 38) !!}</a></li>
                    @endforeach
                </ul>
                @endif
            </div>
            <div class="col-xs-12  col-sm-3 col-md-3 col-lg-3">
                @if(HtmlBlockHelper::findByPosition("footer-contact"))  
                {!! HtmlBlockHelper::findByPosition("footer-contact") !!}
                @endif 
            </div>
        </div>
    </div>
</footer>
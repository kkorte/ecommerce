<footer class="footer">
  <div class="container">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-4">
            @if(HtmlBlockHelper::findByPosition("footer-about-us"))  
            {!! HtmlBlockHelper::findByPosition("footer-about-us") !!}
            @endif 
        </div>


        <div class="col-sm-3 col-md-3 col-lg-offset-2 col-lg-3">
            <h5>News</h5>
            <ul>
                <li><a href="#">newsitem 1</a></li>
                <li><a href="#">newsitem 1</a></li>
                <li><a href="#">newsitem 1</a></li>
                <li><a href="#">newsitem 1</a></li>
                <li><a href="#">newsitem 1</a></li>
                <li><a href="#">newsitem 1</a></li>
            </ul>
        </div>
        <div class="col-sm-3 col-md-3 col-lg-3">
            @if(HtmlBlockHelper::findByPosition("footer-contact"))  
            {!! HtmlBlockHelper::findByPosition("footer-contact") !!}
            @endif 
        </div>
    </div>
  </div>
</footer>
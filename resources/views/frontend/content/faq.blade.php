@extends('frontend._layouts.default')
@section('meta_title', 'veelgestelde vragen')
@section('meta_description', '')
@section('meta_keywords','')
@section('main')

<div class="breadcrumb">
    <div class="row">
        <div class="small-12 medium-12 large-15 columns">
            <nav aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs">
                    <li><a href="/">Home</a></li>
                    <li><a href="#">Veelgestelde vragen</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<div class="content">
    <div class="row">


        <div class="small-4 medium-4 show-for-medium large-4 columns">
            <div class="content-items-summary">
                    @if(HtmlBlockHelper::findByPosition("faq-intro"))  
                    {!! HtmlBlockHelper::findByPosition("faq-intro") !!}
                    @else 
                    <h5>Veelgestelde vragen</h5>
                    <p>lorem ipsum</p>
                    @endif



            </div>
        </div>

        <div class="large-11 columns">
            <div class="content-text">
                <div class="row">
                    <div class="columns large-15">
                        <h1>Veelgestelde vragen</h1>
                    </div>
                </div>


                <div class="row product-container faq-container">


                    <div class="columns  large-15">


                        <ul class="accordion" data-accordion data-allow-all-closed="true">
                            @foreach($faqItems as $faq)

                            <li class="accordion-item" data-accordion-item>
                                <a href="#" class="accordion-title">{!! $faq->question !!}</a>
                                <div class="accordion-content" data-tab-content>
                                  {!! $faq->answer !!}
                              </div>
                            </li>

                          @endforeach


                      </ul>

                  </div>
              </div>
          </div>
      </div>

  </div>

</div>

@stop
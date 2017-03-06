@extends('frontend._layouts.default')
@section('meta_title', 'Foodelicious - contact')
@section('meta_description', 'Contact')
@section('meta_keywords', '')
@section('main') 

<div class="breadcrumb">
    <div class="row">
        <div class="small-12 medium-12 large-15 columns">
            <nav aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs">
                    <li><a href="/">Home</a></li>

                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<div class="content">
    <div class="row">


        <div class="small-4 show-for-medium medium-4 large-4  columns">

            <div class="content-items-summary">

                @if(HtmlBlockHelper::findByPosition("contact-sidebar-1"))  
                {!! HtmlBlockHelper::findByPosition("contact-sidebar-1") !!}
                @else 

                <h5>Adres</h5>
                <p>FOODELICIOUS Food&amp;Gifts<br>
                Mariniersweg 47<br>
                3011 ND Rotterdam<br>
                Tel:&nbsp; 010-41 30 111</p>

                <p>info@foodelicious.nl</p>

                @endif

            </div>

            <div class="content-items-summary">

                @if(HtmlBlockHelper::findByPosition("contact-sidebar-2"))  
                {!! HtmlBlockHelper::findByPosition("contact-sidebar-2") !!}
                @else 

                <h5>Reguliere Openingstijden</h5>

                <ul>
                    <li>dinsdag t/m vrijdag 10.00 tot 18.00</li>
                    <li>zaterdag 10.00 tot 17.00</li>
                    <li>zondag en maandag gesloten</li>
                </ul>

                <p>Op woensdag 27 april en op donderdag 5 mei zijn wij gesloten.</p>

                @endif

            </div>

            <div class="content-items-summary">
                <h5>Lees ook...</h5>
                @if($allContent)
                <ul>
                    @foreach($allContent as $contentItem)
                    <li><a href="/text/{{ $contentItem->slug }}">{!! $contentItem->title !!}</a></li>
                    @endforeach
                </ul>
                @endif
            </div>

        </div>


        <div class="small-15 medium-11 large-10 large-offset-1 columns">
            <div class="content-text">
                <div class="row">
                    <div class="columns small-15 medium-15 large-12">
                        <h1>Contact</h1>
                        <p>Mocht je&nbsp;na het lezen van onze website nog vragen hebben, of wil je&nbsp;iets per e-mail bestellen, dan kun je&nbsp;hier je&nbsp;gegevens achter laten.<br>
                            Wij nemen zo spoedig mogelijk contact met je&nbsp;op. Uiteraard kunt u ook gewoon bellen met 010-4130111 en anders via Twitter of Facebook.</p>
                        </div>
                    </div>


                    <div class="row product-container">


                        <div class="columns small-15 medium-15 large-10">

                            <div class="description">
                                @notification('foundation') 
                                {!! Form::open(array('route' => 'contact', 'method' => 'POST', 'class' => 'form', 'data-abide' => '', 'novalidate' => '')) !!}
                     
                                 <div class="row">

                                    <div class="small-15 medium-15 large-15 columns">
                                        <label for="middle-label">{!! trans('form.name') !!}</label>
                                        {!! Form::text('name', null, array('required' => '')) !!}
                                        <span class="form-error">
                                            {!! trans('form.validation.required') !!}
                                        </span>

                                    </div>

                                </div>


     

                                <div class="row">

                                    <div class="small-15 medium-15 large-15 columns">
                                        <label for="middle-label">{!! trans('form.email') !!}</label>
                                        {!! Form::email('email', null, array('required' => '', 'pattern' => 'email')) !!}
                                        <span class="form-error">
                                            {!! trans('form.validation.required') !!}
                                        </span>

                                    </div>

                                </div>


                          <div class="row">

                                    <div class="small-15 medium-15 large-15 columns">
                                        <label for="middle-label">{!! trans('form.company') !!}</label>
                                        {!! Form::text('company', null, array()) !!}
                                        <span class="form-error">
                                            {!! trans('form.validation.required') !!}
                                        </span>

                                    </div>

                                </div>


                          <div class="row">

                                    <div class="small-15 medium-15 large-15 columns">
                                        <label for="middle-label">{!! trans('form.phone') !!}</label>
                                        {!! Form::text('phonenumber', null, array()) !!}
                                        <span class="form-error">
                                            {!! trans('form.validation.required') !!}
                                        </span>

                                    </div>

                                </div>



                                <div class="row">

                                    <div class="small-15 medium-15 large-15 columns">
                                        <label for="middle-label">{!! trans('form.message') !!}</label>
                                        {!! Form::textarea('message', null, array('required' => '')) !!}
                                        <span class="form-error">
                                            {!! trans('form.validation.required') !!}
                                        </span>

                                    </div>

                                </div>



                                <div class="row">
                                    <div class="small-15 columns text-right">
                                        <button type="submit" class="button button-black">{!! trans('buttons.send') !!}</button>
                                    </div>
                                </div>
       

{!! Form::close() !!}

                          
                            
                            </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

</div>




    @stop
@extends('frontend._layouts.default')

@section('main') 



<div class="breadcrumb">
    <div class="row">
        <div class="small-15 medium-15 large-15 columns">
            <nav aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs">
                    <li><a href="/">Home</a></li>
                    <li><a href="/account">Account</a></li>
                    <li class="active"><a href="#">Inloggen</a></li>

                </ul>
            </nav>
        </div>
    </div>
</div>



<div class="account">
    <div class="row">
        <div class="small-15 medium-10 large-7 columns login">
            <h1>Inloggen groothandel</h1>

            <p>Vul hieronder uw e-mailadres en het wachtwoord dat u eerder heeft ontvangen van Foodelicious. </p>
             @notification('foundation')

            <div class="block">


            <?php echo Form::open(array('route' => 'account.login', 'class' => 'form', 'data-abide' => '', 'novalidate' => '')); ?>

                <div class="row">

                    <div class="small-15 medium-12 large-12 columns">
                        <label for="middle-label">{!! trans('form.email') !!}</label>
                        {!! Form::email('email', null, array('required' => '', 'pattern' => 'email')) !!}
                        <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>

                    </div>

                </div>

                <div class="row">
                    <div class="small-15 medium-12 large-12 columns">
                        <label for="middle-label">{!! trans('form.password') !!}</label>
                        {!! Form::password('password', array('required' => '')) !!}
                      <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>                
                    </div>
                </div>
              
                <div class="row">
                    <div class="small-offset-3 small-12 columns text-right">
                        <a href="{!! URL::route('account.forgot.password') !!}" class="forgot-password-link">{!! trans('titles.forgot-password') !!}</a>
                        <button type="submit" class="button button-black">{!! trans('buttons.login') !!}</button>
                    </div>
                </div>
       
            </form>

            </div>

        </div>

        <div class="small-15 medium-10 large-7 columns login">
            <h1>Nieuwe groothandel klant?</h1>
            <p>Je kunt je <a href="{!! URL::route('account.register') !!}" class="">hier</a> aanmelden wanneer je een groothandel klant wilt worden!</p>


        </div>


    </div>

    <div class="row product">
        <div class="columns small-15">
            <hr/>
<h3>GROOTHANDEL, IMPORTEUR EN DISTRIBUTEUR VAN OLIJFOLIE, AZIJN EN BALSAMICO</h3>

<p>Groothandel, importeur en distributeur van olijfolie, azijn en balsamico. Wij verkopen daarnaast ook een ruime collectie pasta, pesto, pastasauzen, toast, olijven en koekjes.
</p>
<p>Groothandel met delicatessen uit Italië, Spanje, Frankrijk, België, Griekenland, Litouwen, Portugal en Groot Britanië
Wij zijn deze zaak begonnen uit liefde voor lekker eten, met focus op olijfolie en azijn in het bijzonder. Wij zijn op zoek gegaan naar de beste extra vergine olijfolie en de meest bijzondere azijn en balsamico in grootverpakking. Inmiddels hebben we sterke banden opgebouwd met onze leveranciers uit heel Europa. Hierdoor kunnen we unieke producten aanbieden, die speciaal voor ons worden gemaakt. We importeren alles zelf en direct bij de producent, hierdoor betaal je nooit teveel. Uiteraard zijn wij telkens op zoek naar nieuwe producten, en proberen we je te blijven voorzien van een verrassend assortiment. Kwaliteit, smaak, ‘look & feel’ staan daarbij hoog in het vaandel.
</p>
<p>Naast olijfolie in 5 liter blikken en azijn in 3 liter verpakkingen, hebben we ons assortiment in de afgelopen jaren flink uitgebreid. Van biologische Italiaanse delicatessen tot franse mosterd, Spaanse smaakmakers tot luxe truffelproducten, alles is bij ons in grootverpakking te verkrijgen. Je kunt zelfs glazen flesjes bestellen en die in je eigen zaak vullen met bijvoorbeeld basilicum olie of 15 jaar oude balsamico azijn, alles is mogelijk.
</p>
<p>Naast onze goede prijs-kwaliteitverhouding willen wij het je zo gemakkelijk en aangenaam mogelijk maken. Zo kun je bij ons alles online bestellen en we werken met DHL voor een snelle bezorging. Je kunt ons altijd contacteren wanneer je vragen hebt of iets meer wilt weten over een bepaald product, wij vertellen er graag over. Wij zijn meer dan een groothandel, wij denken met je mee.
</p>
<p>Kortom: ben je op zoek naar een leverancier voor je eigen zaak? Een leverancier die alleen voor het beste van het beste gaat, je eerlijk advies geeft en meedenkt over mogelijkheden? Neem dan eens contact met ons op en vertel ons met passie over je culinaire plannen.
</p>
<p>
Jaime en Herman Specker en hun foodie team.</p>
        </div>
    </div>
</div>

@stop
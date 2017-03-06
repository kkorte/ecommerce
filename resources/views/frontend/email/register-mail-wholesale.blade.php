<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<head>
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Account aangemaakt</title>


	<style type="text/css">
	img {
		max-width: 100%;
	}
	body {
		-webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em;
	}
	body {
		background-color: #f6f6f6;
	}
	@media only screen and (max-width: 640px) {
		body {
			padding: 0 !important;
		}
		h1 {
			font-weight: 800 !important; margin: 20px 0 5px !important;
		}
		h2 {
			font-weight: 800 !important; margin: 20px 0 5px !important;
		}
		h3 {
			font-weight: 800 !important; margin: 20px 0 5px !important;
		}
		h4 {
			font-weight: 800 !important; margin: 20px 0 5px !important;
		}
		h1 {
			font-size: 22px !important;
		}
		h2 {
			font-size: 18px !important;
		}
		h3 {
			font-size: 16px !important;
		}
		.container {
			padding: 0 !important; width: 100% !important;
		}
		.content {
			padding: 0 !important;
		}
		.content-wrap {
			padding: 10px !important;
		}
		.invoice {
			width: 100% !important;
		}
	}
	</style>
</head>

<body itemscope itemtype="http://schema.org/EmailMessage" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

	<table class="body-wrap" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
		<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
			<td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
			<td class="container" width="600" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
				<div class="content" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
					


					<div class="logo" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 0px 0px 10px 0px;">
						<table width="100%" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
							<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
								<td class="aligncenter content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 0px;" align="center" valign="top">
									<img src="{!! url('/images/logoemail.png') !!}" />
								</td>
							</tr>
						</table>
					</div>

					
					<table class="main" width="100%" cellpadding="0" cellspacing="0" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">
						<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
							<td class="content-wrap" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top">
								<meta itemprop="name" content="Confirm Email" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;" />
								<table width="100%" cellpadding="0" cellspacing="0" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
									<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
										<td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">


											<p>Beste {!! $billAddress['firstname'] !!}</p>
											<p>Allereerst wil ik u bedanken voor uw interesse in onze producten. <br/>
											U heeft een inlogcode aangevraagd voor onze groothandel in delicatessen.</p>

											<p><strong>Jouw inloggegevens:</strong></p>
											<p>Email-adres: {!! $user['email'] !!}.  </p>
											<p>Wachtwoord: {!! $password !!}</p>  

											<p>Nadat uw aanvraag is goedgekeurd ontvangt u hiervan een aparte email. <br/>
											Daarna kunt u inloggen op de groothandels website</p>

											<p>Hier kunt u inloggen om gelijk in de groothandels webshop te bestellen na goedkeuring van ons.</p>  
											{!! Html::link('/account/login', 'Inloggen', array('class' => 'btn-primary', 'itemprop' => "url", 'style' => 'font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 1em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; text-transform: capitalize; background-color: #d1005d; margin: 0; border-color: #d1005d; border-style: solid; border-width: 10px 20px;')) !!}
											<br/><br/>

											<p><strong>Groothandel Foodelicious</strong></p>

											<p>Zoals u waarschijnlijk op onze site heeft gelezen importeren wij heel veel delicatessen uit Zuid-Europa en verkopen wij dit aan andere winkels, horeca en cateraars.</p>

											<p>
											 Olijfolie, olie, balsamico en azijn is onze specialiteit. Door rechtstreeks contact met de boer kunnen wij speciale, originele en pure producten  aanbieden.  Foodelicious importeert deze producten in grootverpakking van 5000cc cans.  Uiteraard kunnen ook alle oliën en azijnen in  diverse maten flesjes geleverd worden.</p>
											<p>Daarnaast hebben we de scharreleipasta van La Campofilone en Filotea, biologische pastasaus en pesto van Biagi, gedroogde pasta van Verrigni, pimenton van La Chinata, top truffel producten van Acqualanghe, delicatessen uit Spanje van La Chinata, Olijfolie van Ursini,  mooie toast en grissini van Casa Vecchio Mulino, Balsamico’s van Piazza Grande en Mussini en zo kunnen we nog wel even doorgaan. Kortom een mooie complete serie van de mooiste delicatessen en merken.</p>



											<p><strong>De voordelen van Foodelicious op een rij:</strong></p>
											<ul>
											<li>Simpel online bestellen via de <a href="https://foodelicious.nl">webshop</a></li>
											<li>Al vanaf &euro; 150,- sturen wij het gratis naar u op.</li>
											<li>Snelle leveringen</li>
											<li>Top kwaliteit delicatessen tegen scherpe prijzen door directe import</li>
											<li>Advies bij het samenstellen van uw assortiment en uitbreiding hiervan</li>
											<li>Snel en persoonlijk antwoord bij al uw vragen</li>

											</ul>

											<p><strong>Bestelling, levering en facturering</strong></p>


											<p>Bestellen gaat heel simpel online via de webshop en vragen en/of opmerkingen kunt u bij alle bestellingen tijdens de laatste stap invullen.</p>

											<p>
											Uw bestelling wordt verzonden door DHL. Zodra uw pakket op de post gaat ontvangt u een e-mail met daarin de track en trace code.</p>
											<p>
											Om het milieu te sparen worden de facturen per email verzonden naar u. Mocht het emailadres afwijken van het email adres waarmee u zich heeft ingeschreven (waar deze mail binnenkomt) dit graag even aangeven op administratie@foodelicious.nl.
											Facturen worden automatisch na 14 dagen geïncasseerd op het door u aangeven rekeningnummer. 
											</p>

											<p>Mocht u nog vragen hebben dan hoor ik dat uiteraard graag</p>

										</td>
									</tr>
									<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
										<td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">					
											<p style=";">Met vriendelijke groet,</p>
											<p style="padding-top:20px;">Team Foodelicious</p>
											<p style="padding-top:20px;">Mariniersweg 47<br/>
											3011ND Rotterdam<br/>
											Tel:010-4130111 (dinsdag tot en met zaterdag van 10:00-18:00)</p>
											<p><a href="mailto:verkoop@foodelicious.nl">verkoop@foodelicious.nl</a></p>
											<img src="{!! url('/images/foodelicious_footer_logos.png') !!}" alt="footer logo" />    
										</td>
									</tr>

				
								</table>
							</td>
						</tr>
					</table>

					<div class="footer" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
						<table width="100%" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
							<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
								<td class="aligncenter content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">
									Follow <a href="http://twitter.com/foodeliciousnl" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">@foodeliciousnl</a> on Twitter.
								</td>
							</tr>
						</table>
					</div>
				</div>
			</td>

			<td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
		</tr>
	</table>
</body>
</html>
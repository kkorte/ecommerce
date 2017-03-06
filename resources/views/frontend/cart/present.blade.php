<div class="buy-dialog">

    <div class="row product-container">

        <div class="columns large-15">
            <h1>Cadeauservice</h1>
            <p>Voor &euro; 1,50 wordt jouw bestelling mooi ingepakt, inclusief handgeschreven kaartje met een persoonlijke boodschap!</p>
            {!! Form::open(array('route' => array('cart.present'), 'class' => 'form-horizontal form-groups-bordered validate')) !!}

                <div class="row">
         
                    <div class="small-15 medium-12 large-15 columns">
                        <label for="middle-label">Voor</label>
                        @if($totals['present'])
                        {!! Form::select('gender', array('male' => 'man', 'female' => 'vrouw'), $totals['present']['gender'], array('required' => '')) !!}

                        @else
                        {!! Form::select('gender', array('male' => 'man', 'female' => 'vrouw'), null, array('required' => '')) !!}

                        @endif
                      <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>                
                    </div>
                </div>

                
                <div class="row">
         
                    <div class="small-15 medium-12 large-15 columns">
                        <label for="middle-label">Gelegenheid</label>
                        @if($totals['present'])
                        {!! Form::text('occassion', $totals['present']['occassion'], array('required' => '')) !!}
                        @else
                        {!! Form::text('occassion', null, array('required' => '')) !!}
                        @endif
                      <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>                
                    </div>
                </div>


                <div class="row">
         
                    <div class="small-15 medium-12 large-15 columns">
                        <label for="middle-label">Bericht kado kaartje (max 200 karakters):</label>
                        @if($totals['present'])
                        {!! Form::textarea('message', $totals['present']['message'], array('required' => '', "rows" => '6', 'maxlength' => "180")) !!}
                        @else
                        {!! Form::textarea('message', null, array('required' => '', "rows" => '6',  'maxlength' => "180" )) !!}
                        @endif
    
                        <span class="form-error">
                            {!! trans('form.validation.required') !!}
                        </span>                
                    </div>
                </div>

                


            
                {!! Form::submit('toevoegen aan winkelwagen', array('class' => 'button btn-success')) !!}  


                <div class="row">
         
                    <div class="small-15 medium-12 large-15 columns">
                        <p><small>Wis je dat je bij ons een cadeau naar een apart afleveradres kan sturen tijdens het plaatsen van de bestelling!.</small></p>   
                    </div>
                </div>


            </form>  
        </div>
    </div>

    <button class="close-button" data-close aria-label="Close reveal" type="button">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
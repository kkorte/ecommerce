@extends('_layouts.default')

@section('main')

<ol class="breadcrumb">
  <li><a href="/">Home</a></li>
  <li><a href="/account">account</a></li>
  <li><a href="/account/login">login</a></li>
</ol>


<div class="account-container">
    <div class="row">
        <div class="col-lg-6">
            <div class="jumbotron">
                <h2>Inloggen</h2>
                @if ($errors->login->has())
                <div class="alert alert-danger">
                    @foreach ($errors->login->all() as $error)
                        {{ $error }}<br>        
                    @endforeach
                </div>
                @endif
                @if($result)
                	      <div class="alert alert-danger">
                	      		<div class="alert alert-success" role="alert">Je account is geactiveerd. Je kunt hieronder inloggen</div>
                	      </div>
                @endif 
                <?php echo Form::open(array('url' => '/account/login', 'class' => 'validate box login')); ?>

                    <div class="form-group">
                        {{ Form::label('email', 'Email', array('class' => '')) }}
                        {{ Form::email('email', null, array('class' => 'form-control', 'data-validate' => 'required')) }}
                    </div>
                  
                    <div class="form-group">
                        {{ Form::label('password', 'Password', array('class' => '')) }}
                        {{ Form::password('password', array('class' => 'form-control', 'data-validate' => 'required')) }}
                    </div>

                    <button type="submit" class="btn btn-default">Submit</button>

                </form>

            </div>

		</div>

        <div class="col-lg-6">

            <div class="jumbotron">

                <h2>Nieuwe klant?</h2>

                @if ($errors->register->has())
                <div class="alert alert-danger">
                    @foreach ($errors->register->all() as $error)
                        {{ $error }}<br>        
                    @endforeach
                </div>
                @endif

                <?php echo Form::open(array('url' => '/account/register', 'class' => 'box login')); ?>

                    <div class="form-group">
                        {{ Form::label('email', 'Email', array('class' => '')) }}
                        {{ Form::email('email', null, array('class' => 'form-control', 'data-validate' => 'required')) }}
                    </div>
                    
                    <div class="form-group">
                        {{ Form::label('password', 'Password', array('class' => '')) }}
                        {{ Form::password('password', array('class' => 'form-control', 'data-validate' => 'required')) }}
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('firstname', 'Firstname') }}
                                {{ Form::text('firstname', null, array('class' => 'form-control', 'data-validate' => 'required')) }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('lastname', 'Lastname') }}
                                {{ Form::text('lastname', null, array('class' => 'form-control', 'data-validate' => 'required')) }}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('company', 'Company') }}
                        {{ Form::text('company', null, array('class' => 'form-control', 'data-validate' => 'required')) }}
                    </div>


                    <div class="row">
                        <div class="col-lg-5">
                            <div class="form-group">
                                {{ Form::label('zipcode', 'Zipcode') }}
                                {{ Form::text('zipcode', null, array('class' => 'form-control', 'data-validate' => 'required')) }}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('housenumber', 'Housenumber') }}
                                {{ Form::text('housenumber', null, array('class' => 'form-control', 'data-validate' => 'required')) }}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {{ Form::label('housenumber_suffix', 'Houseletter') }}
                                {{ Form::text('housenumber_suffix', null, array('class' => 'form-control', 'data-validate' => 'required')) }}
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        {{ Form::label('street', 'Street') }}
                        {{ Form::text('street', null, array('class' => 'form-control', 'data-validate' => 'required')) }}
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('city', 'City') }}
                                {{ Form::text('city', null, array('class' => 'form-control', 'data-validate' => 'required')) }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('country', 'Country') }}
                                {{ Form::select('country', array('nl' => 'Netherlands', 'be' => 'Belgium'), null, array('class' => 'form-control', 'data-validate' => 'required')) }}
                            </div>
                        </div>
                    </div>
      

                    <button type="submit" class="btn btn-default">Register</button>

                </form>

            </div>

        </div>
    </div>        
</div>
@stop
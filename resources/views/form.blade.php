<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>{{ config('app.name') }} | Reference Form!</title>
  </head>
  <body class="bg-light" data-new-gr-c-s-check-loaded="14.992.0" data-gr-ext-installed=""> 
    @php
      $reference = \Zareismail\Strandprofile\Models\StrandprofileReference::whereHash(
        request()->route('reference'),
      )->firstOrFail(); 
    @endphp
    <div class="container"> 
      <div class="py-5 text-center">
        <h1>Welcome To {{ config('app.name') }}</h1>
        <h3>Thanks for the `Reference Form!` filling</h3>
        <p class="lead">Here you can fill the reference form for the tenant `{{ $reference->auth->name }}`</p>
      </div>

      @unless(boolval($reference->getDetails('filled')))

      <form class="needs-validation was-validated" method="post">
        <div class="row">  
          <div class="col-md-6 mb-3"> 
            <label for="firstName">First name</label>
            <input type="text" class="form-control" id="firstName" placeholder="First name" value="{{ old('firstname') }}" required name="firstName">
            <div class="invalid-feedback">
              Valid first name is required.
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="lastName">Last name</label>
            <input type="text" class="form-control" id="lastName" placeholder="Last name" value="{{ old('lastname') }}" required name="lastname">
            <div class="invalid-feedback">
              Valid last name is required.
            </div>
          </div>

          <div class="col-md-12 mb-3">
            <label for="address">Tenancy address</label>
            <input type="text" class="form-control" id="address" placeholder="Tenancy address" value="{{ old('address') }}" required name="address">
            <div class="invalid-feedback">
              Valid address is required.
            </div>
          </div>

          <div class="col-md-12 mb-3">
            <label for="rent">Monthly rent</label>
            <input type="text" class="form-control" id="rent" placeholder="Monthly rent" value="{{ old('rent') }}" required name="rent">
            <div class="invalid-feedback">
              Valid rent is required.
            </div>
          </div>

          <div class="col-md-12 mb-3">
            <label for="duration">Time at this addresss</label>
            <input type="text" class="form-control" id="duration" placeholder="Tenancy Duration" value="{{ old('duration') }}" required name="duration">
            <div class="invalid-feedback">
              Valid duration is required.
            </div>
          </div> 

          <div class="col-md-12 mb-3">
            <label for="score">Give a score to {{ $reference->auth->name }} for her\his tenancy</label>
            <input type="number" min="0" max="5" class="form-control" id="score" placeholder="Tenancy Rate" value="{{ old('score', 5) }}" name="score">
            <div class="invalid-feedback">
              Valid score is required.
            </div>
          </div>  

          <div class="col-md-12 mb-3">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="damage" name="damage" @if(old('damage')) checked @endif>
              <label class="custom-control-label" for="damage">Tenant caused damage?</label>
            </div>
          </div> 

          <div class="col-md-12 mb-3">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="maitained" name="maitained" @if(old('maitained', 1)) checked @endif>
              <label class="custom-control-label" for="maitained">Was the property maintained well?</label>
            </div>
          </div> 

          <div class="col-md-12 mb-3">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="ontime" name="ontime" @if(old('ontime', 1)) checked @endif>
              <label class="custom-control-label" for="ontime">Rent always paid on time?</label>
            </div>
          </div> 

          <div class="col-md-12 mb-3">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="breach" name="breach" @if(old('breach')) checked @endif>
              <label class="custom-control-label" for="breach">Any breach of tenancy?</label>
            </div>
          </div> 

          <div class="col-md-12 mb-3">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="relet" name="relet" @if(old('relet', 1)) checked @endif>
              <label class="custom-control-label" for="relet">Would re-let to the tenant?</label>
            </div>
          </div>

          <div class="col-md-12 mb-3">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="deposit" name="deposit" @if(old('deposit', 1)) checked @endif onchange="this.checked ? document.getElementsByClassName('deposit_comment')[0].classList.add('d-none') : document.getElementsByClassName('deposit_comment')[0].classList.remove('d-none')"> 
              <label class="custom-control-label" for="deposit">Was the deposit returned?</label>
            </div>

            <br>
            <div class="custom-control deposit_comment @if(old('deposit', 1)) d-none @endif"> 
              <input type="text" class="form-control" id="block_reson" placeholder="Deposit block reason" value="{{ old('deposit_comment') }}" name="deposit_comment">
              <div class="invalid-feedback">
                Valid reason is required.
              </div>
            </div>
          </div> 
        </div> 

        <hr class="mb-4">
        <button class="btn btn-primary btn-lg btn-block" type="submit">Send</button>
      </form>

      @else
        <h1 class="text-danger">Thanks for your cooperation; But this form has been filled earlier.</h1>
      @endif

      <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">© 2021-2022 {{ config('app.name') }}</p> 
      </footer>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> 
  

</body>
</html>
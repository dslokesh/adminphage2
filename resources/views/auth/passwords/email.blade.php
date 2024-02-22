@extends('layouts.appLogin')
  
@section('content')
<section class="mt-header layout-pt-lg layout-pb-lg">
      <div class="container">
        <div data-anim="slide-up" class="row justify-center">
          <div class="col-xl-6 col-lg-7 col-md-9">
            <div class="text-center mb-60 md:mb-30">
              <h1 class="text-30">Forgot Password</h1>
              <div class="text-18 fw-500 mt-20 md:mt-15"> @include('inc.errors-and-messages')</div>
              <div class="mt-5">You forgot your password? Here you can easily retrieve a new password.
              </div>
            </div>

            <div class="contactForm border-1 rounded-12 px-60 py-60 md:px-25 md:py-30">
			 <form method="POST" action="{{ route('password.email') }}">
         {{ csrf_field() }}   
              <div class="form-input ">
			  <input type="text" id="email_address" class="form-control" name="email" placeholder="Email" required autofocus>
                <label class="lh-1 text-16 text-light-1">Email Address </label>
				 @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
              </div>
	

              <div class="row y-ga-10 justify-between items-center pt-30">
                <div class="col-auto">

                  <div class="d-flex items-center">
                    

                  </div>

                </div>

                <div class="col-auto">
                 <a class="btn btn-link" href="{{route('login')}}"> Login</a>
                </div>
              </div>
				<button type="submit" class="button -md -dark-1 bg-accent-1 text-white col-12 mt-30">Request new password <i class="icon-arrow-top-right ml-10"></i></button>
           
			  </form>
            </div>
          </div>
        </div>
      </div>
    </section>
      
@endsection
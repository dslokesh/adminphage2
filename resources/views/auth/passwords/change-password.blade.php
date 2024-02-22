@extends('layouts.appLogin')
  
@section('content')
<section class="mt-header layout-pt-lg layout-pb-lg">
      <div class="container">
        <div data-anim="slide-up" class="row justify-center">
          <div class="col-xl-6 col-lg-7 col-md-9">
            <div class="text-center mb-60 md:mb-30">
              <h1 class="text-30">Change Password</h1>
              <div class="text-18 fw-500 mt-20 md:mt-15"> @include('inc.errors-and-messages')</div>
              </div>
          

             <div class="contactForm border-1 rounded-12 px-60 py-60 md:px-25 md:py-30">
			<form action="{{ route('reset-password') }}" method="post" autocomplete="off">
        @csrf
        @method('PUT')
              <div class="form-input ">
			   <input type="password" id="password" class="form-control" name="password">
                <label class="lh-1 text-16 text-light-1">New Password</label>
					@if ($errors->has('password'))
					<span class="text-danger">{{ $errors->first('password') }}</span>
					@endif
              </div>
			
			<div class="form-input mt-30">
			   <input type="password" id="confirm_password" class="form-control" name="confirm_password" >
                <label class="lh-1 text-16 text-light-1">Confirm Password</label>
					 @if ($errors->has('confirm_password'))
              <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
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
				<button type="submit" class="button -md -dark-1 bg-accent-1 text-white col-12 mt-30">Change Password<i class="icon-arrow-top-right ml-10"></i></button>
           
			  </form>
            </div>
          </div>
        </div>
      </div>
    </section>
      
@endsection
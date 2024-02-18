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
			<form role="form" action="{{route('profile.save')}}" method="post">
            {{ csrf_field() }}
              <div class="form-input ">
			  <input type="password" class="form-control" id="OldPassword" name="OldPassword" placeholder="Old Password" />
                <label class="lh-1 text-16 text-light-1">Old Password </label>
				 @if ($errors->has('OldPassword'))
                <span class="text-danger">{{ $errors->first('OldPassword') }}</span>
            @endif
              </div>
	

              <div class="form-input mt-30">
				  <input type="password" class="form-control" id="password" name="password" placeholder="8 characters, 1 upper case & 1 number." />
                <label class="lh-1 text-16 text-light-1">Password</label>
				@if ($errors->has('password'))
                <span class="text-danger">{{ $errors->first('password') }}</span>
            @endif
              </div>
			 <div class="form-input mt-30">
				  <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm New Password" />
                <label class="lh-1 text-16 text-light-1">Confirm New Password</label>
				@if ($errors->has('confirmPassword'))
                <span class="text-danger">{{ $errors->first('confirmPassword') }}</span>
            @endif
              </div>

              <div class="row y-ga-10 justify-between items-center pt-30">
                <div class="col-auto">

                  <div class="d-flex items-center">
                    

                  </div>

                </div>

              </div>
				<button type="submit" class="button -md -dark-1 bg-accent-1 text-white col-12 mt-30">Update <i class="icon-arrow-top-right ml-10"></i></button>
           
			  </form>
            </div>
          </div>
        </div>
      </div>
    </section>
      
@endsection
@extends('layouts.appLogin')
  
@section('content')
<section class="mt-header layout-pt-lg layout-pb-lg">
      <div class="container">
        <div data-anim="slide-up" class="row justify-center">
          <div class="col-xl-6 col-lg-7 col-md-9">
            <div class="text-center mb-60 md:mb-30">
              <h1 class="text-30">Register</h1>
              <div class="text-18 fw-500 mt-20 md:mt-15">@include('inc.errors-and-messages')</div>
              <div class="mt-5">
                Already have an account? <a href="{{route('login')}}" class="text-accent-1">Log In!</a>
              </div>
            </div>

            <div class="contactForm border-1 rounded-12 px-60 py-60 md:px-25 md:py-30">
			<form action="{{ route('register.post') }}" method="post" class="form" enctype="multipart/form-data">
			{{ csrf_field() }}
              <div class="form-input ">
                <input type="text" id="company_name	" name="company_name" value="{{ old('company_name')}}" class="form-control"  />
				 <label class="lh-1 text-16 text-light-1">Agency Name</label>
                  @if ($errors->has('company_name'))
                      <span class="text-danger">{{ $errors->first('company_name') }}</span>
                  @endif
               
              </div>
				<div class="form-input mt-30">
                 <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" class="form-control"   />
                <label class="lh-1 text-16 text-light-1">First Name</label>
				@if ($errors->has('first_name'))
                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                @endif
              </div>
				<div class="form-input mt-30">
                 <input type="text" id="last_name" name="last_name" value="{{ old('first_name') }}" class="form-control"  />
                <label class="lh-1 text-16 text-light-1">Last Name</label>
				@if ($errors->has('last_name'))
                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                @endif
              </div>
				<div class="form-input mt-30">
                 <input type="text" id="mobile" name="mobile"  value="{{ old('mobile') }}" class="form-control"   />
                <label class="lh-1 text-16 text-light-1">Mobile No with Country Code</label>
				 @if ($errors->has('mobile'))
                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                @endif
              </div>
			<div class="form-input mt-30">
                <input type="email" id="email" name="email" value="{{ old('email') }}"  class="form-control"  />
                <label class="lh-1 text-16 text-light-1">Email ID</label>
				@if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
              </div>
			  <div class="form-input mt-30">
                <textarea id="address" name="address" rows="2" style="resize:none;" class="form-control" >{{ old('address') }}</textarea>
                <label class="lh-1 text-16 text-light-1">Address</label>
				 @if ($errors->has('address'))
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                @endif
              </div>
			  <div class="form-input mt-30">
              <select name="country_id" id="country_id" class="form-control">
				<option value="">Country</option>
				@foreach($countries as $country)
                    <option value="{{$country->id}}" @if(old('country_id') == $country->id) {{'selected="selected"'}} @endif>{{$country->name}}</option>
				@endforeach
                 </select>
               
				 @if ($errors->has('country_id'))
                    <span class="text-danger">{{ $errors->first('country_id') }}</span>
                @endif
              </div>
			  <div class="form-input mt-30">
             <select name="state_id" id="state_id" class="form-control">
				<option value="">State</option>
				</select>
                
				 @if ($errors->has('state_id'))
                    <span class="text-danger">{{ $errors->first('state_id') }}</span>
                @endif
              </div>
			  <div class="form-input mt-30">
               <select name="city_id" id="city_id" class="form-control">
				<option value="">City</option>
				</select>
                
				 @if ($errors->has('city_id'))
                    <span class="text-danger">{{ $errors->first('city_id') }}</span>
                @endif
              </div>
			    <div class="form-input mt-30">
             <input type="text" id="postcode" name="postcode" value="{{ old('postcode') }}" class="form-control"    />
                <label class="lh-1 text-16 text-light-1">Zip Code</label>
				 @if ($errors->has('postcode'))
                    <span class="text-danger">{{ $errors->first('postcode') }}</span>
                @endif
              </div>
			  
              <button type="submit" class="button -md -dark-1 bg-accent-1 text-white col-12 mt-30">
                Register
                <i class="icon-arrow-top-right ml-10"></i>
              </button>

              

              
			  </form>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
@section('scripts')
 @include('inc.citystatecountryjs')
 @endsection
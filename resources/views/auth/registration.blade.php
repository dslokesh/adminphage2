@extends('layouts.appLogin')
  
@section('content')
<div class="container">
            <div class="row g-lg-4 gy-5">
   <div class="col-lg-6 text-center">
                    <div class="contact-form-area mb-5  mt-5">
                        <h3>Register</h3>
						@include('inc.errors-and-messages')
                        <form action="{{ route('register.post') }}" method="post" class="form" enctype="multipart/form-data">
			{{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label>Agency Name*</label>
										<input type="text" id="company_name" name="company_name" value="{{ old('company_name')}}" class=""  placeholder="Agency Name"  />
										@if ($errors->has('company_name'))
										<span class="text-danger">{{ $errors->first('company_name') }}</span>
										@endif
                                    </div>
                                </div>
                             
                              
							   <div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label>First Name*</label>
										<input type="text" id="first_name" name="first_name" value="{{ old('first_name')}}" class=""  placeholder="First Name"  />
										@if ($errors->has('first_name'))
										<span class="text-danger">{{ $errors->first('first_name') }}</span>
										@endif
                                    </div>
                                </div>
								 <div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label>Last Name*</label>
										<input type="text" id="last_name" name="last_name" value="{{ old('last_name')}}" class=""  placeholder="Last Name"  />
										@if ($errors->has('last_name'))
										<span class="text-danger">{{ $errors->first('last_name') }}</span>
										@endif
                                    </div>
                                </div>
								 <div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label>Mobile No with Country Code*</label>
										<input type="text" id="mobile" name="mobile" value="{{ old('mobile')}}" class=""  placeholder="Mobile No with Country Code"  />
										@if ($errors->has('mobile'))
										<span class="text-danger">{{ $errors->first('mobile') }}</span>
										@endif
                                    </div>
                                </div>
								 <div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label>Email ID*</label>
										<input type="text" id="email" name="email" value="{{ old('email')}}" class=""  placeholder="Email ID"  />
										@if ($errors->has('email'))
										<span class="text-danger">{{ $errors->first('email') }}</span>
										@endif
                                    </div>
                                </div>
								 <div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label>Address</label>
										<input type="text" id="address" name="address" value="{{ old('address')}}" class=""  placeholder="Address"  />
										@if ($errors->has('address'))
										<span class="text-danger">{{ $errors->first('address') }}</span>
										@endif
                                    </div>
                                </div>
								
								<div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label>Country</label>
									<select name="country_id" id="country_id" class="">
									<option value="">Country</option>
									@foreach($countries as $country)
									<option value="{{$country->id}}" @if(old('country_id') == $country->id) {{'selected="selected"'}} @endif>{{$country->name}}</option>
									@endforeach
									</select>

									
                                    </div>
									@if ($errors->has('country_id'))
									<span class="text-danger">{{ $errors->first('country_id') }}</span>
									@endif
                                </div>
								<div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label>State</label>
									<select name="state_id" id="state_id" class="">
									<option value="">State</option>
									</select>
									
                                    </div>
									@if ($errors->has('state_id'))
									<span class="text-danger">{{ $errors->first('state_id') }}</span>
									@endif
                                </div>
								<div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label>City</label>
										<select name="city_id" id="city_id" class="">
										<option value="">City</option>
										</select>
									
                                    </div>
									@if ($errors->has('city_id'))
									<span class="text-danger">{{ $errors->first('city_id') }}</span>
									@endif
                                </div>
								<div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label>Zip Code</label>
										 <input type="text" id="postcode" name="postcode" value="{{ old('postcode') }}" class=""  placeholder="Zip Code"  />
										@if ($errors->has('postcode'))
										<span class="text-danger">{{ $errors->first('postcode') }}</span>
										@endif
                                    </div>
                                </div>
								
                                <div class="col-lg-12">
                                    <div class="form-inner">
									<button type="submit" class="primary-btn1 btn-hover">Register <i class="icon-arrow-top-right ml-10"></i></button>
									
                                      
                                    </div>
									<div class="row">
									<div class="col-lg-6">
                <a href="{{route('login')}}" class="text-accent-1" style="text-align:left">Login</a>
              </div>
									
				 </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> 
				  </div>
                </div> 
@endsection
@section('scripts')
 @include('inc.citystatecountryjs')
 @endsection
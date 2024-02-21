@extends('layouts.appLogin')
  
@section('content')
<div class="container">
            <div class="row g-lg-4 gy-5">
   <div class="col-lg-6 offset-md-4 text-center">
                    <div class="contact-form-area mb-5  mt-5">
                        <h3>Edit Profile</h3>
						
						@include('inc.errors-and-messages')
                        <form action="{{ route('profile-edit-post', $user->id) }}" method="post" class="form" enctype="multipart/form-data">
    
    {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label>Agency Name*</label>
										<input type="text" id="company_name" name="company_name" value="{{ old('company_name') ?: $user->company_name }}" class=""  placeholder="Agency Name"  />
										@if ($errors->has('company_name'))
										<span class="text-danger">{{ $errors->first('company_name') }}</span>
										@endif
                                    </div>
                                </div>
                             
                              
							   <div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label>First Name*</label>
										<input type="text" id="first_name" name="first_name"  value="{{ old('first_name') ?: $user->name }}" class=""  placeholder="First Name"  />
										@if ($errors->has('first_name'))
										<span class="text-danger">{{ $errors->first('first_name') }}</span>
										@endif
                                    </div>
                                </div>
								 <div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label>Last Name*</label>
										<input type="text" id="last_name" name="last_name" value="{{ old('last_name') ?: $user->lname }}" class=""  placeholder="Last Name"  />
										@if ($errors->has('last_name'))
										<span class="text-danger">{{ $errors->first('last_name') }}</span>
										@endif
                                    </div>
                                </div>
								 <div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label>Mobile No with Country Code*</label>
										<input type="text" id="mobile" name="mobile" value="{{ old('mobile') ?: $user->mobile }}" class=""  placeholder="Mobile No with Country Code"  />
										@if ($errors->has('mobile'))
										<span class="text-danger">{{ $errors->first('mobile') }}</span>
										@endif
                                    </div>
                                </div>
								 <div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label>Email ID*</label>
										<input type="text" id="email" name="email" value="{{ old('email') ?: $user->email }}" class=""  placeholder="Email ID"  />
										@if ($errors->has('email'))
										<span class="text-danger">{{ $errors->first('email') }}</span>
										@endif
                                    </div>
                                </div>
								
								
								
                                <div class="col-lg-12">
                                    <div class="form-inner">
									<button type="submit" class="primary-btn1 btn-hover">Save <i class="icon-arrow-top-right ml-10"></i></button>
									
                                      
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
 @endsection
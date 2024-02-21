@extends('layouts.appLogin')
  
@section('content')
<div class="container">
            <div class="row g-lg-4 gy-5">

   <div class="col-lg-6 offset-md-4 text-center">
                    <div class="contact-form-area mb-5  mt-5">
                        <h3>Change Password</h3>
						@include('inc.errors-and-messages')
                         <form method="POST" action="{{ route('password.email') }}">
         {{ csrf_field() }}   
                            <div class="row">
                                <div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label>New Password*</label>
										 <input type="password" id="password" class="form-control" name="password" placeholder="New Password">
										@if ($errors->has('email'))
										<span class="text-danger">{{ $errors->first('email') }}</span>
										@endif
                                    </div>
                                </div>
                             <div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label>Confirm Password*</label>
										 <input type="password" id="confirm_password" class="form-control" name="confirm_password" placeholder="Confirm Password">
										@if ($errors->has('confirm_password'))
										<span class="text-danger">{{ $errors->first('confirm_password') }}</span>
										@endif
                                    </div>
                                </div>
                              
                                <div class="col-lg-12">
                                    <div class="form-inner">
									<button type="submit" class="primary-btn1 btn-hover">Change Password <i class="icon-arrow-top-right ml-10"></i></button>
									
                                      
                                    </div>
									<div class="row">
									<div class="col-lg-6 text-start">
                <a href="{{route('login')}}" class="text-accent-1">Login</a>
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
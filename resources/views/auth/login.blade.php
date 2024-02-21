@extends('layouts.appLogin')
  
@section('content')
<div class="container">
            <div class="row g-lg-4 gy-5">
   <div class="col-lg-6 text-center">
                    <div class="contact-form-area mb-5  mt-5">
                        <h3>Log In</h3>
						@include('inc.errors-and-messages')
                        <form action="{{ route('login.post') }}" method="POST" >
				@csrf
                            <div class="row">
                                <div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label>Email Address*</label>
										<input type="text" id="email_address" class="" name="email" placeholder="Email" required autofocus>
										<label class="lh-1 text-16 text-light-1">Email Address </label>
										@if ($errors->has('email'))
										<span class="text-danger">{{ $errors->first('email') }}</span>
										@endif
                                    </div>
                                </div>
                               <div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label>Password</label>
                                        <input type="password" id="password" class="form-control" name="password" placeholder="Password" required>
									@if ($errors->has('password'))
									<span class="text-danger">{{ $errors->first('password') }}</span>
									@endif
                                    </div>
                                </div>
                              
                                <div class="col-lg-12">
                                    <div class="form-inner">
									<button type="submit" class="primary-btn1 btn-hover">Login <i class="icon-arrow-top-right ml-10"></i></button>
									
                                      
                                    </div>
									<div class="row">
									<div class="col-lg-6">
                <a href="{{route('register')}}" class="text-accent-1" style="text-align:left">Sign Up!</a>
              </div>
									<div class="col-lg-6">
                 <a class="btn btn-link" href="{{route('resetpassword')}}" style="text-align:right"> {{ __('Forgot Your Password?') }}</a>
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
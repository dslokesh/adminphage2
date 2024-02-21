@extends('layouts.appLogin')
  
@section('content')
<div class="container">
            <div class="row g-lg-4 gy-5">

   <div class="col-lg-6 offset-md-4 text-center">
                    <div class="contact-form-area mb-5  mt-5">
                        <h3>Forgot Password</h3>
						@include('inc.errors-and-messages')
                         <form method="POST" action="{{ route('password.email') }}">
         {{ csrf_field() }}   
                            <div class="row">
                                <div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label>Email Address*</label>
										<input type="text" id="email_address" class="" name="email" placeholder="Email" required autofocus>
										
                                    </div>
									@if ($errors->has('email'))
									<span class="text-danger">{{ $errors->first('email') }}</span>
									@endif
                                </div>
                             
                              
                                <div class="col-lg-12">
                                    <div class="form-inner">
									<button type="submit" class="primary-btn1 btn-hover">Request new password <i class="icon-arrow-top-right ml-10"></i></button>
									
                                      
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
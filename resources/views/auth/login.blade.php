@extends('layouts.appLogin')
  
@section('content')
<div class="card-body" >
      <p class="login-box-msg"></p>

      <form action="{{ route('login.post') }}" method="POST" >
       @csrf
        <div class="input-group mb-3">
          
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          <input type="text" id="email_address" class="form-control" name="email" placeholder="Email" required autofocus>
        </div>
        @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
        <div class="input-group mb-3">
          
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          <input type="password" id="password" class="form-control" name="password" placeholder="Password" required>
        </div>
        @if ($errors->has('password'))
                <span class="text-danger">{{ $errors->first('password') }}</span>
            @endif
        <div class="row">
          
          <!-- /.col -->
          <div class="col-4 offset-md-4">
            <button type="submit" class="btn btn-primary btn-block">Login</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1 mt-20">
        <a class="btn btn-link" href="{{route('resetpassword')}}"> {{ __('Forgot Your Password?') }}</a>
		<a class="btn btn-link float-right" href="{{route('register')}}"> {{ __('Agency SignUp') }}</a>
      </p>
	  
    </div>
@endsection
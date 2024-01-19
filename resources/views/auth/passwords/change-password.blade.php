@extends('layouts.appLogin')
  
@section('content')
<div class="card-body">
      <p class="login-box-msg">Change Password</p>
		<form action="{{ route('reset-password') }}" method="post" autocomplete="off">
        @csrf
        @method('PUT')
		<input type="hidden" name="email" value="{{ $email }} "/>
		<div class="input-group mb-3">
          <input type="password" id="password" class="form-control" name="password" placeholder="New Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        @if ($errors->has('password'))
              <span class="text-danger">{{ $errors->first('password') }}</span>
          @endif   
		<div class="input-group mb-3">
          <input type="password" id="confirm_password" class="form-control" name="confirm_password" placeholder="Confirm Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        @if ($errors->has('confirm_password'))
              <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
          @endif     
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Change Password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <p class="mt-3 mb-1">
        <a href="{{route('login')}}">Login</a>
      </p>
    </div>
@endsection

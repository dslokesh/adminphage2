@extends('layouts.appLogin')
  
@section('content')
<div class="card-body">
      <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
      <form method="POST" action="{{ route('password.email') }}">
         {{ csrf_field() }}   
        <div class="input-group mb-3">
          <input id="email" type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        @if ($errors->has('email'))
                <span class="text-danger text-left mb-3">{{ $errors->first('email') }}</span>
            @endif
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Request new password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <p class="mt-3 mb-1">
        <a href="{{route('login')}}">Login</a>
      </p>
    </div>
@endsection

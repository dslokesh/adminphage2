@extends('layouts.signUp')
  
@section('content')
<main class="login-form">
  <div class="cotainer">
      <div class=" justify-content-center">
        <div class="col-md-12 ">
          <div class="row">

         
     
<div class="col-md-12 background-white">
             
  
                      <form action="{{ route('register.post') }}" method="post" class="form" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class=" card-primary">
            <div class="card-body row">
               
                  <div class="row">
                <div class="form-group col-md-12">
                  <input type="text" id="company_name	" name="company_name" value="{{ old('company_name')}}" class="form-control"  placeholder="Agency Name" />
                  @if ($errors->has('company_name'))
                      <span class="text-danger">{{ $errors->first('company_name') }}</span>
                  @endif
                </div>
                <div class="form-group col-md-6">
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" class="form-control"  placeholder="First Name" />
                @if ($errors->has('first_name'))
                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                @endif
              </div>
			        <div class="form-group col-md-6">
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" class="form-control"  placeholder="Last Name" />
                @if ($errors->has('last_name'))
                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                @endif
              </div>
			  
                <div class="form-group col-md-6">
                <input type="text" id="mobile" name="mobile" required value="{{ old('mobile') }}" class="form-control"  placeholder="Mobile No with Country Code *" />
                @if ($errors->has('mobile'))
                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                @endif
              </div>
			        <div class="form-group col-md-6">
                <input type="email" id="email" name="email" value="{{ old('email') }}" required class="form-control"  placeholder="Email ID *" />
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
              </div>
			 
              <div class="form-group col-md-12">
               <textarea id="address" name="address" rows="2" style="resize:none;" class="form-control" required placeholder="Address" >{{ old('address') }}</textarea>
                @if ($errors->has('address'))
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                @endif
              </div>
               
			  <div class="form-group col-md-6">
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
			  <div class="form-group col-md-6">
               
                <select name="state_id" id="state_id" class="form-control">
				<option value="">State</option>
				</select>
              </div>
              <div class="form-group col-md-6">
                <select name="city_id" id="city_id" class="form-control">
				<option value="">City</option>
				</select>
              </div>
               <div class="form-group col-md-6">
                <input type="text" id="postcode" name="postcode" value="{{ old('postcode') }}" class="form-control" placeholder="Zip Code"   />
                @if ($errors->has('postcode'))
                    <span class="text-danger">{{ $errors->first('postcode') }}</span>
                @endif
              </div>
              
                </div>
             
			  
            </div>
			
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
      <div class="col-4 offset-md-4">
            <button type="submit" class="btn btn-primary btn-block">Sign Up</button>

        
        </div>
        <div class="col-6 pt-3">
          
       

        
        </div>
      </div>
      <p class="mb-1 mt-20">
       
		<a class="btn btn-link float-right" href="{{route('login')}}"> {{ __('Already have an account?') }}</a>
      </p>
    </form>
                      
                        
                 
              </div>
        </div>
          </div>
      </div>
  </div>
</main>
@endsection
@section('scripts')
 @include('inc.citystatecountryjs')
 @endsection
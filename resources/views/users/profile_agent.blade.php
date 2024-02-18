@extends('layouts.appLogin')
  
@section('content')
<section class="mt-header layout-pt-lg layout-pb-lg">
      <div class="container">
        <div data-anim="slide-up" class="row justify-center">
          <div class="col-xl-6 col-lg-7 col-md-9">
            <div class="text-center mb-60 md:mb-30">
              <h1 class="text-30">Edit Profile</h1>
              <div class="text-18 fw-500 mt-20 md:mt-15">@include('inc.errors-and-messages')</div>
             
            </div>

            <div class="contactForm border-1 rounded-12 px-60 py-60 md:px-25 md:py-30">
			<form action="{{ route('profile-edit-post', $user->id) }}" method="post" class="form" enctype="multipart/form-data">
    
    {{ csrf_field() }}
              <div class="form-input ">
                <input type="text" id="company_name	" name="company_name" value="{{ old('company_name') ?: $user->company_name }}" class="form-control"  />
				 <label class="lh-1 text-16 text-light-1">Agency Name</label>
                  @if ($errors->has('company_name'))
                      <span class="text-danger">{{ $errors->first('company_name') }}</span>
                  @endif
               
              </div>
				<div class="form-input mt-30">
                 <input type="text" id="first_name" name="first_name" value="{{ old('first_name') ?: $user->name }}" class="form-control"  />
                <label class="lh-1 text-16 text-light-1">First Name</label>
				@if ($errors->has('first_name'))
                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                @endif
              </div>
				<div class="form-input mt-30">
               <input type="text" id="last_name" name="last_name" value="{{ old('last_name') ?: $user->lname }}" class="form-control"  />
                <label class="lh-1 text-16 text-light-1">Last Name</label>
				@if ($errors->has('last_name'))
                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                @endif
              </div>
				<div class="form-input mt-30">
                 <input type="text" id="mobile" name="mobile" value="{{ old('mobile') ?: $user->mobile }}" class="form-control" />
                <label class="lh-1 text-16 text-light-1">Mobile No with Country Code</label>
				 @if ($errors->has('mobile'))
                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                @endif
              </div>
			<div class="form-input mt-30">
                <input type="text" id="email" name="email" readonly value="{{ old('email') ?: $user->email }}" class="form-control"/>
                <label class="lh-1 text-16 text-light-1">Email ID</label>
				@if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
              </div>
			  
              <button type="submit" class="button -md -dark-1 bg-accent-1 text-white col-12 mt-30">
                Save
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
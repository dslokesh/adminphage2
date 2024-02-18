@extends('layouts.appLogin')
@section('content')

   
    <section data-anim="fade" class="hero -type-1 -min">
      <div class="hero__bg">
        <img src="{{asset('front/img/hero/1/1.png')}}" alt="image">
        <img src="{{asset('front/img/hero/1/shape.svg')}}" alt="image">
      </div>

      <div class="container">
        <div class="row justify-center">
          <div class="col-xl-8 col-lg-10">
            <div class="hero__content">
              <h1 class="hero__title">
                Phuket
              </h1>

              

              <div class="mt-30">
 <form action="{{ route('agent-vouchers.store') }}" method="post" class="form" style="padding-top: 150px;"> 
    {{ csrf_field() }}
                <div class="searchForm -type-1 -col-2 shadow-1">
                  <div class="searchForm__form">
                   

                    <div class="searchFormItem">
                      <div class="searchFormItem__button">
                        <div class="searchFormItem__icon size-50 rounded-12 border-1 flex-center">
                          <i class="text-20 icon-calendar"></i>
                        </div>
                        <div class="searchFormItem__content">
                          <h5>When</h5>
                          <div>
                           <input type="text" id="travel_from_date" name="travel_from_date" value="{{ old('travel_from_date')?:date('d-m-Y') }}" class="datepickerAgent"  />
                          </div>
                        </div>
                      </div>

                      <!-- ... rest of the code ... -->

                    </div>
					<div class="searchFormItem">
                      <div class="searchFormItem__button">
                        <div class="searchFormItem__icon rounded-12 border-1 flex-center">
                          <i class="text-20 icon-calendar"></i>
                        </div>
                        <div class="searchFormItem__content">
                          <h5>Night</h5>
                          <div>
							<select name="nof_night" id="nof_night" class="form-control">
							<option value="">--select--</option>
							@for($i =1; $i<30; $i++)
							@if(!empty(old('nof_night')))
							<option value="{{$i}}" @if(old('nof_night') == $i) {{'selected="selected"'}} @endif >{{$i}}</option>
							@else
							<option value="{{$i}}" @if($i == 7) {{'selected="selected"'}} @endif >{{$i}}</option>	
							@endif
							@endfor
							</select>
							
                          </div>
                        </div>
                      </div>

                      <!-- ... rest of the code ... -->

                    </div>
                  </div>

                  <div class="searchForm__button">
                    <button class="button -dark-1 bg-accent-1 text-white" type="submit" name="save_and_activity">
                      <i class="icon-search text-16 mr-10"></i>
                      Search
                    </button>
                  </div>
                </div>
				</form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

   
    <!-- /.content -->
@endsection
@section('scripts')
@include('inc.citystatecountryjs')
<script type="text/javascript">
  
  // ... your existing JavaScript code ...

</script>
@endsection

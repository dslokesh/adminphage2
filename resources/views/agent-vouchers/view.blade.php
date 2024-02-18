@extends('layouts.appLogin')
@section('content')

     <section data-anim-wrap class="layout-pt-md layout-pb-lg mt-header">
      <div class="container">
	  
        <div class="row">
          <div data-anim-child="fade" class="col-lg-8">
            @include('inc.errors-and-messages')

            <div class="bg-white rounded-12 shadow-2 py-30 px-30 md:py-20 md:px-20 mt-30">
			
              <h2 class="text-30 md:text-24 fw-700">Booking Details</h2>
 <form id="cusDetails" method="post" action="{{route('agent.vouchers.status.change',$voucher->id)}}" >
			 {{ csrf_field() }}
              <div class="row y-gap-30 contactForm pt-30">
			  
                <div class="col-6">

                  <div class="form-input ">
                    <input type="text" name="fname" value="{{$fname}}" class="form-control"  required>
                    <label class="lh-1 text-16 text-light-1">First Name</label>
                  </div>
					
                </div>
					<div class="col-6">

                  <div class="form-input ">
                    <input type="text" name="lname" value="{{$lname}}" class="form-control"  required>
                    <label class="lh-1 text-16 text-light-1">Last Name</label>
                  </div>

                </div>
                <div class="col-md-6">

                  <div class="form-input ">
                     <input type="text" name="customer_email" value="{{(!empty($voucher->guest_email))?$voucher->guest_email:$voucher->agent->email}}" class="form-control" >
                    <label class="lh-1 text-16 text-light-1">Email</label>
                  </div>

                </div>

                <div class="col-md-6">
                  <div class="form-input ">
                    <input type="text" name="customer_mobile" value="{{(!empty($voucher->guest_phone))?$voucher->guest_phone:$voucher->agent->mobile}}" class="form-control" >
                    <label class="lh-1 text-16 text-light-1">Mobile No</label>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-input ">
                     <input type="text" name="agent_ref_no" value="{{$voucher->agent_ref_no}}" class="form-control" >
                    <label class="lh-1 text-16 text-light-1">Agent Reference No.</label>
                  </div>
                </div>


                

                <div class="col-12">

                  <div class="form-input ">
                     <textarea type="text" class="form-control" style="resize:none;" name="remark" rows="2">{{$voucher->remark}}</textarea>
                    <label class="lh-1 text-16 text-light-1">Remark</label>
                  </div>

                </div>

			
              </div>
			  @php
					$ii = 0;
					@endphp
			@if(!empty($voucherActivity) && $voucher->is_activity == 1)
				@foreach($voucherActivity as $ap)
				  @if(($ap->transfer_option == 'Shared Transfer') || ($ap->transfer_option == 'Pvt Transfer'))
				  @php
					$ii = 1;
					@endphp
				@endif
					@endforeach
			
            <div class="card card-default contactForm  mt-2 {{($ii=='0')?'hide':''}}">
              <div class="card-header">
                <h3 class="card-title"><i class="nav-icon fas fa-book" style="color:black"></i> Additional Information</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
                <div class="card-body row">
					@if(!empty($voucherActivity))
						 @php
					$c=0;
					$tkt=0;
					@endphp
					 @foreach($voucherActivity as $ap)
						@if(($ap->transfer_option != 'Ticket Only'))
							@php $tkt++; @endphp
						@endif
					  @endforeach
					<div class="col-md-6 @if($tkt == 0) hide @endif">
					<div class="form-input ">
					<input type="text" class="form-control" id="defaut_dropoff_location" />
					<label class="lh-1 text-16 text-light-1">Defaut Dropoff Location</label>
					</div>
					</div>
					
					<div class="col-md-6 @if($tkt == 0) hide @endif">
					<div class="form-input ">
					<input type="text" class="form-control" id="defaut_pickup_location" />
					<label class="lh-1 text-16 text-light-1">Defaut Pickup Location</label>
					</div>
					</div>
				
					  @foreach($voucherActivity as $ap)
				  @if(($ap->transfer_option == 'Shared Transfer') || ($ap->transfer_option == 'Pvt Transfer'))
				  @php
					$c++;
					$activity = SiteHelpers::getActivity($ap->activity_id);
          
					@endphp
					
                  <div class="row" style="margin-bottom: 15px;">
                    <div class="col-12">
					<p><strong>{{$c}}. {{$ap->variant_name}} : {{$ap->transfer_option}}
					@if($ap->transfer_option == 'Shared Transfer')
					@php
					$zone = SiteHelpers::getZoneName($ap->transfer_zone);
					@endphp
					- Zone :{{@$zone->name}}
					@endif</strong></p></div>
					@if($activity->entry_type=='Arrival')
						
						<div class="form-group col-md-6">
						 
						<input type="text" class="form-control inputsave autodropoff_location" id="dropoff_location{{$ap->id}}" data-name="dropoff_location"  data-id="{{$ap->id}}" value="{{$ap->dropoff_location}}" required data-zone="{{$ap->transfer_zone}}"  placeholder="Dropoff Location*" />
						
						<label for="inputName" style="width: 100%;"> <span class="float-left"><input type="checkbox" data-idinput="dropoff_location{{$ap->id}}" class="chk_other " data-name="dropoff_other"  data-id="{{$ap->id}}" value="1"  /> Other<span></label>
						</div>
					
					
					<div class="form-group col-md-6 ">
				<input type="text" class="form-control inputsave" id="passenger_name{{$ap->id}}" data-name="passenger_name"  data-id="{{$ap->id}}" required value="{{$ap->passenger_name}}"  placeholder="Passenger Name*" />
				
              </div>
			 
			   <div class="form-group col-md-6 ">
                 <input type="text" id="actual_pickup_time{{$ap->id}}" value="{{$ap->actual_pickup_time}}" class="form-control inputsave" required placeholder="Arrival Time*" data-id="{{$ap->id}}" data-name="actual_pickup_time" />
				 
              </div>
			 
			  
			  <div class="form-group col-md-6 ">
                 <input type="text" id="flight_no{{$ap->id}}" value="{{$ap->flight_no}}" class="form-control inputsave"  placeholder="Arrival Flight Details*" required data-id="{{$ap->id}}" data-name="flight_no" />
				
              </div>
                    
					<div class="form-group col-md-12">
					<input type="text" class="form-control inputsave" id="remark{{$ap->id}}" data-name="remark"  data-id="{{$ap->id}}" value="{{$ap->remark}}"  placeholder="Remark" />
                    </div>
					
					@elseif($activity->entry_type=='Interhotel')
		  
                    <div class="form-group col-md-6">
						
					<input type="text" class="form-control inputsave autocom" id="pickup_location{{$ap->id}}" data-name="pickup_location"  data-id="{{$ap->id}}" value="{{$ap->pickup_location}}" data-zone="{{$ap->transfer_zone}}"  placeholder="Pickup Location*" required />
										 <label for="inputName" style="width: 100%;"><span class="float-left"><input type="checkbox" data-idinput="pickup_location{{$ap->id}}" class="chk_other " data-name="pickup_other"  data-id="{{$ap->id}}" value="1"  /> Other<span></label>

                     
                    </div>
					 <div class="form-group col-md-6">
					
					 
					
					<input type="text" class="form-control inputsave autodropoff_location" id="dropoff_location{{$ap->id}}" data-name="dropoff_location"  data-id="{{$ap->id}}" value="{{$ap->dropoff_location}}" data-zone="{{$ap->transfer_zone}}"  required placeholder="Dropoff Location*" />
					 <label for="inputName" style="width: 100%;"><span class="float-left"><input type="checkbox" data-idinput="dropoff_location{{$ap->id}}" class="chk_other " data-name="dropoff_other"  data-id="{{$ap->id}}" value="1"  /> Other<span></label>
                    </div>
					 <div class="form-group col-md-6 ">
               
                 <input type="text" id="actual_pickup_time{{$ap->id}}" value="{{$ap->actual_pickup_time}}" class="form-control inputsave"  placeholder="Pickup Time*" required data-id="{{$ap->id}}" data-name="actual_pickup_time" />
				 
              </div>
                    <div class="form-group col-md-6">
					
					<input type="text" class="form-control inputsave" id="remark{{$ap->id}}" data-name="remark"  data-id="{{$ap->id}}" value="{{$ap->remark}}" required placeholder="Remark" />
                    </div>
					@elseif($activity->entry_type=='Departure')
		  
                    <div class="form-group col-md-6">
					
					
					<input type="text" class="form-control inputsave autocom" id="pickup_location{{$ap->id}}"  data-name="pickup_location"  data-id="{{$ap->id}}" value="{{$ap->pickup_location}}" data-zone="{{$ap->transfer_zone}}" placeholder="Pickup Location*" required />
					 <label for="inputName" style="width: 100%;"><span class="float-left"><input type="checkbox" data-idinput="pickup_location{{$ap->id}}" class="chk_other " data-name="pickup_other"  data-id="{{$ap->id}}" value="1"  /> Other<span></label>
                     
                    </div>
					
					 <div class="form-group col-md-6 ">
                
                 <input type="text" id="actual_pickup_time{{$ap->id}}" value="{{$ap->actual_pickup_time}}" class="form-control inputsave"  placeholder="Pickup Time*" required data-id="{{$ap->id}}" data-name="actual_pickup_time" />
				 
              </div>
			  <div class="form-group col-md-6 ">
               
                 <input type="text" id="flight_no{{$ap->id}}" value="{{$ap->flight_no}}" class="form-control inputsave"  placeholder="Departure Flight Details*" required data-id="{{$ap->id}}" data-name="flight_no" />
				
              </div>
                    <div class="form-group col-md-6">
					
					<input type="text" class="form-control inputsave" id="remark{{$ap->id}}" data-name="remark"  data-id="{{$ap->id}}" value="{{$ap->remark}}"  placeholder="Remark" />
                    </div>
					@else
						<div class="form-group col-md-6">
					
					 
						
					<input type="text" class="form-control inputsave autocom" id="pickup_location{{$ap->id}}"  data-name="pickup_location"  data-id="{{$ap->id}}" value="{{$ap->pickup_location}}" data-zone="{{$ap->transfer_zone}}" required placeholder="Pickup Location*" required />
					 <label for="inputName" style="width: 100%;"><span class="float-left"><input type="checkbox" data-idinput="pickup_location{{$ap->id}}" class="chk_other " data-name="pickup_other"  data-id="{{$ap->id}}" value="1"   /> Other<span></label>
					  </div>
					
                     @if(($activity->pvt_TFRS=='1') && ($activity->pick_up_required=='1'))
					<div class="form-group col-md-6 ">
                <label for="inputName"></label>
                 <input type="text" id="actual_pickup_time{{$ap->id}}" value="{{$ap->actual_pickup_time}}" class="form-control inputsave" required placeholder="Pickup Time*" data-id="{{$ap->id}}" data-name="actual_pickup_time" />
				 
              </div>
                    @endif
					<div class="form-group col-md-6">
					
					<input type="text" class="form-control inputsave" id="remark{{$ap->id}}" data-name="remark"  data-id="{{$ap->id}}" value="{{$ap->remark}}"  placeholder="Remark" />
                    </div>
					
					@endif
                  </div>
				   @endif
				  @endforeach
                 @endif
				  
                </div>
				@endif
                <!-- /.card-body -->

               
            </div>
			  <div class="card card-default mt-2">
              <div class="card-header">
               <h3 class="card-title"><i class="nav-icon fas fa-credit-card" style="color:black"></i>  Payment Options</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
                <div class="card-body">
                  <div class="row" style="margin-bottom: 5px;">
				  <div class="col-auto">
					@php
					$balance  = $voucher->agent->agent_amount_balance - $voucher->agent->agent_credit_limit;
					@endphp
                  <div class="d-flex items-center">
                    <div class="form-radio ">
                      <input type="radio" checked name="payment"  />
                    </div>
                    <div class="lh-11 ml-10"> Credit Limit (Wallet Balance AED {{($balance > 0)?$balance:0}})</div>
					<div class="form-radio ">
                     <input type="radio" disabled name="payment"  />
                    </div>
                    <div class="lh-11 ml-10">Credit Card / Debit Card</div>
                  </div>
				
                </div>
                    
                   
                  </div>
               
                </div>
                <!-- /.card-body -->
			
   
	  <div class="col-auto">

                  <div class="d-flex items-center">
                    <div class="form-checkbox ">
                      <input type="checkbox" name="tearmcsk" required id="tearmcsk" />
                      <div class="form-checkbox__mark">
                        <div class="form-checkbox__icon">
                          <svg width="10" height="8" viewBox="0 0 10 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.29082 0.971021C9.01235 0.692189 8.56018 0.692365 8.28134 0.971021L3.73802 5.51452L1.71871 3.49523C1.43988 3.21639 0.987896 3.21639 0.709063 3.49523C0.430231 3.77406 0.430231 4.22604 0.709063 4.50487L3.23309 7.0289C3.37242 7.16823 3.55512 7.23807 3.73783 7.23807C3.92054 7.23807 4.10341 7.16841 4.24274 7.0289L9.29082 1.98065C9.56965 1.70201 9.56965 1.24984 9.29082 0.971021Z" fill="white" />
                          </svg>
                        </div>
                      </div>
                    </div>

                    <div class="lh-11 ml-10">By clicking Pay Now you agree that you have read ad understood our Terms and Conditions</div>

                  </div>

                </div>
				<div class="row m-3">
				<div class="col-6 text-right">
				@if($voucher->status_main < 4)
				<button type="submit" name="btn_hold" class="button -md -blue-1 bg-accent-2 text-white col-12 mt-30">Hold</button>
				@endif
				</div>
				<div class="col-6 text-right">
				@if($voucher->status_main < 5 )
				<button type="submit" name="btn_paynow" class="button -md -dark-1 bg-accent-1 text-white col-12 mt-30">Pay Now</button>
				@endif
				</div>

</div>
               
            </div>
			
            </form>
			</div>


           </div>

          <div data-anim-child="fade delay-2" class="col-lg-4">
            <div class="pl-50 md:pl-0">
              <div class="bg-white rounded-12 shadow-2 py-30 px-30 md:py-20 md:px-20">
                <h2 class="text-20 fw-500">Your booking details</h2>

				@php
				$totalGrand =0; 
			  @endphp
			  @if(!empty($voucherActivity) && $voucher->is_activity == 1)
					@if(!empty($voucherActivity))
					  @foreach($voucherActivity as $ap)
				  @php
					$activity = SiteHelpers::getActivity($ap->activity_id);
					@endphp
				  <div class="d-flex mt-30">
				   <img src="{{asset('uploads/activities/thumb/'.$activity->image)}}" style="width:50px" alt="image">
                  <div class="ml-10">Tour Option : {{$ap->variant_name}}</div>
				  <div class="ml-10"> <form id="delete-form-{{$ap->id}}" method="post" action="{{route('agent.voucher.activity.delete',$ap->id)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <small>
                            <a class="btn btn-xs btn-danger border-round" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$ap->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            "><i class="fas fa-trash-alt"></i></a></small></div>
                </div>

                <div class="line mt-20 mb-20"></div>
                <div class="">

                  <div class="d-flex items-center justify-between">
                    <div class="fw-500">Date:</div>
                    <div class="">{{ $ap->tour_date ? date(config('app.date_format'),strtotime($ap->tour_date)) : null }}</div>
                  </div>

                  <div class="d-flex items-center justify-between">
                    <div class="fw-500">Transfer Type:</div>
                    <div class="">{{$ap->transfer_option}}</div>
                  </div>
					@if($ap->transfer_option == 'Shared Transfer')
					@php
					$pickup_time = SiteHelpers::getPickupTimeByZone($ap->variant_zones,$ap->transfer_zone);
					@endphp
					 <div class="d-flex items-center justify-between">
                    <div class="fw-500">Pickup Timing:</div>
                    <div class="">{{$pickup_time}}</div>
                  </div>
				  @endif
				@if(($ap->transfer_option == 'Pvt Transfer') && ($ap->variant_pick_up_required == '1')  && ($ap->variant_pvt_TFRS == '1'))
					@php
					$pickup_time = SiteHelpers::getPickupTimeByZone($ap->variant_zones,$ap->transfer_zone);
					@endphp
					 <div class="d-flex items-center justify-between">
                    <div class="fw-500">Pickup Timing:</div>
                    <div class="">{{$ap->variant_pvt_TFRS_text}}</div>
                  </div>
				  @endif
                 

                  <div class="d-flex items-center justify-between">
                    <div class="fw-500">Pax:</div>
                    <div class="">Adult x {{$ap->adult}}</div>
                  </div>

                  <div class="d-flex items-center justify-between">
                    <div class="fw-500"></div>
                    <div class="">Child x{{$ap->child}}</div>
                  </div>
					<div class="d-flex items-center justify-between">
                    <div class="fw-500">Amount Incl. VAT:</div>
                    <div class="">AED {{$ap->totalprice}}</div>
                  </div>
                </div>

                <div class="line mt-20 mb-20"></div>
				@php
					$totalGrand += $ap->totalprice; 
				  @endphp
				 @endforeach
                 @endif
				  @endif
               
                <div class="">

                  <div class="d-flex items-center justify-between">
                    <div class="fw-500"><strong>Grand Total</strong></div>
                    <div class=""> <strong>AED {{$totalGrand}}</strong></div>
                  </div>

                

                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>
@endsection



@section('scripts')
<script  src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js
"></script>



<script type="text/javascript">
 
  $(function(){
	 $('.chk_other').each(function() {
        var inputid = $(this).data('idinput');
        var isChecked = $(this).is(':checked');

        // Handle checkbox change
        $(this).on('change', function() {
            if ($(this).is(':checked')) {
                $("body #" + inputid).autocomplete("option", "disabled", true);
            } else {
                $("body #" + inputid).autocomplete("option", "disabled", false);
            }
        });
    });
	 

$('#cusDetails').validate({
        errorPlacement: function (error, element) {
            // Customize error placement logic here
            if (element.attr("name") === "fname") {
                error.insertAfter(element.parent());
            } else if (element.attr("name") === "lname") {
                error.insertAfter(element.parent());
            } else {
                // Default behavior
                error.insertAfter(element);
            }
        },
        // Other validation options...
    });

	 $(document).on('blur', '.inputsave', function(evt) {
		
		$("#loader-overlay").show();
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('voucherReportSave')}}",
            type: 'POST',
            dataType: "json",
            data: {
               id: $(this).data('id'),
			   inputname: $(this).data('name'),
			   val: $(this).val()
            },
            success: function( data ) {
               //console.log( data );
			  $("#loader-overlay").hide();
            }
          });
	 }); 

   $(document).on('change', '.inputsavehotel', function(evt) {
		
		$("#loader-overlay").show();
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('voucherHotelInputSave')}}",
            type: 'POST',
            dataType: "json",
            data: {
               id: $(this).data('id'),
			   inputname: $(this).data('name'),
			   val: $(this).val()
            },
            success: function( data ) {
               //console.log( data );
			  $("#loader-overlay").hide();
            }
          });
	 }); 

	 var path = "{{ route('auto.hotel') }}";
	 var inputElement = $(this); // Store reference to the input element

	 $(".autocom").each(function() {
    var inputElement = $(this);
    inputElement.autocomplete({
        source: function(request, response) {
            $.ajax({
                url: path,
                type: 'GET',
                dataType: "json",
                data: {
                    search: request.term,
                    //zone: inputElement.attr('data-zone')
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {
			
            $(this).val(ui.item.label);
            return false;
        },
        change: function(event, ui) {
            if (ui.item == null) {
                $(this).val('');
            }
        }
    });
});

 $(".autodropoff_location").each(function() {
    var inputElement = $(this);
    inputElement.autocomplete({
        source: function(request, response) {
            $.ajax({
                url: path,
                type: 'GET',
                dataType: "json",
                data: {
                    search: request.term,
                    //zone: inputElement.attr('data-zone')
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {
            $(this).val(ui.item.label);
            return false;
        },
        change: function(event, ui) {
            if (ui.item == null) {
               $(this).val('');
            }
        }
    });
});


	
    $("#defaut_dropoff_location").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: path,
                type: 'GET',
                dataType: "json",
                data: {
                    search: request.term,
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {
            $(this).val(ui.item.label);
			var selectBox = $('.autodropoff_location'); // Adjust selector as per your HTML structure
			selectBox.val(ui.item.label);
			savedropoff_location(ui.item.label);
            return false;
        },
        change: function(event, ui) {
            if (ui.item == null) {
               $(this).val('');
            }
        }
    });

 $("#defaut_pickup_location").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: path,
                type: 'GET',
                dataType: "json",
                data: {
                    search: request.term,
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {
            $(this).val(ui.item.label);
			var selectBox = $('.autocom'); // Adjust selector as per your HTML structure
			selectBox.val(ui.item.label);
			savepickup_location(ui.item.label);
            return false;
        },
        change: function(event, ui) {
            if (ui.item == null) {
               $(this).val('');
            }
        }
    });


	});
	
	function savepickup_location(v){
		
		if(v!=''){
		$(".autocom.inputsave").each(function() {
			$("#loader-overlay").show();
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('voucherReportSave')}}",
            type: 'POST',
            dataType: "json",
            data: {
               id: $(this).data('id'),
			   inputname: $(this).data('name'),
			   val: $(this).val()
            },
            success: function( data ) {
               //console.log( data );
			  $("#loader-overlay").hide();
            }
          });
    });
		}
	}
	
	function savedropoff_location(v){
		
		if(v!=''){
		$(".autodropoff_location.inputsave").each(function() {
			$("#loader-overlay").show();
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('voucherReportSave')}}",
            type: 'POST',
            dataType: "json",
            data: {
               id: $(this).data('id'),
			   inputname: $(this).data('name'),
			   val: $(this).val()
            },
            success: function( data ) {
               //console.log( data );
			  $("#loader-overlay").hide();
            }
          });
    });
		}
	}


</script>
@endsection
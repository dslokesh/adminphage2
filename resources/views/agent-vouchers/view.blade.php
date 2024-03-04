@extends('layouts.appLogin')
@section('content')

@php
$currency = SiteHelpers::getCurrencyPrice();
@endphp

<div class="breadcrumb-section" style="background-image: linear-gradient(270deg, rgba(0, 0, 0, .3), rgba(0, 0, 0, 0.3) 101.02%), url(assets/img/innerpage/inner-banner-bg.png);">  
        <div class="container">
            <div class="row">
                <div class="col-lg-12 d-flex justify-content-center">
                    <div class="banner-content">
                        <h1>Checkout</h1>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Start Checkout section -->
    <div class="checkout-page pt-120 mb-120">
        <div class="container">
            <div class="row g-lg-4 gy-5">
                <div class="col-lg-8">
                    <div class="inquiry-form">
                        <div class="title">
                            <h4>Guest Details</h4>
                        </div>
                        <form id="cusDetails" method="post" action="{{route('agent.vouchers.status.change',$voucher->id)}}" >
			                      {{ csrf_field() }}
                            <div class="row">
                              <div class="col-md-6">
                                    <div class="form-inner mb-30">
                                        <label>First Name*</label>
                                        <input type="text" name="fname" value="{{$fname}}" class="form-control"  required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner mb-30">
                                        <label>Last Name*</label>
                                        <input type="text" name="lname" value="{{$lname}}" class="form-control"  required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner mb-30">
                                        <label>Email</label>
                                        <input type="text" name="customer_email" value="{{(!empty($voucher->guest_email))?$voucher->guest_email:$voucher->agent->email}}" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner mb-30">
                                        <label>Mobile No.*</label>
                                        <input type="text" name="customer_mobile" value="{{(!empty($voucher->guest_phone))?$voucher->guest_phone:$voucher->agent->mobile}}" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner mb-30">
                                        <label>Agent Reference No.</label>
                                        <input type="text" name="agent_ref_no" value="{{$voucher->agent_ref_no}}" class="form-control" >

                                        <input type="hidden" name="remark" value="{{$voucher->remark}}" class="form-control" >
                                    </div>
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
                    @if($ii == '1')
                    
			
                    <div class="inquiry-form" style="margin-top: 20px;">
                        <div class="title">
                            <h4>Additional Information</h4>
                        </div>
                            <div class="row">
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
                                <div class="col-md-6 @if($tkt == 0) d-none @endif">
                                  <div class="form-inner mb-30">
                                  <label class="">Defaut Dropoff Location</label>
                                  <input type="text" class="form-control" id="defaut_dropoff_location" />
                                
                                  </div>
                                </div>
                                
                                <div class="col-md-6 @if($tkt == 0) d-none @endif">
                                  <div class="form-inner mb-30">
                                  <label class="">Defaut Pickup Location</label>
                                  <input type="text" class="form-control" id="defaut_pickup_location" />
                                 
                                  </div>
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
						
						<div class="col-md-6 form-inner mb-30">
						 
						<input type="text" class="form-control inputsave autodropoff_location" id="dropoff_location{{$ap->id}}" data-name="dropoff_location"  data-id="{{$ap->id}}" value="{{$ap->dropoff_location}}" required data-zone="{{$ap->transfer_zone}}"  placeholder="Dropoff Location*" />
						
						
            

            <div class="form-inner">
                                        <label class="containerss">
                                        <input type="checkbox" data-idinput="dropoff_location{{$ap->id}}" class="chk_other " data-name="dropoff_other"  data-id="{{$ap->id}}" value="1"   /> 
                                            <span class="checkmark"></span>
                                            <span class="text">Other</span>
                                        </label>
                                    </div>

            
       
						</div>
					
					
					<div class="col-md-6 form-inner mb-30 ">
				<input type="text" class="form-control inputsave" id="passenger_name{{$ap->id}}" data-name="passenger_name"  data-id="{{$ap->id}}" required value="{{$ap->passenger_name}}"  placeholder="Passenger Name*" />
				
              </div>
			 
			   <div class="col-md-6 form-inner mb-30 ">
                 <input type="text" id="actual_pickup_time{{$ap->id}}" value="{{$ap->actual_pickup_time}}" class="form-control inputsave" required placeholder="Arrival Time*" data-id="{{$ap->id}}" data-name="actual_pickup_time" />
				 
              </div>
			 
			  
			  <div class="col-md-6 form-inner mb-30 ">
                 <input type="text" id="flight_no{{$ap->id}}" value="{{$ap->flight_no}}" class="form-control inputsave"  placeholder="Arrival Flight Details*" required data-id="{{$ap->id}}" data-name="flight_no" />
				
              </div>
                    
					<div class="col-md-12 form-inner mb-30 ">
					<input type="text" class="form-control inputsave" id="remark{{$ap->id}}" data-name="remark"  data-id="{{$ap->id}}" value="{{$ap->remark}}"  placeholder="Remark" />
                    </div>
					
					@elseif($activity->entry_type=='Interhotel')
		  
                    <div class="col-md-6 form-inner mb-30">
						
					<input type="text" class="form-control inputsave autocom" id="pickup_location{{$ap->id}}" data-name="pickup_location"  data-id="{{$ap->id}}" value="{{$ap->pickup_location}}" data-zone="{{$ap->transfer_zone}}"  placeholder="Pickup Location*" required />
										
          
          
          <div class="form-inner">
                                        <label class="containerss">
                                        <input type="checkbox" data-idinput="pickup_location{{$ap->id}}" class="chk_other " data-name="pickup_other"  data-id="{{$ap->id}}" value="1"   /> 
                                            <span class="checkmark"></span>
                                            <span class="text">Other</span>
                                        </label>
                                    </div>

         

                     
                    </div>
					 <div class="col-md-6 form-inner mb-30">
					
					 
					
					<input type="text" class="form-control inputsave autodropoff_location" id="dropoff_location{{$ap->id}}" data-name="dropoff_location"  data-id="{{$ap->id}}" value="{{$ap->dropoff_location}}" data-zone="{{$ap->transfer_zone}}"  required placeholder="Dropoff Location*" />
					
                        <div class="form-inner">
                                        <label class="containerss">
                                        <input type="checkbox" data-idinput="dropoff_location{{$ap->id}}" class="chk_other " data-name="dropoff_other"  data-id="{{$ap->id}}" value="1"   /> 
                                            <span class="checkmark"></span>
                                            <span class="text">Other</span>
                                        </label>
                                    </div>
          
          
      
                    </div>
					 <div class="col-md-6 form-inner mb-30 ">
               
                 <input type="text" id="actual_pickup_time{{$ap->id}}" value="{{$ap->actual_pickup_time}}" class="form-control inputsave"  placeholder="Pickup Time*" required data-id="{{$ap->id}}" data-name="actual_pickup_time" />
				 
              </div>
                    <div class="col-md-6 form-inner mb-30">
					
					<input type="text" class="form-control inputsave" id="remark{{$ap->id}}" data-name="remark"  data-id="{{$ap->id}}" value="{{$ap->remark}}" required placeholder="Remark" />
                    </div>
					@elseif($activity->entry_type=='Departure')
		  
                    <div class="col-md-6 form-inner mb-30">
					
					
					<input type="text" class="form-control inputsave autocom" id="pickup_location{{$ap->id}}"  data-name="pickup_location"  data-id="{{$ap->id}}" value="{{$ap->pickup_location}}" data-zone="{{$ap->transfer_zone}}" placeholder="Pickup Location*" required />
					
          
          
          <div class="form-inner">
                                        <label class="containerss">
                                        <input type="checkbox" data-idinput="pickup_location{{$ap->id}}" class="chk_other " data-name="pickup_other"  data-id="{{$ap->id}}" value="1"   /> 
                                            <span class="checkmark"></span>
                                            <span class="text">Other</span>
                                        </label>
                                    </div>

        
                     
                    </div>
					
					 <div class="col-md-6 form-inner mb-30 ">
                
                 <input type="text" id="actual_pickup_time{{$ap->id}}" value="{{$ap->actual_pickup_time}}" class="form-control inputsave"  placeholder="Pickup Time*" required data-id="{{$ap->id}}" data-name="actual_pickup_time" />
				 
              </div>
			  <div class="col-md-6 form-inner mb-30 ">
               
                 <input type="text" id="flight_no{{$ap->id}}" value="{{$ap->flight_no}}" class="form-control inputsave"  placeholder="Departure Flight Details*" required data-id="{{$ap->id}}" data-name="flight_no" />
				
              </div>
                    <div class="col-md-6 form-inner mb-30">
					
					<input type="text" class="form-control inputsave" id="remark{{$ap->id}}" data-name="remark"  data-id="{{$ap->id}}" value="{{$ap->remark}}"  placeholder="Remark" />
                    </div>
					@else
						<div class="col-md-6 form-inner mb-30">
					
					 
						
					<input type="text" class="form-control inputsave autocom" id="pickup_location{{$ap->id}}"  data-name="pickup_location"  data-id="{{$ap->id}}" value="{{$ap->pickup_location}}" data-zone="{{$ap->transfer_zone}}" required placeholder="Pickup Location*" required />
					 
          
                                <div class="form-inner">
                                        <label class="containerss">
                                        <input type="checkbox" data-idinput="pickup_location{{$ap->id}}" class="chk_other " data-name="pickup_other"  data-id="{{$ap->id}}" value="1"   /> 
                                            <span class="checkmark"></span>
                                            <span class="text">Other</span>
                                        </label>
                                    </div>

          
					  </div>
					
                     @if(($activity->pvt_TFRS=='1') && ($activity->pick_up_required=='1'))
					<div class="col-md-6 form-inner mb-30 ">
                <label for="inputName"></label>
                 <input type="text" id="actual_pickup_time{{$ap->id}}" value="{{$ap->actual_pickup_time}}" class="form-control inputsave" required placeholder="Pickup Time*" data-id="{{$ap->id}}" data-name="actual_pickup_time" />
				 
              </div>
                    @endif
					<div class="col-md-6 form-inner mb-30">
					
					<input type="text" class="form-control inputsave" id="remark{{$ap->id}}" data-name="remark"  data-id="{{$ap->id}}" value="{{$ap->remark}}"  placeholder="Remark" />
                    </div>
					
					@endif
                  </div>
				   @endif
				  @endforeach
                 @endif
                 </div>
                 @endif
               
				@endif
        <div class="inquiry-form mt-30" >

        <div class="choose-payment-method">
                                        <h6>Select Payment Method</h6>
                                        <div class="">
                                        @php
					$balance  = $voucher->agent->agent_amount_balance - $voucher->agent->agent_credit_limit;
					@endphp

       
                                            <ul>
                                                <li class="paypal active " style="margin-bottom: 15px;">
                                                <input type="radio" checked name="payment"  /> Credit Limit (Wallet Balance AED {{($balance > 0)?$balance:0}})
                                                </li>
                                                <li class="stripe"  style="margin-bottom: 15px;">
                                                <input type="radio" disabled name="payment"  />
                                                Credit Card / Debit Card
                                                </li>
                                                
                                            </ul>
                                        </div>
                                        
                                    </div>

        <div class="col-md-12">
                                      <div class="form-inner">
                                          <label class="containerss">
                                              <input type="checkbox" required='required'>
                                              <span class="checkmark"></span>
                                              <span class="text">By clicking Pay Now you agree that you have read ad understood our Terms and Conditions</span>
                                          </label>
                                      </div>
                                  </div>
                                    <div class="form-inner">
                                        <div class="row m-3">
                                            <div class="col-6 text-right">
                                              @if($voucher->status_main < 4)
                                              <button type="submit" name="btn_hold" class="secondary-btn2">Hold</button>
                                              @endif
                                            </div>
                                            <div class="col-6 text-right">
                                              @if($voucher->status_main < 5 )
                                              <button type="submit" name="btn_paynow" class="primary-btn3">Pay Now</button>
                                              @endif
                                            </div>
                                        </div>
                                    </div>
        </div>
        

        </form>

                </div>
                <div class="col-lg-4">
                    <div class="inquiry-form">
                        <div class="title">
                            <h4>Booking Details</h4>
                        </div>
                        
                            <div class="cart-menu">
                                <div class="cart-body">
                                    <ul>
                                    @php
				$totalGrand =0; 
			  @endphp
			  @if(!empty($voucherActivity) && $voucher->is_activity == 1)
					@if(!empty($voucherActivity))
					  @foreach($voucherActivity as $ap)
				  @php
					$activity = SiteHelpers::getActivity($ap->activity_id);
					@endphp
                                        <li class="single-item">
                                            <div class="item-area">
                                                <div class="main-item">
                                                    <div class="item-img">
                                                    <img src="{{asset('uploads/activities/thumb/'.$activity->image)}}" style="width:50px" alt="image">
                                                    </div>
                                                    <div class="content-and-quantity">
                                                        <div class="content">
                                                            <div class="price-and-btn d-flex align-items-center justify-content-between">
                                                                <span></span>

                                                                <form id="delete-form-{{$ap->id}}" method="post" action="{{route('agent.voucher.activity.delete',$ap->id)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <small>
                            <a class="close-btn" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$ap->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            "><i class="bi bi-x"></i></a></small>

                                                               
                                                            </div>
                                                            <h6><a href="#">Tour Option : {{$ap->variant_name}}</a></h6>
                                                        </div>
                                                        <ul>
                                                          <li><strong>Date: </strong>{{ $ap->tour_date ? date(config('app.date_format'),strtotime($ap->tour_date)) : null }}</li>
                                                          <li><strong>Transfer Type: </strong>{{$ap->transfer_option}}</li>
                                                           @if($ap->transfer_option == 'Shared Transfer')
                                                              @php
                                                              $pickup_time = SiteHelpers::getPickupTimeByZone($ap->variant_zones,$ap->transfer_zone);
                                                              @endphp
                                                              <li><strong>Pickup Time: </strong>{{$pickup_time}}</li>
                                                            @endif
                                                            @if(($ap->transfer_option == 'Pvt Transfer') && ($ap->variant_pick_up_required == '1')  && ($ap->variant_pvt_TFRS == '1'))
                                                              @php
                                                              $pickup_time = SiteHelpers::getPickupTimeByZone($ap->variant_zones,$ap->transfer_zone);
                                                              @endphp
                                                              <li><strong>Pickup Time: </strong>{{$ap->variant_pvt_TFRS_text}}</li>
                                                            @endif
                                                            <li><strong>Pax(s): </strong>Adult(s) : {{$ap->adult}} @if($ap->child > 0) Child(s) : {{$ap->child}} @endif</li>
                                                          
                                                            <li><strong>Amount: </strong>{{$currency['code']}} {{$ap->totalprice*$currency['value']}}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
            
                                        </li>
                                        @php
					$totalGrand += $ap->totalprice; 
				  @endphp
				 @endforeach
                 @endif
				  @endif
                                    </ul>
                                </div>
                                <div class="cart-footer">
                                    <div class="pricing-area">
                                        
                                        <ul class="total">
                                            <li><h4>Grand Total: {{$currency['code']}} {{$totalGrand*$currency['value']}}</h4></li>
                                        </ul>
                                    </div>
                                    

                                  
                                </div>
                            </div>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Checkout section -->




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
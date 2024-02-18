@extends('layouts.appLogin')
@section('content')

   
    <section data-anim-wrap class="layout-pt-md layout-pb-lg mt-header">
      <div class="container">
        <div class="row">
          <div data-anim-child="fade" class="col-lg-12">
           
         

            <div class="bg-white rounded-12 shadow-2 py-30 px-30 md:py-20 md:px-20 mt-30">
              <div class="d-flex flex-column items-center text-center">
                <div class="size-80 rounded-full flex-center bg-accent-1 text-white">
                  <i class="icon-check text-26"></i>
                </div>

                <h2 class="text-30 md:text-24 fw-700 mt-20">Booking Confirmation details</h2>
              </div>

              <div class="border-dashed-1 py-30 px-50 rounded-12 mt-30">
                <div class="row y-gap-15">

                  <div class="col-md-3 col-6">
                    <div>Voucher Number</div>
                    <div class="text-accent-2">{{$voucher->code}}</div>
                  </div>

                  <div class="col-md-3 col-6">
                    <div>From Date</div>
                    <div class="text-accent-2">{{$voucher->travel_from_date}}</div>
                  </div>

                  <div class="col-md-3 col-6">
                    <div>To Date</div>
                    <div class="text-accent-2">{{$voucher->travel_to_date}}</div>
                  </div>
				 <div class="col-md-3 col-6">
                    <div class="text-accent-2">@if($voucher->status_main == 5)
          <a class="button  -dark-1 bg-accent-1 text-white col-12  btn-sm" href="{{route('voucherInvoicePdf',$voucher->id)}}" >
                              Download Invoice&nbsp<i class="fas fa-download">
                              </i>
                             
                          </a>
						  @endif</div>
                  </div>
				  <div class="col-md-3 col-6">
                    <div>Guest Name</div>
                    <div class="text-accent-2">{{$voucher->guest_name}}</div>
                  </div>
				  <div class="col-md-3 col-6">
                    <div>Email</div>
                    <div class="text-accent-2">{{$voucher->guest_email}}</div>
                  </div>
				  <div class="col-md-3 col-6">
                    <div>Mobile No.</div>
                    <div class="text-accent-2">{{$voucher->guest_phone}}</div>
                  </div>
				  <div class="col-md-3 col-6">
                    <div>Agent Reference No.</div>
                    <div class="text-accent-2">{{$voucher->agent_ref_no}}</div>
                  </div>
				  <div class="col-md-12">
                    <div>Remark</div>
                    <div class="text-accent-2">{{$voucher->remark}}</div>
                  </div>
                </div>
              </div>

              <h2 class="text-30 md:text-24 fw-700 mt-60 md:mt-30">Activity Details</h2>
				@php
				$totalGrand =0; 
			  @endphp
			  @if(!empty($voucherActivity) && $voucher->is_activity == 1)
					@if(!empty($voucherActivity))
					  @foreach($voucherActivity as $ap)
				  @php
					$ticketCount = SiteHelpers::getTicketCountByCode($ap->variant_unique_code);
					@endphp
					@php
				$tourDt = date("Y-m-d",strtotime($ap->tour_date));
				$validTime = SiteHelpers::checkCancelBookingTime($ap->variant_unique_code,$ap->activity_id,$tourDt,$ap->transfer_option);
				$activity = SiteHelpers::getActivity($ap->activity_id);
				@endphp
				
              <div class="d-flex item-center justify-between y-gap-5 pt-30">
                <div class="text-18 fw-500">{{$ap->activity_title}}</div>
				
                <div class="text-18 fw-500">@if($validTime['btm'] == '0')
                      Non - Refundable
					@else
						  Cancellation upto<br/>{{$validTime['validuptoTime']}}
					@endif
					</div>
					<div class="text-18 fw-500">@if(($ap->status == '4') && ($validTime['btm'] =='1') && ($ap->ticket_downloaded == '0'))
						<form id="cancel-form-{{$ap->id}}" method="post" action="{{route('agent-voucher.activity.cancel',$ap->id)}}" style="display:none;">
						{{csrf_field()}}
						</form>
							<a class="btn-danger  float-right  btn-sm ml-2" href="javascript:void(0)" onclick="
							if(confirm('Are you sure, You want to cancel this?'))
							{
							event.preventDefault();
							document.getElementById('cancel-form-{{$ap->id}}').submit();
							}
							else
							{
							event.preventDefault();
							}

							"><i class="fas fa-times"></i> Cancel</a>
						@endif
						
                                @if(($voucher->status_main == 5) and ($ap->ticket_generated == '0') and ($ticketCount > '0') and ($ap->status == '3'))
                        <form id="tickets-generate-form-{{$ap->id}}" method="post" action="{{route('tickets.generate',$ap->id)}}" style="display:none;">
                                            {{csrf_field()}}
                            <input type="hidden" id="statusv" value="2" name="statusv"  /> 
                            <input type="hidden" id="payment_date" name="payment_date"  /> 
                                        </form>
                        
                          <a class="btn btn-success float-right mr-3 btn-sm" href="javascript:void(0)" onclick="
                                            if(confirm('You want to download ticket?'))
                                            {
                                                event.preventDefault();
                                                document.getElementById('tickets-generate-form-{{$ap->id}}').submit();
                                            }
                                            else
                                            {
                                                event.preventDefault();
                                            }
                                        
                                        "><i class="fas fa-download"></i> Ticket</a>
                          
                          @elseif(($ap->ticket_generated == '1') and ($ap->status == '4'))
						  <a class="btn btn-success float-right  btn-sm  d-pdf" href="#" onclick='window.open("{{route('ticket.dwnload',$ap->id)}}");return false;'  ><i class="fas fa-download"></i> Ticket</a>
                         
                          @endif
						  
						  @if($ap->status == 1)
							<span style="color:red"  >{{ config('constants.voucherActivityStatus')[$ap->status] }}</span>
							@endif
                          </div>
              </div>

              <div class="mt-25">

                <div class="d-flex items-center justify-between">
                  <div class="fw-500">Status:</div>
                  <div class="">@if($ap->status == '1')
				Cancellation Requested
				@elseif($ap->status == '2')
				Cancelled
				@elseif($ap->status == '3')
				In Process
				@elseif($ap->status == '4')
				Confirm
				@elseif($ap->status == '5')
				Vouchered
				@endif </div>
                </div>

                <div class="d-flex items-center justify-between">
                  <div class="fw-500">Tour Option:</div>
                  <div class="">{{$ap->variant_name}}</div>
                </div>

                <div class="d-flex items-center justify-between">
                  <div class="fw-500">Date:</div>
                  <div class="">{{$ap->tour_date}}</div>
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
				<div class="d-flex items-center justify-between">
                  <div class="fw-500">Pickup Timing:</div>
                  <div class="">{{$ap->variant_pvt_TFRS_text}}</div>
                </div>
				@endif
                <div class="d-flex items-center justify-between">
                  <div class="fw-500">Pax:</div>
                  <div class="">Adult x{{$ap->adult}}  - Child x{{!empty($ap->child)?$ap->child:0}}</div>
                </div>
				<div class="d-flex items-center justify-between">
                  <div class="fw-500">Amount Incl. VAT:</div>
                  <div class="">AED {{$ap->totalprice}}</div>
                </div>
				@if(($ap->transfer_option == 'Shared Transfer') || ($ap->transfer_option == 'Pvt Transfer'))
			@if($activity->entry_type=='Arrival')	
			<div class="d-flex items-center justify-between">
                  <div class="fw-500">Dropoff Location:</div>
                  <div class="">{{$ap->dropoff_location}}</div>
                </div>
				<div class="d-flex items-center justify-between">
                  <div class="fw-500">Passenger Name:</div>
                  <div class="">{{$ap->passenger_name}}</div>
                </div>
				<div class="d-flex items-center justify-between">
                  <div class="fw-500">Arrival Time:</div>
                  <div class="">{{$ap->actual_pickup_time}}</div>
                </div>
				<div class="d-flex items-center justify-between">
                  <div class="fw-500">Flight Details:</div>
                  <div class="">{{$ap->flight_no}}</div>
                </div>
				<div class="d-flex items-center justify-between">
                  <div class="fw-500">Remark:</div>
                  <div class="">{{$ap->remark}}</div>
                </div>
				@elseif($activity->entry_type=='Interhotel')
				<div class="d-flex items-center justify-between">
                  <div class="fw-500">Pickup Location:</div>
                  <div class="">{{$ap->pickup_location}}</div>
                </div>
				<div class="d-flex items-center justify-between">
                  <div class="fw-500">Dropoff Location:</div>
                  <div class="">{{$ap->dropoff_location}}</div>
                </div>
				<div class="d-flex items-center justify-between">
                  <div class="fw-500">Pickup Time:</div>
                  <div class="">{{$ap->actual_pickup_time}}</div>
                </div>
				<div class="d-flex items-center justify-between">
                  <div class="fw-500">Remark:</div>
                  <div class="">{{$ap->remark}}</div>
                </div>
				@elseif($activity->entry_type=='Departure')
				<div class="d-flex items-center justify-between">
                  <div class="fw-500">Pickup Location:</div>
                  <div class="">{{$ap->pickup_location}}</div>
                </div>
				<div class="d-flex items-center justify-between">
                  <div class="fw-500">Pickup Time:</div>
                  <div class="">{{$ap->actual_pickup_time}}</div>
                </div>
				<div class="d-flex items-center justify-between">
                  <div class="fw-500">Flight Details:</div>
                  <div class="">{{$ap->flight_no}}</div>
                </div>
				<div class="d-flex items-center justify-between">
                  <div class="fw-500">Remark:</div>
                  <div class="">{{$ap->remark}}</div>
                </div>
				@else
				<div class="d-flex items-center justify-between">
                  <div class="fw-500">Pickup Location:</div>
                  <div class="">{{$ap->pickup_location}}</div>
                </div>
				@if(($activity->pvt_TFRS=='1') && ($activity->pick_up_required=='1'))
				<div class="d-flex items-center justify-between">
                  <div class="fw-500">Pickup Time:</div>
                  <div class="">{{$ap->actual_pickup_time}}</div>
                </div>
				@endif
				<div class="d-flex items-center justify-between">
                  <div class="fw-500">Remark:</div>
                  <div class="">{{$ap->remark}}</div>
                </div>
				@endif
				@endif
				
              </div>

              <div class="line mt-30 mb-30"></div>
			
			@php
					$totalGrand += $ap->totalprice; 
				  @endphp
				 @endforeach
                 @endif
				  @endif
            
              
              <div class="row justify-end">
                <div class="col-md-4">

                  <div class="d-flex items-center justify-between">
                    <div class="text-18 fw-500">Subtotal</div>
                    <div class="text-18 fw-500">AED {{$totalGrand}}</div>
                  </div>

                  <div class="d-flex items-center justify-between">
                    <div class="text-18 fw-500">Total</div>
                    <div class="text-18 fw-500">AED {{$totalGrand}}</div>
                  </div>

                  <div class="d-flex items-center justify-between">
                    <div class="text-18 fw-500">Amount Paid</div>
                    <div class="text-18 fw-500">AED {{$totalGrand}}</div>
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

<script type="text/javascript">

   $(".d-pdf").on('click', function (e) {
    e.preventDefault();
    window.location.href = this.getAttribute('href');
    // Reload the page after a delay (adjust the delay time as needed)
    setTimeout(function () {
        location.reload();
    }, 2000); // Reload after 2 seconds
});

</script>
@endsection
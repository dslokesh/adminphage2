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
                        <h1>Booking Detail : {{$voucher->code}}</h1>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Start Checkout section -->
    <div class="checkout-page pt-120 mb-120">
        <div class="container">
            <div class="row g-lg-4 gy-5">
                <div class="col-lg-12">
                  <h2 class="text-30 md:text-24 fw-700 mt-20">Booking Confirmation Details</h2>
                    <div class="booking-form-wrap mb-40">
                        <div class="row">
                        <div class="col-md-3 col-6 form-inner mb-30">
                    <div>Voucher Number</div>
                    <div class="text-accent-2">{{$voucher->code}}</div>
                  </div>

                  <div class="col-md-3 col-6 form-inner mb-30">
                    <div>From Date</div>
                    <div class="text-accent-2">{{$voucher->travel_from_date}}</div>
                  </div>

                  <div class="col-md-3 col-6 form-inner mb-30">
                    <div>To Date</div>
                    <div class="text-accent-2">{{$voucher->travel_to_date}}</div>
                  </div>
				 <div class="col-md-3 col-6 form-inner mb-30">
                    <div class="text-accent-2">@if($voucher->status_main == 5)
          <a class="button  -dark-1 bg-accent-1 text-white col-12  btn-sm" href="{{route('voucherInvoicePdf',$voucher->id)}}" >
                              Download Invoice&nbsp<i class="fas fa-download">
                              </i>
                             
                          </a>
						  @endif</div>
                  </div>
				  <div class="col-md-3 col-6 form-inner mb-30">
                    <div>Guest Name</div>
                    <div class="text-accent-2">{{$voucher->guest_name}}</div>
                  </div>
				  <div class="col-md-3 col-6 form-inner mb-30">
                    <div>Email</div>
                    <div class="text-accent-2">{{$voucher->guest_email}}</div>
                  </div>
				  <div class="col-md-3 col-6 form-inner mb-30">
                    <div>Mobile No.</div>
                    <div class="text-accent-2">{{$voucher->guest_phone}}</div>
                  </div>
				  <div class="col-md-3 col-6 form-inner mb-30">
                    <div>Agent Reference No.</div>
                    <div class="text-accent-2">{{$voucher->agent_ref_no}}</div>
                  </div>
				  <div class="col-md-12 form-inner mb-30">
                    <div>Remark</div>
                    <div class="text-accent-2">{{$voucher->remark}}</div>
                  </div>
                        </div>
                    </div>

<!-- End Block 1 -->

<h2 class="text-30 md:text-24 fw-700 mt-20">Activity Details</h2>
                   
                        

                        @php
				$totalGrand =0; 
			  @endphp
			  @if(!empty($voucherActivity) && $voucher->is_activity == 1)
					@if(!empty($voucherActivity))
					  @foreach($voucherActivity as $ap)
				  @php
					$ticketCount = SiteHelpers::getTicketCountByCode($ap->variant_code);
					@endphp
					@php
				$tourDt = date("Y-m-d",strtotime($ap->tour_date));
				$validTime = SiteHelpers::checkCancelBookingTime($ap->variant_unique_code,$ap->activity_id,$tourDt,$ap->transfer_option);
				$activity = SiteHelpers::getActivity($ap->activity_id);
				@endphp
          
              <div class="room-suits-card mb-30">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <div class="swiper hotel-img-slider swiper-fade swiper-initialized swiper-horizontal swiper-watch-progress swiper-backface-hidden">
                                 
                                    <div class="swiper-wrapper" id="swiper-wrapper-58e7db6662f9966d" aria-live="off">
                                        <div class="swiper-slide swiper-slide-visible swiper-slide-active swiper-slide-next" role="group" aria-label="1 / 1" data-swiper-slide-index="0" style="width: 285px; opacity: 1; transform: translate3d(0px, 0px, 0px);">
                                            <div class="room-img">
                                            <img src="{{asset('uploads/activities/'.$activity->image)}}" alt="image">
                                            </div>
                                        </div>
                                    </div>
                                  
                                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                            </div>
                            <div class="col-md-8">
                                <div class="room-content">
                                    <div class="content-top">
                                        <h5>
                                            {{$ap->activity_title}}  : {{$ap->variant_name}}
                                           
                                        </h5>
                                        <div class="highlight-tour mb-20">
                        
                    
                                        <ul class="">
                                                                             
                    <li>Date : {{$ap->tour_date}}</li>


                    <li>Transfer Type : {{$ap->transfer_option}}</li>
                
				@if($ap->transfer_option == 'Shared Transfer')
					@php
					$pickup_time = SiteHelpers::getPickupTimeByZone($ap->variant_zones,$ap->transfer_zone);
					@endphp
          <li>Pickup Timing: {{$pickup_time}} </li>
				@endif
				@if(($ap->transfer_option == 'Pvt Transfer') && ($ap->variant_pick_up_required == '1')  && ($ap->variant_pvt_TFRS == '1'))
				<li>Pickup Timing: {{$ap->variant_pvt_TFRS_text}} </li>
				@endif
        <li>Pax: Adult x{{$ap->adult}}  - Child x{{!empty($ap->child)?$ap->child:0}} </li>
				
				@if(($ap->transfer_option == 'Shared Transfer') || ($ap->transfer_option == 'Pvt Transfer'))
			@if($activity->entry_type=='Arrival')	
			<li>Dropoff Location: {{$ap->dropoff_location}}</li>
      <li>Passenger Name: {{$ap->passenger_name}} </li>
			<li>Arrival Time: {{$ap->actual_pickup_time}} </li>
      <li>Flight Details: {{$ap->flight_no}}</li>
      <li>Remark: {{$ap->remark}}</li>
				@elseif($activity->entry_type=='Interhotel')
				<li>Pickup Location: {{$ap->pickup_location}}</li>
                <li>Dropoff Location: {{$ap->dropoff_location}}</li>
                <li> Pickup Time: {{$ap->actual_pickup_time}}</li>
                <li>Remark: {{$ap->remark}}</li>
				@elseif($activity->entry_type=='Departure')
				<li>Pickup Location: {{$ap->pickup_location}}</li>
                <li>Pickup Time: {{$ap->actual_pickup_time}}</li>
                <li>Flight Details: {{$ap->flight_no}}</li>
                <li>Remark: {{$ap->remark}}</li>
				@else
				<li>Pickup Location: {{$ap->pickup_location}}</li>
				@if(($activity->pvt_TFRS=='1') && ($activity->pick_up_required=='1'))
        <li> Pickup Time: {{$ap->actual_pickup_time}}</li>
				@endif
				<li>Remark: {{$ap->remark}}</li>
				@endif
				@endif
				
                                           
                                        </ul>
                                        </div>
                                    </div>
                                    <div class="content-bottom">
                                        <div class="room-type">
                                            <div class="deals">
                                            <a class="primary-btn2 "  href="javascript:void(0);" data-act="6" style="cursor:pointer;" data-vid="68" data-card-widget="collapse" title="Collapse">
                                            @if($ap->status == '1')
				Cancellation Requested
				@elseif($ap->status == '2')
				Cancelled
				@elseif($ap->status == '3')
				In Process
				@elseif($ap->status == '4')
				Confirm
				@elseif($ap->status == '5')
				Vouchered
				@endif 
                    </a>
                                            </div>
                                        </div>
                                       <div class="price-and-book">
                                       @if($validTime['btm'] == '0')
                                Non - Refundable
                    @else
                        Cancellation upto<br/>{{$validTime['validuptoTime']}}
                    @endif
                                            <div class="price-area">
                                               
                                                <span>{{$currency['code']}} {{$ap->totalprice*$currency['value']}}</span>
                                                
                                            </div>
                                            <div class="book-btn">


                                            @if(($ap->status == '4') && ($validTime['btm'] =='1') && ($ap->ticket_downloaded == '0'))
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
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>

                        
                    </div>                  

        </div>


         @php
					$totalGrand += $ap->totalprice; 
				  @endphp
				 @endforeach
                 @endif
				  @endif
          
<!-- End Block 2 -->

<div class="row g-lg-4 gy-5">
                <div class="col-lg-12">
                    <div class="booking-form-wrap mb-40">
                        <div class="row">
                       

                  <div class="col-md-12" style="text-align: right">
                    <h3>Total Amount : {{$currency['code']}} {{$totalGrand*$currency['value']}}</h3>
                  </div>
                          </div>
                          </div>
                          </div>
                          </div>

                </div>
                
            </div>
        </div>
    </div>
    <!-- End View section -->



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
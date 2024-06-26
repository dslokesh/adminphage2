@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Booking Confirmation( {{$voucher->code}})</h1>
          </div>
		 
						
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div class="row">
       
		
       <!-- left column -->
       <div class="offset-md-2 col-md-8">
              <div class="row multistep">
                <div class="col-md-3 multistep-step complete">
                    <div class="text-center multistep-stepname" style="font-size: 16px;">Add to Cart</div>
                    <div class="progress"><div class="progress-bar"></div></div>
                    <a href="#" class="multistep-dot"></a>
                </div>

                <div class="col-md-3 multistep-step complete">
                    <div class="text-center multistep-stepname" style="font-size: 16px;">Payment</div>
                    <div class="progress"><div class="progress-bar"></div></div>
                    <a href="#" class="multistep-dot"></a>
                </div>

                <div class="col-md-3 multistep-step current">
                    <div class="text-center multistep-stepname" style="font-size: 16px;">Confirmation</div>
                    <div class="progress"><div class="progress-bar"></div></div>
                    <a href="#" class="multistep-dot"></a>
                </div>

                
            </div>
</div>
</div>

        <div class="row" style="margin-top: 30px;">
       
		
          <!-- left column -->
          <div class="offset-md-2 col-md-8">
		   <form id="cusDetails" method="post" action="{{route('agent.vouchers.status.change',$voucher->id)}}" >
			 {{ csrf_field() }}
            <!-- general form elements -->
            <div class="card card-default">
              <div class="card-header">
                 <h3 class="card-title"><i class="nav-icon fas fa-user" style="color:black"></i> Agent Details</h3>
				 <h3 class="card-title" style="float:right">
				 @if(($voucher->status_main == 4) OR ($voucher->status_main == 5))

         <a class="btn btn-success btn-sm" href="{{route('voucherActivityItineraryPdf',$voucher->id)}}" >
                              Itinerary <i class="fas fa-download">
                              </i>
                             
                          </a>
                          @if(($voucher->status_main == 4))
          <a class="btn btn-info btn-sm" href="{{route('voucherInvoicePdf',$voucher->id)}}" >
                              Proforma Invoice <i class="fas fa-download">
                              </i>
                             
                          </a>
                          @else

                          <a class="btn btn-info btn-sm" href="{{route('voucherInvoicePdf',$voucher->id)}}" >
                               Invoice <i class="fas fa-download">
                              </i>
                             
                          </a>

						  @endif
              @endif
						  </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
                <div class="card-body">
                  <div class="row" style="margin-bottom: 15px;">
                    
                    <div class="col-6">
					<label for="inputName">Agency Name:</label>
          {{ ($voucher->agent)?$voucher->agent->company_name:''}}
                    </div>
                   
                
                   
                   
                    <div class="col-6">
					  <label for="inputName">Mobile No.:</label>
                     {{$voucher->mobile}}
                    </div>
                    
                  </div>
                 
                </div>
                <!-- /.card-body -->
				
               
            </div>

            <div class="card card-default">
              <div class="card-header">
                 <h3 class="card-title"><i class="nav-icon fas fa-user" style="color:black"></i> Passenger Details</h3>
				 <h3 class="card-title" style="float:right">
				
						  </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
                <div class="card-body">
                  <div class="row" style="margin-bottom: 15px;">
                    
                    <div class="col-6">
					<label for="inputName">Guest Name:</label>
                     {{$voucher->guest_name}}
                    </div>
                   
                
                    <div class="col-6">
					<label for="inputName">Email:</label>
                     {{$voucher->guest_email}}
                    </div>
                   
                    <div class="col-6">
					  <label for="inputName">Mobile No.:</label>
                     {{$voucher->guest_phone}}
                    </div>
                    <div class="col-6">
                      
					   <label for="inputName">Agent Reference No.:</label>
                     {{$voucher->agent_ref_no}}
                    </div>
					<div class="col-6">
                      
					   <label for="inputName">File Handling By:</label>
                     {{$voucher->file_handling_by}}
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: 5px;">
                    <div class="col-12">
					 <label for="inputName">Remark.:</label>
                     {{$voucher->remark}}
                     
                    </div>
                   
                  </div>
                </div>
                <!-- /.card-body -->
				
               
            </div>
           
          

            <!-- /.card -->

           
            <!-- /.card -->
 <!-- general form elements -->
 
<!-- /.card -->

            <!-- Horizontal Form -->
            
            <!-- /.card -->
</form>
          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="offset-md-2 col-md-8">
            <!-- Form Element sizes -->
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
            <div class="card card-default">
              <div class="card-header">
                <div class="row">
				<div class="col-md-6 text-left">
                    <h3 class="card-title">
                      <strong> {{$ap->activity_title}}</strong></h3>

                      <span class="badge bg-warning" style="margin-left: 5px;">
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
     </span> 
                  </div>
                  <div class="col-md-2 text-rihgt">
                    <h6 class="card-title" style="font-size:10px">
					@if($validTime['btm'] == '0')
                      <strong> Non - Refundable</strong>
					@else
						 <strong> Cancellation upto<br/>{{$validTime['validuptoTime']}}</strong>
					@endif
				  </h6>
                  </div>
				 
				  
                
        
     
   

        <div class="col-md-4 text-right ">
		@if((($ap->status == '3') || ($ap->status == '4')) && ($ap->ticket_downloaded == '1') && (auth()->user()->role_id == '1'))
						
						<form id="cancel-form-{{$ap->id}}" method="post" action="{{route('voucher.activity.cancel',$ap->id)}}" style="display:none;">
						{{csrf_field()}}
						</form>
						
							<a class="btn btn-primary  float-right cancelAct btn-sm ml-2" data-variantcode="{{$ap->variant_code}}" data-apid="{{$ap->id}}" href="javascript:void(0)" ><i class="fas fa-times"></i> Cancel </a>
						@endif
				@if((($ap->status == '3') || ($ap->status == '4')) && ($ap->ticket_downloaded == '0'))
						
						<form id="cancel-form-{{$ap->id}}" method="post" action="{{route('voucher.activity.cancel',$ap->id)}}" style="display:none;">
						{{csrf_field()}}
						</form>
						
							<a class="btn btn-primary  float-right cancelAct btn-sm ml-2" data-variantcode="{{$ap->variant_code}}" href="javascript:void(0)" data-apid="{{$ap->id}}" ><i class="fas fa-times"></i> Cancel </a>
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
              <div class="card-body">
			  
			  <div class="">
                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-5 text-left">
                      <strong>Tour Option</strong>
                    </div>
                    <div class="col-md-7 text-right">
                      {{$ap->variant_name}}
                    </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Date</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$ap->tour_date}}
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Transfer Type</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$ap->transfer_option}}
                  </div>
                </div>
               @if($ap->transfer_option == 'Shared Transfer')
					@php
					$pickup_time = SiteHelpers::getPickupTimeByZone($ap->variant_zones,$ap->transfer_zone);
					@endphp
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Pickup Timing</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$pickup_time}}
                  </div>
                </div>
				@endif
				@if(($ap->transfer_option == 'Pvt Transfer') && ($ap->variant_pick_up_required == '1')  && ($ap->variant_pvt_TFRS == '1'))
					
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Pickup Timing</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$ap->variant_pvt_TFRS_text}}
                  </div>
                </div>
				@endif
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Pax</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$ap->adult}} Adult {{$ap->child}} Child
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Amount Incl. VAT</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   AED {{$ap->totalprice}}
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Total</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   AED {{$ap->totalprice}}
                  </div>
                </div>
				</div>
				 @if(($ap->transfer_option == 'Shared Transfer') || ($ap->transfer_option == 'Pvt Transfer'))
			   <div class="row" style="margin-bottom: 15px;">
					@if($activity->entry_type=='Arrival')
                    <div class="col-6">
					<label for="inputName">Dropoff Location:</label>
					{{$ap->dropoff_location}}
                     
                    </div>
					 <div class="col-6">
					<label for="inputName">Passenger Name:</label>
					{{$ap->passenger_name}}
                     
                    </div>
					<div class="col-6">
					<label for="inputName">Arrival Time:</label>
					{{$ap->actual_pickup_time}}
                     
                    </div>
					<div class="col-6">
					<label for="inputName">Flight Details:</label>
					{{$ap->flight_no}}
                     
                    </div>
                    <div class="col-8">
					<label for="inputName">Remark:</label>
					{{$ap->remark}}
                    </div>
				
					@elseif($activity->entry_type=='Interhotel')
					<div class="col-6">
					<label for="inputName">Pickup Location:</label>
					{{$ap->pickup_location}}
                     
                    </div>
					 <div class="col-6">
					<label for="inputName">Dropoff Location:</label>
					{{$ap->dropoff_location}}
                     
                    </div>
					<div class="col-6">
					<label for="inputName">Pickup Time:</label>
					{{$ap->actual_pickup_time}}
                     
                    </div>
                    <div class="col-12 pt-3">
					<label for="inputName">Remark:</label>
					{{$ap->remark}}
                    </div>
					@elseif($activity->entry_type=='Departure')
					<div class="col-6">
					<label for="inputName">Pickup Location:</label>
					{{$ap->pickup_location}}
                     
                    </div>
					
					<div class="col-6">
					<label for="inputName">Pickup Time:</label>
					{{$ap->actual_pickup_time}}
                     
                    </div>
					<div class="col-6">
					<label for="inputName">Flight Details:</label>
					{{$ap->flight_no}}
                     
                    </div>
                    <div class="col-12 pt-3">
					<label for="inputName">Remark:</label>
					{{$ap->remark}}
                    </div>
					@else
					<div class="col-6">
					<label for="inputName">Pickup Location:</label>
					{{$ap->pickup_location}}
                     
                    </div>
					
					 
					@if(($activity->pvt_TFRS=='1') && ($activity->pick_up_required=='1'))
					<div class="col-6">
					<label for="inputName">Pickup Time:</label>
					{{$ap->actual_pickup_time}}
                     
                    </div>
					
					@endif
					
                    <div class="col-8">
					<label for="inputName">Remark:</label>
					{{$ap->remark}}
                    </div>
					
					
					@endif
					
                  </div>
				  @endif
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
@php
					$totalGrand += $ap->totalprice; 
				  @endphp
				 @endforeach
                 @endif
				  @endif
            <!-- /.startteldiv-->
            @if(!empty($voucherHotel) && $voucher->is_hotel == 1)
            @if(!empty($voucherHotel))
              @foreach($voucherHotel as $vh)
              @php
              $room = SiteHelpers::hotelRoomsDetails($vh->hotel_other_details)
              @endphp
              <div class="card card-default">
                <div class="card-header">
                  <div class="row">
          <div class="col-md-8 text-left">
                      <h3 class="card-title">
                        <strong> {{$vh->hotel->name}}</strong></h3>
                    </div>
          
             </div>
                </div>
                <div class="card-body">
          
          <div class="">
            <div class="row" style="margin-bottom: 5px;">
              <div class="col-md-5 text-left">
                <strong>Hotel Category</strong>
              </div>
              <div class="col-md-7 text-right">
                {{$vh->hotel->hotelcategory->name}}
              </div>
          </div>
                  <div class="row" style="margin-bottom: 5px;">
                      <div class="col-md-5 text-left">
                        <strong>Check In</strong>
                      </div>
                      <div class="col-md-7 text-right">
                        {{$vh->check_in_date}}
                      </div>
                  </div>
                  <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-5 text-left">
                      <strong>Check Out</strong>
                    </div>
                    <div class="col-md-7 text-right">
                     {{$vh->check_out_date}}
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-5 text-left">
                      <strong>Room Type</strong>
                    </div>
                    <div class="col-md-7 text-right">
                      {{$room['room_type']}}
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-5 text-left">
                      <strong>Number of Rooms</strong>
                    </div>
                    <div class="col-md-7 text-right">
                      {{$room['number_of_rooms']}}
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-5 text-left">
                      <strong>Occupancy</strong>
                    </div>
                    <div class="col-md-7 text-right">
                      {{$room['occupancy']}}
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-5 text-left">
                      <strong>Meal Plan</strong>
                    </div>
                    <div class="col-md-7 text-right">
                      {{$room['mealplan']}}
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-5 text-left">
                      <strong>Amount Incl. VAT</strong>
                    </div>
                    <div class="col-md-7 text-right">
                     AED {{$room['price']}}
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-5 text-left">
                      <strong>Total</strong>
                    </div>
                    <div class="col-md-7 text-right">
                     AED {{$room['price']}}
                    </div>
                  </div>
          </div>
			<div class="row" style="margin-bottom: 15px;">
                      <div class="col-6">
                        <label for="inputName">Confirmation Number:</label>
					{{$vh->confirmation_number}}

                       
                      </div>
                     <div class="col-12">
                        <label for="inputName">Remark:</label>
					{{$vh->remark}}

                       
                      </div>
                    </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
  @php
            $totalGrand += $room['price']; 
            @endphp
           @endforeach
                   @endif
            @endif
             <!-- /.endhoteldiv-->
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title"><strong>Total Payment</strong></h3>
              </div>
              <div class="card-body">
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-6 text-left">
                    <strong>Amount Incl. VAT</strong>
                  </div>
                  <div class="col-md-6 text-right">
                   AED {{$totalGrand}}
                  </div>
                </div>
               <!-- <div class="row" style="margin-bottom: 15px;">
                  <div class="col-md-6 text-left">
                    <strong>Handling charges (2%)</strong>
                  </div>
                  <div class="col-md-6 text-right">
                   AED 2.30
                  </div>
                </div> -->
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-6 text-left">
                    <h3>Final Amount</h3>
                  </div>
                  <div class="col-md-6 text-right">
                   <h3>AED {{$totalGrand}}</h3>
                  </div>
				  
                </div>
				
              </div>
			  
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
			
            
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  
    <!-- /.content -->
	
	<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cancellation Chart</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group" id="dataCancel">
                   <table id="cancellationTable" class="table table-bordered table-striped" style="display: none;">
					<thead>
						<tr>
							<th>Duration</th>
							<th>Ticket Refund Value</th>
							<th>Transfer Refund Value</th>
						</tr>
					</thead>
					<tbody>
						<!-- Table rows will be dynamically added here -->
					</tbody>
				</table>
                   
                </div>
            </div>
           <div class="modal-footer d-flex justify-content-between">
			<button type="button" class="btn btn-sm btn-primary-flip btn-sm" id="selectCancelBtn"><i class="fa fa-tick"></i> Yes</button>
			<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">No</button>
		</div>

        </div>
    </div>
</div>

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
 $(document).ready(function() {
 $(document).on('click', '.cancelAct', function(evt) {
	 variantcode = $(this).data('variantcode');
	 formid = $(this).data('apid');
	  evt.preventDefault();
	
		 $.ajax({
			  url: "{{ route('get.canellation.chart') }}",
			  type: 'POST',
			  dataType: "json",
			  data: {
				  "_token": "{{ csrf_token() }}",
				  variantcode:variantcode,
				  },
			  success: function(data) {
				   var cancellationData = data.cancellation;
				  if(cancellationData.length > 0) {
						$('#cancellationTable tbody').empty();
						cancellationData.forEach(function(cancel) {
							var row = '<tr>' +
								'<td>' + cancel.duration + '</td>' +
								'<td>' + cancel.ticket_refund_value + '</td>' +
								'<td>' + cancel.transfer_refund_value + '</td>' +
								'</tr>';
							$('#cancellationTable tbody').append(row);
						});
						
						$('#cancellationTable').show();
						openModal(data.cancel,formid);
				} else {
						 var row = '<tr>' +
                '<td colspan="3" style="text-align: center;">No Cancellation Chart Found</td>' +
                '</tr>';
            $('#cancellationTable tbody').append(row);
			$('#cancellationTable').show();
			openModal(data.cancel,formid);
					}
				//console.log(data);
			  },
			  error: function(error) {
				console.log(error);
			  }
		});
	
	
 });
 });
function openModal(cancel,formid) {
        $('#cancelModal').modal('show');
        $('#selectCancelBtn').on('click', function() {
			$("body #cancel-form-"+formid).submit();
        });
		
        $('#cancelModal .close').on('click', function() {
            $('#cancelModal').modal('hide');
        });
   
}


</script>
@endsection

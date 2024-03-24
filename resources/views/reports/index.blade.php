@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Logistic Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Logistic Report</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
				<div class="card-tools">
				 <div class="row">
				 @if(auth()->user()->role_id == '1')
				<a href="{{ route('voucherReportExport', request()->input()) }}" class="btn btn-info btn-sm mb-2 mr-4">Export to CSV</a>
				@endif
				   </div></div>
				   
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  <div class="row">
            <form id="filterForm" class="form-inline" method="get" action="{{ route('voucherReport') }}" >
              <div class="form-row align-items-center">
			   <div class="col-auto col-md-3">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Search Result</div>
                  </div>
                 <select name="booking_type" id="booking_type" class="form-control">
                    <option value = "1" @if(request('booking_type')==1) selected="selected" @endif>Booking Date</option>
					<option value = "2" @if(request('booking_type')==2) selected="selected" @endif>Travel Date</option>
					<!--<option value = "3">Deadline Date</option>-->
                 </select>
                </div>
              </div>
			  <div class="col-auto col-md-2">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">From Date</div></div>
                    <input type="text" name="from_date" value="{{ request('from_date') }}" autocomplete ="off" class="form-control datepicker"  placeholder="From Date" />
                  </div>
                </div>
				<div class="col-auto col-md-2">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">To Date</div></div>
                    <input type="text" name="to_date" value="{{ request('to_date') }}" class="form-control datepicker" autocomplete ="off"  placeholder="To Date" />
                  </div>
                </div>
                <div class="col-auto col-md-3">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">Voucher Code</div></div>
                    <input type="text" name="vouchercode" value="{{ request('vouchercode') }}" class="form-control"  placeholder="Voucher Code" />
                  </div>
                </div>
                <div class="col-auto col-md-3" style="display:none">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Booking Status</div>
                  </div>
                 <select name="booking_status" id="booking_status" class="form-control">
						<option value = "">All</option>
						@foreach($voucherStatus as $vsk => $vs)
						<option value = "{{$vsk}}" @if(request('booking_status')==$vsk) selected="selected" @endif>{{$vs}}</option>
						@endforeach
                 </select>
                </div>
              </div>
               
              <div class="col-auto col-md-2">
                <button class="btn btn-info mb-2" type="submit">Filter</button>
                <a class="btn btn-default mb-2  mx-sm-2" href="{{ route('voucherReport') }}">Clear</a>
              </div>
            </form>
          </div>
        </div><div class="col-md-12" style="overflow-x:auto">
                <table id="example3" class="table rounded-corners">
                  <thead>
                  <tr>
				  <th>Booking Date</th>
					<th>Booking #</th>
                    <th width="7%">Service Date</th>
					<th>Guest Name</th>
					<th>Guest Contact No</th>
					<th>Entry Type</th>
					<th>Pickup/Flight</th>
					<th>Service</th>
					  <th>Varaint</th>
					  <th>Dropoff/Flight</th>
					  <th>A</th>
                    <th>C</th>
                    <th>I</th>
					<th>SIC/PVT</th>
					<th>Pickup Time</th>
					<th>Dropoff Time</th>
					<th>Driver name</th>
					<th>TKT Supplier</th>
					<th>TKT Supplier Ref #</th>
					<th>Agency</th>
					<th>Remark</th>
					
					<th>TFR Supplier</th>
					<th>TFR SP</th>
					<th>TFR Net Cost</th>
					<th>TFR Supplier 2</th>
					<th>TFR Net Cost 2</th>
					
					<th>Status</th>
                  </tr>
				  
                  </thead>
                  <tbody>
				  @foreach ($records as $record)
				  @php
				  $class = SiteHelpers::voucherActivityStatus($record->status);
				  @endphp
                  <tr class="{{$class}}">
				  <td>{{($record->voucher)?$record->voucher->booking_date:''}}</td>
					<td>{{($record->voucher)?$record->voucher->code:''}}</td>
                    <td>
					<input type="text" readonly class="form-control inputsave datepicker" id="tour_date{{$record->id}}" data-name="tour_date"  data-id="{{$record->id}}" value="{{$record->tour_date}}" />
					</td>
					<td>{{($record->voucher)?$record->voucher->guest_name:''}}</td>
					<td>
					<input type="text"  class="form-control inputsaveV" id="guest_phone{{$record->id}}" data-name="guest_phone"  data-id="{{$record->voucher_id}}" value="{{($record->voucher)?$record->voucher->guest_phone:''}}" /></td>
					<td>{{$record->activity_entry_type}}</td>
					<td><input type="hidden" class="form-control inputsave" id="pickup_location{{$record->id}}" data-name="pickup_location" data-id="{{$record->id}}" value="{{$record->pickup_location}}"  />{{$record->pickup_location}}</td>
					<td>{{$record->activity_title}}</td>
					<td>{{($record->variant_name)?$record->variant_name:''}}</td>
					<td><input type="text" class="form-control inputsave" id="dropoff_location{{$record->id}}" data-name="dropoff_location"  data-id="{{$record->id}}" value="{{$record->dropoff_location}}" /></td>
					 <td>{{$record->adult}}</td>
                    <td>{{$record->child}}</td>
                    <td>{{$record->infant}}</td>
					<td>
					@if($record->transfer_option == "Shared Transfer")
					SIC
					@php
					$zone = SiteHelpers::getZoneName($record->transfer_zone);
					@endphp
						- <b>{{@$zone->name}} </b>
					
					@endif
					@if($record->transfer_option == 'Pvt Transfer')
					PVT
					@endif
					
				</td>
				<td><input type="text" class="form-control inputsave" id="actual_pickup_time{{$record->id}}" data-name="actual_pickup_time"  data-id="{{$record->id}}" value="{{$record->actual_pickup_time}}" /></td>
				
				<td><input type="text" class="form-control inputsave" id="dropoff_time{{$record->id}}" data-name="dropoff_time"  data-id="{{$record->id}}" value="{{$record->dropoff_time}}" /></td>	
					<td><input type="text" class="form-control inputsave" id="driver_name{{$record->id}}" data-name="driver_name"  data-id="{{$record->id}}" value="{{$record->driver_name}}" /></td>
					
					
					
					<td>
					 <select name="supplier_ticket{{$record->id}}" id="supplier_ticket{{$record->id}}" class="form-control inputsaveSp">
						<option data-name="supplier_ticket"  data-id="{{$record->id}}" value="">All</option>
						@foreach($supplier_ticket as  $stv)
						
						<option data-name="supplier_ticket"  data-id="{{$record->id}}" value = "{{$stv->id}}" @if($record->supplier_ticket==$stv->id) selected="selected" @endif >{{$stv->company_name}}</option>
						@endforeach
                 </select>
					</td>
					<td><input type="text" class="form-control inputsave" id="ticket_supp_ref_no{{$record->id}}" data-name="ticket_supp_ref_no"  data-id="{{$record->id}}" value="{{$record->ticket_supp_ref_no}}" /></td>
					<td>{{($record->voucher->agent)?$record->voucher->agent->company_name:''}}</td>
					<td><input type="text" class="form-control inputsave" id="remark{{$record->id}}" data-name="remark"  data-id="{{$record->id}}" value="{{$record->remark}}" /></td>
					
					
					
					
					
					
					
				
				
				<td>
					 <select name="supplier_transfer{{$record->id}}" id="supplier_transfer{{$record->id}}" class="form-control inputsaveSp">
						<option data-name="supplier_transfer"  data-id="{{$record->id}}" value="">All</option>
						@foreach($supplier_transfer as  $stt)
						<option data-name="supplier_transfer"  data-id="{{$record->id}}" value = "{{$stt->id}}" @if($record->supplier_transfer==$stt->id) selected="selected" @endif >{{$stt->company_name}}</option>
						@endforeach
                 </select>
					</td>
				
				
					<td>
					{{$record->original_trans_rate}}
					</td>
					
					<td><input type="text" class="form-control inputsave" id="actual_transfer_cost{{$record->id}}" data-name="actual_transfer_cost"  data-id="{{$record->id}}" value="{{$record->actual_transfer_cost}}" /></td>
					
					<td><select name="supplier_transfer2{{$record->id}}" id="supplier_transfer2{{$record->id}}" class="form-control inputsaveSp">
						<option data-name="supplier_transfer2"  data-id="{{$record->id}}" value="">All</option>
						@foreach($supplier_transfer as  $stt)
						<option data-name="supplier_transfer2"  data-id="{{$record->id}}" value = "{{$stt->id}}" @if($record->supplier_transfer==$stt->id) selected="selected" @endif >{{$stt->company_name}}</option>
						@endforeach
                 </select></td>
					<td><input type="text" class="form-control inputsave" id="actual_transfer_cost2{{$record->id}}" data-name="actual_transfer_cost2"  data-id="{{$record->id}}" value="{{$record->actual_transfer_cost2}}" /></td>
					<td>
					@php
					$actStatus = config('constants.voucherActivityStatus');
					@endphp
					<select name="status{{$record->id}}" id="status{{$record->id}}" class="form-control inputsaveSp">
						@foreach($actStatus as $k => $status)
						@if($k > 2)
						<option data-name="status"  data-id="{{$record->id}}" value = "{{$k}}" @if($record->status==$k) selected="selected" @endif >{{$status}}</option>
						@endif
						@endforeach
                 </select>
					</td>
                  </tr>
                
                  @endforeach
                  </tbody>
                </table></div>
				<div class="pagination pull-right mt-3"> 
				</div> 
				
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('scripts')
 <!-- Script -->
 <script type="text/javascript">
$(document).ready(function() {
	
	$(document).on('change', '.inputsave', function(evt) {
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
			   val: $(this).val(),
			   type: "Report",
			   report_type: "Logistic Report"
            },
            success: function( data ) {
               //console.log( data );
			  $("#loader-overlay").hide();
            }
          });
	 });	
	 
	 $(document).on('change', '.inputsaveSp', function(evt) {
		$("#loader-overlay").show();
		var id =$(this).find(':selected').data('id');
		var spInput = $(this).attr('id');
		
		if(spInput == 'supplier_transfer'+id){
			 var cost = parseFloat($('#actual_transfer_cost' + id).val());
			var cost = $('#actual_transfer_cost' + id).val().trim(); // Get and trim the input value

					if (cost === '' || isNaN(parseFloat(cost)) || parseFloat(cost) < 0) {
						alert("Please enter a valid TFR Net Cost greater than or equal to 0");
						$('#' + spInput).val('');  // Reset the value to an empty string or a default value
						$("#loader-overlay").hide();
						return false;
					}
		}
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
               id: $(this).find(':selected').data('id'),
			   inputname: $(this).find(':selected').data('name'),
			   val: $(this).val(),
			   type: "Report",
			   report_type: "Logistic Report"
            },
            success: function( data ) {
               //console.log( data );
			  $("#loader-overlay").hide();
            }
          });
	 });
	 
	 $(document).on('change', '.inputsaveV', function(evt) {
		$("#loader-overlay").show();
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('voucherReportSaveInVoucher')}}",
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
});

  </script> 
  @endsection

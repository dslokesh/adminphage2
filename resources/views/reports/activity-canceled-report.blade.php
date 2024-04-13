@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Voucher Activity Canceled Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Voucher Activity Canceled Report</li>
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
				<a href="{{ route('voucherActivtyCanceledReportExportExcel', request()->input()) }}" class="btn btn-info btn-sm mb-2 mr-4">Export to CSV</a>
				   </div></div>
				   
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  <div class="row">
            <form id="filterForm" class="form-inline" method="get" action="{{ route('voucherActivtyCanceledReport') }}" >
              <div class="form-row align-items-center">
			   <div class="col-auto col-md-3">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Search Result</div>
                  </div>
                 <select name="booking_type" id="booking_type" class="form-control">
                    <option value = "1">Canceled Date</option>
					<option value = "2">Tour Date</option>
					<!--<option value = "3">Deadline Date</option>-->
                 </select>
                </div>
              </div>
			  <div class="col-auto col-md-3">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">From Date</div></div>
                    <input type="text" name="from_date" value="{{ request('from_date') }}" autocomplete ="off" class="form-control datepicker"  placeholder="From Date" />
                  </div>
                </div>
				<div class="col-auto col-md-3">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">To Date</div></div>
                    <input type="text" name="to_date" value="{{ request('to_date') }}" class="form-control datepicker" autocomplete ="off"  placeholder="To Date" />
                  </div>
                </div>
                <div class="col-auto col-md-3">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">Voucher Code</div></div>
                    <input type="text" name="reference" value="{{ request('reference') }}" class="form-control"  placeholder="Reference Number" />
                  </div>
                </div>
                
               
              <div class="col-auto col-md-2">
                <button class="btn btn-info mb-2" type="submit">Filter</button>
                <a class="btn btn-default mb-2  mx-sm-2" href="{{ route('voucherActivtyCanceledReport') }}">Clear</a>
              </div>
            </form>
          </div>
        </div><div class="col-md-12" style="overflow-x:auto">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
					<th>Voucher Code</th>
					<th>Agency</th>
                    <th>Activty</th>
					<th>Service</th>
					<th>Guest Name</th>
					<th>Guest Contact</th>
                    <th>A</th>
                    <th>C</th>
                    <th>I</th>
					<th>Tour Date</th>
					<th>Canceled Date</th>					
					<th>Ticket Cost</th>
					<th>Transfer Cost</th>
					<th>Ticket Discount</th>
					<th>Transfer Discount</th>
					<th>Total</th>
					<th>Ticket Refund </th>
					<th>Transfer Refund </th>
					<th></th>
                  </tr>
				  
                  </thead>
                  <tbody>
				  @foreach ($records as $record)
				  @php
				  $allPrice = PriceHelper::getTicketAllTypeCost($record->id);
				  $refundAmount = PriceHelper::getRefundAmountAfterCancellation($record->id);
				  $trefundAmt = ($record->refund_amount_tkt)?$record->refund_amount_tkt:$refundAmount['refund_tkt_priceAfDis'];
				  $transrefundAmt = ($record->refund_amount_trans)?$record->refund_amount_trans:$refundAmount['refund_trns_priceAfDis'];
				  @endphp
                  <tr>
					<td>{{($record->voucher)?$record->voucher->code:''}}</td>
					<td>{{($record->voucher->agent)?$record->voucher->agent->company_name:''}}</td>
                   
					<td>{{$record->activity_title}}</td>
					<td>{{$record->variant_name}}</td>
					<td>{{($record->voucher)?$record->voucher->guest_name:''}}</td>
					<td>{{($record->voucher)?$record->voucher->guest_phone:''}}</td>
                    <td>{{$record->adult}}</td>
                    <td>{{$record->child}}</td>
                    <td>{{$record->infant}}</td>
					<td>{{$record->tour_date}}</td>
					<td>{{$record->canceled_date}}</td>
					<td>{{ $allPrice['tkt_price'] }}</td>
					<td>{{ $allPrice['trns_price'] }}</td>
					<td>{{ $allPrice['discounTkt'] }}</td>
					<td>{{ $allPrice['discountTrns'] }}</td>
					<td>{{ $allPrice['totalPriceAfDis'] }}</td>
					<td>
					@if($record->status == 1)
					<input type="text" class="form-control inputsave onlynumbrf" id="refund_amount_tkt{{$record->id}}"  data-id="{{$record->id}}" value="{{$trefundAmt}}" data-inputname="refund_amount_tkt" placeholder="Refund Amount" />
					@else
					{{$record->refund_amount_tkt}}
					@endif
					</td>
					<td>
					@if($record->status == 1)
					
					<input type="text" class="form-control inputsave onlynumbrf @if($record->transfer_option == 'Ticket Only') hide @endif" id="refund_amount_tras{{$record->id}}"  data-id="{{$record->id}}" data-inputname="refund_amount_trans" value="{{$transrefundAmt}}" placeholder="Refund Amount" />
					
					@else
					{{$record->refund_amount_trans}}
					@endif
					</td>
					
					<td>
					<form id="refund-change-form-{{$record->id}}" method="post" action="{{route('activityFinalRefundSave')}}" style="display:none;">
                                {{csrf_field()}}
								<input type="hidden"  value="{{$record->id}}" name="id"  /> 
								<input type="hidden"  value="{{$transrefundAmt}}" name="trans"  /> 
								<input type="hidden"  value="{{$trefundAmt}}" name="tkt"  /> 
                            </form>
							
					<a class="btn btn-success float-right  btn-sm  d-pdf" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('refund-change-form-{{$record->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            " >Save</td>
					
                  </tr>
                 
                  @endforeach
				   </tbody>
                </table></div>
				<div class="pagination pull-right mt-3"> 
				{!! $records->appends(request()->query())->links() !!}
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
	$(document).on('keypress', '.onlynumbrf', function(evt) {
	var charCode = (evt.which) ? evt.which : evt.keyCode
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
  return true;

});
	$(document).on('change', '.inputsave', function(evt) {
		$("#loader-overlay").show();
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('activityRefundSave')}}",
            type: 'POST',
            dataType: "json",
            data: {
               id: $(this).data('id'),
			   inputname: $(this).data('inputname'),
			   val: $(this).val()
            },
            success: function( data ) {
              //alert( data );
			  $("#loader-overlay").hide();
			  if(data[0].status==2){
				  alert("Amount Already Refunded.");
				 //location.reload(true);
			  }
			  if(data[0].status==3){
				  alert("Agent not found.");
				 //location.reload(true);
			  }
			  if(data[0].status==4){
				  alert("The refund price cannot be greater than the refund eligible price.");
				 //location.reload(true);
			  }
			  
			  location.reload(true);
            }
          });
	 });	
	
});

  </script> 
  @endsection
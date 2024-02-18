@extends('layouts.appLogin')
@section('content')
<div class="dashboard__content mt-5">
   <div class="dashboard__content_content">

          <h1 class="text-30">My Booking</h1>

          <div class="rounded-12 bg-white shadow-2 px-40 pt-40 pb-30 md:px-20 md:pt-20 md:mb-20 mt-60">
            <div class="tabs -underline-2 js-tabs">
              <div class="card-body">
			  <div class="row">
            <form id="filterForm" class="form-inline" method="get" action="{{ route('agent-vouchers.index') }}" >
              <div class="form-row align-items-center">
			   <div class="col-auto col-md-3">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Search Result</div>
                  </div>
                 <select name="booking_type" id="booking_type" class="form-control">
                   <option value="1" {{ (request('booking_type') == 1) ? 'selected' : '' }}>Booking Date</option>
					<option value="2" {{ (request('booking_type') == 2) ? 'selected' : '' }}>Travel Date</option>
					<!--<option value = "3">Deadline Date</option>-->
                 </select>
                </div>
              </div>
			  <div class="col-auto col-md-3">
                  <div class="input-group mb-2 ">
                    <div class="input-group-prepend"><div class="input-group-text">From Date</div></div>
                    <input type="text" name="from_date" value="{{ request('from_date') }}" autocomplete ="off" class="form-control  datepicker"  placeholder="From Date" />
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
                    <div class="input-group-prepend"><div class="input-group-text">Agent Reference</div></div>
                    <input type="text" name="reference" value="{{ request('reference') }}" class="form-control"  placeholder="Agent Reference Number" />
                  </div>
                </div>
				 <div class="col-auto col-md-3">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">Booking Number</div></div>
                    <input type="text" name="vcode" value="{{ request('vcode') }}" class="form-control"  placeholder="Booking Number" />
                  </div>
                </div>
                <div class="col-auto col-md-3">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">Service Name</div></div>
                    <input type="text" name="activity_name" value="{{ request('activity_name') }}" class="form-control"  placeholder="Service Name" />
                  </div>
                </div>
                <div class="col-auto col-md-3">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">Customer</div></div>
                    <input type="text" name="customer" value="{{ request('customer') }}" class="form-control"  placeholder="Customer" />
                  </div>
                </div>
				
              <div class="col-auto col-md-2">
                <button class="btn btn-info mb-2" type="submit">Filter</button>
                <a class="btn btn-default mb-2  mx-sm-2" href="{{ route('agent-vouchers.index') }}">Clear</a>
              </div>
            </form>
          </div>
        </div>
		 </div>

              <div class="tabs__content js-tabs-content">

                <div class="tabs__pane -tab-item-1 is-tab-el-active">
                  <div class="overflowAuto">
                    <table class="tableTest mb-30">
                      <thead class="bg-light-1 rounded-12">
                        <tr>
                  <th>Booking Number</th>
                  <th>Booking Date</th>
                  <th>Service Type</th>
					
					<th>Service Name</th>
          <th>Travel Date</th>
					<th>Agent Ref. No.</th>
					<th>Customer</th>
					<th>Adult</th>
					<th>Child</th>
					<th>Infant</th>
					
				
					
                    <th>Status</th>
                  
				
                    <th></th>
                  </tr>
                      </thead>

                      <tbody>
 @foreach ($records as $record)
                  <tr>
                  <td>{{ ($record->voucher->code)}}</td>
                  <td>
					{{ $record->voucher->booking_date ? date(config('app.date_format'),strtotime($record->voucher->booking_date)) : null }}
</td>
				  <td>{{ ($record->activity->entry_type)}}</td>
				  
				   <td>{{ ($record->activity->title)}}</td>
           <td>
					{{ $record->tour_date ? date(config('app.date_format'),strtotime($record->tour_date)) : null }}
					</td>
				   <td>{{ ($record->voucher->agent_ref_no)}}</td>
					<td>{{ ($record->voucher->guest_name)?$record->voucher->guest_name:''}}</td>
					<td>{{ ($record->adult)}}</td>
					<td>{{ ($record->child)}}</td>
					<td>{{ ($record->infant)}}</td>
					
				
					
                    <td>{!! SiteHelpers::voucherStatus($record->voucher->status_main) !!}</td>
                

                     <td width="12%">
					 @if($record->voucher->status_main == '4')
					 
					 <a class="button -dark-1 size-35 bg-light-1 rounded-full flex-center" alt="View Details" href="{{route('agent-vouchers.show',$record->voucher->id)}}">
                              <i class="fas fa-eye">
                              </i>
                              
                          </a>
					@endif
          @if($record->voucher->status_main > 4)
					 
          <a class="button -dark-1 size-35 bg-light-1 rounded-full flex-center" alt="View Details" href="{{route('agentVoucherView',$record->voucher->id)}}">
                             <i class="fas fa-eye">
                             </i>
                             
                         </a>
         @endif
					
						  
                         </td>
                  </tr>
				 
                  @endforeach
                      </tbody>
                    </table>
                  </div>


               <div class="pagination justify-center">
    <div class="pagination pull-right mt-3"> {!! $records->appends(request()->query())->links() !!} </div> 
</div>


                  
                </div>

              
              </div>
            </div>
          </div>

          <div class="text-center pt-30">
            © Copyright Viatours 2023
          </div>

        </div>
  </div>    
@endsection
@section('scripts')
<script type="text/javascript">
    var path = "{{ route('auto.agent') }}";
  
    $( "#agent_id" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
               search: request.term,
            },
            success: function( data ) {
               response( data );
            }
          });
        },
		
        select: function (event, ui) {
           $('#agent_id').val(ui.item.label);
           //console.log(ui.item); 
		   $('#agent_id_select').val(ui.item.value);
		    $('#agent_details').html(ui.item.agentDetails);
           return false;
        },
        change: function(event, ui){
            // Clear the input field if the user doesn't select an option
            if (ui.item == null){
                $('#agent_id').val('');
				 $('#agent_id_select').val('');
				 $('#agent_details').html('');
            }
        }
      });
  
</script>
@endsection
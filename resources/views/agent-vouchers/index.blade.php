@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Bookings</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Bookings</li>
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
                <h3 class="card-title">Bookings</h3>
			
              </div>
              <!-- /.card-header -->
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
                    <option value = "1">Booking Date</option>
					<option value = "2">Travel Date</option>
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
			  <div class="col-md-12" style="overflow-x:auto">
                <table id="example1" class="table rounded-corners">
                  <thead>
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
                

					
					 <td class="hide">
					 @if($record->voucher->is_activity == 1)
						 @if($record->voucher->status_main < 4)
					 <a class="btn btn-info btn-sm" href="{{route('agent-vouchers.add.activity',$record->voucher->id)}}">
                              <i class="fas fa-plus">
                              </i>
                             
                          </a>
						  @endif
						  @endif
						  </td>
						  <td class="hide">
						   @if(($record->voucher->status_main == 4) OR ($record->voucher->status_main == 5))
					 <a class="btn btn-info btn-sm" href="{{route('voucherInvoicePdf',$record->voucher->id)}}" >
                              <i class="fas fa-download">
                              </i>
                             
                          </a>
						  @endif
						  </td>
					
                     <td>
					 @if($record->voucher->status_main == '4')
					 
					 <a class="btn btn-info btn-sm" alt="View Details" href="{{route('agent-vouchers.show',$record->voucher->id)}}">
                              <i class="fas fa-eye">
                              </i>
                              
                          </a>
					@endif
          @if($record->voucher->status_main > 4)
					 
          <a class="btn btn-info btn-sm" alt="View Details" href="{{route('agentVoucherView',$record->voucher->id)}}">
                             <i class="fas fa-eye">
                             </i>
                             
                         </a>
         @endif
					 <a class="btn btn-info btn-sm hide" href="{{route('agent-vouchers.edit',$record->voucher->id)}}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              
                          </a>
						   <form id="delete-form-{{$record->voucher->id}}" method="post" action="{{route('agent-vouchers.destroy',$record->voucher->id)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <a class="btn btn-danger btn-sm hide" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$record->voucher->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            "><i class="fas fa-trash"></i></a>
                         </td>
                  </tr>
				 
                  @endforeach
                  </tbody>
                 
                </table>
				</div>
				<div class="pagination pull-right mt-3"> {!! $records->appends(request()->query())->links() !!} </div> 
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
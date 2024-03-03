@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Hotel Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Hotel Report</li>
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
				
				   </div></div>
				   
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="overflow-x:auto">
			 
                <table id="example3" class="table table-bordered table-striped">
                  <thead>
                 			  
				   <tr>
                    <th>Booking Date</th>
					<th>Payment Date</th>
					<th>Booking #</th>
					<th>HCN</th>
					<th>Check In</th>
					<th>Check Out</th>
					<th>Hotel Name</th>
					<th>NO. Of Nights</th>
					<th>NO. Of Rooms</th>
					<th>Total Net Cost</th>
					<th>Mark up</th>
					<th>Payment Due Date</th>
					<th>Supplier</th>
					<th>Payment Status</th>
					<th>Payment Status Updated by</th>
					
                  </tr>
				  
                  </thead>
                  <tbody>
				 
				  @foreach ($records as $record)
				  @php
            $room = SiteHelpers::hotelRoomsDetails($record->hotel_other_details);
			 $night = SiteHelpers::numberOfNight($record->check_in_date,$record->check_out_date);
			 $markUp = @$room['markup_v_s']+@$room['markup_v_d']+@$room['markup_v_eb']+@$room['markup_v_cwb']+@$room['markup_v_cnb'];
            @endphp
                  <tr>
                    <td>{{($record->voucher)?$record->voucher->booking_date:''}}</td>
					<td>{{($record->voucher)?$record->voucher->payment_date:''}}</td>
					<td>{{($record->voucher)?$record->voucher->code:''}}</td>
					
					<td>{{$record->hotel->hotelcategory->name}}</td>
					<td>{{$record->check_in_date}}</td>
					<td>{{$record->check_out_date}}</td>
					<td>{{($record->hotel)?$record->hotel->name:''}}</td>
					<td>{{$night }}</td>
					<td>{{$room['number_of_rooms']}}</td>
					<td>{{$room['price']}}</td>
					<td>{{$markUp}}</td>
					<td></td>
					<td></td>
					 <td>{!! SiteHelpers::voucherStatus($record->voucher->status_main) !!}</td>
					<td>{{($record->voucher)?@$record->voucher->updatedBy->name:''}}</td>
					</tr>
                 
                  @endforeach
				 </tbody>
					
                </table>
				
				
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
 $(document).ready(function(){
	var activity_id = "{{request('activity_id')}}";
	var oldactivity_variant = "{{request('activity_variant')}}";
	
	$("body #activity_id").on("change", function () {
            var activity_id = $(this).val();
			$("#activity_variant").prop("disabled",true);
            $.ajax({
                type: "POST",
                url: '{{ route("variantByActivity") }}',
                data: {'activity_id': activity_id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
					 $('#activity_variant').html('<option value="">--select--</option>');
					$.each(data, function (key, value) {
                            $("#activity_variant").append('<option value="' + value
                                .u_code + '">' + value.variant_name + '</option>');
                        });
					$('#activity_variant').val(oldactivity_variant).prop('selected', true);
					$("#activity_variant").prop("disabled",false);
					
					
                }
            });
        });
		if(activity_id){
					$("body #activity_id").trigger("change");
					}
					
		if(oldactivity_variant){
					$("body #activity_id").trigger("change");
					}
		});
			</script>  
@endsection
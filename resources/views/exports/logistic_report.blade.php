<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
					<th>Booking #</th>
                    <th>Service Date</th>
					<th>Guest Name</th>
					<th>Guest Contact No</th>
					<th>Pickup</th>
					<th>Service</th>
					  <th>Varaint</th>
					  <th>Dropoff</th>
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
					
                  </tr>
				  
                  </thead>
                  <tbody>
				 @foreach($records as $record)
				 
                   <tr>
					<td>{{($record->voucher)?$record->voucher->code:''}}</td>
                    <td>
					{{$record->tour_date}}
					</td>
					<td>{{($record->voucher)?$record->voucher->guest_name:''}}</td>
				<td>{{($record->voucher)?$record->voucher->guest_phone:''}}</td>
					<td>{{$record->pickup_location}}</td>
					<td>{{$record->activity_title}}</td>
					<td>{{($record->variant_name)?$record->variant_name:''}}</td>
					<td>{{$record->dropoff_location}}</td>
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
				<td>{{$record->actual_pickup_time}}</td>
				
				<td>{{$record->dropoff_time}}</td>
				<td>{{$record->driver_name}}</td>
					<td>{{($record->supplierticket)?$record->supplierticket->company_name:''}}</td>
					<td>{{$record->ticket_supp_ref_no}}</td>
					<td>{{($record->voucher->agent)?$record->voucher->agent->company_name:''}}</td>
					<td>{{$record->remark}}</td>
					
				<td>{{($record->suppliertransfer)?$record->suppliertransfer->company_name:''}}</td>
				
					<td>
					@if($record->transfer_option == "Shared Transfer")
					@php
					$markup_sic_transfer =  (($record->zonevalprice_without_markup) * ($record->markup_p_sic_transfer/100));
					@endphp
					{{$record->zonevalprice_without_markup + $markup_sic_transfer}}
					@endif
					@if($record->transfer_option == 'Pvt Transfer')
					{{$record->pvt_traf_val_with_markup}}
					@endif
					</td>
					<td>{{$record->actual_transfer_cost}}</td>
					
                  </tr>
				  @endforeach
                  </tbody>
                 
                </table>
				</body>
</html>
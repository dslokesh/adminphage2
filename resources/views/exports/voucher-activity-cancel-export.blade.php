<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
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
					<th>Total Cost</th>
                  </tr>
				  
                  </thead>
                  <tbody>
				   @foreach ($records as $record)
                  <tr>
					<td>{{($record->voucher)?$record->voucher->code:''}}</td>
					<td>{{($record->voucher->agent)?$record->voucher->agent->company_name:''}}</td>
                   
					<td>{{($record->activity)?$record->activity->title:''}}</td>
					<td>{{$record->variant_name}}</td>
					<td>{{($record->voucher)?$record->voucher->guest_name:''}}</td>
					<td>{{($record->voucher)?$record->voucher->guest_phone:''}}</td>
                    <td>{{$record->adult}}</td>
                    <td>{{$record->child}}</td>
                    <td>{{$record->infant}}</td>
					<td>{{$record->tour_date}}</td>
					<td>{{$record->canceled_date}}</td>
					<td>{{$record->totalprice}}</td>
                  </tr>
                  @endforeach
                  </tbody>
                 
                </table>
				</body>
</html>
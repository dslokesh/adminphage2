@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Voucher Details ( {{$voucher->code}})</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('vouchers.index') }}">Vouchers</a></li>
              <li class="breadcrumb-item active">Voucher Details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    
        <div class="col-md-12">
		<div class="card card-primary card-outline card-tabs">
		
	   
	   <div class="card-body">
		
			@if(!empty($voucherActivity) && $voucher->is_activity == 1)
				<div class="row p-2">
			 
			  <div class="col-md-12">
			  <form action="{{route('invoicePriceChangeSave',$voucher->id)}}" method="post" class="form" >
			  {{ csrf_field() }}
                <table class="table table-bordered">
                  <thead>
				  
                  <tr>
					<th>Tour Option</th>
                    <th>Transfer Option</th>
					<th width="10%">Tour Date</th>
					<th>Adult</th>
                    <th>Child</th>
                    <th>Infant</th>
					<th>Discount</th>
					<th>Amount</th>
					<th>Total Amount</th>
					<th>Discount</th>
					<th>Net Amount</th>
                  </tr>
				  @if(!empty($voucherActivity))
					  @foreach($voucherActivity as $kk => $ap)
					@php
					$activity = SiteHelpers::getActivity($ap->activity_id);
					$priceT = $ap->totalprice + $ap->discountPrice;
					@endphp
					
				   <tr>
                    <td>{{$activity->title}} - {{$ap->variant_name}} - {{$ap->variant_code}}</td>
					<td>{{$ap->transfer_option}}
					@if($ap->transfer_option == 'Shared Transfer')
						@php
					$zone = SiteHelpers::getZoneName($ap->transfer_zone);
					@endphp
						- <b>Zone :</b> {{$zone->name}}
					@endif
					
					@if($ap->transfer_option == 'Shared Transfer')
					- <b>Pickup Location :</b> {{$ap->pickup_location}}
					@elseif($ap->transfer_option == 'Pvt Transfer')
					- <b>Pickup Location :</b> {{$ap->pickup_location}}
					@endif
					</td>
					<td>{{$ap->tour_date}}</td>
					<td>{{$ap->adult}}</td>
                    <td>{{$ap->child}}</td>
                    <td>{{$ap->infant}}</td>
					<td>{{$ap->discountPrice}}</td>
					<td>{{$ap->totalprice}}</td>
					<td>{{$priceT}}
					<input type="hidden" id="totalprice{{$kk}}" value="{{$priceT}}"  data-inputnumber="{{$kk}}"   />
					</td>
					<td><input type="text" id="discount{{$kk}}" name="discount[{{$ap->id}}]}" class="form-control priceChange" value="0" data-inputnumber="{{$kk}}"   /></td>
					<td>
					<input type="hidden" id="newPrice{{$kk}}" value="" data-inputnumber="{{$kk}}"   />
					<span id="price{{$kk}}" style="font-weight:bold">{{$priceT}}</span>
					</td>
                  </tr>
				  @endforeach
				 @endif
				
				  </table>
				  <button type="submit" class="btn btn-primary float-right mr-2" onclick="return confirm('Are you sure change invoice price?')" name="save_and_continue">Save</button>
				  <button type="submit" class="btn btn-secondary mr-2"  name="save_and_continue">Cancel</button>
				  </form>
              </div>
			 </div>	
		@endif
			
</div>

      </div>


    </section>
    <!-- /.content -->
@endsection



@section('scripts')
<script type="text/javascript">
  $(function(){
	   $(document).on('change', '.priceChange', function(evt) {
	var inputnumber = $(this).data('inputnumber');
	var amt = parseFloat($("body #totalprice"+inputnumber).val());
	var discount = parseFloat($(this).val());
	/* if(discount == null || isNaN(discount) || discount <0)
	{
		discount = 0;
		$(this).val(0);
		return true;
	} */
	
	if(discount > amt){
		alert("Discount not greater than total amount.");
		$("body #discount"+inputnumber).val(0);
		$("body #price"+inputnumber).text(amt);
		$("body #newPrice"+inputnumber).val(amt);
		return false;
	}
	var totalPrice =  amt - discount;
	$("body #price"+inputnumber).text(totalPrice);
	$("body #newPrice"+inputnumber).val(totalPrice);
	});
	
	
	
});
</script>
@endsection
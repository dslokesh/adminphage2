@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Discount Details</h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

  

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
  
<div class="row multistep">
        <div class="col-md-3 multistep-step complete">
            <div class="text-center multistep-stepname" style="font-size: 16px;">Add to Cart</div>
            <div class="progress"><div class="progress-bar"></div></div>
            <a href="#" class="multistep-dot"></a>
        </div>

        <div class="col-md-3 multistep-step current">
            <div class="text-center multistep-stepname" style="font-size: 16px;">Discount</div>
            <div class="progress"><div class="progress-bar"></div></div>
            <a href="#" class="multistep-dot"></a>
        </div>

        <div class="col-md-3 multistep-step next">
            <div class="text-center multistep-stepname" style="font-size: 16px;">Voucher</div>
            <div class="progress"><div class="progress-bar"></div></div>
            <a href="#" class="multistep-dot"></a>
        </div>
		 <div class="col-md-3">
				@if($voucher->is_activity == 1)
				@if($voucher->status_main < 5)
				<a class="btn btn-info btn-sm float-left" style=" margin-top: 20px;margin-left: 120px;" href="{{route('voucher.add.activity',$voucher->id)}}" >Add More</a>

				@endif
				@endif
				</div>
        
        
    </div>
	
        <div class="row" style="margin-top: 30px;">
		
          <!-- left column -->
          <div class="offset-md-2 col-md-6">
		  
			
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title"><i class="nav-icon fas fa-book" style="color:black"></i> Discount Information</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
                <div class="card-body">
				
					@if(!empty($voucherActivity))
						 @php
					$c=0;
					$tkt=0;
					@endphp
					
					
					 @foreach($voucherActivity as $ap)
					 @php
					$c++;
					@endphp
				  
          
                  <div class="row" style="margin-bottom: 15px;">
                   <div class="col-12"><p><strong>{{$c}}. {{$ap->variant_name}} : {{$ap->transfer_option}}@if($ap->transfer_option == 'Shared Transfer')
					@php
					$zone = SiteHelpers::getZoneName($ap->transfer_zone);
					@endphp
					- Zone :{{(isset($zone->name))?$zone->name:''}}
					@endif</strong></p></div>
					
					@if($ap->original_tkt_rate > 0)
					<div class="form-group col-md-6 ">
              <label>Ticket Discount ({{$ap->original_tkt_rate}})</label>
                 <input type="text" id="discount_tkt{{$ap->id}}" value="{{$ap->discount_tkt}}"   class="form-control inputsaveDisTktTrans"  placeholder="Ticket Discount"  data-id="{{$ap->id}}" data-maxdis="{{$ap->original_tkt_rate}}" data-name="discount_tkt" />
				
              </div>
			  @endif
			  @if($ap->original_trans_rate > 0)
			  <div class="form-group col-md-6 ">
              <label>Transfer Discount ({{$ap->original_trans_rate}})</label>
                 <input type="text" id="discount_sic_pvt_price{{$ap->id}}" value="{{$ap->discount_sic_pvt_price}}"   class="form-control inputsaveDisTktTrans"  placeholder="Transfer Discount" data-maxdis="{{$ap->original_trans_rate}}"  data-id="{{$ap->id}}" data-name="discount_sic_pvt_price" />
				
              </div>
			  @endif
                  </div>
				  
				  @endforeach
                 @endif
				  
                </div>
                </div>
				
                <!-- /.card-body -->

               
           
			
          
            
            <!-- /.card -->
 <!-- general form elements -->
 <div class="card card-default">
  
   

    <div class="card-footer">
      <div class="row" style="margin-bottom: 5px;">
        
        <div class="col-12 text-right">
			@if(!empty($voucherActivity))
			<a href="{{ route('vouchers.show',$voucher->id) }}" class="btn btn-lg btn-primary pull-right" style="width:100%">
			<i class="fas fa-shopping-cart"></i>
			Checkout
			</a>
			@endif
        </div>
      </div>
    </div>

</div>
<!-- /.card -->

            <!-- Horizontal Form -->
            

          </div>
          <!--/.col (left) -->
         <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  
    <!-- /.content -->
@endsection



@section('scripts')

<script type="text/javascript">
 
  $(function(){
$(document).on('change', '.inputsaveDisTktTrans', function(evt) {
		$("#loader-overlay").show();
		var id = $(this).data('id');
		var inputname = $(this).data('name');
		var maxdis = $(this).data('maxdis');
		var val = $(this).val();
		if(val > maxdis){
			alert("Invalid discounts: Discount should not be greater than the original price.");
			$("#loader-overlay").hide();
			$(this).val(0)
			return false;
		}
		//alert(id);
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
               id: id,
			   inputname: inputname,
			   val: val,
            },
            success: function( data ) {
			   if(inputname == 'supplier_ticket'){
          
				   $("#actual_total_cost"+id).val(data[0].cost);
			   }
			  $("#loader-overlay").hide();
            }
          });
	 });
	 
	});
	


</script>
@endsection

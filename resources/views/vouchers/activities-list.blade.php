@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header" >
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Activities & Tours (Ageny : {{$voucher->agent->company_name}}) (<i class="fa fa-wallet" aria-hidden="true"></i> : AED {{$voucher->agent->agent_amount_balance}})</h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content" id="activities-list-blade">
        
    <div class="container-fluid">
       
              <!-- /.card-header -->
             
             
          <div class="col-md-12 ">
             
               
               

       <div class="row">
       <div class="col-md-12 card card-default d-none">
              <!-- form start -->
              <form id="filterForm" class="form-inline" method="get" action="{{ route('voucher.add.activity',$vid) }}" >
                <div class="card-body">
                  <div class="row">
                      <div class="col-md-4">
                        <div class="input-group">
                          <input type="text" name="name" value="{{ request('name') }}" class="form-control"  placeholder="Filter with Name" />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="input-group ">
                            <button class="btn btn-info" type="submit">   <i class="fas fa-search"></i> Search</button>
                            <a class="btn btn-default  mx-sm-2" href="{{ route('voucher.add.activity',$vid) }}">Clear</a>
                        </div>
                      </div>
                      <div class="col-md-2 text-right">
                          <div class="input-group  text-right float-right">
                          @if($voucher->is_hotel == '1')
                                <a href="{{ route('voucher.add.hotels',$voucher->id) }}" class="btn btn-md btn-secondary pull-right">
                                  <i class="fas fa-hotel"></i>
                                  Add Hotels
                              </a>
                              @endif
                        </div>
                        </div>
                      <div class="col-md-2 text-right">
                        <div class="input-group  text-right float-right">
                            @if($voucherActivityCount > 0)
                                  <a href="{{ route('vouchers.show',$voucher->id) }}" class="btn btn-md btn-primary pull-right">
                                <i class="fas fa-shopping-cart"></i>
                                Checkout({{$voucherActivityCount}})
                            </a>
                            @endif
                        </div>
                      </div>
                  </div>
                </div>
                <!-- /.card-body -->
                </form>
                </div>
             <div class="card-body @if($voucherActivityCount > 0) col-md-9 @else offset-1 col-md-10 @endif">
             <table id="tbl-activites" class="dataTable" style="width:100%" cellpadding="0px;" cellspaccing="0px" aria-describedby="example2_info">
              <thead>
                <tr>
                <th class=" " tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="" aria-sort=""></th>
                </tr>
              </thead>
                  @foreach ($records as $record)
				  @php
            $minPrice = $record->min_price;
			$cutoffTime = SiteHelpers::getActivityVarByCutoffCancellation($record->id);
          @endphp
          <tr><td>
                   <!-- Default box -->
      <div class="card collapsed-card ">
        <div class="card-header">
          <div class="row">
            <div class="col-md-3">
              <img src="{{asset('uploads/activities/'.$record->image)}}" class="img-fluid" style="width: 278px;height:173px" />
            </div>
            <div class="col-md-6">
              <h2 class="card-title" >
			  <strong> <a class="" href="{{route('voucher.activity.view',[$record->id,$vid])}}" target="_blank">
                            {{$record->title}}
                          </a></strong>
			 </h2>
              <br/> <br/>
              <ul class="list-unstyled" style="margin-top: 70px;">
				@if($record->entry_type == 'Tour')
                <li class="text-color">
                 <i class="far fa-fw  fa-check-circle"></i> Instant Confirmation
                </li>
				@endif
                <li  class="text-color">
                 <i class="far fa-fw  fa-check-circle "></i> {!!$cutoffTime!!}
                </li>
               
                
              </ul>
            </div>
            <div class="col-md-3 text-right text-dark" style="padding-top: 60px;">
              
              <span >
              From 
              <br/>
              AED {{$minPrice}}
              <br/>
              </span>
              <br/>
              <button type="button" data-act="{{ $record->id }}"  data-vid="{{ $vid }}" class="btn btn-sm btn-primary-flip loadvari" data-card-widget="collapse" title="Collapse">
                SELECT
              </button>
            </div>
          </div>
        
        </div>
        <div class="card-body pdivvarc" id="pdivvar{{ $record->id }}" style="display: none;">
          <div class="row p-2">
			 
            <div class="col-md-12 var_data_div_cc" id="var_data_div{{ $record->id }}">
                    
                  </div>
              
           </div>
        </div>
        <!-- /.card-body -->
        
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
				 
      </td></tr>
                  @endforeach
</table> 
                 
				<div class="pagination pull-right mt-3"> {!! $records->appends(request()->query())->links() !!} </div> 
</div>
@php
					$total = 0;
					@endphp
 @if(!empty($voucherActivity) && $voucher->is_activity == 1)
 <div class="col-md-3  mt-2 " id="div-cart-list" >
				
			  
					@if(!empty($voucherActivity))
					  @foreach($voucherActivity as $ap)
				  @php
          $total += $ap->totalprice;
		  $activityImg = SiteHelpers::getActivityImageName($ap->activity_id);
					@endphp
            <div class="card">
			
              
              <div class="card-body card-body-hover" >
             
              <div class="row">
              <div class="col-10">
              <span class="cart-title font-size-21 text-dark">
              {{$ap->activity_title}}
              </span>
              </div>
              <div class="col-2  text-right">
              <form id="delete-form-{{$ap->id}}" method="post" action="{{route('voucher.activity.delete',$ap->id)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <small>
                            <a class="btn btn-xs btn-danger border-round" title="delete" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$ap->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            "><small><i class="fas fa-trash-alt "></i></small></a></small>
              </div>
              </div>
             
                                  <div class="row" >
				  <div class="col-md-3" style="padding: 5px 0px 5px 5px; ">
              <img src="{{asset('uploads/activities/'.$activityImg)}}" class="img-fluid" style="border-radius: 5px;" />
            </div>
			<div class="col-md-9">
              <ul class="list-unstyled" style="">
             
                <li>
                 {{$ap->variant_name}}
                </li>
				<li>
                  {{$ap->transfer_option}}
                </li>
                <li>
                   {{ $ap->tour_date ? date(config('app.date_format'),strtotime($ap->tour_date)) : null }}
                </li>
                <li>

                 <i class="fas fa-male color-grey" style="font-size:16px;" title="Adult"></i> <span class="color-black">{{$ap->adult}}</span> <i class="fas fa-child color-grey" title="Child"></i>  <span class="color-black">{{$ap->child}}</span>

                  <span class="float-right " ><h2 class="card-title text-right color-black"><strong>AED {{$ap->totalprice}}</strong></h2></span>
                </li>
                
              </ul>
			   
            </div>
			
                </div>
              
              </div>
              <!-- /.card-body -->
            </div>
			
				 @endforeach
                 @endif
                 <div class="input-group  text-right float-right mb-3">
                            @if($voucherActivityCount > 0)
                               <h2 class="card-title color-black " style="width:100%"><strong>Total Amount : AED {{$total}}</strong></h2>
                            @endif
                        </div>
						
                 <div class="input-group  text-right float-right">
                            @if($voucherActivityCount > 0)
                                  <a href="{{ route('vouchers.show',$voucher->id) }}" class="btn btn-lg btn-primary pull-right" style="width:100%">
                                <i class="fas fa-shopping-cart"></i>
                                Checkout({{$voucherActivityCount}})
                            </a>
                            @endif
                        </div>
				
</div>
  @endif
</div>
</div>
           
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
         
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('scripts')

	
<script type="text/javascript">
  $(document).ready(function() {
	  $('body #activity_select0').prop('checked', false); // Checks it
	 $("body #tour_date0").prop('required',true);
			
$(document).on('click', '.loadvari', function(evt) {
  var actid = $(this).data('act');
   var inputnumber = $(this).data('inputnumber');
  $("body #loader-overlay").show();
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
           
		$.ajax({
            url: "{{route('get-vouchers.activity.variant')}}",
            type: 'POST',
            dataType: "json",
            data: {
              act: $(this).data('act'),
              vid: $(this).data('vid'),
            },
            success: function( data ) {
               //console.log( data.html );
               //alert("#var_data_div");
               
             $("body .var_data_div_cc").html('');
             $("body .pdivvarc").css('display','none');
			      $("body #var_data_div"+actid).html(data.html);
            $("body #pdivvar"+actid).css('display','block');
            $("body #loader-overlay").hide();
			// Onload change price 
			var pvttr =  $("body #transfer_option0").find(':selected').val();
			$("body #adult0").trigger("change");
			if(pvttr == 'Pvt Transfer'){
				setTimeout(function() {
				$("body .t_option#transfer_option0").trigger("change");
				}, 1000);
			}
			
			if(pvttr == 'Shared Transfer'){
				$("body .t_option#transfer_option0").trigger("change");
			}
			
				//var response = JSON.parse(data.dates);
				var disabledDates = data.dates.disabledDates;
				var availableDates = data.dates.availableDates;
				 var disabledDay = data.disabledDay;
				  $("body #tour_date0").prop('required',true);
				// console.log(disabledDay);
				$(".tour_datepicker").datepicker({
                        /* beforeShowDay: function(date) {
                            var dateString = $.datepicker.formatDate('yy-mm-dd', date);
							if(disabledDay.length > 0){
								if (disabledDay.indexOf(date.getDay()) != -1) {
									return [false, "disabled-day", "This day is disabled"];
								}
							}
                            if (availableDates.indexOf(dateString) != -1) {
                                return [true, "available-date", "This date is available"];
                            }else{
								return [false, "disabled-date", "This date is disabled"];
							}
                            return [true];
                        }, */
							minDate: new Date(),
							weekStart: 1,
							daysOfWeekHighlighted: "6,0",
							autoclose: true,
							todayHighlight: true,
							dateFormat: 'dd-mm-yy'
                    });
			
			
            }
          });
});
});
</script>  
<script>
        $(document).ready(function ()
        {   
            var table = $('#tbl-activites').DataTable();
        });
		

    </script> 
<script type="text/javascript">
  $(document).ready(function() {
   adultChildReq(0,0,0);
 
 $(document).on('change', '.priceChange', function(evt) {
  const inputnumber = $(this).data('inputnumber');
  const activityVariantId = $("body #activity_variant_id" + inputnumber).val();
  const adult = parseInt($("body #adult" + inputnumber).val());
  const child = parseInt($("body #child" + inputnumber).val());
  const infant = parseInt($("body #infant" + inputnumber).val());
  const discount = parseFloat($("body #discount" + inputnumber).val());
  const tourDate = $("body #tour_date" + inputnumber).val();
  const transferOption = $("body #transfer_option" + inputnumber).find(':selected').data("id");
  const transferOptionName = $("body #transfer_option" + inputnumber).find(':selected').val();
  const variantId = $("body #transfer_option" + inputnumber).find(':selected').data("variant");
  let zonevalue = 0;
  const agentId = "{{$voucher->agent_id}}";
  const voucherId = "{{$voucher->id}}";
  let grandTotal = 0;

  const transferZoneTd = $("body #transfer_zone_td" + inputnumber);
  const colTd = $("body .coltd");
  const transferZone = $("body #transfer_zone" + inputnumber);
  const loaderOverlay = $("body #loader-overlay");

  transferZoneTd.css("display", "none");
  colTd.css("display", "none");
  transferZone.prop('required', false);

  if (transferOption == 2) {
    transferZoneTd.css("display", "block");
    colTd.css("display", "block");
    transferZone.prop('required', true);
    zonevalue = parseFloat(transferZone.find(':selected').data("zonevalue"));
  } else if (transferOption == 3) {
    colTd.css("display", "block");
  }

  loaderOverlay.show();
	adultChildReq(adult,child,inputnumber);
  const argsArray = {
    transfer_option: transferOptionName,
    activity_variant_id: activityVariantId,
    agent_id: agentId,
    voucherId: voucherId,
    adult: adult,
    infant: infant,
    child: child,
    discount: discount,
    tourDate: tourDate,
    zonevalue: zonevalue
  };

  getPrice(argsArray)
    .then(function(price) {
      $("body #price" + inputnumber).html(price.variantData.totalprice);
	  $("body #totalprice" + inputnumber).val(price.variantData.totalprice);
    })
    .catch(function(error) {
      console.error('Error:', error);
    })
    .finally(function() {
      loaderOverlay.hide();
    });
});
 
 
 $(document).on('change', '.actcsk', function(evt) {
   let inputnumber = $(this).data('inputnumber');
    const adult = parseInt($("body #adult" + inputnumber).val());
  const child = parseInt($("body #child" + inputnumber).val());
   adultChildReq(adult,child,inputnumber);
   if ($(this).is(':checked')) {
       $("body #transfer_option"+inputnumber).prop('required',true);
		$("body #tour_date"+inputnumber).prop('required',true);
     
     $("body #transfer_option"+inputnumber).prop('disabled',false);
     $("body #tour_date"+inputnumber).prop('disabled',false);
     $("body #adult"+inputnumber).prop('disabled',false);
     $("body #child"+inputnumber).prop('disabled',false);
     $("body #infant"+inputnumber).prop('disabled',false);
     $("body #discount"+inputnumber).prop('disabled',false);
	 $("body #adult"+inputnumber).trigger("change");
     } else {
       $("body #transfer_option"+inputnumber).prop('required',false);
     $("body #tour_date"+inputnumber).prop('required',false);
     
     $("body #transfer_option"+inputnumber).prop('disabled',true);
     $("body #tour_date"+inputnumber).prop('disabled',true);
     $("body #adult"+inputnumber).prop('disabled',true);
     $("body #child"+inputnumber).prop('disabled',true);
     $("body #infant"+inputnumber).prop('disabled',true);
     $("body #discount"+inputnumber).prop('disabled',true);
     $("body #discount"+inputnumber).prop('disabled',true);
     $("body #price"+inputnumber).text(0);
     }
 });

 
 });
 
 $(document).on('keypress', '.onlynumbrf', function(evt) {
   var charCode = (evt.which) ? evt.which : evt.keyCode
   if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
     return false;
   return true;
 
 });

 
 function getPrice(argsArray) {
  return new Promise(function(resolve, reject) {
    $.ajax({
      url: "{{ route('get-activity.variant.price') }}",
      type: 'POST',
      dataType: "json",
      data: argsArray,
      success: function(data) {
        resolve(data);
      },
      error: function(error) {
        reject(error);
      }
    });
  });
}

function adultChildReq(a,c,inputnumber) {
	a = (isNaN(a))?0:a;
	c = (isNaN(c))?0:c;
  var total = a+c;
  if(total == 0){
	  $("body #adult"+inputnumber).prop('required',true); 
  } else {
	  $("body #adult"+inputnumber).prop('required',false); 
  }
}

   </script> 
@endsection

@extends('layouts.appLogin')
@section('content')
<section data-anim="fade" class="pageHeader -type-3">
      <div class="container">
        <div class="row justify-between">
          <div class="col-auto">
           
          </div>

          <div class="col-auto">
            <div class="pageHeader__subtitle"></div>
          </div>
        </div>

        <div class="row pt-30">
          <div class="col-auto">
            <h1 class="pageHeader__title"></h1>
          </div>
        </div>
      </div>
    </section>
	
  <section class="layout-pb-xl">
      <div class="container">
        <div class="row">
          

          <div data-anim="slide-up delay-2" class="@if($voucherActivityCount > 0) col-xl-9 col-lg-8 @else col-xl-12 @endif" >
            <div class="row y-gap-5 justify-between">
              <div class="col-auto">
                <div>Activities & Tours</div>
              </div>
				 <div class="col-md-12 card card-default">
              <!-- form start -->
              <form id="filterForm" class="form-inline" method="get" action="{{ route('agent-vouchers.add.activity',$vid) }}" >
                <div class="card-body">
                  <div class="row">
                      <div class="col-md-9">
                        <div class="input-group">
                          <input type="text" name="name" value="{{ request('name') }}" class="form-control"  placeholder="Filter with Name" />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="input-group ">
                            <button class="btn btn-info" type="submit">   <i class="fas fa-search"></i> Search</button>
                            <a class="btn btn-default  mx-sm-2" href="{{ route('agent-vouchers.add.activity',$vid) }}">Clear</a>
                        </div>
                      </div>
                     
                      
                  </div>
                </div>
                <!-- /.card-body -->
                </form>
                </div>
              
            </div>
				@foreach ($records as $record)
				@php
				$minPrice = $record->min_price;
				$cutoffTime = SiteHelpers::getActivityVarByCutoffCancellation($record->id);
				@endphp
            <div class="row y-gap-30 pt-30">

              <div class="col-12">

                <div class="tourCard -type-2">
                  <div class="tourCard__image">
                    <img src="{{asset('uploads/activities/'.$record->image)}}" alt="image">

                  </div>

                  <div class="tourCard__content">
                  
                    <h3 class="tourCard__title mt-5">
                      <span> <a class="" href="{{route('agent-vouchers.activity.view',[$record->id,$vid])}}" target="_blank">
                            {{$record->title}}
                          </a></span>
                    </h3>

                   

                    <div class="row x-gap-20 y-gap-5 pt-30">
                      <div class="col-auto">
					 
                        <div class="text-14 text-accent-1">
						 @if($record->entry_type == 'Tour')
                          <i class="icon-price-tag mr-10"></i>
                          Instant Confirmation
						  @endif
                        </div>
                      </div>
					   
                      <div class="col-auto">
                        <div class="text-14">
                          <i class="icon-check mr-10"></i>
                          {!!$cutoffTime!!}
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="tourCard__info">
                    <div>
                      <div class="d-flex items-center text-14">
                        <i class="icon-clock mr-10"></i>
                        {{$voucher->nof_night+1}} Days {{$voucher->nof_night}} Nights
                      </div>

                      <div class="tourCard__price">
                        <div></div>

                        <div class="d-flex items-center">
                          From <span class="text-20 fw-500 ml-5">AED {{$minPrice}}</span>
                        </div>
                      </div>
                    </div>
					
			  
                    <button class="button -outline-accent-1 text-accent-1 loadvari" data-act="{{ $record->id }}"  data-vid="{{ $vid }}" data-card-widget="collapse" title="Collapse">
                      SELECT
                      <i class="icon-arrow-top-right ml-10"></i>
                    </button>
                  </div>
                </div>

              </div>
			<div class="pdivvarc tourCard -type-2" id="pdivvar{{ $record->id }}" style="display: none;">
         
			 
            <div class="col-md-12 var_data_div_cc" id="var_data_div{{ $record->id }}">
                    
                  </div>
              
          
        </div>
			 
            </div>
@endforeach 
          <div class="pagination pull-right mt-3"> {!! $records->appends(request()->query())->links() !!} </div>  
          </div>
		  @php
					$total = 0;
					
					@endphp
 @if(($voucherActivity->count() > 0) && $voucher->is_activity == 1)
          <div class="col-xl-3 col-lg-4">
            <div class="lg:d-none">
              <div class="sidebar -type-1 rounded-12">
              

                <div class="sidebar__content" style="padding:15px 0px 0px 0px">
               

				
			  
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
						
                 <div class="input-group  text-right float-right mb-2">
                            @if($voucherActivityCount > 0)
                                  <a href="{{ route('agent-vouchers.show',$voucher->id) }}" class="button -md -dark-1 bg-accent-1 text-white col-12 mt-30" style="width:100%">
                                <i class="fas fa-shopping-cart"></i>
                                Checkout({{$voucherActivityCount}})
                            </a>
                            @endif
                        </div>
				


                </div>
              </div>
            </div>

          
          </div>  
		  @endif
        </div>
		
      </div>
    </section>
<div class="modal fade" id="timeSlotModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Select Time Slot</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="timeSlotDropdown">Choose a time slot:</label>
                    <select class="form-control" required id="timeSlotDropdown">
                        <!-- Time slots will be dynamically added here -->
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary-flip btn-sm" id="selectTimeSlotBtn"><i class="fa fa-cart-plus"></i></button>
                <!-- You can add a button here for further actions if needed -->
            </div>
        </div>
    </div>
</div>

    <!-- /.content -->
@endsection

@section('scripts')
<script  src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js
"></script>
	
<script type="text/javascript">
  $(document).ready(function() {
			
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
            url: "{{route('get-agent-vouchers.activity.variant')}}",
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
			 $('.actcsk:first').prop('checked', true).trigger("change");
			
            }
          });
});
});
</script>  
 
<script type="text/javascript">
  $(document).ready(function() {
	  $('body #cartForm').validate({});
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
    $("body .priceChange").prop('required',false);
	$("body .priceChange").prop('disabled',true);
	$("body .addToCart").prop('disabled',true);
	$("body #ucode").val('');
	$('#timeslot').val('');
	$("body .priceclass").text(0);
   if ($(this).is(':checked')) {
       $("body #transfer_option"+inputnumber).prop('required',true);
		$("body #tour_date"+inputnumber).prop('required',true);
     
     $("body #transfer_option"+inputnumber).prop('disabled',false);
     $("body #tour_date"+inputnumber).prop('disabled',false);
	 $("body #addToCart"+inputnumber).prop('disabled',false);
     $("body #adult"+inputnumber).prop('disabled',false);
     $("body #child"+inputnumber).prop('disabled',false);
     $("body #infant"+inputnumber).prop('disabled',false);
     $("body #discount"+inputnumber).prop('disabled',false);
	 $("body #adult"+inputnumber).trigger("change");
	 var ucode = $("body #activity_select"+inputnumber).val();
	 $("body #ucode").val(ucode);
     }
 });

  $(document).on('click', '.addToCart', function(evt) {
	  evt.preventDefault();
	 if($('body #cartForm').validate({})){
		 variant_id = $(this).data('variantid');
		 inputnumber = $(this).data('inputnumber');
		 const transferOptionName = $("body #transfer_option" + inputnumber).find(':selected').val();
		 $.ajax({
			  url: "{{ route('get.variant.slots') }}",
			  type: 'POST',
			  dataType: "json",
			  data: {
				  variant_id:variant_id,
				  transferOptionName:transferOptionName
				  },
			  success: function(data) {
				  if(data.status == 1) {
						
						var timeslot = $('#timeslot').val();
						if(timeslot==''){
							openTimeSlotModal(data.slots);
						} 
					} else if (data.status == 2) {
						$("body #cartForm").submit();
					}
				//console.log(data);
			  },
			  error: function(error) {
				console.log(error);
			  }
		});
		  
	 }
	
 });
 });
 
 function getPrice(argsArray) {
	argsArray.adult = (isNaN(argsArray.adult))?0:argsArray.adult;
	argsArray.child = (isNaN(argsArray.child))?0:argsArray.child;
  return new Promise(function(resolve, reject) {
    $.ajax({
      url: "{{ route('agent.get.activity.variant.price') }}",
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

  function openTimeSlotModal(slots, selectedSlot) {
    var isValid = $('body #cartForm').valid();
    if (isValid) {
		$("body #timeSlotDropdown").removeClass('error-rq');
        $('#timeSlotModal').modal('show');

        var dropdown = $('#timeSlotDropdown');
        dropdown.empty();

        $.each(slots, function(index, slot) {
            var option = $('<option></option>').attr('value', slot).text(slot);
            if (slot === selectedSlot) {
                option.attr('selected', 'selected');
            }
            dropdown.append(option);
        });

        dropdown.on('change', function() {
            var selectedValue = dropdown.val();
			$('body #timeslot').val('');
            if (selectedValue !== 'select') {
                $('#timeslot').val(selectedValue);
				$("body #timeSlotDropdown").removeClass('error-rq');
            }
        });

        $('#selectTimeSlotBtn').on('click', function() {
				var timeslot = $('body #timeslot').val();
				$("body #timeSlotDropdown").removeClass('error-rq');
				//if(timeslot==''){
				//$("body #timeSlotDropdown").addClass('error-rq');
				//} else { 
					$("body #cartForm").submit();
				//}
						
            
        });

        $('#timeSlotModal .close').on('click', function() {
            $('body #timeslot').val('');
            $('#timeSlotModal').modal('hide');
        });
    }
}

$(document).on('keypress', '.onlynumbrf', function(evt) {
   var charCode = (evt.which) ? evt.which : evt.keyCode
   if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
     return false;
   return true;
 
 });


 </script> 
@endsection

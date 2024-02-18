@extends('layouts.appLogin')
@section('content')

<div data-anim="fade" class="container">
      <div class="row justify-between py-30 mt-80">
        <div class="col-auto">
          <div class="text-14"></div>
        </div>

        <div class="col-auto">
          <div class="text-14"></div>
        </div>
      </div>
    </div>

    <section class="">
      <div data-anim-wrap class="container">
	   <div class="col-auto">
            @include('inc.errors-and-messages')
			 </div>
        <div data-anim-child="slide-up" class="row y-gap-20 justify-between items-end">
		
          <div class="col-auto">
            

            <h2 class="text-40 sm:text-30 lh-14 mt-20">
             {{$activity->title}}
            </h2>

           
          </div>

          <div class="col-auto">
            <div class="d-flex x-gap-30 y-gap-10">
			 @php
            $minPrice = $activity->min_price;
          @endphp
              Starting From : AED {{$minPrice}}
            </div>
			
          </div>
        </div>
<div data-anim-child="slide-up delay-2" class="tourSingleGrid -type-1 mt-30">
          <div class="tourSingleGrid__grid mobile-css-slider-2">
				@if(!empty($activity->image))
				<img src="{{asset('uploads/activities/'.$activity->image)}}"  class="img-fluid" style="border-radius: 5px;" />
				@endif
				@if($activity->images->count() > 0)
				@foreach($activity->images as $k => $image)
				<img src="{{asset('uploads/activities/'.$image->filename)}}" alt="image">
				@endforeach
				@endif 
            
          </div>

          <div class="tourSingleGrid__button">
		  @if(!empty($activity->image))
			    <a href="{{asset('uploads/activities/'.$activity->image)}}" class="js-gallery" data-gallery="gallery1">
              <span class="button -accent-1 py-10 px-20 rounded-200 bg-dark-1 lh-16 text-white">See all photos</span>
            </a>
				@endif
          @if($activity->images->count() > 0)
				@foreach($activity->images as $k => $image)
			 <a href="{{asset('uploads/activities/'.$image->filename)}}" class="js-gallery" data-gallery="gallery1"></a>
				@endforeach
				@endif 
            
          </div>
        </div>
       
      </div>
    </section>

    <section class="layout-pt-md js-pin-container">
      <div class="container">
        <div class="row y-gap-30 justify-between">
          <div class="col-lg-8">
            <div class="row y-gap-20 justify-between items-center layout-pb-md">

              <div class="col-lg-3 col-6">
                <div class="d-flex items-center">
                  <div class="flex-center size-50 rounded-12 border-1">
                    <i class="text-20 fas fa-fw fa-clock"></i>
                  </div>

                  <div class="ml-10">
                    <div class="lh-16">Duration</div>
                    <div class="text-14 text-light-2 lh-16">2 Hours Approx</div>
                  </div>
                </div>
              </div>

              <div class="col-lg-3 col-6">
                <div class="d-flex items-center">
                  <div class="flex-center size-50 rounded-12 border-1">
                    <i class="text-20 far fa-fw  fa-check-circle"></i>
                  </div>

                  <div class="ml-10">
                    <div class="lh-16">Mobile Voucher Accepted</div>
                  </div>
                </div>
              </div>

              <div class="col-lg-3 col-6">
                <div class="d-flex items-center">
                  <div class="flex-center size-50 rounded-12 border-1">
                    <i class="text-20 far fa-fw  fa-check-circle"></i>
                  </div>

                  <div class="ml-10">
                    <div class="lh-16"> Instant Confirmation</div>
                  </div>
                </div>
              </div>

             <div class="col-lg-3 col-6">
                <div class="d-flex items-center">
                  <div class="flex-center size-50 rounded-12 border-1">
                   <i class="fas fa-exchange-alt"></i>
                  </div>

                  <div class="ml-10">
                    <div class="lh-16"> Transfer Available </div>
                  </div>
                </div>
              </div>

            </div>
			 <div class="card-body pdivvarc" id="pdivvar" style="display: none;">
					  <div class="row p-2">
						 
						<div class="col-md-12 var_data_div_cc" id="var_data_div">
								
							  </div>
						  
					   </div>
					</div>
		<div class="line mt-60 mb-60"></div>
            <h2 class="text-30">Short Description</h2>
            <p class="mt-20">{!! $activity->sort_description !!}</p>

<h2 class="text-30">Description</h2>
            <p class="mt-20">{!! $activity->description !!}</p>

<h2 class="text-30">Bundle Product Cancellation</h2>
            <p class="mt-20">{!! $activity->bundle_product_cancellation !!}</p>
<h2 class="text-30">Bundle Product Cancellation</h2>
            <p class="mt-20">{!! $activity->notes !!}</p>

			
			

            <div class="line mt-60 mb-60"></div>


            
          </div>

          <div class="col-lg-4" @if($voucherActivityCount==0) style="display:none" @endif>
            <div class="d-flex justify-end js-pin-content">
              <div class="tourSingleSidebar">
                <div class="d-flex items-center">
                  <div>Tour Details</div>
                </div>

                <div class="searchForm -type-1 -sidebar mt-20">
                  <div class="searchForm__form">
                    <div class="searchFormItem js-select-control js-form-dd js-calendar">
                      <div class="searchFormItem__button" data-x-click="calendar">
                         @php
					$total = 0;
					@endphp
 @if(!empty($voucherActivity) && $voucher->is_activity == 1)
 <div class="col-md-12  mt-2 " id="div-cart-list" >
				
			  
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

                    
                  </div>
                </div>

              </div>
            </div>
          </div>
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

    
@endsection
@section('scripts')
<script  src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js
"></script>
 <script type="text/javascript">
 
  $(document).ready(function() {
	  
			$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
			
			

  var actid = "{{$activity->id}}";
  var vid = "{{$vid}}";
  
   var inputnumber = $(this).data('inputnumber');
  $("body #loader-overlay").show();
		
           
		$.ajax({
            url: "{{route('get-agent-vouchers.activity.variant')}}",
            type: 'POST',
            dataType: "json",
            data: {
              act: actid,
              vid: vid,
            },
            success: function( data ) {
               //console.log( data.html );
               //alert("#var_data_div");
               
             //$("body .var_data_div_cc").html('');
             //$("body .pdivvarc").css('display','none');
			      $("body #var_data_div").html(data.html);
            $("body #pdivvar").css('display','block');
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

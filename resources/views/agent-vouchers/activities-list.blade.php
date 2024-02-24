@extends('layouts.appLogin')
@section('content')

<div class="breadcrumb-section"
        style="background-image: linear-gradient(270deg, rgba(0, 0, 0, .3), rgba(0, 0, 0, 0.3) 101.02%), url(assets/img/innerpage/inner-banner-bg.png);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 d-flex justify-content-center">
                    <div class="banner-content">
                        <h1>Activities & Tours</h1>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Start Room Details section -->
    <div class="room-suits-page pt-120 mb-120">
        <div class="container">
            <div class="row g-lg-4 gy-5">
                <div class="col-xl-4 order-lg-1 order-2">
                    <div class="sidebar-area">
                        <div class="single-widget mb-30">
                            <h5 class="widget-title">Search Here</h5>
                            <form id="filterForm" class="form-inline" method="get" action="{{ route('agent-vouchers.add.activity',$vid) }}" >
                                <div class="search-box">
                                <input type="text" name="name" value="{{ request('name') }}" class="form-control" style="border-radius: 5px 0px 0px 5px;"  placeholder="Filter with Name" />
                                    
                                    <button type="submit"><i class="bx bx-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <!-- <div class="single-widget mb-30">
                            <h5 class="widget-title">Tags</h5>
                            <div class="checkbox-container">
                                <ul>
                                    <li>
                                        <label class="containerss">
                                            <input type="checkbox">
                                            <span class="checkmark"></span>
                                            <span class="text">Book without credit card</span>
                                            <span class="qty">250</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="containerss">
                                            <input type="checkbox">
                                            <span class="checkmark"></span>
                                            <span class="text">Free cancellation</span>
                                            <span class="qty">90</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="containerss">
                                            <input type="checkbox">
                                            <span class="checkmark"></span>
                                            <span class="text">Breakfast Included</span>
                                            <span class="qty">35</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="containerss">
                                            <input type="checkbox">
                                            <span class="checkmark"></span>
                                            <span class="text">No prepayment</span>
                                            <span class="qty">28</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="containerss">
                                            <input type="checkbox">
                                            <span class="checkmark"></span>
                                            <span class="text">Romantic</span>
                                            <span class="qty">12</span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div> -->
                        <!-- <div class="single-widget mb-30">
                            <h5 class="shop-widget-title">Price Filter</h5>
                                <div class="range-wrap">
                                    <div class="row">
                                        <div class="col-sm-12">
                                        <form>
                                            <input type="hidden" name="min-value" value="">
                                            <input type="hidden" name="max-value" value="">
                                        </form>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                        <div id="slider-range"></div>
                                        </div>
                                    </div>
                                    <div class="slider-labels">
                                        <div class="caption">
                                            <span id="slider-range-value1"></span>
                                        </div>
                                        <a href="#">Apply</a>
                                        <div class="caption">
                                            <span id="slider-range-value2"></span>
                                        </div>
                                    </div>
                                </div>
                        </div> -->
                        
                        
                    </div>
                </div>
                <div class="col-xl-8 order-lg-2 order-1">
                @foreach ($records as $record)
                @php
                  $minPrice = $record->min_price;
                  $cutoffTime = SiteHelpers::getActivityVarByCutoffCancellation($record->id);
                @endphp

                    <div class="room-suits-card mb-30">
                        <div class="row g-0">
                            <div class="col-md-4">
                            <div class="room-img">
                                    <a href="{{route('agent-vouchers.activity.view',[$record->id,$vid])}}"><img src="{{asset('uploads/activities/'.$record->image)}}" alt=""></a>
                                </div>
                               
                            </div>
                            <div class="col-md-8">
                                <div class="room-content">
                                    <div class="content-top">
                                        <h5>
                                            <a class="" href="{{route('agent-vouchers.activity.view',[$record->id,$vid])}}" target="_blank">
                                              {{$record->title}}
                                            </a>
                                        </h5>
                                       
                                        <ul class="facilisis">
                                            @if($record->entry_type == 'Tour')
                                              <li>
                                                  <i class="icon-price-tag mr-10"></i>
                                                  Instant Confirmation
                                              </li>
                                            @endif
                                            <li> {!!$cutoffTime!!}</li>
                                           
                                        </ul>
                                    </div>
                                    <div class="content-bottom">
                                        <div class="room-type">
                                            <div class="deals">
                                                <!-- <span><strong>Free cancellation</strong> <br> before 48 hours</span> -->
                                            </div>
                                        </div>
                                       <div class="price-and-book">
                                            <div class="price-area">
											@php
											$currency = SiteHelpers::getCurrencyPrice();
											@endphp
                                                <span>{{$currency['code']}} {{$minPrice*$currency['value']}}</span>
                                                
                                            </div>
                                            <div class="book-btn">

                                            <a class="primary-btn2 loadvari" data-act="{{ $record->id }}" style="cursor:pointer;"  data-vid="{{ $vid }}" data-card-widget="collapse" title="Collapse">
                                            Select <i class="bi bi-arrow-right"></i>
                    </a>
                                               
                                            </div>
                                       </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>

                        <div style="padding: 0px 20px;">
                                <div class="col-md-12">
			                              <div class="pdivvarc tourCard -type-2" id="pdivvar{{ $record->id }}" style="display: none;">
                                       <div class="col-md-12 var_data_div_cc" id="var_data_div{{ $record->id }}">

                                        </div>
                                    </div>

                                </div>
              
          
                         </div>
                       
                    </div>

                    @endforeach 
          <div class="pagination pull-right mt-3"> 
            
<!--           
          <div class="row mt-70">
                        <div class="col-lg-12">
                            <nav class="inner-pagination-area">
                                <ul class="pagination-list">
                                    <li>
                                        <a href="#" class="shop-pagi-btn"><i class="bi bi-chevron-left"></i></a>
                                    </li>
                                    <li>
                                        <a href="#">1</a>
                                    </li>
                                    <li>
                                        <a href="#" class="active">2</a>
                                    </li>
                                    <li>
                                        <a href="#">3</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="bi bi-three-dots"></i></a>
                                    </li>
                                    <li>
                                        <a href="#">6</a>
                                    </li>
                                    <li>
                                        <a href="#" class="shop-pagi-btn"><i class="bi bi-chevron-right"></i></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div> -->
          
          {!! $records->appends(request()->query())->links() !!} </div>  
          </div>
		  @php
					$total = 0;
					
					@endphp
                    
                    
                </div>
            </div>
        </div>
    </div>

<!-- CART VIEW -->

@include("inc.sidebar_cart")



<div class="modal login-modal " id="timeSlotModal" data-bs-keyboard="false" tabindex="-1"  aria-modal="true" role="dialog" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-clode-btn" data-bs-dismiss="modal"></div>
                <div class="modal-header">
                  <!-- Select Time Slot -->
                </div>
                <div class="modal-body">
                    <div class="login-registration-form">
                        <div class="form-title">
                           <p>Select Time Slot</p>
                             <!-- <p>Enter your email address for Login.</p> -->
                        </div>
                        <form>
                            <div class="form-inner mb-20">
                              <select class="form-control" required id="timeSlotDropdown">
                       
                              </select>
                            </div>
                            
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="secondary-btn1 btn-sm" id="selectTimeSlotBtn">Add To Cart</button>
              
            </div>
            </div>
        </div>
    </div>
<!-- 

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
                        Time slots will be dynamically added here 
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary-flip btn-sm" id="selectTimeSlotBtn"><i class="fa fa-cart-plus"></i></button>
               You can add a button here for further actions if needed 
            </div>
        </div>
    </div>
</div> -->

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

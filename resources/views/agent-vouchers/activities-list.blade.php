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
    <div class="room-suits-page pt-50 mb-120">
        <div class="container">
		
            <div class="row g-lg-4 gy-5">
              <div class="col-md-12">
			           <div class="package-inner-title-section">
                    <p>166 Things to do in UAE</p>
                      <div class="selector-and-grid">
                          <div class="selector">
                              <select  class="tagsinput" onchange="searchActivity()" id="porder" >
                                  <option value="">Sorting</option>
                                  <option value="ASC">Price Low to High</option>
                                  <option value="DESC">Price High to Low</option>
                                </select>
                          </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 order-lg-1 order-2">
				<form id="filterForm" class="form-inline"  >
                    <div class="sidebar-area">
                        <div class="single-widget mb-30">
                            <h5 class="widget-title">Search Here</h5>
							
							<div class="search-box">
							<input type="text" name="name" value="{{ request('name') }}" class="form-control tagsinput" style="border-radius: 5px 0px 0px 5px;" placeholder="Search by Tour Name" />
							
							</div>
							
                        </div>
						 <div class="single-widget mb-30">
                            <h5 class="shop-widget-title">Price </h5>
                                <div class="range-wrap">
                                    <div class="row">
                                        <div class="col-sm-12">
                                        <form>
                                            <input type="text" name="min-value" id="min-value"  value="">
                                            <input type="text" name="max-value" id="max-value" value="">
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
                                        <!--<a href="javascript:;" onclick="searchActivity()">Apply</a>-->
                                        <div class="caption">
                                            <span id="slider-range-value2"></span>
                                        </div>
                                    </div>
                                </div>
                        </div> 
                        
                        <div class="single-widget mb-30">
                            <h5 class="widget-title">Fliter By Category</h5>
                            <div class="checkbox-container">
                                <ul>
								@foreach($tags as $tag)
                                    <li>
                                        <label class="containerss">
                                            <input type="checkbox" class="tagsinput" name="tags[]" value="{{$tag}}">
                                            <span class="checkmark"></span>
                                            <span class="text">{{$tag}}</span>
                                        </label>
                                    </li>
                                  @endforeach
                                   
                                </ul>
                            </div>
                        </div> 
						
                      
                    </div>
					</form>
                        
                </div>
				
				 <div class="col-xl-9 order-lg-2 order-1" id="listdata_ajax">
				 
                    @include('agent-vouchers.activities-list-ajax')
                   </div>  
				   <div id="pagination_ajax"></div>
                </div>
            </div>
        </div>
    </div>

<!-- CART VIEW -->

@include("inc.sidebar_cart")



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
                <div class="form-group" id="radioSlotGroup">
                    <!-- Radio buttons will be dynamically added here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary-flip btn-sm" id="selectTimeSlotBtn"><i class="fa fa-cart-plus"></i></button>
                <!-- You can add a button here for further actions if needed -->
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
		$("body #cartForm").removeClass('error-rq');
        $('#timeSlotModal').modal('show');

        var radioGroup = $('#radioSlotGroup');
        radioGroup.empty();

        $.each(slots, function(index, slot) {
            var radio = $('<input type="radio" name="timeSlotRadio">')
                .attr('value', slot)
                .prop('checked', slot === selectedSlot);
            var label = $('<label>').text(slot).prepend(radio);
            radioGroup.append(label);
        });

        $('#selectTimeSlotBtn').on('click', function() {
            var selectedValue = $('input[name="timeSlotRadio"]:checked').val();
            if (selectedValue) {
                $('#timeslot').val(selectedValue);
                $("body #cartForm").submit();
            } else {
                $("body #cartForm").addClass('error-rq');
            }
        });

        $('#timeSlotModal .close').on('click', function() {
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

$(document).on('keypress', '.tagsinput', function(evt) {
  searchActivity()
 });

 
$(document).on('change', '.tagsinput', function(evt) {
  searchActivity()
 });
 
$(document).ready(function() {
	var min = "{{$minPrice}}";
	var max = "{{$maxPrice}}";
    $('.noUi-handle').on('click', function() {
      $(this).width(50);
    });
    var rangeSlider = document.getElementById('slider-range');
	
    var moneyFormat = wNumb({
      decimals: 0,
      thousand: ',',
      prefix: ''
    });
    noUiSlider.create(rangeSlider, {
      start: [min, max],
      step: 1,
      range: {
        'min': [parseFloat(min)],
        'max': [parseFloat(max)]
      },
      format: moneyFormat,
      connect: true
    });
    
    // Set visual min and max values and also update value hidden form inputs
    rangeSlider.noUiSlider.on('update', function(values, handle) {
      document.getElementById('slider-range-value1').innerHTML = values[0];
      document.getElementById('slider-range-value2').innerHTML = values[1];
      document.getElementById('min-value').value = moneyFormat.from(
        values[0]);
      document.getElementById('max-value').value = moneyFormat.from(
        values[1]);
		
		debounceSearchActivity();
    });
	
	
  });
  const debounceSearchActivity = debounce(searchActivity, 500);
  function debounce(func, delay) {
        let timeout;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                func.apply(context, args);
            }, delay);
        };
    }
	
function searchActivity(page = 1) {
	$("body #loader-overlay").show();
    var vid = "{{$vid}}"; 
    var name = $("input[name='name']").val(); 
	var porder = $("#porder").val();
	
	var minPrice = document.getElementById('min-value').value;
	var maxPrice = document.getElementById('max-value').value;
	 var selectedTags = $('input[name="tags[]"]:checked').map(function () {
        return this.value;
    }).get();
	//console.log(selectedTags);
    $("body #loader-overlay").show();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "{{ route('agent-vouchers.add.activity.search') }}",
        type: 'GET',
        dataType: "json",
        data: {
            name: name,
            vid: vid,
			selectedTags: selectedTags,
			minPrice: minPrice,
			maxPrice: maxPrice,
			porder:porder,
			page: page
        },
        success: function(data) {
            $("#listdata_ajax").html(data.html); // Replace the content of the div
            $("#pagination_ajax").html(data.pagination);
			$("body #loader-overlay").hide();
        },
        error: function(error) {
            //console.error('Error:', error);
        },
        complete: function() {
            $("body #loader-overlay").hide();
        }
    });
}
$(document).on('click', '#pagination_ajax a', function(e) {
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    searchActivity(page);
});
 </script> 
@endsection

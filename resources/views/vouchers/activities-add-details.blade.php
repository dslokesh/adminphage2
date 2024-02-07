@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header d-done" >
      <div class="container-fluid">
        <div class="row mb-2">
          <!-- <div class="col-sm-6">
            <h1>Voucher Code :{{$voucher->code}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
			 <li class="breadcrumb-item"><a href="{{ route('vouchers.index') }}">Vouchers</a></li>
              <li class="breadcrumb-item"><a href="{{ route('voucher.add.activity',[$voucher->id]) }}">Activities</a></li>
              <li class="breadcrumb-item active">Activity Details</li>
            </ol>
          </div> -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content" id="activities-list-blade">
    <div class="row">
        <div class="col-md-12">
		
          <div class="card">
           
			
			<div class="card-body">
			<div class="row">
			
				 <div class="col-md-7">
				 @if(!empty($activity->image))
               
			   <img src="{{asset('uploads/activities/'.$activity->image)}}"  class="img-fluid" style="border-radius: 5px;" />
			 
			 @endif
				 </div>
					<div class="col-md-5">
						<div class="row">
								
							@if($activity->images->count() > 0)
								
										
								@foreach($activity->images as $k => $image)
								@if($k < 6)
								<div class="col-md-6" style="margin-bottom: 16px;">
								<img src="{{asset('uploads/activities/'.$image->filename)}}"  class="img-fluid"  style="border-radius: 5px;">
								</div>
								@endif 
								@endforeach
							
							@endif 
							</div>
					
					</div>
			   
	
				
			 </div>
			 <hr class="col-md-12">
			  <div class="row">
			   <div class="col-md-6" >
				 <h3><i class="far fa-fw  fa-check-circle"></i> {{$activity->title}}</h3>
              </div>
			   <div class="col-md-6 text-right">
			   @php
            $minPrice = $activity->min_price;
          @endphp
		  <small>Starting From </small><br/>
				 <h3>AED {{$minPrice}}</h3>
              </div>
			  
			  </div>
			 
			    <div class="row">
					<div class="col-md-12">
						<ul class="list-inline list-group list-group-horizontal">
							<li style="padding-right: 10px;">
							<i class="fas fa-fw fa-clock"></i> 2 Hours Approx
							</li>
							<li style="padding-right: 10px;">
							<i class="far fa-fw  fa-check-circle "></i> Mobile Voucher Accepted
							</li>
							<li style="padding-right: 10px;">
							<i class="far fa-fw  fa-check-circle"></i> Instant Confirmation 
							</li>
							<li style="padding-right: 10px;">
							<i class="fas fa-exchange-alt"></i> Transfer Available 
							</li>
						</ul>
					</div>
			  </div>

			 
			    <div class="row fixme">
					<div class="col-md-12">
						<ul class="list-inline list-group list-group-horizontal">
							<li style="padding-right: 10px;">
								<a href="#description">Short Description</a>
							</li>
							<li style="padding-right: 10px;">
								|
							</li>
							<li style="padding-right: 10px;">
								<a href="#tour_options">Tour Options</a>
							</li>
							<li style="padding-right: 10px;">
								|
							</li>
							<li style="padding-right: 10px;">
								<a href="#inclusion">Description</a>
							</li>
							<li style="padding-right: 10px;">
								|
							</li>
							<li style="padding-right: 10px;">
								<a href="#booking">Notes</a>
							</li>
							
						</ul>
					</div>
			  </div>
			 
				  <div class="form-group col-md-12" id="description"  >
				 
                <h4>Short Description</h4>
				{!! $activity->sort_description !!}
              </div>
			  <hr class="col-md-12 p-30" id="tour_options">
		

				<form action="{{route('voucher.activity.save')}}" method="post" class="form" >
				{{ csrf_field() }}
				 <input type="hidden" id="activity_id" name="activity_id" value="{{ $aid }}"  />
				 <input type="hidden" id="v_id" name="v_id" value="{{ $vid }}"  />
				 <input type="hidden" id="activity_vat" name="activity_vat" value="{{ ($activity->vat > 0)?$activity->vat:0 }}"  />
				 <input type="hidden" id="vat_invoice" name="vat_invoice" value="{{ $voucher->vat_invoice }}"  />
			
				<div class="row   mt-2" style="">
				<div class="col-lg-12">
				<h4>Tour Options</h4>
				</div>
				
				  </div>
				<div id="hDetailsDiv">
				<div class="row p-2" >
			 
			  <div class="col-md-12">
			   <table class="table rounded-corners" style="border-radius: 10px !important;font-size:10pt;">
                  <thead>
				 
				  @if(!empty($variantData))
					 
					  @foreach($variantData['activityVariants'] as $kk => $ap)
				  @if($kk == 0)
                  <tr>
					<th valign="middle">Tour Option</th>
                    <th id="top" valign="middle"  colspan="2">Transfer Option</th>
					<th valign="middle">Tour Date</th>
					<th valign="middle">Adult</th>
                    <th valign="middle">Child<br/><small>({{$ap->prices->child_start_age}}-{{$ap->prices->child_end_age}} Yrs)</small></th>
                    <th valign="middle">Infant<br/><small>(Below {{$ap->prices->child_start_age}} Yrs)</small></th>
					<th valign="middle">Total Amount</th>
                  </tr>
				  </thead>
				  @endif
				  <tbody>
				 @php
				  $actZone = SiteHelpers::getZone($ap->variant->zones,$ap->variant->sic_TFRS);
				 $tourDates = SiteHelpers::getDateList($voucher->travel_from_date,$voucher->travel_to_date,$ap->variant->black_out,$ap->variant->sold_out);
				  @endphp
				   <tr>
                    <td>
					
					<input type="hidden"  name="activity_variant_id[{{$ap->ucode}}]" id="activity_variant_id{{$kk}}" value="{{$ap->id}}" data-inputnumber="{{$kk}}" /> 
					
					<input type="checkbox"  name="activity_select[{{$ap->ucode}}]" id="activity_select{{$kk}}" value="{{ $aid }}" @if($kk == '0') checked @endif class="actcsk" data-inputnumber="{{$kk}}" /> <strong>{{$ap->variant->title}} </strong>
					</td>
					<td> <select name="transfer_option[{{$ap->ucode}}]" id="transfer_option{{$kk}}" class="form-control priceChange" data-inputnumber="{{$kk}}" @if($kk > '0') disabled="disabled" @endif >
						@if($kk > '0')
						<option value="">--Select--</option>
						@endif
						@if(($ap->activity->entry_type=='Ticket Only') && ($ap->prices->adult_rate_without_vat > 0))
						<option value="Ticket Only" data-id="1">Ticket Only</option>
						@endif
						@if($ap->variant->sic_TFRS==1)
						<option value="Shared Transfer" data-id="2">Shared Transfer</option>
						@endif
						@if($ap->variant->pvt_TFRS==1)
						<option value="Pvt Transfer" data-id="3" data-variant="{{$ap->variant_id}}" >Pvt Transfer</option>
						@endif
						</select>
						<input type="hidden" id="pvt_traf_val{{$kk}}" value="0"  name="pvt_traf_val[{{$ap->ucode}}]"    />
						</td>
						<td> 
						<div  style="display:none;border:none;" id="transfer_zone_td{{$kk}}">
						@if($ap->variant->sic_TFRS==1)
						@if(!empty($actZone))
						<select name="transfer_zone[{{$ap->ucode}}]" id="transfer_zone{{$kk}}" class="form-control priceChange"  data-inputnumber="{{$kk}}">
						
						
						@foreach($actZone as $z)
						<option value="{{$z['zone_id']}}" data-zonevalue="{{$z['zoneValue']}}" data-zoneptime="{{$z['pickup_time']}}">{{$z['zone']}}</option>
						@endforeach
						@else
							<input type="hidden" id="transfer_zone{{$kk}}" value=""  name="transfer_zone[{{$ap->ucode}}]"    />
						@endif
						</select>
						@else
							<input type="hidden" id="transfer_zone{{$kk}}" value=""  name="transfer_zone[{{$ap->ucode}}]"    />
						@endif
						
						</div> 
						</td>
						
					<td>
					<select name="tour_date[{{$ap->ucode}}]" id="tour_date{{$kk}}"  class="form-control priceChange" data-inputnumber="{{$kk}}"  >
						
						<option value="">--Select--</option>
						@foreach($tourDates as $tourDate)
						<option value="{{$tourDate}}" >{{$tourDate}}</option>
						@endforeach
						</select>
						
					
					</td>
					<td><select name="adult[{{$ap->ucode}}]" id="adult{{$kk}}" class="form-control priceChange"  data-inputnumber="{{$kk}}" @if($kk > '0') disabled="disabled" @endif>
						<option value="">0</option>
						@for($a=$ap->prices->adult_min_no_allowed; $a<=$ap->prices->adult_max_no_allowed; $a++)
						@if($ap->prices->adult_min_no_allowed+$ap->prices->child_min_no_allowed > 0)
						<option value="{{$a}}" @if($voucher->adults==$a) selected="selected" @endif>{{$a}}</option>
						@endif
						@endfor
						</select></td>
                    <td><select name="child[{{$ap->ucode}}]" id="child{{$kk}}" class="form-control priceChange" data-inputnumber="{{$kk}}" @if($kk > '0') disabled="disabled" @endif>
						<option value="">0</option>
						
						@for($child=$ap->prices->child_min_no_allowed; $child<=$ap->prices->child_max_no_allowed; $child++)
							@if($child > 0)
						<option value="{{$child}}" @if($voucher->childs==$child) selected="selected" @endif>{{$child}}</option>
					@endif
						@endfor
						</select></td>
                    <td><select name="infant[{{$ap->ucode}}]" id="infant{{$kk}}" class="form-control priceChange" data-inputnumber="{{$kk}}" @if($kk > '0') disabled="disabled" @endif>
						@for($inf=$ap->prices->infant_min_no_allowed; $inf<=$ap->prices->infant_max_no_allowed; $inf++)
						<option value="{{$inf}}" @if($voucher->infants==$inf && $voucher->infants > 0) selected="selected" @endif>{{$inf}}</option>
						@endfor
						</select>
						
						</td>
						
					
						<input type="hidden" id="discount{{$kk}}" style="width: 50px;" value="0"  name="discount[{{$ap->ucode}}]" @if($kk > '0') disabled="disabled" @endif data-inputnumber="{{$kk}}" class="form-control onlynumbrf priceChangedis"    />
						
						<td class="text-center" >
						
						<span id="price{{$kk}}" style="font-weight:bold">0</span>
						<input type="hidden" id="totalprice{{$kk}}" value="0"  name="totalprice[{{$ap->ucode}}]"    />
						</td>
                  </tr>
				  @endforeach
				 @endif
					</tbody>
				  </table>
              </div>
			 </div>	
			 </div>	
			  <div class="row">

        <div class="col-12 mt-3">
         
			<button type="submit" class="btn btn-success float-right mr-2" name="save_and_continue">Add To Cart</button>
        </div>
      </div>
			 </form>
		<div class="col-md-12">
			  <div class="row mt-5">
			  <hr class="col-md-12 p-30" id="inclusion">
			   <div class="form-group col-md-12" >
			   
				<h4>Description</h4>
				{!! $activity->description !!}
              </div>
			  <hr class="col-md-12 p-30" id="booking">
			   <div class="form-group col-md-12">
			   
			   <h4>Notes</h4>
				{!! $activity->notes !!}
              </div>
			  
              </div>
			 
			  </div>
<div class="row mb-20" style="margin-bottom: 20px;">
	<div class="col-md-2 mb-20">
	<a href="{{route('voucher.add.activity',$vid)}}" class="btn btn-secondary mr-2">Back</a>
	</div>
	
</div>
</div>	 	 
		  
		 
		
          <!-- /.card-body --> 
        </div>
		
          
			
          </div>
		 
          <!-- /.card -->
        </div>
      </div>
  
    </section>
    <!-- /.content -->
@endsection



@section('scripts')
 <script>
         $(function() {
          
            var disabledDates = "";
            var availableDates = "";
			 var disabledDay = "";

            
            $(".tour_datepicker").datepicker({
                beforeShowDay: function(date) {
                    var dateString = $.datepicker.formatDate('yy-mm-dd', date);
                    
					/* for (let i = 0; i < disabledDay.length; ++i) {
						if (date.getDay() === disabledDay[i]) {
							return [false, "disabled-day", "This date is disabled"];
						}
					} */
					//console.log(availableDates);
					
					
                    if (availableDates.indexOf(dateString) != -1) {
                        return [true, "available-date", "This date is available"];
                    } else {
					return [false, "disabled-date", "This date is disabled"];	
					}
						
                    return [true];
                },
				minDate: new Date(),
				weekStart: 1,
				daysOfWeekHighlighted: "6,0",
				autoclose: true,
				todayHighlight: true,
				dateFormat: 'dd-mm-yy'
            });
        }); 
    </script>
 <script type="text/javascript">
 $(document).ready(function() {
	 $('body #activity_select0').prop('checked', true); // Checks it
	 $("body #tour_date0").prop('required',true);
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

 

 
 $(document).on('keypress', '.onlynumbrf', function(evt) {
   var charCode = (evt.which) ? evt.which : evt.keyCode
   if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
     return false;
   return true;
 
 });
 });
 
 function getPrice(argsArray) {
  return new Promise(function(resolve, reject) {
	  $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
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

<script type="text/javascript">
$(window).on('load', function(){
 var owl = $('.owl-carousel');
owl.owlCarousel({
    loop:true,
    nav:true,
	dots:false,
    margin:10,
	items:1
  
});

  
  
});


</script>  
@endsection

			@php
			$activity = $variantData['activity'];
			 
			@endphp
				<form action="{{route('voucher.activity.save')}}" method="post" class="form" >
				{{ csrf_field() }}
				 <input type="hidden" id="activity_id" name="activity_id" value="{{ $aid }}"  />
				 <input type="hidden" id="v_id" name="v_id" value="{{ $vid }}"  />
				 <input type="hidden" id="activity_vat" name="activity_vat" value="{{ ($activity->vat > 0)?$activity->vat:0 }}"  />
				 <input type="hidden" id="vat_invoice" name="vat_invoice" value="{{ $voucher->vat_invoice }}"  />
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
				  
			  <div class="row">

        <div class="col-12 mt-3">
          <button type="submit" class="btn btn-sm  btn-primary-flip float-right" name="save">Add To Cart</button>
        </div>
      </div>
			 </form>
          <!-- /.card-body --> 
       
      
    <!-- /.content -->

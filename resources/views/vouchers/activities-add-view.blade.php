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
					<th valign="middle">Total Selling Price*</th>
					<th valign="middle">Net Disc</th>
					<th valign="middle">Total Amount</th>
                  </tr>
				  </thead>
				  @endif
				  <tbody>
				 @php
				  $markup = SiteHelpers::getAgentMarkup($voucher->agent_id,$ap->activity_id,$ap->variant_code);
				  $actZone = SiteHelpers::getZone($activity->zones,$activity->sic_TFRS);
				 
				  @endphp
				   <tr>
                    <td><input type="checkbox"  name="activity_select[{{$ap->ucode}}]" id="activity_select{{$kk}}" value="{{ $aid }}" @if($kk == '0') checked @endif class="actcsk" data-inputnumber="{{$kk}}" /> <strong>{{$ap->variant->title}} </strong>
					</td>
					<td> <select name="transfer_option[{{$ap->ucode}}]" id="transfer_option{{$kk}}" class="form-control t_option" data-inputnumber="{{$kk}}" @if($kk > '0') disabled="disabled" @endif >
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
						<option value="Pvt Transfer" data-id="3">Pvt Transfer</option>
						@endif
						</select>
						<input type="hidden" id="pvt_traf_val{{$kk}}" value="0"  name="pvt_traf_val[{{$ap->ucode}}]"    />
						</td>
						<td> 
						<div  style="display:none;border:none;" id="transfer_zone_td{{$kk}}">
						@if($ap->variant->sic_TFRS==1)
						@if(!empty($actZone))
						<select name="transfer_zone[{{$ap->ucode}}]" id="transfer_zone{{$kk}}" class="form-control zoneselect"  data-inputnumber="{{$kk}}">
						
						
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
						
						<input type="hidden" id="zonevalprice{{$kk}}" value="0"  name="zonevalprice[{{$ap->ucode}}]"    />
						</div> 
						</td>
					
							<input type="hidden" style="display:none" id="pickup_location{{$kk}}" value=""  name="pickup_location[{{$ap->ucode}}]" placeholder="Pickup Location" class="form-control"   />
						
					<td>
					<input type="text"id="tour_date{{$kk}}" value="{{date('d-m-Y',strtotime($voucher->travel_from_date))}}"  name="tour_date[{{ $ap->ucode }}]" placeholder="Tour Date" class="form-control tour_datepicker" required @if($kk > '0') disabled="disabled" @endif     />
					
					</td>
					<td><select name="adult[{{$ap->ucode}}]" id="adult{{$kk}}" class="form-control priceChange" required data-inputnumber="{{$kk}}" @if($kk > '0') disabled="disabled" @endif>
					@if($kk > '0')
						<option value="">0</option>
						@endif
						
						@for($a=$ap->prices->adult_min_no_allowed; $a<=$ap->prices->adult_max_no_allowed; $a++)
						@if($ap->prices->adult_min_no_allowed > 0)
						<option value="{{$a}}" @if($voucher->adults==$a && $voucher->adults > 0) selected="selected" @endif>{{$a}}</option>
						@endif
						@endfor
						</select></td>
                    <td><select name="child[{{$ap->ucode}}]" id="child{{$kk}}" class="form-control priceChange" data-inputnumber="{{$kk}}" @if($kk > '0') disabled="disabled" @endif>
						@for($child=$ap->prices->child_min_no_allowed; $child<=$ap->prices->child_max_no_allowed; $child++)
						<option value="{{$child}}" @if($voucher->childs==$child && $voucher->childs > 0) selected="selected" @endif>{{$child}}</option>
						@endfor
						</select></td>
                    <td><select name="infant[{{$ap->ucode}}]" id="infant{{$kk}}" class="form-control priceChange" data-inputnumber="{{$kk}}" @if($kk > '0') disabled="disabled" @endif>
						@for($inf=$ap->prices->infant_min_no_allowed; $inf<=$ap->prices->infant_max_no_allowed; $inf++)
						<option value="{{$inf}}" @if($voucher->infants==$inf && $voucher->infants > 0) selected="selected" @endif>{{$inf}}</option>
						@endfor
						</select>
						<input type="hidden" value="{{$markup['ticket_only']}}" id="mpt{{$kk}}"  name="mpt[{{$ap->u_code}}]"    />
						
						<input type="hidden" value="{{$markup['sic_transfer']}}" id="mpst{{$kk}}"  name="mpst[{{$ap->u_code}}]"    />
					
						<input type="hidden" value="{{$markup['pvt_transfer']}}" id="mppt{{$kk}}"  name="mppt[{{$ap->u_code}}]"    />

						<input type="hidden" value="{{$markup['ticket_only_m']}}" id="mptt{{$kk}}"  name="mptt[{{$ap->u_code}}]"    />

						<input type="hidden" value="{{$markup['sic_transfer_m']}}" id="mpstt{{$kk}}"  name="mpstt[{{$ap->u_code}}]"    />
					
						<input type="hidden" value="{{$markup['pvt_transfer_m']}}" id="mpptt{{$kk}}"  name="mpptt[{{$ap->u_code}}]"    />
						</td>
						
						
						<td>
						<input type="text" id="net_price{{$kk}}" style="width: 50px;" value="" required  name="net_price[{{$ap->ucode}}]" @if($kk > '0') disabled="disabled" @endif data-inputnumber="{{$kk}}" class="form-control onlynumbrf priceChangenp"    />
						</td>
						<td>
						<input type="text" id="discount{{$kk}}" style="width: 50px;" value="0"  name="discount[{{$ap->ucode}}]" @if($kk > '0') disabled="disabled" @endif data-inputnumber="{{$kk}}" class="form-control onlynumbrf priceChangedis"    />
						</td>
						<td class="text-center" >
						@php
						$priceAd = ($ap->adult_rate_with_vat*$ap->adult_min_no_allowed);
						$mar = (($priceAd * $markup['ticket_only'])/100);
						$price = ($priceAd + ($ap->chield_rate_with_vat*$ap->chield_min_no_allowed) + ($ap->infant_rate_with_vat*$ap->infant_min_no_allowed));
						
						$price +=$mar;
						if($activity->vat > 0){
						$vat = (($activity->vat * $price)/100);
						$price +=$vat;
						}
						
						@endphp

						@if($voucher->vat_invoice == '1')
						<input type="hidden" value="{{$ap->prices->adult_rate_without_vat}}" id="adultPrice{{$kk}}"  name="adultPrice[{{ $ap->ucode }}]"    />

						<input type="hidden" value="{{$ap->prices->child_rate_without_vat}}" id="childPrice{{$kk}}"  name="childPrice[{{ $ap->ucode }}]"    />
						<input type="hidden" value="{{$ap->prices->infant_rate_without_vat}}" id="infPrice{{$kk}}"  name="infPrice[{{ $ap->ucode }}]"    />

						@else 

						<input type="hidden" value="{{$ap->prices->adult_rate_with_vat}}" id="adultPrice{{$kk}}"  name="adultPrice[{{ $ap->ucode }}]"    />

						<input type="hidden" value="{{$ap->prices->child_rate_with_vat}}" id="childPrice{{$kk}}"  name="childPrice[{{ $ap->ucode }}]"    />
						<input type="hidden" value="{{$ap->prices->infant_rate_with_vat}}" id="infPrice{{$kk}}"  name="infPrice[{{ $ap->ucode }}]"    />
						@endif

						
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

<?php

namespace App\Helpers;

use Ramsey\Uuid\Uuid;
use DB;
use Carbon\Carbon;
use Auth;
use App\Models\User;
use App\Models\VoucherActivity;
use App\Models\VoucherHotel;
use App\Models\ActivityPrices;
use App\Models\AgentPriceMarkup;
use App\Models\ActivityVariant;
use App\Models\VariantPrice;
use App\Models\Zone;
use App\Models\TransferData;
use App\Models\Variant;
use App\Models\Activity;
use App\Models\Voucher;
use SiteHelpers;

class PriceHelper 
{
    
	public static function getActivityVariantListArrayByTourDate($date,$activityId)
    {
		$user = auth()->user();
		$data = [];
		$activity = Activity::find($activityId);
		$data['activity'] = $activity;
		$data['activityVariants'] = [];
		$date = date("Y-m-d",strtotime($date));
		
			$activityVariants = ActivityVariant::with('prices', 'variant', 'activity')
			->where('activity_id', $activityId)
			->whereHas('prices', function ($query) use ($date) {
				$query->where('rate_valid_from', '<=', $date)
					  ->where('rate_valid_to', '>=', $date);
			})->get();
	
	   if(!empty($activityVariants)){
			$data['activityVariants'] = $activityVariants;
		}
	   
	   return $data;
    }
	
	public static function getActivityVariantPrice($activityVariantId,$tourDate)
    {
		$user = auth()->user();
		$tourDate = date("Y-m-d",strtotime($tourDate));
		$price = VariantPrice::where('activity_variant_id', $activityVariantId)->where('rate_valid_from', '<=', $tourDate)->where('rate_valid_to', '>=', $tourDate)->first();
	
	   return $price;
    }
	
	
	public static function getActivityPriceSaveInVoucher($transfer_option,$activity_variant_id,$agent_id,$voucher,$u_code,$adult,$child,$infant,$discount,$tourDate)
    {
		$adult = ($adult == null) ? 0 : $adult;
		$child = ($child == null) ? 0 : $child;
		$infant = ($infant == null) ? 0 : $infant;
		$totalPrice = 0;
		$zonePrice = 0;
		$transferPrice = 0;
		$vatPrice = 0;
		$adult_total_rate = 0;
		$adultPrice = 0;
		$childPrice = 0;
		$infPrice = 0;
		$pvtTrafValWithMarkup = 0;
		$totalmember = $adult + $child;
		$vat_invoice = $voucher->vat_invoice;
		$startDate = $voucher->travel_from_date;
		$endDate = $voucher->travel_to_date;
		$user = auth()->user();
		$activityVariant = ActivityVariant::with('variant', 'activity')->where("id",$activity_variant_id)->first();
		
		$activity = $activityVariant->activity;
		$variant = $activityVariant->variant;
		$avat = 0;
		if($activity->vat > 0){
		$avat = $activity->vat;	
		}
		
		$price = PriceHelper::getActivityVariantPrice($activity_variant_id,$tourDate);
		
		
		/* if($vat_invoice == 1){
			if(!empty($price)){
			$adultPrice = $price->adult_rate_without_vat;
			$childPrice = $price->child_rate_without_vat;
			$infPrice = $price->infant_rate_without_vat;
			}
		} else { */
	
			if(!empty($price)){
			$adultPrice = $price->adult_rate_with_vat ;
			$childPrice = $price->child_rate_with_vat;
			$infPrice = $price->infant_rate_with_vat;
			}
		//}
	
	$adultPriceTotal  = $adultPrice * $adult;
	$childPriceTotal  = $childPrice * $child;
	$infantPriceTotal  = $infPrice * $infant;
	$adult_total_rate = $adultPriceTotal + $childPriceTotal + $infantPriceTotal;
	$adult_total_rate = ($adult_total_rate > 0)?$adult_total_rate:0;
		if(isset($activityVariant->ucode)){
		$markup = SiteHelpers::getAgentMarkup($agent_id,$activityVariant->activity_id, $activityVariant->ucode);
		}else{
			$markup['ticket_only'] = 0;
			$markup['sic_transfer'] = 0;
			$markup['pvt_transfer'] = 0;
			$markup['ticket_only_m'] = 1;
			$markup['sic_transfer_m'] = 1;
			$markup['pvt_transfer_m'] = 1;
		}
		
		$adultPriceMarkupTotal = $markup['ticket_only'] * $adult; // ticket_only as adult
		$childPriceMarkupTotal = $markup['sic_transfer'] * $child; // sic_transfer as child
		$infantPriceMarkupTotal = $markup['pvt_transfer'] * $infant; // pvt_transfer as infant
		$markupTotal = $adultPriceMarkupTotal + $childPriceMarkupTotal + $infantPriceMarkupTotal;
		 
			if($variant->sic_TFRS==1){
				
				 $actZone = SiteHelpers::getZone($variant->zones,$variant->sic_TFRS);
				 if(!empty($actZone))
				 {
					  $zonePrice = $actZone[0]['zoneValue'] * $totalmember;
				 }
			}
			if($variant->pvt_TFRS==1){
					$td = TransferData::where('transfer_id', $variant->transfer_plan)->where('qty', $totalmember)->first();
					if(!empty($td))
					{
					 $transferPrice = $td->price * $totalmember ;
					}
			}
			
			$totalTransferPrice = 0;
			$ticketPrice = $adultPriceTotal + $childPriceTotal  + $infantPriceTotal;
			if($transfer_option == 'Ticket Only'){
				$totalPrice = $ticketPrice;
			} else {
			if($transfer_option == 'Shared Transfer'){
				$totalPrice =  $ticketPrice + $zonePrice;
				$totalTransferPrice = $zonePrice;
			}elseif($transfer_option == 'Pvt Transfer'){
				  $totalPrice = $ticketPrice + $transferPrice;
				  $totalTransferPrice = $transferPrice;
			}
			}
			
		
		$grandTotal = $totalPrice + $markupTotal;
		if($vat_invoice == 1){
		//$vatPrice = (($avat/100) * $grandTotal);
		}
		
		//$total = round(($grandTotal+$vatPrice - $discount),2);
		$total = round(($grandTotal),2);
		$data = [
		'adultPrice' =>$adultPrice,
		'childPrice' =>$childPrice,
		'infPrice' =>$infPrice,
		'activity_vat' =>$avat,
		'pvt_traf_val_with_markup' =>$transferPrice,
		'zonevalprice_without_markup' =>$zonePrice,
		'markup_p_ticket_only' =>$markup['ticket_only'],
		'markup_p_sic_transfer' =>$markup['sic_transfer'],
		'markup_p_pvt_transfer' =>$markup['pvt_transfer'],
		'ticketPrice' =>$ticketPrice,
		'transferPrice' =>$totalTransferPrice,
		'vat_per' =>$avat,
		'totalprice' =>$total,
		];
		//dd($data);
		return $data;
		
    }
	
	
	public static function getActivityPriceByVariant($data)
    {
		$currency = SiteHelpers::getCurrencyPrice();
		$transfer_option = (isset($data['transfer_option']))?$data['transfer_option']:0;
		$activity_variant_id = (isset($data['activity_variant_id']))?$data['activity_variant_id']:0;
		$agent_id = (isset($data['agent_id']))?$data['agent_id']:0;
		$voucherId = (isset($data['voucherId']))?$data['voucherId']:0;
		$adult = (isset($data['adult']) && $data['adult'] > 0)?(int)$data['adult']:0;
		$child = (isset($data['child']) && $data['child'] > 0)?(int)$data['child']:0;
		$infant = (isset($data['infant']) && $data['infant'] > 0)?$data['infant']:0;
		$tourDate = (isset($data['tourDate']))?date("Y-m-d",strtotime($data['tourDate'])):0;
		$discount = (isset($data['discount']))?$data['discount']:0;
		$zonevalue = (isset($data['zonevalue']))?$data['zonevalue']:0;
		
		
		$totalPrice = 0;
		$zonePrice = 0;
		$transferPrice = 0;
		$vatPrice = 0;
		$adult_total_rate = 0;
		$adultPrice = 0;
		$childPrice = 0;
		$infPrice = 0;
		$pvtTrafValWithMarkup = 0;
		$totalmember = $adult + $child;
		$voucher = Voucher::where("id",$voucherId)->first();
		$vat_invoice = $voucher->vat_invoice;
		$startDate = $voucher->travel_from_date;
		$endDate = $voucher->travel_to_date;
		$user = auth()->user();
		$activityVariant = ActivityVariant::with('variant', 'activity')->where("id",$activity_variant_id)->first();
		$grandTotal = 0;
		$total = 0;
		$activity = $activityVariant->activity;
		$variant = $activityVariant->variant;
		$avat = 0;
		if($activity->vat > 0){
		$avat = $activity->vat;	
		}
		
		if(isset($activityVariant->ucode)){
			$markup = SiteHelpers::getAgentMarkup($agent_id,$activityVariant->activity_id, $activityVariant->ucode);
		}else{
			$markup['ticket_only'] = 0;
			$markup['sic_transfer'] = 0;
			$markup['pvt_transfer'] = 0;
			$markup['ticket_only_m'] = 1;
			$markup['sic_transfer_m'] = 1;
			$markup['pvt_transfer_m'] = 1;
		}
				
		$price = PriceHelper::getActivityVariantPrice($activity_variant_id,$tourDate);
		
		if(!empty($price)){
		
				/* if($vat_invoice == 1){
					if(!empty($price)){
					$adultPrice = $price->adult_rate_without_vat;
					$childPrice = $price->child_rate_without_vat;
					$infPrice = $price->infant_rate_without_vat;
					}
				} else {
			
					if(!empty($price)){ */
					$adultPrice = $price->adult_rate_with_vat ;
					$childPrice = $price->child_rate_with_vat;
					$infPrice = $price->infant_rate_with_vat;
					/* }
				} */
			
				$adultPriceTotal  = $adultPrice * $adult;
				$childPriceTotal  = $childPrice * $child;
				$infantPriceTotal  = $infPrice * $infant;
				$adult_total_rate = $adultPriceTotal + $childPriceTotal + $infantPriceTotal;
				$adult_total_rate = ($adult_total_rate > 0)?$adult_total_rate:0;
				
				
				$adultPriceMarkupTotal = $markup['ticket_only'] * $adult; // ticket_only as adult
				$childPriceMarkupTotal = $markup['sic_transfer'] * $child; // sic_transfer as child
				$infantPriceMarkupTotal = $markup['pvt_transfer'] * $infant; // pvt_transfer as infant
				$markupTotal = $adultPriceMarkupTotal + $childPriceMarkupTotal + $infantPriceMarkupTotal;
				 
					if($variant->sic_TFRS==1){
						$zonePrice = $zonevalue * $totalmember;
					}
					
					if($variant->pvt_TFRS==1){
							$td = TransferData::where('transfer_id', $variant->transfer_plan)->where('qty', $totalmember)->first();
							if(!empty($td))
							{
							 $transferPrice = $td->price * $totalmember ;
							}
					}
					
					$ticketPrice = $adultPriceTotal + $childPriceTotal  + $infantPriceTotal;
					if($transfer_option == 'Ticket Only'){
						$totalPrice = $ticketPrice;
					} else {
					if($transfer_option == 'Shared Transfer'){
						$totalPrice =  $ticketPrice + $zonePrice;
					}elseif($transfer_option == 'Pvt Transfer'){

						  $totalPrice = $ticketPrice + $transferPrice;
					}
					}
					
				
				$grandTotal = $totalPrice + $markupTotal;
				if($vat_invoice == 1){
				$vatPrice = (($avat/100) * $grandTotal);
				}
				
				//$total = round(($grandTotal+$vatPrice - $discount),2);
				$subTotal = $grandTotal;
				//$subTotal = $grandTotal+round($vatPrice,2);
				$priceConvert = $subTotal * round(($currency['value']),2);
				$total = round(($priceConvert),2);
		}
		
		
		$data = [
		'adultPrice' =>$adultPrice,
		'childPrice' =>$childPrice,
		'infPrice' =>$infant,
		'totalprice' =>$total,
		'activity_vat' =>$avat,
		'pvt_traf_val_with_markup' =>$transferPrice,
		'zonevalprice_without_markup' =>$zonePrice,
		'markup_p_ticket_only' =>$markup['ticket_only'],
		'markup_p_sic_transfer' =>$markup['sic_transfer'],
		'markup_p_pvt_transfer' =>$markup['pvt_transfer'],
		];
		
		return $data;
		
    }
	
	
	public static function getTotalTicketCostAllType($id) 
	{
		$voucherActivity = VoucherActivity::where('id',$id)->first();
		$returnTotalPrice = 0;
		if(!empty($voucherActivity)){
			$totalPrice = $voucherActivity->totalprice;
			$discounTkt = $voucherActivity->discount_tkt;
			$discountTrns = $voucherActivity->discount_sic_pvt_price;
			$totalDiscount = $discounTkt + $discountTrns;
			$returnTotalPrice = $totalPrice - $totalDiscount;
		}
		
		return $returnTotalPrice;
	}
	
	public static function getTotalCostTicketOnly($vid) 
	{
		$voucherActivity = VoucherActivity::where('voucher_id',$vid)->first();
		$returnTotalPrice = 0;
		if(!empty($voucherActivity)){
			$totalPrice = $voucherActivity->totalprice;
			$discounTkt = $voucherActivity->discount_tkt;
			$returnTotalPrice = $totalPrice - $discounTkt;
		}
		
		return $returnTotalPrice;
	}
	
	public static function getTicketAllTypeCost($id) 
{
    $voucherActivity = VoucherActivity::where('id', $id)->first();
    $returnTotalPrice = [
        'totalPrice' => 0,
        'tkt_price' => 0,
        'trns_price' => 0,
        'discounTkt' => 0,
        'discountTrns' => 0,
        'totalPriceAfDis' => 0,
        'tkt_priceAfDis' => 0,
        'trns_priceAfDis' => 0,
        'totalDiscount' => 0,
    ];

    if (!empty($voucherActivity)) {
        $totalPrice = $voucherActivity->totalprice;
        $discounTkt = $voucherActivity->discount_tkt;
        $discountTrns = $voucherActivity->discount_sic_pvt_price;
        $totalDiscount = $discounTkt + $discountTrns;

        // Calculate total price after discount
        $returnTotalPrice['totalPriceAfDis'] = $totalPrice - $totalDiscount;
        $tkt_priceAfDis = $voucherActivity->original_tkt_rate - $discounTkt;
		$trns_priceAfDis = $voucherActivity->original_trans_rate - $discountTrns;
        // Assign values to array keys
        $returnTotalPrice['totalPrice'] = ($totalPrice)?$totalPrice:0;
        $returnTotalPrice['tkt_price'] = ($voucherActivity->original_tkt_rate)?$voucherActivity->original_tkt_rate:0;
        $returnTotalPrice['trns_price'] = ($voucherActivity->original_trans_rate)?$voucherActivity->original_trans_rate:0;
        $returnTotalPrice['discounTkt'] = ($discounTkt)?$discounTkt:0;
        $returnTotalPrice['discountTrns'] = ($discountTrns)?$discountTrns:0;
        $returnTotalPrice['totalDiscount'] = ($totalDiscount)?$totalDiscount:0;
        $returnTotalPrice['tkt_priceAfDis'] = ($tkt_priceAfDis)?$tkt_priceAfDis:0;
        $returnTotalPrice['trns_priceAfDis'] = ($trns_priceAfDis)?$trns_priceAfDis:0;
    }

    return $returnTotalPrice;
}

	
	
	public static function getRefundAmountAfterCancellation($voucherActivityId)
	{
    $totalPrice = self::getTicketAllTypeCost($voucherActivityId);
    $voucherActivity = VoucherActivity::where('id', $voucherActivityId)->first();
	
    $cancelData = json_decode($voucherActivity->cancellation_time_data);
	
    $bookingDate = Carbon::parse($voucherActivity->booking_date);
    $cancelDate = Carbon::parse($voucherActivity->canceled_date);
    $minutesDifference = $bookingDate->diffInMinutes($cancelDate);
	//dd($cancelDate);
	$tkt_priceAfDis = 	$totalPrice['tkt_priceAfDis'];
	$trns_priceAfDis = 	$totalPrice['trns_priceAfDis'];
    $returnTotalPrice = [
        'refund_tkt_priceAfDis' => $tkt_priceAfDis,
        'refund_trns_priceAfDis' => $trns_priceAfDis,
    ];
	
	if(!empty($cancelData)){
		foreach ($cancelData as $ca) {
			$durationParts = explode('-', $ca->duration);
			$startHours = intval($durationParts[0]);
			$endHours = intval($durationParts[1] ?? PHP_INT_MAX);

			if ($minutesDifference >= $startHours * 60 && $minutesDifference < $endHours * 60) {
				$ticket_refund_per = $ca->ticket_refund_value;
				$trns_refund_per = $ca->transfer_refund_value;
				$ticketPrice = ($tkt_priceAfDis * $ticket_refund_per) / 100;
				$trnsPrice = ($trns_priceAfDis * $trns_refund_per) / 100;
				$returnTotalPrice['refund_tkt_priceAfDis'] = $ticketPrice;
				$returnTotalPrice['refund_trns_priceAfDis'] = $trnsPrice;
				break; 
			}
		}
	}
	 
	//dd($refundAmount);
    return $returnTotalPrice;
	}
}

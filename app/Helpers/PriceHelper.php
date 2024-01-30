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


class PriceHelper 
{
    
	public static function getActivityVariantListArrayByTourDate($date,$activityId)
    {
		$user = auth()->user();
		$data = [];
		$activity = Activity::find($activityId);
		$data['activity'] = $activity;
		$data['activityVariants'] = [];
		
		
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
}

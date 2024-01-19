<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\Airline;
use App\Models\User;
use App\Models\Customer;
use App\Models\Country;
use App\Models\Zone;
use App\Models\Hotel;
use App\Models\VoucherHotel;
use App\Models\Activity;
use App\Models\ActivityPrices;
use App\Models\TransferData;
use Illuminate\Http\Request;
use App\Models\VoucherActivity;
use App\Models\Ticket;
use SiteHelpers;
use Carbon\Carbon;
use SPDF;
use Illuminate\Support\Facades\Auth;
use App\Models\AgentAmount;
use Illuminate\Support\Facades\Mail;
use App\Mail\VoucheredBookingEmailMailable;

class AgentVouchersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		 $perPage = config("constants.ADMIN_PAGE_LIMIT");
		 $data = $request->all();
		$query = VoucherActivity::whereHas('voucher', function($q){
    $q->where('agent_id', '=', Auth::user()->id);
	$q->where(function ($q) {
		$q->where('status_main', 4)->orWhere('status_main', 5);
		});
});
		
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				if($data['booking_type'] == 2) {
				 $query->whereDate('tour_date', '>=', $startDate);
				 $query->whereDate('tour_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
					$query->whereHas('voucher', function($q)  use($startDate,$endDate){
				 $q->where('booking_date', '>=', $startDate);
				 $q->where('booking_date', '<=', $endDate);
				});
		
				}
				}
			}
		 if(isset($data['vcode']) && !empty($data['reference'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('agent_ref_no', '=', $data['reference']);
			});
		}
		
		 if(isset($data['vcode']) && !empty($data['vcode'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', '=', $data['vcode']);
			});
		}
		 if(isset($data['activity_name']) && !empty($data['activity_name'])) {
			$query->whereHas('activity', function($q)  use($data){
				$q->where('title', 'like', '%' . $data['activity_name'] . '%');
			});
		}
		if(isset($data['customer']) && !empty($data['customer'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('guest_name', 'like', '%' . $data['customer'] . '%');
			});
		}
		
       
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		$agetid = '';
		$agetName = '';
		
		
		
        return view('agent-vouchers.index', compact('records'));

    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
		$airlines = Airline::where('status', 1)->orderBy('name', 'ASC')->get();
		if(old('customer_id_select')){
		$customerTBA = Customer::where('id', old('customer_id_select'))->where('status', 1)->first();
		}else{
		$customerTBA = Customer::where('id', 1)->where('status', 1)->first();	
		}
		
        return view('agent-vouchers.create', compact('countries','airlines','customerTBA'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		
        $request->validate([
            
			'country_id'=>'required',
			'travel_from_date'=>'required',
			'nof_night'=>'required',
        ], [
			'arrival_airlines_id.required_if' => 'The airlines id field is required.',
			'arrival_date.required_if' => 'The arrival date field is required .',
			'depature_date.required_if' => 'The depature date field is required .',
			'depature_airlines_id.required_if' => 'The depature airlines field is required .',
			'travel_from_date.required' => 'The travel date from field is required .',
			'nof_night.required' => 'The number of night field is required .',
		]);
		
		
		$arrival_date = $request->input('arrival_date'); // get the value of the date input
		$depature_date = $request->input('depature_date'); // get the value of the date input
		$customer = Customer::where('mobile',$request->input('customer_mobile'))->first();
		
		$timestamp = strtotime($request->input('travel_from_date'));
		$travel_from_date = date('Y-m-d', $timestamp);
		$daysToAdd = $request->input('nof_night');
		$newTimestamp = strtotime("+{$daysToAdd} days", $timestamp);
		$travel_to_date = date('Y-m-d', $newTimestamp);
		
		if(empty($customer))
		{
			$customer = new Customer();
			$customer->name = $request->input('customer_name');
			$customer->mobile = $request->input('customer_mobile');
			$customer->email = $request->input('customer_email');
			$customer->save();
		}
		else
		{
			//$customer->name = $request->input('customer_name');
			//$customer->email = $request->input('customer_email');
			//$customer->save();
		}
			
		

        $record = new Voucher();
        $record->agent_id = $request->input('agent_id_select');
		$record->customer_id = $customer->id;
		$record->country_id = '1';
		$record->is_hotel = $request->input('is_hotel');
		$record->is_flight = $request->input('is_flight');
		$record->is_activity = $request->input('is_activity');
		$record->arrival_airlines_id = $request->input('arrival_airlines_id');
		$record->arrival_date = $arrival_date;
		$record->arrival_airport = $request->input('arrival_airport');
		$record->arrival_terminal = $request->input('arrival_terminal');
		$record->depature_airlines_id = $request->input('depature_airlines_id');
		$record->depature_date = $depature_date;
		$record->depature_airport = $request->input('depature_airport');
		$record->depature_terminal = $request->input('depature_terminal');
		$record->travel_from_date = $travel_from_date;
		$record->travel_to_date = $travel_to_date;
		$record->nof_night = $request->input('nof_night');
		$record->vat_invoice = $request->input('vat_invoice');
		$record->agent_ref_no = $request->input('agent_ref_no');
		$record->guest_name = $request->input('guest_name');
		$record->arrival_flight_no = $request->input('arrival_flight_no');
		$record->depature_flight_no = $request->input('depature_flight_no');
		$record->remark = $request->input('remark');
		$record->status = 1;
		$record->created_by = Auth::user()->id;
        $record->save();
		$code = 'ABT-'.date("Y")."-00".$record->id;
		$recordUser = Voucher::find($record->id);
		$recordUser->code = $code;
		
		$recordUser->save();
		
		
		if ($request->has('save_and_activity')) {
			if($record->is_activity == 1){
			return redirect()->route('agent-vouchers.add.activity',$record->id)->with('success', 'Voucher Created Successfully.');
			}
			else
			{
				return redirect()->route('agent-vouchers.index')->with('error', 'If select hotel yes than you can add hotel.');
			}
		} else {
        return redirect()->route('agent-vouchers.index')->with('success', 'Voucher Created Successfully.');
		}
		
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show($vid)
    {
		$voucher = Voucher::where('id',$vid)->where('agent_id',Auth::user()->id)->first();
		
		if (empty($voucher)) {
            return abort(404); //record not found
        }
		if($voucher->status_main  > 4)
		{
			return redirect()->route('agentVoucherView',$voucher->id);
		}
		$voucherHotel = VoucherHotel::where('voucher_id',$voucher->id)->get();
		$voucherActivity = VoucherActivity::where('voucher_id',$voucher->id)->get();
		$name = explode(' ',$voucher->guest_name);
		
		$fname = '';
		$lname = '';
		if(!empty($name)){
			$fname = trim($name[0]);
			unset($name[0]);
			$lname = trim(implode(' ', $name));
		}
		$voucherStatus = config("constants.voucherStatus");
        return view('agent-vouchers.view', compact('voucher','voucherHotel','voucherActivity','voucherStatus','fname','lname'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = Voucher::where('id',$id)->where('agent_id',Auth::user()->id)->first();
		if (empty($record)) {
            return abort(404); //record not found
        }
		
		$countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
		$airlines = Airline::where('status', 1)->orderBy('name', 'ASC')->get();
		$customer = Customer::where('id',$record->customer_id)->first();
       return view('agent-vouchers.edit')->with(['record'=>$record,'countries'=>$countries,'airlines'=>$airlines,'customer'=>$customer]);
		
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Zone  $Zone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
			'country_id'=>'required',
			'travel_from_date'=>'required',
			'nof_night'=>'required',
			'arrival_airlines_id' => 'required_if:is_flight,==,1',
			'arrival_date' => 'required_if:is_flight,==,1',
        ], [
			'arrival_airlines_id.required_if' => 'The airlines id field is required.',
			'arrival_date.required_if' => 'The arrival date field is required .',
			'depature_date.required_if' => 'The depature date field is required .',
			'depature_airlines_id.required_if' => 'The depature airlines field is required .',
			'travel_from_date.required' => 'The travel date from field is required .',
			'nof_night.required' => 'The number of night field is required .',
		]);

		$arrival_date = $request->input('arrival_date'); // get the value of the date input
		$depature_date = $request->input('depature_date'); // get the value of the date input
		$customer = Customer::where('mobile',$request->input('customer_mobile'))->first();
		
		if(empty($customer))
		{
			$customer = new Customer();
			$customer->name = $request->input('customer_name');
			$customer->mobile = $request->input('customer_mobile');
			$customer->email = $request->input('customer_email');
			$customer->save();
		}
		else
		{
			//$customer->name = $request->input('customer_name');
			//$customer->email = $request->input('customer_email');
			//$customer->save();
		}
		
        $record = Voucher::find($id);
        $record->agent_id = $request->input('agent_id_select');
		$record->customer_id = $customer->id;
		$record->country_id = $request->input('country_id');
		$record->is_hotel = $request->input('is_hotel');
		$record->is_flight = $request->input('is_flight');
		$record->is_activity = $request->input('is_activity');
		$record->arrival_airlines_id = $request->input('arrival_airlines_id');
		$record->arrival_date = $arrival_date;
		$record->arrival_airport = $request->input('arrival_airport');
		$record->arrival_terminal = $request->input('arrival_terminal');
		$record->depature_airlines_id = $request->input('depature_airlines_id');
		$record->depature_date = $depature_date;
		$record->depature_airport = $request->input('depature_airport');
		$record->depature_terminal = $request->input('depature_terminal');
		$record->travel_from_date = $request->input('travel_from_date');
		$record->travel_to_date = $request->input('travel_to_date');
		$record->nof_night = $request->input('nof_night');
		$record->vat_invoice = $request->input('vat_invoice');
		$record->agent_ref_no = $request->input('agent_ref_no');
		$record->guest_name = $request->input('guest_name');
		$record->arrival_flight_no = $request->input('arrival_flight_no');
		$record->depature_flight_no = $request->input('depature_flight_no');
		$record->remark = $request->input('remark');
		$record->status = 1;
		$record->updated_by = Auth::user()->id;
        $record->save();
		
		if($record->is_activity != 1)
		{
		$voucherActivity = VoucherActivity::where('voucher_id',$record->id)->delete();
		}
		
        return redirect('agent-vouchers')->with('success','Voucher Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Voucher  $Voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Voucher::where('id',$id)->where('agent_id',Auth::user()->id)->first();
		if (empty($record)) {
            return abort(404); //record not found
        }
		//$voucherHotel = VoucherHotel::where('voucher_id',$id)->delete();
		$voucherActivity = VoucherActivity::where('voucher_id',$id)->delete();
		
        $record->delete();
        return redirect('agent-vouchers')->with('success', 'Voucher Deleted.');
    }
	
	
	public function autocompleteAgent(Request $request)
    {
		$search  = $request->get('search');
		$nameOrCompany  = ($request->get('nameorcom'))?$request->get('nameorcom'):'Company';
		if($nameOrCompany == 'Company'){
        $users = User::where('role_id', 3)
					->where('is_active', 1)
					->where(function ($query) use($search) {
						$query->where('company_name', 'LIKE', '%'. $search. '%')
						->orWhere('code', 'LIKE', '%'. $search. '%')
						->orWhere('mobile', 'LIKE', '%'. $search. '%');
					})->get();
		$response = array();
      foreach($users as $user){
		   $agentDetails = '<b>Code:</b> '.$user->code.' <b>Email:</b>'.$user->email.' <b> Mobile No:</b>'.$user->mobile.' <b>Address:</b>'.$user->address. " ".$user->postcode;
         $response[] = array("value"=>$user->id,"label"=>$user->company_name.'('.$user->code.')',"agentDetails"=>$agentDetails);
      }
	}
	elseif($nameOrCompany == 'Name'){
        $users = User::where('role_id', 3)
					->where('is_active', 1)
					->where(function ($query) use($search) {
						$query->where('name', 'LIKE', '%'. $search. '%')
						->orWhere('code', 'LIKE', '%'. $search. '%')
						->orWhere('mobile', 'LIKE', '%'. $search. '%');
					})->get();
		$response = array();
      foreach($users as $user){
		   $agentDetails = '<b>Code:</b> '.$user->code.' <b>Email:</b>'.$user->email.' <b> Mobile No:</b>'.$user->mobile.' <b>Address:</b>'.$user->address. " ".$user->postcode;
         $response[] = array("value"=>$user->id,"label"=>$user->full_name.'('.$user->code.')',"agentDetails"=>$agentDetails);
      }
	}	  
        return response()->json($response);
    }
	
	
	
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addActivityList(Request $request,$vid)
    {
       $data = $request->all();
		$typeActivities = config("constants.typeActivities"); 
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucher = Voucher::find($vid);
		
		if($voucher->status_main  == '4')
		{
			return redirect()->route('agent-vouchers.show',$voucher->id)->with('error', 'You can not add more activity. your voucher already confirmed.');
		}
		if($voucher->status_main  == '5')
		{
			return redirect()->route('agentVoucherView',$voucher->id)->with('error', 'You can not add more activity. your voucher already vouchered.');
		}
		
		$startDate = $voucher->travel_from_date;
		$endDate = $voucher->travel_to_date;
        $query = Activity::with('prices')->where('status',1)->where('is_price',1);
	
        if (isset($data['name']) && !empty($data['name'])) {
            $query->where('title', 'like', '%' . $data['name'] . '%');
        }
       
	  $records = $query->whereHas('prices', function ($query) use($startDate,$endDate) {
           $query->where('rate_valid_from', '<=', $startDate)->where('rate_valid_to', '>=', $endDate)->where('for_backend_only', '0');
       })->orderBy('created_at', 'DESC')->paginate($perPage); 
	   
       //$records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		
		$voucherActivityCount = VoucherActivity::where('voucher_id',$vid)->count();
		$voucherHotel = VoucherHotel::where('voucher_id',$vid)->get();
		$voucherActivity = VoucherActivity::where('voucher_id',$vid)->orderBy('tour_date','ASC')->get();
        return view('agent-vouchers.activities-list', compact('records','typeActivities','vid','voucher','voucherActivityCount','voucherActivity'));
		
       
    }
	
	 public function addActivityView($aid,$vid)
    {
		$query = Activity::with('images')->where('id', $aid);
		$activity = $query->where('status', 1)->first();
		
		$voucher = Voucher::find($vid);
		$startDate = $voucher->travel_from_date;
		$endDate = $voucher->travel_to_date;
		

		$activityPrices = ActivityPrices::where('activity_id', $aid)
->where('rate_valid_from', '<=', $startDate)->where('rate_valid_to', '>=', $endDate)->get();

		
		$typeActivities = config("constants.typeActivities"); 
		
			
			
       return view('agent-vouchers.activities-add-details', compact('activity','aid','vid','voucher','typeActivities','activityPrices'));
    } 
	
	public function getActivityVariant(Request $request)
    {
		$data = $request->all();
		$aid = $data['act'];
		$vid = $data['vid'];
		$query = Activity::where('id', $data['act']);
		$activity = $query->where('status', 1)->first();
		$voucher = Voucher::find($data['vid']);
		$startDate = $voucher->travel_from_date;
		$endDate = $voucher->travel_to_date;
		
		/* $activityPrices = ActivityPrices::where('activity_id', $data['act'])
			->where('rate_valid_from', '<=', $startDate)->where('rate_valid_to', '>=', $endDate)->where('for_backend_only', '0')
			->orderByRaw('CAST(adult_rate_without_vat AS DECIMAL(10, 2))')
			->get(); */
	

		$activityPrices = ActivityPrices::where('activity_id', $data['act'])->where('rate_valid_from', '<=', $startDate)->where('rate_valid_to', '>=', $endDate)->where('for_backend_only', '0')->get();

		$dates = SiteHelpers::getDateListBoth($voucher->travel_from_date,$voucher->travel_to_date,$activity->black_sold_out);
		$disabledDay = SiteHelpers::getNovableActivityDays($activity->availability);
		$typeActivities = config("constants.typeActivities"); 
		
		$returnHTML = view('agent-vouchers.activities-add-view', compact('activity','aid','vid','voucher','typeActivities','activityPrices'))->render();
		
		return response()->json(array('success' => true, 'html'=>$returnHTML, 'dates'=>$dates,'disabledDay'=>$disabledDay));	
			
    }
	
	
	public function getPVTtransferAmount(Request $request)
    {
		$activity = Activity::where('id', $request->acvt_id)->where('status', 1)->first();
		$price = 0;
		$total = 0;
		$markupPer = $request->markupPer;
		//$activityPrices = ActivityPrices::where('activity_id', $aid)->get();
		if($activity->pvt_TFRS == 1)
		{
			$td = TransferData::where('transfer_id', $activity->transfer_plan)->where('qty', $request->adult)->first();
			if(!empty($td))
			{
				$price = $td->price;
			}
		}
		
		$totalPrice  = $price*$request->adult;
		$markup = (($markupPer/100) * $totalPrice);
		//$total = ($markup + $totalPrice);
		$total = $totalPrice;
		return $total;
    }
	
	
	public function activitySaveInVoucher(Request $request)
    {
		
		$activity_select = $request->input('activity_select');
	if(isset($activity_select))
	{
		
		$voucher_id = $request->input('v_id');
		$activity_id = $request->input('activity_id');
		$voucher = Voucher::find($voucher_id);
		$activity = Activity::find($activity_id);
		$startDate = $voucher->travel_from_date;
		$endDate = $voucher->travel_to_date;
		$getAvailableDateList = SiteHelpers::getDateList($voucher->travel_from_date,$voucher->travel_to_date,$activity->black_sold_out);
		
		$variant_name = $request->input('variant_name');
		$variant_code = $request->input('variant_code');
		$transfer_option = $request->input('transfer_option');
		$tour_date = $request->input('tour_date');
		$transfer_zone = $request->input('transfer_zone');
		$adult = $request->input('adult');
		$child = $request->input('child');
		$infant = $request->input('infant');
		$discount = $request->input('discount');
		$variant_unique_code = $request->input('variant_unique_code');
		
		$data = [];
		$total_activity_amount = 0;
		foreach($activity_select as $k => $v)
		{
			$totalmember = $adult[$k] + $child[$k];
			$priceCal = SiteHelpers::getActivityPriceSaveInVoucherActivity($transfer_option[$k],$activity_id,$voucher->agent_id,$voucher,$variant_unique_code[$k],$adult[$k],$child[$k],$infant[$k],$discount[$k]);
			if($priceCal['totalprice'] > 0){
				$tour_dt = date("Y-m-d",strtotime($tour_date[$k]));
				if(!in_array($tour_dt,$getAvailableDateList)){
				return redirect()->back()->with('error', 'This Tour is not available for Selected Date.');
				}
			
			
			
			
			$data[] = [
			'voucher_id' => $voucher_id,
			'activity_id' => $activity_id,
			'activity_vat' => $priceCal['activity_vat'],
			'variant_unique_code' => $variant_unique_code[$k],
			'variant_name' => $variant_name[$k],
			'variant_code' => $variant_code[$k],
			'transfer_option' => $transfer_option[$k],
			'tour_date' => $tour_dt,
			'pvt_traf_val_with_markup' => $priceCal['pvt_traf_val_with_markup'],
			'transfer_zone' => $transfer_zone[$k],
			'zonevalprice_without_markup' => $priceCal['zonevalprice_without_markup'],
			'adult' => $adult[$k],
			'child' => $child[$k],
			'infant' => $infant[$k],
			'markup_p_ticket_only' => $priceCal['markup_p_ticket_only'],
			'markup_p_sic_transfer' => $priceCal['markup_p_sic_transfer'],
			'markup_p_pvt_transfer' => $priceCal['markup_p_pvt_transfer'],
			'adultPrice' => $priceCal['adultPrice'],
			'childPrice' => $priceCal['childPrice'],
			'infPrice' => $priceCal['infPrice'],
			'discountPrice' => $discount[$k],
			'totalprice' => number_format($priceCal['totalprice'], 2, '.', ''),
			'created_by' => Auth::user()->id,
			'updated_by' => Auth::user()->id,	
                ];

				$total_activity_amount += $priceCal['totalprice'] - $discount[$k];
			}
		}
		
		if(count($data) > 0)
		{
			VoucherActivity::insert($data);
			$voucher = Voucher::find($voucher_id);
			$voucher->total_activity_amount += $total_activity_amount;
			$voucher->save();
		}

		
		
		if ($request->has('save_and_continue')) {
        //return redirect()->back()->with('success', 'Activity added Successfully.');
		return redirect()->route('agent-vouchers.add.activity',$voucher_id)->with('success', 'Activity added Successfully.');
		} else {
			return redirect()->back()->with('success', 'Activity added Successfully.');
        //return redirect('vouchers')->with('success', 'Activity Added Successfully.');
		}
	}
		
       return redirect()->back()->with('error', 'Please select activity variant.');
	   
    }
	
	public function destroyActivityFromVoucher($id)
    {
        $record = VoucherActivity::find($id);
		
        $record->delete();
        return redirect()->back()->with('success', 'Activity Deleted Successfully.');
    }
	

	public function autocompleteHotel(Request $request)
    {
		$search  = $request->get('search');
		$zone  = $request->get('zone');
		if(!empty($zone)){
        $hotels = Hotel::where('zone_id', $zone)
					->where('status', 1)
					->where('name', 'LIKE', '%'. $search. '%')
					->paginate(10);
		}else{
			$hotels = Hotel::where('status', 1)
					->where('name', 'LIKE', '%'. $search. '%')
					->paginate(10);
		}
		$response = array();
		
      foreach($hotels as $hotel){
         $response[] = array("value"=>$hotel->name,"label"=>$hotel->name);
      }
	
        return response()->json($response);
    }
	
	public function statusChangeVoucher(Request $request,$id)
    {
		$data = $request->all();
		
		$record = Voucher::where('id',$id)->where('agent_id',Auth::user()->id)->first();
		
		if (empty($record)) {
            return abort(404); //record not found
        }

		$voucherActivity = VoucherActivity::where('voucher_id',$record->id);
		$voucherActivityRecord = $voucherActivity->get();
		if($voucherActivity->count() == 0){
			return redirect()->back()->with('error', 'Please add activity this booking.');
	   }
		$paymentDate = date('Y-m-d', strtotime('-2 days', strtotime($record->travel_from_date)));
		$record->guest_name = $data['fname'].' '.$data['lname'];
		$record->guest_email = $data['customer_email'];
		$record->guest_phone = $data['customer_mobile'];
		$record->agent_ref_no = $data['agent_ref_no'];
		$record->remark = $data['remark'];
		$record->updated_by = Auth::user()->id;
		$record->payment_date = $paymentDate;

		if ($request->has('btn_paynow')) {
		$agent = User::find($record->agent_id);
		if(!empty($agent))
		{
			
			
			$agentAmountBalance = $agent->agent_amount_balance;
			$total_activity_amount = $record->voucheractivity->sum('totalprice');
			if($agentAmountBalance >= $total_activity_amount)
			{
			
			$voucherCount = Voucher::where('status_main',5)->count();
			$voucherCountNumber = $voucherCount +1;
			if($record->vat_invoice == 1)
			{
			$code = 'VIN-1100001'.$voucherCountNumber;
			}else{
			$code = 'WVIN-1100001'.$voucherCountNumber;
			}
			
			$record->booking_date = date("Y-m-d");
			$record->invoice_number = $code;
			$record->status_main = 5;
			$record->save();
			$agent->agent_amount_balance -= $total_activity_amount;
			$agent->save();
			
			$agentAmount = new AgentAmount();
			$agentAmount->agent_id = $record->agent_id;
			$agentAmount->amount = $total_activity_amount;
			$agentAmount->date_of_receipt = date("Y-m-d");
			$agentAmount->transaction_type = "Payment";
			$agentAmount->transaction_from = 2;
			$agentAmount->role_user = 3;
			$agentAmount->created_by = Auth::user()->id;
			$agentAmount->updated_by = Auth::user()->id;
			$agentAmount->save();
			$recordUser = AgentAmount::find($agentAmount->id);
			$recordUser->receipt_no = $code;
			$recordUser->is_vat_invoice = $record->vat_invoice;
			$recordUser->save(); 
			
			$voucherHotel = VoucherHotel::where('voucher_id',$record->id)->get();
			
			$emailData = [
			'voucher'=>$record,
			'voucherActivity'=>$voucherActivityRecord,
			'voucherHotel'=>$voucherHotel,
			];
			if(!empty($record->guest_email)){
			//Mail::to($record->guest_email,'Booking Confirmation.')->cc($agent->email)->send(new VoucheredBookingEmailMailable($emailData)); 
			} else{
			//Mail::to($agent->email,'Booking Confirmation.')->send(new VoucheredBookingEmailMailable($emailData)); 	
			}
			
			}else{
				 return redirect()->back()->with('error', 'Agency amount balance not sufficient for this booking.');
			}
			
		}
		else{
				 return redirect()->back()->with('error', 'Agency  Name not found this voucher.');
			}
		
		}
		else if ($request->has('btn_hold')) {
		
			$record->booking_date = date("Y-m-d");
			$record->status_main = 4;
			$record->save();
		}
		
	
		
        return redirect()->route('agentVoucherView',$record->id)->with('success', 'Voucher Created Successfully.');
    }
	
	 public function agentVoucherView($vid)
    {
		$voucher =  Voucher::where('id',$vid)->where('agent_id',Auth::user()->id)->first();
		if (empty($voucher)) {
            return abort(404); //record not found
        }
		$voucherActivity = VoucherActivity::where('voucher_id',$voucher->id)->get();
	
		$voucherStatus = config("constants.voucherStatus");
        return view('agent-vouchers.bookedview', compact('voucher','voucherActivity','voucherStatus'));
    }
	
	public function cancelActivityFromVoucher($id)
	{
		$record = VoucherActivity::find($id);
		if($record->ticket_downloaded == '0'){
		$record->status = 1;
		$record->canceled_date = Carbon::now()->toDateTimeString();
		$record->save();
		$tc = Ticket::where("voucher_activity_id",$record->id)->where("voucher_id",$record->voucher_id)->where("activity_id",$record->activity_id)->where("ticket_generated",'1')->where("ticket_downloaded",'0')->first();
		if(!empty($tc)){
		$tc->voucher_activity_id = '0';
		$tc->ticket_generated = '0';
		$tc->ticket_generated_by = '';
		$tc->generated_time = '';
		$tc->voucher_id = '0';
		$tc->save();
		}
		
		$recordCount = VoucherActivity::where("voucher_id",$record->voucher_id)->where("status",'0')->count();
		if($recordCount == '0'){
			$voucher = Voucher::find($record->voucher_id);
			$voucher->status_main = 6;
			$voucher->save();		
		}
		return redirect()->back()->with('success', 'Activity Canceled Successfully.');
		}
		else{
		return redirect()->back()->with('error', "Ticket already downloaded you can not cancel this.");	
		}
	}
}

<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\User;
use App\Models\Customer;
use App\Models\Activity;
use App\Models\ActivityPrices;
use App\Models\AgentPriceMarkup;
use App\Models\TransferData;
use Illuminate\Http\Request;
use App\Models\VoucherActivity;
use App\Models\AgentAmount;
use App\Models\Ticket;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\ReportLog;
use App\Models\VoucherHotel;
use DB;
use Illuminate\Support\Facades\Auth;
use SiteHelpers;
use PriceHelper;
use Carbon\Carbon;
use SPDF;
use App\Models\Variant;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LogisticReportExport;
use App\Exports\AccountsReceivablesReportExcelExport;
use App\Exports\VoucherActivityRefundExport;
use App\Exports\VoucherActivityCancelExport;
use App\Exports\TicketStockExport;
use App\Exports\AgentLedgerExport;
use App\Exports\InvoiceReportExport;
use App\Exports\TicketOnlyReportExcelExport;

class ReporsController extends Controller
{
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function voucherReport(Request $request)
    {
		$this->checkPermissionMethod('list.logisticreport');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		$twoDaysAgo = date("Y-m-d", strtotime(date("Y-m-d") . " -2 days"));
		$twoDaysNull = date("Y-m-d", strtotime(date("Y-m-d") . " +2 days"));
		$supplier_ticket = User::where("service_type",'Ticket')->orWhere('service_type','=','Both')->get();
		$supplier_transfer = User::where("service_type",'Transfer')->orWhere('service_type','=','Both')->get();
		
		$query = VoucherActivity::where('id','!=', null)->whereNotIn('status',[1,2])->where(function ($query)  {
			$query->where('transfer_option',  "Pvt Transfer")->orWhere('transfer_option',  "Shared Transfer");
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
				 $q->whereDate('booking_date', '>=', $startDate);
				 $q->whereDate('booking_date', '<=', $endDate);
				});
		
				}
				}
				
			}
			else{
			 $query->whereDate('tour_date', '>=', $twoDaysNull);
		}
        if(isset($data['vouchercode']) && !empty($data['vouchercode'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['vouchercode']);
			});
		}
		
		$query->whereHas('voucher', function($q)  use($data){
				$q->where('status_main', '=', 5);
			});

			$query->whereHas('voucher', function($q)  use($data){
				$q->orderBy('booking_date', 'DESC');
			});
			
        //$records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		//$records = $query->orderBy('created_at', 'DESC')->get();
		
		$records = $query->get();
        return view('reports.index', compact('records','voucherStatus','supplier_ticket','supplier_transfer'));

    }
	
	public function voucherReportExport(Request $request)
    {
		$this->checkPermissionMethod('list.logisticreport');
        $data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$twoDaysAgo = date("Y-m-d", strtotime(date("Y-m-d") . " -2 days"));
		$twoDaysNull = date("Y-m-d", strtotime(date("Y-m-d") . " +2 days"));
		$query = VoucherActivity::with(["voucher",'activity','voucher.customer','supplierticket','suppliertransfer'])->whereNotIn('status',[1,2])->where('id','!=', null)->where(function ($query)  {
           $query->where('transfer_option',  "Pvt Transfer")->orWhere('transfer_option',  "Shared Transfer");
       });;
		
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
				 $q->whereDate('booking_date', '>=', $startDate);
				 $q->whereDate('booking_date', '<=', $endDate);
				});
		
				}
				}
			}
			else{
			 $query->whereDate('tour_date', '>=', $twoDaysNull);
		}
		
		if(isset($data['vouchercode']) && !empty($data['vouchercode'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['vouchercode']);
			});
		}
		
		
		$query->whereHas('voucher', function($q)  use($data){
				$q->where('status_main', '=', 5);
		});
		
        $records = $query->orderBy('created_at', 'DESC')->get();
   // return Excel::download(new LogisticReportExport(['records' => $records]), 'users.xlsx');

return Excel::download(new LogisticReportExport($records), 'logistic_records'.date('d-M-Y s').'.csv');        //return Excel::download(new LogisticReportExport($records), 'records.csv');
    }
	
	public function voucherTicketOnlyReport(Request $request)
    {
		$this->checkPermissionMethod('list.voucherTicketOnlyReport');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		$supplier_ticket = User::where("service_type",'Ticket')->orWhere('service_type','=','Both')->get();
		$supplier_transfer = User::where("service_type",'Transfer')->orWhere('service_type','=','Both')->get();
		
		$query = VoucherActivity::with("activity")->where('id','!=', null)->whereNotIn('status',[1,2])->whereHas('activity', function ($query)  {
           $query->where('entry_type',  "Ticket Only");
       });
		$twoDaysAgo = date("Y-m-d", strtotime(date("Y-m-d") . " -2 days"));
		$twoDaysNull = date("Y-m-d", strtotime(date("Y-m-d") . " +2 days"));
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
				 $q->whereDate('booking_date', '>=', $startDate);
				 $q->whereDate('booking_date', '<=', $endDate);
				});
		
				}
				}
			}
		else{
			$query->whereDate('tour_date', '>=', $twoDaysNull);
		}
		
        if(isset($data['vouchercode']) && !empty($data['vouchercode'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['vouchercode']);
			});
		}
		
		$query->whereHas('voucher', function($q)  use($data){
				$q->where('status_main', '=', 5);
			});
			
			// $query->whereHas('voucher', function($q)  use($data){
			// 	$q->orderBy('booking_date', 'DESC');
			// });
       // $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		$records = $query->orderBy('created_at', 'DESC')->get();
		//$records = $query->get();
        return view('reports.voucher-ticket-only-report', compact('records','voucherStatus','supplier_ticket','supplier_transfer'));

    }
	
	public function voucherTicketOnlyReportExport(Request $request)
    {
		$this->checkPermissionMethod('list.voucherTicketOnlyReport');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		$supplier_ticket = User::where("service_type",'Ticket')->orWhere('service_type','=','Both')->get();
		$supplier_transfer = User::where("service_type",'Transfer')->orWhere('service_type','=','Both')->get();
		
		$query = VoucherActivity::where('id','!=', null)->whereNotIn('status',[1,2])->whereHas('activity', function ($query)  {
           $query->where('entry_type',  "Ticket Only");
       });
		$twoDaysAgo = date("Y-m-d", strtotime(date("Y-m-d") . " -2 days"));
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
				 $q->whereDate('booking_date', '>=', $startDate);
				 $q->whereDate('booking_date', '<=', $endDate);
				});
		
				}
				}else{
			$query->whereDate('tour_date', '>=', $twoDaysAgo);
			}
			}
		else{
			 $query->whereDate('tour_date', '>=', $twoDaysAgo);
		}
		
        if(isset($data['vouchercode']) && !empty($data['vouchercode'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['vouchercode']);
			});
		}
		
		$query->whereHas('voucher', function($q)  use($data){
				$q->where('status_main', '=', 5);
			});
			
		$records = $query->orderBy('created_at', 'DESC')->get();
		return Excel::download(new TicketOnlyReportExcelExport($records), 'ticket_only_records'.date('d-M-Y s').'.csv');

    }
	
	public function voucherReportSave(Request $request)
    {
		$data = $request->all();
		
		$record = VoucherActivity::find($data['id']);
        
		
		
		
		if(($data['inputname'] == 'supplier_ticket') && !empty($data['val']))
		{
			$record->{$data['inputname']} = $data['val'];
			$totalprice = 0;
			$voucher = Voucher::find($record->voucher_id);
			$priceCal = SiteHelpers::getActivitySupplierCost($record->activity_id,$data['val'],$voucher,$record->variant_code,$record->adult,$record->child,$record->infant,$record->discount);
			$totalprice = $priceCal['totalprice'];
			$record->actual_total_cost = $totalprice;
       		
			$response[] = array("status"=>2,'cost'=>$totalprice);
		} else if (($data['inputname'] == 'discountPrice') ) {
				$discount = $data['val'];
				$totalPrice = $record->totalprice;
				if(($totalPrice > $discount)){
				$discountPrice = $record->discountPrice;
				$tpD = $discountPrice + $totalPrice;
				$record->{$data['inputname']} = $discount;
				
				$totalPrice = $tpD - $discount;

				$record->totalprice = $totalPrice;
				}
				$response[] = array("status" => 2, 'cost' => $record->totalprice);
		} else if(($data['inputname'] == 'discount_tkt') && !empty($data['val'])) {
			$record->discount_tkt = $data['val'];
			$response[] = array("status" => 2, 'cost' => $record->totalprice);
		} else if(($data['inputname'] == 'discount_sic_pvt_price') && !empty($data['val'])) {
			$record->discount_sic_pvt_price = $data['val'];
			$response[] = array("status" => 2, 'cost' => $record->totalprice);
		}
		else
		{
			$record->{$data['inputname']} = $data['val'];
			$response[] = array("status"=>1,'cost'=>"0");
		}
		
		$record->save();
		if(isset($data['type']) && $data['type'] == 'Report'){
			ReportLog::create([
			"input"=>$data['inputname'],
			"input_vaue"=>$data['val'],
			"updated_by"=>Auth::user()->id,
			"report_type"=>isset($data['report_type'])?$data['report_type']:''
			]);
		}
		
		return response()->json($response);
	}

	// public function voucherReportSave(Request $request)
    // {
	// 	$data = $request->all();
	// 	$record = VoucherActivity::find($data['id']);
    //     $record->{$data['inputname']} = $data['val'];
    //     $record->save();
	// 	if($data['inputname'] == 'supplier_ticket')
	// 	{
	// 		$cost = 0;
	// 		$cost = SiteHelpers::voucherActivityValue($data['id'],$data['val']);
	// 		$record->{'actual_total_cost'} = $cost;
    //    		 $record->save();
	// 			$response[] = array("status"=>"1",'cost'=>$cost);
	// 			return response()->json($response);
	// 	}
		
	// }
	
	public function voucherReportSaveInVoucher(Request $request)
    {
		$data = $request->all();
		$record = Voucher::find($data['id']);
        $record->{$data['inputname']} = $data['val'];
		if(($data['inputname'] == 'guest_name') OR ($data['inputname'] == 'guest_phone')){
        $record->save();
		}
		$response[] = array("status"=>1);
        return response()->json($response);
	}


/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function accountsReceivablesReport(Request $request)
    {
		$this->checkPermissionMethod('list.accountsreceivables');
		 $data = $request->all();
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
        $query = User::with(['country', 'state', 'city']);
		$query->where('role_id', 3);
		$query->whereColumn('agent_credit_limit','!=','agent_amount_balance');
        if (isset($data['name']) && !empty($data['name'])) {
            $query->where('name', 'like', '%' . $data['name'] . '%');
        }
       if (isset($data['email']) && !empty($data['email'])) {
            $query->where('email', 'like', '%' . $data['email'] . '%');
        }
		if (isset($data['cname']) && !empty($data['cname'])) {
            $query->where('company_name', 'like', '%' . $data['cname'] . '%');
        }
       
        if (isset($data['code']) && !empty($data['code'])) {
            $query->where('code', $data['code']);
        }
		
		 if (isset($data['mobile']) && !empty($data['mobile'])) {
            $query->where('mobile', $data['mobile']);
        }
		
		if (isset($data['city_id']) && !empty($data['city_id'])) {
            $query->where('city_id', $data['city_id']);
        }
		
        if (isset($data['status']) && !empty($data['status'])) {
            if ($data['status'] == 1)
                $query->where('is_active', 1);
            if ($data['status'] == 2)
                $query->where('is_active', 0);
        }

        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);

        $countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
        $states = State::where('status', 1)->orderBy('name', 'ASC')->get();
        $cities = City::where('status', 1)->orderBy('name', 'ASC')->get();

		
        return view('reports.accounts-receivables-report', compact('records', 'countries', 'states', 'cities'));

    }
	
	 public function accountsReceivablesReportExcel(Request $request)
    {
		$this->checkPermissionMethod('list.accountsreceivables');
		 $data = $request->all();
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
        $query = User::with(['country', 'state', 'city']);
		$query->where('role_id', 3);
		$query->whereColumn('agent_credit_limit','!=','agent_amount_balance');
       
        $records = $query->orderBy('created_at', 'DESC')->get();
		return Excel::download(new AccountsReceivablesReportExcelExport($records), 'accounts_receivables_records'.date('d-M-Y s').'.csv');

    }
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function agentLedgerReport(Request $request)
    {
		//$this->checkPermissionMethod('list.agent.ledger');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		$s = 0;
		$query = AgentAmount::where('is_vat_invoice','=', '0')->where("role_user",3);
		if(Auth::user()->role_id == '3')
		{
			$query->where('agent_id', '=', Auth::user()->id);
		}
		else
		{
			if(isset($data['agent_id_select']) && !empty($data['agent_id_select'])) {
					$query->where('agent_id', '=', $data['agent_id_select']);
					$s = 1;
			}
		}
		
		if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = date('Y-m-d', strtotime($data['from_date']));
			$endDate = date('Y-m-d', strtotime($data['to_date']));
			 $query->whereDate('date_of_receipt', '>=', $startDate);
			 $query->whereDate('date_of_receipt', '<=', $endDate);
		$s = 1;
			}
		if($s == 1){	
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		}
		else
		{
		$records = AgentAmount::where('id','=', null)->orderBy('created_at', 'DESC')->paginate($perPage);	
		}
		$agetid = '';
		$agetName = '';
		
		if(old('agent_id')){
		$agentTBA = User::where('id', old('agent_id_select'))->where('status', 1)->first();
		$agetid = $agentTBA->id;
		$agetName = $agentTBA->company_name;
		}
        return view('reports.agent-ledger-report', compact('records','voucherStatus','agetid','agetName'));

    }
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function agentLedgerReportWithVat(Request $request)
    {
		$this->checkPermissionMethod('list.agent.ledger');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		
		$s = 0;
		$openingBalance = 0;
		$agent_id = '';
		$query = AgentAmount::where("id","!=",NULL);
		if(Auth::user()->role_id == '3')
		{
			$agent_id  = Auth::user()->id;
			$query->where('agent_id', '=', Auth::user()->id);
		}
		else
		{
			if(isset($data['agent_id_select']) && !empty($data['agent_id_select'])) {
				$agent_id  = $data['agent_id_select'];
					$query->where('agent_id', '=', $data['agent_id_select']);
					$s = 1;
			}
		}
		
		if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = date('Y-m-d', strtotime($data['from_date']));
			$endDate = date('Y-m-d', strtotime($data['to_date']));
			 $query->whereDate('date_of_receipt', '>=', $startDate);
			 $query->whereDate('date_of_receipt', '<=', $endDate);
		$s = 1;
		if($agent_id!=''){
		$payment = AgentAmount::where('agent_id',  $agent_id)->whereDate('date_of_receipt', '<=', $startDate)->where("transaction_type","Payment")->sum('amount');
		$receipt = AgentAmount::where('agent_id',  $agent_id)->whereDate('date_of_receipt', '<=', $startDate)->where("transaction_type","Receipt")->sum('amount');
		$openingBalance = $receipt - $payment;
		} else {
			$payment = AgentAmount::whereDate('date_of_receipt', '<=', $startDate)->where("transaction_type","Payment")->sum('amount');
		$receipt = AgentAmount::whereDate('date_of_receipt', '<=', $startDate)->where("transaction_type","Receipt")->sum('amount');
		$openingBalance = $receipt - $payment;
		}
	
		}
		
		$openingBalance = number_format($openingBalance,2, '.', '');
		
		if($s == 1){	
        $records = $query->orderBy('created_at', 'DESC')->get();
		}
		else
		{
		$records = AgentAmount::where('id','=', null)->orderBy('created_at', 'DESC')->get();	
		}
		$agetid = '';
		$agetName = '';
		
		if(old('agent_id')){
		$agentTBA = User::where('id', old('agent_id_select'))->where('status', 1)->first();
		$agetid = $agentTBA->id;
		$agetName = $agentTBA->company_name;
		}
		
		if(Auth::user()->role_id == '3')
		{
        return view('reports.agent-with-vat-ledger-report', compact('records','voucherStatus','agetid','agetName','openingBalance'));
		} else {
		 return view('reports.agent-with-vat-ledger-report-forAdmin', compact('records','voucherStatus','agetid','agetName','openingBalance'));	
		}

    }
	
	 public function agentLedgerReportWithVatExportExcel(Request $request)
    {
		$this->checkPermissionMethod('list.agent.ledger');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		
		
		
		$s = 0;
		$openingBalance = 0;
		$agent_id = '';
		$query = AgentAmount::where("id","!=",NULL);
		if(Auth::user()->role_id == '3')
		{
			$agent_id  = Auth::user()->id;
			$query->where('agent_id', '=', Auth::user()->id);
		}
		else
		{
			if(isset($data['agent_id_select']) && !empty($data['agent_id_select'])) {
				$agent_id  = $data['agent_id_select'];
					$query->where('agent_id', '=', $data['agent_id_select']);
					$s = 1;
			}
		}
		
		if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = date('Y-m-d', strtotime($data['from_date']));
			$endDate = date('Y-m-d', strtotime($data['to_date']));
			 $query->whereDate('date_of_receipt', '>=', $startDate);
			 $query->whereDate('date_of_receipt', '<=', $endDate);
		$s = 1;
		if($agent_id!=''){
		$payment = AgentAmount::where('agent_id',  $agent_id)->whereDate('date_of_receipt', '<=', $startDate)->where("transaction_type","Payment")->sum('amount');
		$receipt = AgentAmount::where('agent_id',  $agent_id)->whereDate('date_of_receipt', '<=', $startDate)->where("transaction_type","Receipt")->sum('amount');
		$openingBalance = $receipt - $payment;
		} else {
			$payment = AgentAmount::whereDate('date_of_receipt', '<=', $startDate)->where("transaction_type","Payment")->sum('amount');
		$receipt = AgentAmount::whereDate('date_of_receipt', '<=', $startDate)->where("transaction_type","Receipt")->sum('amount');
		$openingBalance = $receipt - $payment;
		}
	
		}
		
		$openingBalance = number_format($openingBalance,2, '.', '');
		
		if($s == 1){	
        $records = $query->orderBy('created_at', 'DESC')->get();
		}
		else
		{
		$records = AgentAmount::where('id','=', null)->orderBy('created_at', 'DESC')->get();	
		}
		
		return Excel::download(new AgentLedgerExport($records,$openingBalance), 'agent_ledger_export_records'.date('d-M-Y s').'.csv');

    }
	
	public function voucherActivtyCanceledReport(Request $request)
    {
		$this->checkPermissionMethod('list.ActivityCanceledReport');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		$supplier_ticket = User::where("service_type",'Ticket')->orWhere('service_type','=','Both')->get();
		$supplier_transfer = User::where("service_type",'Transfer')->orWhere('service_type','=','Both')->get();
		
		$query = VoucherActivity::where('id','!=', null);
		
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				if($data['booking_type'] == 2) {
				 $query->whereDate('tour_date', '>=', $startDate);
				 $query->whereDate('tour_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
				 $query->where('canceled_date', '>=', $startDate);
				 $query->where('canceled_date', '<=', $endDate);
				}
				}
			}
        if(isset($data['reference']) && !empty($data['reference'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['reference'] . '%');
			});
		}
		
		$query->where('status', '=', 1);
			
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		
        return view('reports.activity-canceled-report', compact('records','voucherStatus','supplier_ticket','supplier_transfer'));

    }
	
	public function voucherActivtyCanceledReportExportExcel(Request $request)
    {
		$this->checkPermissionMethod('list.ActivityCanceledReport');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		
		$query = VoucherActivity::where('id','!=', null);
		
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				if($data['booking_type'] == 2) {
				 $query->whereDate('tour_date', '>=', $startDate);
				 $query->whereDate('tour_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
				 $query->where('canceled_date', '>=', $startDate);
				 $query->where('canceled_date', '<=', $endDate);
				}
				}
			}
        if(isset($data['reference']) && !empty($data['reference'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['reference'] . '%');
			});
		}
		
		$query->where('status', '=', 1);
			
        $records = $query->orderBy('created_at', 'DESC')->get();
       return Excel::download(new VoucherActivityCancelExport($records), 'voucher_activity_cancel_records'.date('d-M-Y s').'.csv');

    }
	
	public function activityRefundSave(Request $request)
    {
		$data = $request->all();
		
		$totalPrice = 0;
		$tkt = 0;
		$record = VoucherActivity::where("id",$data['id'])->where('status', '=', 1)->first();
		$price = PriceHelper::getRefundAmountAfterCancellation($record->id);
		$tktPrice = $price['refund_tkt_priceAfDis'];
		$trnsPrice = $price['refund_trns_priceAfDis'];
		if($data['inputname'] == 'refund_amount_tkt'){
			$totalPrice = $tktPrice;
			$tkt = 1;
		} elseif($data['inputname'] == 'refund_amount_trans'){
			$totalPrice = $trnsPrice;
			$tkt = 2;
		}
		
		/* if($data['val'] <= $totalPrice){ */
				if(!empty($record)){
				if($tkt==1){
					$record->refund_amount_tkt = $data['val'];
				} elseif($tkt==2){
					$record->refund_amount_trans = $data['val'];
				}
				
				
				$record->refund_by = Auth::user()->id;
				$record->save();
				$response[] = array("status"=>1);
			
			/* }
			else{
			$response[] = array("status"=>3);
			} */
			
		}
		else{
			$response[] = array("status"=>4);
		}
		
        return response()->json($response);
	}
	
	public function activityFinalRefundSave(Request $request)
    {
		$data = $request->all();
		$id = $data['id'];
		$tktPrice = $data['trans'];
		$trnsPrice = $data['tkt'];
		$totalPrice = 0;
		$tkt = 0;
		$record = VoucherActivity::where("id",$id)->where('status', '=', 1)->first();
		
		
		
			if(!empty($record)){
			$record->status = 2;
			$record->refund_amount_tkt = $tktPrice;
			$record->refund_amount_trans = $trnsPrice;
			$record->refund_by = Auth::user()->id;
			$record->save();
			
			$totalPrice = $tktPrice + $trnsPrice;
			$voucher = Voucher::where('id',$record->voucher_id)->select(['agent_id','vat_invoice','invoice_number'])->first();
			$agent = User::find($voucher->agent_id);
			if(!empty($agent))
			{
				if($totalPrice > 0){
				$agent->agent_amount_balance += $totalPrice;
				$agent->save();
				
				$agentAmount = new AgentAmount();
				$agentAmount->agent_id = $agent->id;
				$agentAmount->amount = $totalPrice;
				$agentAmount->date_of_receipt = date("Y-m-d");
				$agentAmount->transaction_type = "Receipt";
				$agentAmount->role_user = 3;
				$agentAmount->transaction_from = 4;
				$agentAmount->created_by = Auth::user()->id;
				$agentAmount->updated_by = Auth::user()->id;
				$agentAmount->receipt_no = $voucher->invoice_number;
				$agentAmount->is_vat_invoice = $voucher->vat_invoice;
				$agentAmount->save();
				}
				
				return redirect()->back()->with('success', 'Activity Canceled Successfully.');
			}else{
			return redirect()->back()->with('error', 'Agent Not Found.');
			}
			
			}
			else{
			return redirect()->back()->with('error', 'Voucher Not Found.');
			}
			
		
        return response()->json($response);
	}
	

public function voucherActivtyRefundedReport(Request $request)
    {
		$this->checkPermissionMethod('list.ActivityRefundReport');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		$supplier_ticket = User::where("service_type",'Ticket')->orWhere('service_type','=','Both')->get();
		$supplier_transfer = User::where("service_type",'Transfer')->orWhere('service_type','=','Both')->get();
		
		$query = VoucherActivity::where('id','!=', null);
		
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				if($data['booking_type'] == 2) {
				 $query->whereDate('tour_date', '>=', $startDate);
				 $query->whereDate('tour_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
				 $query->where('canceled_date', '>=', $startDate);
				 $query->where('canceled_date', '<=', $endDate);
				}
				}
			}
        if(isset($data['reference']) && !empty($data['reference'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['reference'] . '%');
			});
		}
		
		$query->where('status', '=', 2);
			
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		
        return view('reports.activity-refunded-report', compact('records','voucherStatus','supplier_ticket','supplier_transfer'));

    }
	
	public function voucherActivtyRefundedReportExportExcel(Request $request)
    {
		$this->checkPermissionMethod('list.ActivityRefundReport');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		
		$query = VoucherActivity::where('id','!=', null);
		
		if(isset($data['booking_type']) && !empty($data['booking_type'])) {
			
			if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				if($data['booking_type'] == 2) {
				 $query->whereDate('tour_date', '>=', $startDate);
				 $query->whereDate('tour_date', '<=', $endDate);
				}
				elseif($data['booking_type'] == 1) {
				 $query->where('canceled_date', '>=', $startDate);
				 $query->where('canceled_date', '<=', $endDate);
				}
				}
			}
        if(isset($data['reference']) && !empty($data['reference'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['reference'] . '%');
			});
		}
		
		$query->where('status', '=', 2);
			
        $records = $query->orderBy('created_at', 'DESC')->get();
       return Excel::download(new VoucherActivityRefundExport($records), 'voucher_activity_refund_records'.date('d-M-Y s').'.csv');

    }
	
	public function ticketStockReport(Request $request)
    {
		$this->checkPermissionMethod('list.TicketStockReport');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$activities = Activity::where('status', 1)->orderBy('title', 'ASC')->get();
		$variants = Variant::where('status', 1)->orderBy('title', 'ASC')->get();
		$query = Ticket::with(['variant'])
            ->select(
                'activity_variant',
                'valid_till',
                DB::raw('SUM(CASE WHEN id != "0" AND ticket_for = "Adult" THEN 1 ELSE 0 END) as stock_uploaded_adult'),
                DB::raw('SUM(CASE WHEN id != "0" AND ticket_for = "Child" THEN 1 ELSE 0 END) as stock_uploaded_child'),
				DB::raw('SUM(CASE WHEN id != "0" AND ticket_for = "Both" THEN 1 ELSE 0 END) as stock_uploaded_both'),
                DB::raw('SUM(CASE WHEN ticket_generated = "1" AND ticket_for = "Adult" THEN 1 ELSE 0 END) as stock_allotted_adult'),
                DB::raw('SUM(CASE WHEN ticket_generated = "1" AND ticket_for = "Child" THEN 1 ELSE 0 END) as stock_allotted_child'),
				DB::raw('SUM(CASE WHEN ticket_generated = "1" AND ticket_for = "Both" THEN 1 ELSE 0 END) as stock_allotted_both'),
                DB::raw('SUM(CASE WHEN ticket_generated = "0" AND ticket_for = "Adult" THEN 1 ELSE 0 END) as stock_left_adult'),
                DB::raw('SUM(CASE WHEN ticket_generated = "0" AND ticket_for = "Child" THEN 1 ELSE 0 END) as stock_left_child'),
				DB::raw('SUM(CASE WHEN ticket_generated = "0" AND ticket_for = "Both" THEN 1 ELSE 0 END) as stock_left_both')
            );
		if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = date("Y-m-d",strtotime($data['from_date']));
			$endDate =  date("Y-m-d",strtotime($data['to_date']));
				 $query->whereDate('valid_till', '>=', $startDate);
				 $query->whereDate('valid_till', '<=', $endDate);
		}
		
		if(isset($data['ticket_no']) && !empty($data['ticket_no'])) {
				$query->where('ticket_no', 'like', '%' . $data['ticket_no']);
		}

		if(isset($data['serial_number']) && !empty($data['serial_number'])) {
			$query->where('serial_number', 'like', '%' . $data['serial_number']);
	}

		
		if (isset($data['activity_variant']) && !empty($data['activity_variant'])) {
				 $query->where('activity_variant',  $data['activity_variant']);
		}
				
            $query->groupBy('activity_variant', 'valid_till');
           $records = $query->paginate($perPage);
			
		
	
		return view('reports.ticket-report', compact('records','variants'));
	}
	
	public function ticketStockReportExportExcel(Request $request)
    {
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$variants = Variant::where('status', 1)->orderBy('title', 'ASC')->get();
		$query = Ticket::with(['variant'])
            ->select(
                'activity_variant',
                'valid_till',
                DB::raw('SUM(CASE WHEN id != "0" AND ticket_for = "Adult" THEN 1 ELSE 0 END) as stock_uploaded_adult'),
                DB::raw('SUM(CASE WHEN id != "0" AND ticket_for = "Child" THEN 1 ELSE 0 END) as stock_uploaded_child'),
				DB::raw('SUM(CASE WHEN id != "0" AND ticket_for = "Both" THEN 1 ELSE 0 END) as stock_uploaded_both'),
                DB::raw('SUM(CASE WHEN ticket_generated = "1" AND ticket_for = "Adult" THEN 1 ELSE 0 END) as stock_allotted_adult'),
                DB::raw('SUM(CASE WHEN ticket_generated = "1" AND ticket_for = "Child" THEN 1 ELSE 0 END) as stock_allotted_child'),
				DB::raw('SUM(CASE WHEN ticket_generated = "1" AND ticket_for = "Both" THEN 1 ELSE 0 END) as stock_allotted_both'),
                DB::raw('SUM(CASE WHEN ticket_generated = "0" AND ticket_for = "Adult" THEN 1 ELSE 0 END) as stock_left_adult'),
                DB::raw('SUM(CASE WHEN ticket_generated = "0" AND ticket_for = "Child" THEN 1 ELSE 0 END) as stock_left_child'),
				DB::raw('SUM(CASE WHEN ticket_generated = "0" AND ticket_for = "Both" THEN 1 ELSE 0 END) as stock_left_both')
            );
		if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = date("Y-m-d",strtotime($data['from_date']));
			$endDate =  date("Y-m-d",strtotime($data['to_date']));
				 $query->whereDate('valid_till', '>=', $startDate);
				 $query->whereDate('valid_till', '<=', $endDate);
		}
		
		if (isset($data['activity_id']) && !empty($data['activity_id'])) {
				 $query->where('activity_id',  $data['activity_id']);
		}
		
		if (isset($data['activity_variant']) && !empty($data['activity_variant'])) {
				 $query->where('activity_variant',  $data['activity_variant']);
		}
				
            $query->groupBy('activity_variant', 'valid_till');
           $records = $query->get();
			
		
	 return Excel::download(new TicketStockExport($records), 'ticket_stock_records'.date('d-M-Y s').'.csv');
	}
   
   
   public function voucherActivityReport(Request $request)
    {
		$this->checkPermissionMethod('list.voucherActivityReport');
		$data = $request->all();
		//$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$perPage = "1000";
		$voucherStatus = config("constants.voucherStatus");
		$supplier_ticket = User::where("service_type",'Ticket')->orWhere('service_type','=','Both')->get();
		$supplier_transfer = User::where("service_type",'Transfer')->orWhere('service_type','=','Both')->get();
		
		$query = VoucherActivity::where('id','!=', null);
		
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
				 $q->whereDate('booking_date', '>=', $startDate);
				 $q->whereDate('booking_date', '<=', $endDate);
				});
		
				}
				}
			}
        if(isset($data['vouchercode']) && !empty($data['vouchercode'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['vouchercode']);
			});
		}
		if(isset($data['invoicecode']) && !empty($data['invoicecode'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('invoice_number', 'like', '%' . $data['invoicecode']);
			});
		}
		if(isset($data['booking_status']) && !empty($data['booking_status'])) {
		$query->whereHas('voucher', function($q) use ($data) {
			$statuses = is_array($data['booking_status']) ? $data['booking_status'] : [$data['booking_status']];
				$q->whereIn('status_main', $statuses);
		});
		}else {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('status_main','5');
			});
		}
		$agent_id = '';
		if(isset($data['agent_id_select']) && !empty($data['agent_id_select'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$agent_id  = $data['agent_id_select'];
				$q->where('agent_id', '=', $data['agent_id_select']);
			});
		}
		
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		//$records = $query->orderBy('created_at', 'DESC')->get();
		$agetid = '';
		$agetName = '';
		
		if(old('agent_id')){
		$agentTBA = User::where('id', old('agent_id_select'))->where('status', 1)->first();
		$agetid = $agentTBA->id;
		$agetName = $agentTBA->company_name;
		}
		
        return view('reports.invoice-report', compact('records','voucherStatus','supplier_ticket','supplier_transfer','agetid','agetName'));

    }
	
	 public function voucherActivityReportExcelReport(Request $request)
    {
		$this->checkPermissionMethod('list.voucherActivityReport');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$voucherStatus = config("constants.voucherStatus");
		$supplier_ticket = User::where("service_type",'Ticket')->orWhere('service_type','=','Both')->get();
		$supplier_transfer = User::where("service_type",'Transfer')->orWhere('service_type','=','Both')->get();
		
		$query = VoucherActivity::where('id','!=', null);
		
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
				 $q->whereDate('booking_date', '>=', $startDate);
				 $q->whereDate('booking_date', '<=', $endDate);
				});
		
				}
				}
			}
			if(isset($data['vouchercode']) && !empty($data['vouchercode'])) {
				$query->whereHas('voucher', function($q)  use($data){
					$q->where('code', 'like', '%' . $data['vouchercode']);
				});
			}
			if(isset($data['invoicecode']) && !empty($data['invoicecode'])) {
				$query->whereHas('voucher', function($q)  use($data){
					$q->where('invoice_number', 'like', '%' . $data['invoicecode']);
				});
			}
		if(isset($data['booking_status']) && !empty($data['booking_status'])) {
		$query->whereHas('voucher', function($q) use ($data) {
			$statuses = is_array($data['booking_status']) ? $data['booking_status'] : [$data['booking_status']];
				$q->whereIn('status_main', $statuses);
		});
		}else {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('status_main','5');
			});
		}
		if(isset($data['agent_id_select']) && !empty($data['agent_id_select'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$agent_id  = $data['agent_id_select'];
				$q->where('agent_id', '=', $data['agent_id_select']);
			});
		}
		$records = $query->orderBy('created_at', 'DESC')->get();
		return Excel::download(new InvoiceReportExport($records), 'invoice_report'.date('d-M-Y s').'.csv');

    }
	
	
	public function voucherHotelReport(Request $request)
    {
		$this->checkPermissionMethod('list.voucherHotelReport');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$twoDaysAgo = date("Y-m-d", strtotime(date("Y-m-d") . " -2 days"));
		$supplier_ticket = User::where("service_type",'Ticket')->orWhere('service_type','=','Both')->get();
		
		$query = VoucherHotel::where('id','!=', null);
		
		$query->whereHas('voucher', function($q)  use($data,$twoDaysAgo){
				$q->whereIn('status_main',[4,5]);
				$q->orderBy('booking_date', 'DESC');
			});
		$query->whereDate('check_in_date', '>=', $twoDaysAgo);
		$records = $query->get();
        return view('reports.voucher_hotel_report', compact('records'));

    }
}

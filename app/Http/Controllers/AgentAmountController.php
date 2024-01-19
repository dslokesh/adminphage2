<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Models\AgentAmount;
use DB;
use SiteHelpers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AgentAmountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$this->checkPermissionMethod('list.agentamount');
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$data = $request->all();
		$query = AgentAmount::with('agent')->whereIn('transaction_from',[1,6]);
		if (isset($data['agent_id_select']) && !empty($data['agent_id_select'])) {
            $query->where('agent_id', $data['agent_id_select']);
        }
		if (isset($data['receipt_no']) && !empty($data['receipt_no'])) {
            $query->where('receipt_no', 'like', '%' . $data['receipt_no'] . '%');
        }
		if (isset($data['amount']) && !empty($data['amount'])) {
            $query->where('amount', $data['amount']);
        }
		if (isset($data['date_of_receipt']) && !empty($data['date_of_receipt'])) {
            $query->whereDate('date_of_receipt', $data['date_of_receipt']);
        }
		if (isset($data['transaction_type']) && !empty($data['transaction_type'])) {
            $query->where('transaction_type', $data['transaction_type']);
        }
		
		$agetid = '';
		$agetName = '';
		
		if(old('agent_id')){
		$agentTBA = User::where('id', old('agent_id_select'))->where('status', 1)->first();
		$agetid = $agentTBA->id;
		$agetName = $agentTBA->company_name;
		}
		
		$records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
        return view('agentamounts.index', compact('records','agetid','agetName'));

    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$this->checkPermissionMethod('list.agentamount');
        return view('agentamounts.create');
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
            'agent_id'=>'required',
			'amount'=>'required',
			'date_of_receipt'=>'required',
        ], [
			
		]);
		
		
		$date_of_receipt = $request->input('date_of_receipt'); 
		$agent = User::find($request->input('agent_id_select'));
        $record = new AgentAmount();
        $record->agent_id = $request->input('agent_id_select');
		$record->amount = $request->input('amount');
		$record->date_of_receipt = $date_of_receipt;
		$record->transaction_type = $request->input('transaction_type');
		$record->transaction_from = $request->input('transaction_from');
		$record->role_user = $agent->role_id;
		$record->remark = $request->input('remark');
        $record->is_vat_invoice = $request->input('is_vat_invoice');
		$record->created_by = Auth::user()->id;
		$record->updated_by = Auth::user()->id;
		
        
		
		
		//if(Auth::user()->role_id == '3'){
			if(($request->input('transaction_type') == "Receipt"))
			{
				$agent->agent_amount_balance += $request->input('amount');
				$agent->save();
				
				$record->save();
				$receipt_no = 'A-'.date("Y")."-00".$record->id;
				$recordUser = AgentAmount::find($record->id);
				$recordUser->receipt_no = $receipt_no;
				$recordUser->save();
			}else if(($request->input('transaction_type') == "Payment"))
			{
				if($agent->agent_amount_balance >= $request->input('amount'))
                {
                    $agent->agent_amount_balance -= $request->input('amount');
                    $agent->save();
                    
                    $record->save();
                    $receipt_no = 'A-'.date("Y")."-00".$record->id;
                    $recordUser = AgentAmount::find($record->id);
                    $recordUser->receipt_no = $receipt_no;
                    $recordUser->save();
				}
				else{
					return redirect()->route('agentamounts.index')->with('error', 'Agency amount cannot be set to 0.');
				}
			}
		//}
		
		
        return redirect()->route('agentamounts.index')->with('success', 'Data Created Successfully.');
		
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show(Voucher $voucher)
    {
		//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       //
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
      //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Voucher  $Voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       //
    }
	
}

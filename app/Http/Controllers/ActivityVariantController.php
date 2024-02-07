<?php
namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Variant;
use App\Models\ActivityVariant;
use App\Models\VariantPrice;
use DB;
use Image;
use File;

class ActivityVariantController extends Controller
{
    
	 
    public function index(Request $request)
    {
		//$this->checkPermissionMethod('list.activity');
        $data = $request->all();
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
        $query = ActivityVariant::with(['activity','variant'])->where('id','!=','');
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		//dd($records);
        return view('activity_variants.index', compact('records'));
    }


  public function create(Request $request)
    {
		//$this->checkPermissionMethod('list.activity');
        $data = $request->all();
		$activities = Activity::where('status',1)->get();
		$variants = Variant::where('status',1)->where('is_price',1)->get();
		//dd($records);
        return view('activity_variants.create', compact('activities','variants'));
    }
	
	public function store(Request $request)
	{
    $request->validate([
        'code' => 'required',
        'activity_id' => 'required',
        'variant_id' => 'required_if:activity_id,1', 
        'variant_id.*' => 'exists:variants,id',
    ], [
        'activity_id.required' => 'Please select activity.',
        'variant_id.required_if' => 'Please select at least one variant.',
        'variant_id.*.exists' => 'One or more selected variants do not exist in the database.',
    ]);

    $variantIds = $request->input('variant_id');
    $code = $request->input('code');
    $activityId = $request->input('activity_id');

    foreach ($variantIds as $variantId) {
        $record = ActivityVariant::create([
            'code' => $code,
            'activity_id' => $activityId,
            'variant_id' => $variantId,
        ]);

        $record->update(['ucode' => 'AV'.$record->id]);
    }

    return redirect('activity-variants')->with('success', 'Activity Variant(s) Created Successfully.');
	}
	
	public function destroy($id)
    {
        $record = ActivityVariant::find($id);
        $record->delete();
		return redirect('activity-variants')->with('success', 'Activity Variant Deleted Successfully.');
    }
}
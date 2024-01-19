<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;
use DB;
class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$this->checkPermissionMethod('list.city');
		$data = $request->all();
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$query = City::with('country','state');
		if(isset($data['name']) && !empty($data['name']))
        {
            $query->where('name','like', '%'.$data['name'].'%');
        }
		if(isset($data['country_id']) && !empty($data['country_id']))
        {
            $query->where('country_id',$data['country_id']);
        }
		if(isset($data['state_id']) && !empty($data['state_id']))
        {
            $query->where('state_id',$data['state_id']);
        }
		if(isset($data['status']) && !empty($data['status']))
        {
            if($data['status']==1)
            $query->where('status',1);
            if($data['status']==2)
            $query->where('status',0);
        }
		
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		 
		$countries = Country::where('status',1)->orderBy('name', 'ASC')->get();
		$states = State::where('status',1)->orderBy('name', 'ASC')->get();
        return view('cities.index', compact('records','countries','states'));

    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$this->checkPermissionMethod('list.city');
		 $countries = Country::where('status',1)->orderBy('name', 'ASC')->get();
        return view('cities.create',compact('countries'));
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
            'name'=>'required|max:255|sanitizeScripts',
			'state_id'=>'required',
			'country_id'=>'required'
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
			'country_id.required' => 'The country field is required.',
			'state_id.required' => 'The state field is required.',
		]);
		
		
		$recordData = City::where('state_id',$request->input('state_id'))->where('name',$request->input('name'))->count();
		if($recordData > 0)
		{
		return redirect()->back()->withInput()->with('error','The City name has already been taken in this country.');
		}
        $record = new City();
		$record->country_id = $request->input('country_id');
		$record->state_id = $request->input('state_id');
        $record->name = $request->input('name');
		$record->status = $request->input('status');
        $record->save();
        return redirect('cities')->with('success','City Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$this->checkPermissionMethod('list.city');
        $record = City::find($id);
		$countries = Country::where('status',1)->orderBy('name', 'ASC')->get();
		$states = State::where('status',1)->orderBy('name', 'ASC')->get();
        return view('cities.edit')->with('record',$record)->with('countries',$countries)->with('states',$states);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $request->validate([
            'name'=>'required|max:255|sanitizeScripts',
			'state_id'=>'required',
			'country_id'=>'required'
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
			'country_id.required' => 'The country field is required.',
			'state_id.required' => 'The state field is required.',
		]);
		
		$recordData = City::where('id','!=',$id)->where('state_id',$request->input('state_id'))->where('name',$request->input('name'))->count();
		if($recordData > 0)
		{
		return redirect()->back()->withInput()->with('error','The City name has already been taken in this state.');
		}
		
        $record = City::find($id);
		$record->country_id = $request->input('country_id');
		$record->state_id = $request->input('state_id');
        $record->name = $request->input('name');
		$record->status = $request->input('status');
        $record->save();
        return redirect('cities')->with('success','City Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = City::find($id);
        $record->delete();
        return redirect('cities')->with('success', 'City Deleted.');
    }
	
}

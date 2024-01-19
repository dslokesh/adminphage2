<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityVariant extends Model
{
    protected $table = "activity_variants";
	
	public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }
	
	public function variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id', 'id');
    }
	
	public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

   
	
   
}
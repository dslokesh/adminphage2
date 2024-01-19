<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = "tickets";
	
	public function activity()
    {
        return $this->belongsTo(Activity::class,'activity_id','id');
    }
	
	public function voucheractivity()
    {
        return $this->belongsTo(ActivityPrices::class,'activity_variant','u_code');
    }
	
	public function voucher()
    {
        return $this->belongsTo(Voucher::class,'voucher_id','id');
    }
	
	
	
}

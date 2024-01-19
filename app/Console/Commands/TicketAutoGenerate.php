<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Voucher;
use App\Models\User;
use App\Models\VoucherActivity;
use App\Models\TicketLog;
use App\Models\Ticket;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use SiteHelpers;

class TicketAutoGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ticketAutoGenerate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ticket Auto Generated Successfully';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
		$voucherActivities = VoucherActivity::with("activity")->where("ticket_generated","0")->where("status","3")->whereHas('activity', function ($query)  {
           $query->where('entry_type',  "Ticket Only");
       })->get();
	   
	   $totalprice =0;
		foreach($voucherActivities as $voucherActivity){
			
		$adult = $voucherActivity->adult;
		$child = $voucherActivity->child;
		$totalTicketNeed = $adult+$child;
		$countTotalTicketNeed = $totalTicketNeed;
		$countTotalTicketNeed = $totalTicketNeed;
		//$ticketQuery = Ticket::where('ticket_generated','0')->where('activity_id',$voucherActivity->activity_id)->where('activity_variant',$voucherActivity->variant_unique_code)->whereDate('valid_from', '<=',$voucherActivity->tour_date)->whereDate('valid_till', '>=',$voucherActivity->tour_date)->whereDate('tour_date', '>=',date("Y-m-d"))->orderBy("valid_till","ASC");
		
		$ticketQuery = Ticket::where('ticket_generated','0')->where('activity_id',$voucherActivity->activity_id)->where('activity_variant',$voucherActivity->variant_unique_code)->whereDate('valid_from', '<=',$voucherActivity->tour_date)->whereDate('valid_till', '>=',$voucherActivity->tour_date)->orderBy("valid_till","ASC");
		
		$totalTickets =$ticketQuery->get();
		$totalTicketCount =$totalTickets->count();
		$tcArray = [];
		if($totalTicketCount >= $totalTicketNeed)
		{
			foreach($totalTickets as $ticket){
				if(($ticket->ticket_for == 'Adult') && ($adult > 0)){
					$tcArray[$ticket->id] = $ticket->id;
					$adult--;
					$totalTicketNeed--;
				} elseif(($ticket->ticket_for == 'Child') && ($child > 0)){
					$tcArray[$ticket->id] = $ticket->id;
					$child--;
					$totalTicketNeed--;
				} elseif(($ticket->ticket_for == 'Both') && ($totalTicketNeed > 0)){
					// Check if the 'Both' ticket is for an adult or child
					if ($adult > 0) {
						$tcArray[$ticket->id] = $ticket->id;
						$adult--;
					} elseif ($child > 0) {
						$tcArray[$ticket->id] = $ticket->id;
						$child--;
					}
					$totalTicketNeed--;
				}
			}
			
			
			if(($totalTicketNeed == 0) && (count($tcArray) == $countTotalTicketNeed)){
				$tcCountEx = Ticket::where("voucher_id",'=',$voucherActivity->voucher_id)->where("voucher_activity_id",'=',$voucherActivity->id)->count();
				if($tcCountEx == 0){
				foreach($tcArray as $ta){
					$voucherCheck = Voucher::find($voucherActivity->voucher_id);
					if($voucherCheck->booking_date >= date("Y-m-d")){
						$tc = Ticket::find($ta);
						$tc->voucher_activity_id = $voucherActivity->id;
						$tc->ticket_generated = 1;
						$tc->ticket_generated_by = Auth::user()->id;
						$tc->generated_time = date("d-m-Y h:i:s");
						$tc->voucher_id = $voucherActivity->voucher_id;
						$tc->save();
					}
				}
				
				$voucher = Voucher::find($voucherActivity->voucher_id);
				//$agentsupplierId = '947d43d9-c999-446c-a841-a1aee22c7257';
				//$priceCal = SiteHelpers::getActivityPriceSaveInVoucherActivity("Ticket Only",$voucherActivity->activity_id,$agentsupplierId,$voucher,$voucherActivity->variant_unique_code,$voucherActivity->adult,$voucherActivity->child,$voucherActivity->infant,$voucherActivity->discount);
				//$totalprice = $priceCal['totalprice'];
				
				$voucherActivity->ticket_generated = 1;
				//$voucherActivity->supplier_ticket = $agentsupplierId;
				//$voucherActivity->actual_total_cost = $totalprice;
				$voucherActivity->status = 4;
				$voucherActivity->save();
				}
			}
			
				$log = new TicketLog();
				$log->total_record = $countTotalTicketNeed;
				$log->save();
					
		}
	}
		
	$this->line('Ticket Auto Generated Successfully.');
	exit;
    }
}

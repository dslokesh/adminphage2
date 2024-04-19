<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="initial-scale=1.0"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="format-detection" content="telephone=no"/>
<title>Ticket</title>

<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700&subset=latin,cyrillic,greek" rel="stylesheet" type="text/css">
<style>
body
{
  font-size: 10pt;
}
body p
{
  font-size: 8pt;
}
.col-6 {
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
}
</style>
</head>
  <body  style=" width:100%; height:100%;">
  @foreach($tickets as $ticket)
  <div style = "display:block; clear:both; page-break-after:always;"></div>
  <div class="width:100%; padding: 10px 0px;">
            <div style="width: 35%;float: left;">
                @if(file_exists(public_path('uploads/variants/'.$ticket->variant->brand_logo)) && !empty($ticket->variant->brand_logo))
                  <img src="{{asset('uploads/variants/thumb/'.$ticket->variant->brand_logo)}}" style="max-height: 150px;max-width: 150px; display: block !important; height: auto; width: auto;" alt="logo-top" border="0" hspace="0" vspace="0" height="auto">
                  @else
                  {{-- Code to show a placeholder or alternate image --}}
                  <img src="{{ asset('uploads/variants/thumb/no-image.png') }}" style="max-width: 200px;width: 200px;height: 150px" alt="no-image">
                  @endif
            </div>
            <div style="width: 55%;float: right;margin-top: 15px;;padding:15px 10px 0px 10px;text-align: right;">
               <h3 style="margin:0px;">This is your E-Ticket.</h3>
               <p>This ticket is non refundable , non transferable and Void if altered.</p>
            </div>
             
          </div>
          <div style="clear:both; width: 100%;height: 10px;border-bottom: 2px #000 solid;">&nbsp;</div>
      <div style="width: 100%;margin-top: 10px;">
          
          <div style="width:100%; padding: 10px 0px;">
             <div style="width: 70%;float: left;background-color: #e4f2fd;text-align:center;border-radius:5px;">
                            <table class="table table-condensed table-striped" cellspacing="0" cellpadding="4px">
                                <thead>
								 <tr >
                                    <td style="text-align: left;width:200px">
                                      Tour Name
                                    </td>
                                    <td style="text-align: left;width:60%">
									: {{ $voucherActivity->variant_name }}
                                    </td>
                                   </tr>
                                  <tr >
                                    <td style="text-align: left;width:200px">
                                      Guest Name
                                    </td>
                                   <td style="text-align: left;width:60%">
									: {{(empty($voucher->guest_name))?$voucher->agent->name:$voucher->guest_name}}
                                    </td>
                                   </tr>
                                   @if($ticket->ticket_for != 'Both')
                                   <tr >
                   <td style="text-align: left;width:200px">
                                       Ticket Type
                                    </td>
                                    <td style="text-align: left;width:60%">
                                    : {{$ticket->ticket_for}} 
                                    </td>
									 </tr>
								   @endif
								   <tr >
									<td style="text-align: left;width:200px">
                                       Travel Date
                                    </td>
                                    <td style="text-align: left;width:60%">
									: {{ $voucherActivity->tour_date ? date(config('app.date_format'),strtotime($voucherActivity->tour_date)) : null }}
                                    </td>
                                   </tr>
									 
									  <tr >
                    <td style="text-align: left;width:200px">
                                       Validity
                                    </td>
                                    <td style="text-align: left;width:60%">
                                     : {{ $ticket->valid_till ? date(config('app.date_format'),strtotime($ticket->valid_till)) : null }}
                                    </td>
									 </tr>
								   <tr>
								<td style="text-align: left;width:200px">
                                      Confirmation ID 
                                    </td>
                                    <td style="text-align: left;width:60%">
                                    : {{ $voucher->code}}
                                    </td>
									 </tr>
                                </thead>
                               
                    <tr>
                    
                    </tr>
                  </table>
             </div>
			 <div style="width: 28%;float: right;text-align: center;">
			 {!! QrCode::size(100)->generate(trim($ticket->ticket_no)) !!}<br/>
			{{$ticket->ticket_no}} 
             </div>
          </div>
      </div>
      <div style="clear:both; width: 100%;height: 10px;border-bottom: 2px #000 solid;">&nbsp;</div>
      <div style="width: 98%;margin-top:10px;text-align:justify;" style="">
      @if(file_exists(public_path('uploads/variants/'.$ticket->variant->ticket_banner_image)) && !empty($ticket->variant->ticket_banner_image))
            <img src="{{asset('uploads/variants/'.$ticket->variant->ticket_banner_image)}}"  alt="" border="0" hspace="0" vspace="0" height="auto" style="max-width: 100%;width: 100%;height: auto;max-height: 250px;border-radius:5px;">
           
            @endif   
      <h3>General Rules and Regulations</h3>
						<p style="font-size: 9px!important;">{!! @$ticket->variant->terms_conditions !!}</p>
          
               @if(file_exists(public_path('uploads/variants/'.$ticket->variant->ticket_footer_image)) && !empty($ticket->variant->ticket_footer_image))
            <img src="{{asset('uploads/variants/'.$ticket->variant->ticket_footer_image)}}"  alt="" border="0" hspace="0" vspace="0" height="auto" style="max-width: 100%;width: 100%;height: auto;max-height: 250px;border-radius:5px;">
           
            @endif   
      </div>
     

      @endforeach
     
    </body>
</html>

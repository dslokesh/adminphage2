@extends('emails.layout')
@section('message')
<div style="width: 100%;margin: 20px 0px;padding: 0px 20px">
		<p>
			<strong>Hello,</strong>
		</p>
		<p>New Agency Registered.</p>
 
<p> Here are the details.</p>
 
<p>Agent Name: {{$technician_details['name']}}<br>
	Email: {{$technician_details['email']}}<br>
	Agency: {{$technician_details['company']}}<br></p>


 
	<p><strong>Thanks </strong></p><p><strong></br>Team Abatera B2B </strong></p>
	</div>
@endsection

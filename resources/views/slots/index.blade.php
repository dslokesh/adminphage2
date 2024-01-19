@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Slots</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
			<li class="breadcrumb-item"><a href="{{ route('variants.index') }}">Variants</a></li>
              <li class="breadcrumb-item active">Slots</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('variant.slots.save') }}" method="post" class="form">
    {{ csrf_field() }}
				<div class="row">
					<div class="col-md-12">
					  <div class="card card-primary">
						<div class="card-header">
						  <h3 class="card-title">Slots</h3>
						</div>
						<div class="card-body">
				 <table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th colspan="4"><h4 class="text-center">Variant : {{$variant->title}}</h4></th>
        </tr>
        <tr>
            <th>Slot Timing</th>
            <th>Ticket Only</th>
            <th>SIC Transfer</th>
            <th>PVT Transfer</th>
        </tr>
    </thead>
    <tbody>
   @foreach ($slots as $k => $record)
    <tr>
        <td>
            <input type="hidden" name="slot[{{$k}}][time]" value="{{$record}}">{{$record}}
        </td>
        <td>
            <input type="checkbox" name="slot[{{$k}}][to]" value="1" {{ (isset($dbSlot[$record]) && $dbSlot[$record]['ticket_only']==1) ? 'checked' : '' }}>
        </td>
        <td>
            <input type="checkbox" name="slot[{{$k}}][sic]" value="1" {{ (isset($dbSlot[$record]) && $dbSlot[$record]['sic']==1) ? 'checked' : '' }}>
        </td>
        <td>
            <input type="checkbox" name="slot[{{$k}}][pvt]" value="1" {{ (isset($dbSlot[$record]) && $dbSlot[$record]['pvt']==1) ? 'checked' : '' }}>
        </td>
    </tr>
@endforeach
        <input type="hidden" name="variant_id" value="{{$variant->id}}">
    </tbody>
</table>

			
			  
					</div>
			
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12 mb-2">
          <a href="{{ route('variants.index') }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-success float-right">Save</button>
        </div>
      </div>
    </form>
    </section>
    <!-- /.content -->
@endsection
@section('scripts')

@endsection
@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cancellation Chart</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('variants.index') }}">Variants</a></li>
              <li class="breadcrumb-item active">Cancellation Chart</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <form action="{{ route('variant.canellation.save') }}" method="post" class="form" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Cancellation Chart</h3>
                        </div>
                        <div class="card-body row">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Duration (Hours)</th>
                                        <th>Ticket (Refund Value) %</th>
                                        <th>Transfer (Refund Value) %</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
								<input type="hidden" name="varidid" value="{{ $varidid }}" />
								<input type="hidden" name="varidCode" value="{{ $variant->ucode }}" />
                                    @if($records->count() > 0)
                                        @foreach ($records as $key => $record)
										<tr>
											<td>
												<select name="duration[]" class="form-control" required>
													<option value="0-24" @if($record->duration =='0-24') {{'selected="selected"'}} @endif>0-24</option>
													<option value="24-48" @if($record->duration =='24-48') {{'selected="selected"'}} @endif>24-48</option>
													<option value="48+" @if($record->duration =='48+') {{'selected="selected"'}} @endif>48+</option>
												</select>
											</td>
											<td><input type="text" name="ticket_refund_value[]"  value="{{ $record->ticket_refund_value }}" class="form-control" placeholder="Ticket (Refund Value)" required /></td>
											<td><input type="text" name="transfer_refund_value[]" value="{{ $record->transfer_refund_value }}" class="form-control" placeholder="Transfer (Refund Value)" required /></td>
											@if($key == 0)
												 <td><button type="button" class="btn btn-success btn-sm add-more-row"><i class="fas fa-plus"></i></button></td>
											@endif
											@if($key > 0)
												<td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
											@endif
										</tr>
									@endforeach

                                    @else
                                        <tr>
                                            <td>
                                                <select name="duration[]" class="form-control" required>
                                                    <option value="0-24" @if(request('duration') =='0-24') {{'selected="selected"'}} @endif>0-24</option>
                                                    <option value="24-48" @if(request('duration') =='24-48') {{'selected="selected"'}} @endif>24-48</option>
                                                    <option value="48+" @if(request('duration') =='48+') {{'selected="selected"'}} @endif>48+</option>
                                                </select>
                                            </td>
                                            <td><input type="text" name="ticket_refund_value[]" value="" class="form-control" placeholder="Ticket (Refund Value)" required /></td>
                                            <td><input type="text" name="transfer_refund_value[]" value="" class="form-control" placeholder="Transfer (Refund Value)" required /></td>
                                            <td><button type="button" class="btn btn-success btn-sm add-more-row"><i class="fas fa-plus"></i></button></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 mb-3">
                    <a href="{{ route('variants.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" name="save" class="btn btn-primary float-right">Save</button>
                </div>
            </div>
        </form>
    </section>
    <!-- /.content -->
@endsection
@section('scripts')
    <!-- Script -->
    <script>
      document.addEventListener("DOMContentLoaded", function () {
    // Function to add a new row
    function addRow() {
        var tableBody = document.querySelector("#example1 tbody");
        // Check if the number of existing rows is less than 3 before inserting a new row
        if (tableBody.rows.length < 3) {
            var newRow = tableBody.insertRow(tableBody.rows.length);

            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);
            var cell4 = newRow.insertCell(3);

            cell1.innerHTML = '<select name="duration[]" class="form-control" required><option value="0-24" selected>0-24</option><option value="24-48">24-48</option><option value="48+">48+</option></select>';
            cell2.innerHTML = '<input type="text" name="ticket_refund_value[]" value="" class="form-control" placeholder="Ticket (Refund Value)" required />';
            cell3.innerHTML = '<input type="text" name="transfer_refund_value[]" value="" class="form-control" placeholder="Transfer (Refund Value)" required />';
            cell4.innerHTML = '<button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button>';

            // Add event listener for remove button
            cell4.querySelector(".remove-row").addEventListener("click", function () {
                tableBody.deleteRow(newRow.rowIndex);
            });
        }
    }

    // Add event listener for "Add More" button
    document.querySelector(".add-more-row").addEventListener("click", addRow);

    // Event delegation for remove buttons
    document.querySelector("#example1 tbody").addEventListener("click", function (event) {
        if (event.target.classList.contains("remove-row")) {
            var rowToRemove = event.target.closest("tr");
            rowToRemove.remove();
        }
    });
});

    </script>
@endsection

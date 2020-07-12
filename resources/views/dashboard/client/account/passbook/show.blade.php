@extends('layouts.app')

@section('content')

<section class="content-header">
  <h1>
    Client : {{$client->client_full_name}} Account : {{$account->slug}}

  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('dashboard.home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{route('dashboard.clients.list')}}"><i class="fa fa-dashboard"></i> Clients</a></li>
    <li><a href="{{route('dashboard.clients.accounts.list',['slug'=> $client->slug])}}"><i class="fa fa-dashboard"></i> Accounts</a></li>
    <li class="active">Passbook</li>
  </ol>
</section>
<!-- passbook list begin -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <!-- /.box-header -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">Passbook Entries</h3>
        </div>
        <div class="box-body table-responsive ">

          <table id="tablelist" class="display">
            <thead>
              <tr>
                <th>Start Date</th>
                <th>Next Date</th>
                <th>End Date</th>
                <th>Base Amount(₹)</th>
                <th>Interest Rate(%)</th>
                <th>Interest Amount(₹)</th>
                <th>Current Amount(₹)</th>
                <th>Total Amount(₹)</th>
                <th>Withdrawn Amount(₹)</th>
                <th>Withdrawn Date</th>
                <th>Penalty(₹)</th>
              </tr>
            </thead>

            @if($passbookEntries->count() > 0)
            <?php $i=0; ?>
            <tbody>
              @foreach($passbookEntries as $passbookEntry)
              <?php $i++; ?>

              <tr>
                <td>{{ $passbookEntry->start_date }}</td>
                <td>{{ $passbookEntry->next_date }}</td>
                <td>{{ $passbookEntry->end_date }}</td>
                <td>{{ $passbookEntry->base_amount }}</td>
                <td>{{ $passbookEntry->interest_rate }}</td>
                <td>{{ $passbookEntry->interest_amount }}</td>
                <td>{{ $passbookEntry->current_amount }}</td>
                <td>{{ $passbookEntry->total_amount }}</td>
                <td>{{ $passbookEntry->withdrawn_amount}}</td>
                <td>{{ $passbookEntry->withdrawn_date}}</td>
                <td>{{ $passbookEntry->penalty }}</td>
                </tr>

                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
              </tfoot>
              @else
              <tbody>
                <tr>

                  <th colspan="7" class="text-center">No passbook created yet</th>

                </tr>
              </tbody>
              @endif
            </table>

          </div>
          <!-- /.box-body -->
        </div>
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- account list end -->
@endsection
@section('scripts')
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script>

$(document).ready(function() {

  // DataTable
  var table = $('#tablelist').dataTable({
    "order": [],
    "autoWidth": true,
    columnDefs: [ { orderable: false, targets: [6,7] } ]
  });

} );
</script>
@stop

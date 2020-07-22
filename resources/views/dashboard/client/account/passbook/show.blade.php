@extends('layouts.app')

@section('content')

<section class="content-header">
  <h1>
    Client : {{$client->client_full_name}} | Account : {{\Carbon\Carbon::parse($account->start_date)->format('j F Y')}} to {{\Carbon\Carbon::parse($account->end_date)->format('j F Y')}}

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
          <div class="pull-right">
            <a data-toggle="modal" data-target="#customReport" title="Custom Report" class="btn btn-warning"><i class="fa fa-download"></i> Custom Report</a>
            <div class="modal modal-warning fade" id="customReport">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Custom Report: {{\Carbon\Carbon::parse($passbookOldest->date)->format('j F Y')}} to {{\Carbon\Carbon::parse($passbookLatest->date)->format('j F Y')}}</h4>
                    </div>
                    <div class="modal-body">
                      <form method="post" action="{{route('dashboard.clients.accounts.passbook.custom_passbook_pdf',['clientSlug' => $client->slug, 'accountSlug' => $account->slug])}}">
                        {{ csrf_field()}}
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label for="from_date">From Date<span style="color:red;">*</span></label>
                              <input type="date" id="from_date" name="from_date" class="form-control" value="{{old('from_date')}}" placeholder="Enter From Date" required>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label for="to_date">To Date<span style="color:red;">*</span></label>
                              <input type="date" id="to_date" name="to_date" class="form-control" value="{{old('to_date')}}" placeholder="Enter To Date" required>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-outline disw">Submit</button>
                    </div>
                      </form>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->
            <a href="{{route('dashboard.clients.accounts.passbook.full_passbook_pdf',['clientSlug' => $client->slug, 'accountSlug' => $account->slug])}}" class="btn btn-warning"><i class="fa fa-download"></i> Full Report</a>
          </div>
        </div>
        <div class="box-body table-responsive ">

          <table id="tablelist" class="display">
            <thead>
              <tr>
                <th>Date(Entry)</th>
                <th>Base Amount(₹)</th>
                <th>Tenure(months)</th>
                <th>Interest %</th>
                <th>Interest Amount(₹)</th>
                <th>Current Amount(₹)</th>
                <th>Total Amount(₹)</th>
                <th>Withdrawn Date</th>
                <th>Withdrawn Amount(₹)</th>
                <th>Penalty(₹)</th>
                <th>Referred By</th>
                <th>Commission Type</th>
                <th>Commission %</th>
                <th>Commision Amt(₹)</th>
                <th>Commission Total Amt(₹)</th>
              </tr>
            </thead>

            @if($passbookEntries->count() > 0)
            <?php $i=0; ?>
            <tbody>
              @foreach($passbookEntries as $passbookEntry)
              <?php $i++; ?>

              <tr>
                <td>{{ $passbookEntry->date }}</td>
                <td>{{ $passbookEntry->base_amount }}</td>
                <td>{{ $passbookEntry->tenure}}</td>
                <td>{{ $passbookEntry->interest_rate }}</td>
                <td>{{ $passbookEntry->interest_amount }}</td>
                <td>{{ $passbookEntry->current_amount }}</td>
                <td>{{ $passbookEntry->total_amount }}</td>
                <td>{{ $passbookEntry->withdrawn_date}}</td>
                <td>{{ $passbookEntry->withdrawn_amount}}</td>
                <td>{{ $passbookEntry->penalty }}</td>
                <td>{{ $passbookEntry->account->client->referred_by}}</td>
                <td>
                  @if($passbookEntry->account->commission_type == 1)
                   Monthly
                  @elseif($passbookEntry->account->commission_type == 2)
                   OneTime
                  @else
                   N.A
                  @endif
                </td>
                <td>{{ $passbookEntry->commission_percentage}}</td>
                <td>{{ $passbookEntry->commission_amount}}</td>
                <td>{{ $passbookEntry->commission_total_amount}}</td>
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
    columnDefs: [ { orderable: false, targets: [2,10] } ]
  });

} );
</script>
@stop

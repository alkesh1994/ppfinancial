@extends('layouts.app')

@section('content')

<section class="content-header">
  <h1>
    Elapsing Accounts List

  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('dashboard.home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{route('dashboard.clients.list')}}"><i class="fa fa-dashboard"></i> Clients</a></li>
    <li class="active">Accounts</li>
  </ol>
</section>
<!-- account list begin -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <!-- /.box-header -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">Elapsing Accounts List</h3>
        </div>
        <div class="box-body table-responsive ">

          <table id="tablelist" class="display">
            <thead>
              <tr>
                <th>Pay Date</th>
                <th>Name</th>
                <th>Phone No</th>
                <th>Interest Amount</th>
                <th>Days Left</th>
                <th>View</th>
              </tr>
            </thead>

            @if($accounts->count() > 0)
            <tbody>
              @foreach($accounts as $account)
              <?php
              $elapsingAccountNextDate = \Carbon\Carbon::parse($elapsingAccount->next_date)->subDays(1)->format('Y-m-d');
              $elapsingAccountCurrentDate = date("Y-m-d");
              $elapsingAccountNextDateTime = new DateTime($elapsingAccountNextDate);
              $elapsingAccountCurrentDateTime = new DateTime($elapsingAccountCurrentDate);
              $elapsingAccountInterval = $elapsingAccountNextDateTime->diff($elapsingAccountCurrentDateTime);
              $elapsingAccountDaysLeft = $elapsingAccountInterval->format('%a');
              ?>

              <tr>
                <td>{{\Carbon\Carbon::parse($account->next_date)->subDays(1)->format('Y-m-d')}}</td>
                <td>{{$account->client->client_full_name}}</td>
                <td>{{$account->client->client_phone_number}}</td>
                <td>{{$account->interest_amount}}</td>
                <td><span class="label label-success">{{$elapsingAccountDaysLeft}}</span></td>
                <td>
                  <a href="{{ route('dashboard.clients.accounts.passbook.show',['clientSlug'=> $account->client->slug,'accountSlug'=> $account->slug]) }}" title="Passbook"><span class="label label-success"><i class="glyphicon glyphicon-list-alt"></i></span></a>
                </td>
                </tr>

                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th>Pay Date</th>
                  <th>Name</th>
                  <th>Phone No</th>
                  <th>Interest Amount</th>
                  <th>Days Left</th>
                  <th></th>
                </tr>
              </tfoot>
              @else
              <tbody>
                <tr>

                  <th colspan="7" class="text-center">No elapsing accounts yet</th>

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
  // Setup - add a text input to each footer cell
  var set = $('#tablelist tfoot th');
  var length = set.length;
  $('#tablelist tfoot th').each(function (index,element) {
    if (index<(length-1)) {
      var title = $(this).text();
      $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    }

  } );

  // DataTable
  var table = $('#tablelist').dataTable({
    "order": [],
    "autoWidth": true,
    columnDefs: [ { orderable: false, targets: [2,4] } ]
  });

  // Apply the search
  table.columns().every( function () {
    var that = this;

    $( 'input', this.footer() ).on( 'keyup change clear', function () {
      if ( that.search() !== this.value ) {
        that
        .search( this.value )
        .draw();
      }
    } );
  } );
  $('#tablelist tfoot tr').appendTo('#tablelist thead');
} );
</script>
@stop

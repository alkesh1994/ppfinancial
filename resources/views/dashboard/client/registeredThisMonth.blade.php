@extends('layouts.app')

@section('content')

<section class="content-header">
  <h1>
    Clients Registered In {{\Carbon\Carbon::now()->format('F Y')}}

  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('dashboard.home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Clients</li>
  </ol>
</section>


<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <!-- /.box-header -->
      <div class="box box-primary">
        <div class="box-header">
          <div class="pull-right">
            <a href="{{route('dashboard.clients.create_client')}}" class="btn btn-warning"><i class="fa fa-plus-circle"></i> Create Client</a>
          </div>
        </div>
        <div class="box-body table-responsive ">

          <table id="tablelist" class="display">
            <thead>
              <tr>
                <th>Client Name</th>
                <th>Phone Number</th>
                <th>Bank Name</th>
                <th>Bank Branch</th>
                <th>Action</th>
              </tr>
            </thead>

            @if($clients->count() > 0)
            <?php $i=0; ?>
            <tbody>
              @foreach($clients as $client)
              <?php $i++; ?>

              <tr>
                <td>{{ $client->client_full_name }}</td>
                <td>{{ $client->client_phone_number }}</td>
                <td>{{ $client->client_bank_name }}</td>
                <td>{{ $client->client_bank_branch }}</td>
                <td>
                  <a href="{{ route('dashboard.clients.edit_client',['slug'=> $client->slug]) }}" title="Edit" target="_blank"><span class="label label-warning"><i class="glyphicon glyphicon-pencil"></i></span></a>
                  <a href="{{ route('dashboard.clients.accounts.list',['slug'=> $client->slug]) }}" title="Accounts" target="_blank"><span class="label label-success"><i class="glyphicon glyphicon-book"></i></span></a>
                  <a data-toggle="modal" data-target="#delete-client{{$i}}" title="Delete"><span class="label label-primary"><i class="glyphicon glyphicon-trash"></i></span></a>
                  <div class="modal modal-warning fade" id="delete-client{{$i}}">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Delete Client!!</h4>
                          </div>
                          <div class="modal-body">
                            <h4>Are you sure you want to delete this client?</h4>
                            <p>(This client will be moved to trashed)</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                            <a class="btn btn-outline" href="{{ route('dashboard.clients.delete_client',['id'=> $client->id]) }}">Yes Delete</a>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                  </td>
                </tr>

                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th>Client Name</th>
                  <th>Phone Number</th>
                  <th>Bank Name</th>
                  <th>Bank Branch</th>
                  <th></th>
                </tr>
              </tfoot>
              @else
              <tbody>
                <tr>

                  <th colspan="5" class="text-center">No Client registered this month</th>

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
  var table = $('#tablelist').DataTable({
    "order": [],
    columnDefs: [ { orderable: false, targets: [4] } ]
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

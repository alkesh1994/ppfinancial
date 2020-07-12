@extends('layouts.app')

@section('content')

<section class="content-header">
  <h1>
    Client : {{$client->client_full_name}}

  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('dashboard.home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{route('dashboard.clients.list')}}"><i class="fa fa-dashboard"></i> Clients</a></li>
    <li class="active">Accounts</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- account form begin -->
      <form role="form" method="post">
        {{ csrf_field()}}
        <!-- Personal Details begin -->
        <div class="box box-primary" style="padding-bottom:0px;margin-bottom:0px;">
          <div class="box-header with-border">
            <h3 class="box-title">Create Account</h3>
          </div>
          <div class="box-body">
            <input type="hidden" name="client_id" value="{{$client->id}}">
            <div class="row">
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="start_date">Start Date<span style="color:red;">*</span></label>
                  <input type="date" id="start_date" name="start_date" class="form-control" value="{{old('start_date')}}" placeholder="Enter Start Date">
                  <span data-name="start_date" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="amount_received">Amount Received<span style="color:red;">*</span></label>
                  <input type="number" id="amount_received" name="amount_received" class="form-control" value="{{old('amount_received')}}" placeholder="Enter Amount Received" onkeypress="updateAmounts()">
                  <span data-name="amount_received" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="tenure">Tenure</label>
                  <select class="form-control" id="tenure" name="tenure" onchange="updateAmounts()">
                    <option value="6">6 months</option>
                    <option value="12">1 year</option>
                  </select>
                  <span data-name="tenure" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-1">
                <div class="form-group">
                  <label for="interest_rate">Interest Rate %</label>
                  <select class="form-control" id="interest_rate" name="interest_rate" onchange="updateAmounts()">
                    <option value="1.5">1.5</option>
                    <option value="2">2</option>
                    <option value="2.5">2.5</option>
                    <option value="3">3</option>
                  </select>
                  <span data-name="interest_rate" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="total_amount">Total Amount</label>
                  <input type="text" id="total_amount" class="form-control" value="" placeholder="Total Amount" disabled>
                  <span data-name="total_amount" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-1">
                <div class="form-group">
                  <label for="commission_percentage">Commission %</label>
                  <select class="form-control" id="commission_percentage" name="commission_percentage" onchange="updateAmounts()">
                    <option value="0">N.A</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                  </select>
                  <span data-name="commission_percentage" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="commission_amount">Commission Amount</label>
                  <input type="text" id="commission_amount" class="form-control" value="{{old('commission_amount')}}" placeholder="Commission Amount" disabled>
                  <span data-name="commission_amount" class="error" style="color:red;"></span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Personal Details end -->
        <!-- Form submit begin -->
        <div class="row" style="padding-top:0px;margin-top:0px;">
          <div class="col-md-12">
            <!-- /.box-body -->
            <div class="text-center box-footer" style="padding-top:20px;">
              <button type="submit" name="action" class="btn btn-primary btn-lg dis" value="draft" style="  box-shadow: 2px 5px #888888;">Submit</button>
            </div>
          </div>
        </div>
        <!-- Form submit End -->
      </div>
    </form>
  </div>
</section>
<!-- account form end -->
<!-- account list begin -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <!-- /.box-header -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">Accounts List</h3>
        </div>
        <div class="box-body table-responsive ">

          <table id="tablelist" class="display">
            <thead>
              <tr>
                <th>StartDate</th>
                <th>End Date</th>
                <th>Amt Rcvd</th>
                <th>Tenure</th>
                <th>Interest Rate</th>
                <th>Total Amt</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>

            @if($accounts->count() > 0)
            <?php $i=0; ?>
            <tbody>
              @foreach($accounts as $account)
              <?php $i++; ?>

              <tr>
                <td>{{ $account->start_date }}</td>
                <td>{{ $account->end_date }}</td>
                <td>{{ $account->amount_received }} ₹</td>
                <td>{{ $account->tenure_display }}</td>
                <td>{{ $account->interest_rate}} %</td>
                <td>{{ $account->total_amount}} ₹</td>
                <td><button @if($account->active)class="btn btn-sm btn-flat btn-success"@else class="btn btn-sm btn-flat btn-danger"@endif >{{$account->status}}</button></td>
                <td>
                  <a href="{{ route('dashboard.clients.accounts.passbook.list',['clientSlug'=> $client->slug,'accountSlug'=> $account->slug]) }}" title="Passbook" target="_blank"><span class="label label-success"><i class="glyphicon glyphicon-list-alt"></i></span></a>
                  <a href="" title="Accounts" target="_blank"><span class="label label-primary"><i class="glyphicon glyphicon-book"></i></span></a>
                  <a data-toggle="modal" data-target="#delete-account{{$i}}" title="Delete"><span class="label label-danger"><i class="glyphicon glyphicon-trash"></i></span></a>
                  <div class="modal modal-danger fade" id="delete-account{{$i}}">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Delete Account!!</h4>
                          </div>
                          <div class="modal-body">
                            <h4>Are you sure you want to delete this account?</h4>
                            <p>(This account will be moved to trashed)</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                            <a class="btn btn-outline" href="{{ route('dashboard.clients.accounts.delete_account',['clientSlug'=> $client->slug,'accountId'=> $account->id]) }}">Yes Delete</a>
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
                  <th>StartDate</th>
                  <th>End Date</th>
                  <th>Amt Rcvd</th>
                  <th>Tenure</th>
                  <th>Interest Rate</th>
                  <th>Total Amt</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </tfoot>
              @else
              <tbody>
                <tr>

                  <th colspan="7" class="text-center">No account created yet</th>

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
<!-- create account -->
<script type="text/javascript">
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$('button[type=submit]').on('click', function () {

  var $this = $(this);

  var form=$this.closest('form'),error=form.find('span.error');

  error.map(function(elem){
    $(this).html("")
  })

  var formData = new FormData(form[0]);
  formData.append('total_amount',document.getElementById('total_amount').value);
  formData.append('commission_amount',document.getElementById('commission_amount').value);

  $.ajax({
    url: "{{route('dashboard.clients.accounts.store')}}",
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    beforeSend: function() {
      $(".dis").prop('disabled', true); // disable button
    },
    statusCode: {
      401: function() {
        window.location.replace("{{route('dashboard.home')}}");
      }
    },
    success: function(result)
    {

      window.location.replace("{{route('dashboard.clients.accounts.list',['slug' => $client->slug])}}");
    },
    error: function(error)
    {
      $(".dis").prop('disabled', false);
      var errors = jQuery.parseJSON(error.responseText);
      $.each(errors.errors,function(k,v){
        var errorEle = form.find('span[data-name="'+k+'"]');
        errorEle.text(v)
      });
    }
  });
});

</script>
<script type="text/javascript">
//dynamically update total amount
function updateAmounts() {

  var amount_received = +document.getElementById('amount_received').value;
  var interest_rate = +document.getElementById('interest_rate').value;
  var tenure = +document.getElementById('tenure').value;
  var commission_percentage = +document.getElementById('commission_percentage').value;

  var interest_amount = (amount_received * interest_rate)/100;

  var commission_amount = (amount_received * commission_percentage)/100;

  if(tenure === 6)
    var total_amount = amount_received + interest_amount * 6;

  if(tenure === 12)
    var total_amount = amount_received + (interest_amount * 12);

  document.getElementById('total_amount').value = total_amount;
  document.getElementById('commission_amount').value = commission_amount;
}
</script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script>

$(document).ready(function() {
  // Setup - add a text input to each footer cell
  var set = $('#tablelist tfoot th');
  var length = set.length;
  $('#tablelist tfoot th').each(function (index,element) {
    if (index<(length-2)) {
      var title = $(this).text();
      $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    }

  } );

  // DataTable
  var table = $('#tablelist').dataTable({
    "order": [],
    "autoWidth": true,
    columnDefs: [ { orderable: false, targets: [6,7] } ]
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

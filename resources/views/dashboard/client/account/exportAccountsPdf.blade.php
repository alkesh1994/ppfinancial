<!DOCTYPE html>
<html>
<head>
  <style>
  #customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }

  #customers td, #customers th {
    border: 1px solid #ddd;
    padding: 2px;
  }

  #customers tr:nth-child(even){background-color: #f2f2f2;}

  #customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
  }
  .container-fluid {
    padding: 0px;
    margin:0px;
  }
  .container{
    padding: 20px;
    border:2px;
  }
  .jumbotron{padding:2rem 1rem;
    margin-bottom:0;
    background-color:#e9ecef;
    border-radius:.3rem}
    @media (min-width:576px){.jumbotron{padding:0.5rem 2rem}
  }
  .jumbotron-fluid{padding-right:0;padding-left:0;border-radius:0}
</style>

</head>
<body>
  <div class="jumbotron">
    <div class="row">

      <div class="col-md-2">
      </div>

      <div class="col-md-8">
        <div class=""style="text-align:center">
          <img src="{{asset('images/ppflogo.png')}}" class="rounded" alt="pp finalcial solutions logo" width="100" height="80">
        </div>

        <p style="font-size:14px; text-align:center;"> <strong>Address:</strong> 510 Vision Vatika,Vitthalwadi, Akurdi,Pune 411035 </p>

        <div class="input-group mb-3" style="text-align:center;">
          <div class="input-group-prepend">
            <span class="input-group-text"><strong>Name:</strong> {{$client->client_full_name}}</span>

            <span class="input-group-text"><strong>Phone No.:</strong> {{$client->client_phone_number}}</span>

            <span class="input-group-text"><strong>Address:</strong> {{$client->client_permanent_address}}</span>
          </div>

        </div>

        <div class="input-group mb-3" style="text-align:center;">
          <div class="input-group-prepend">

            <span class="input-group-text"><strong>Bank:</strong> {{$client->client_bank_name}}</span>

            <span class="input-group-text"><strong>Account No:</strong> {{$client->client_bank_account_number}}</span>

            <span class="input-group-text"><strong>IFS Code:</strong> {{$client->client_bank_ifsc_code}}</span>
          </div>

        </div>

      </div>
    </div>

  </div>
  <div class="container-fluid">

    <p style="text-align:center;font-size:18px;"><strong>Accounts</strong></p>
    <table id="customers" style="font-size:10px;">
      <tr>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Amount Received</th>
        <th>Current Amount</th>
        <th>Tenure</th>
        <th>Interest Rate</th>
        <th>Total Amount</th>
        <th>Commission Type</th>
        <th>Status</th>
      </tr>
      @foreach($accounts as $account)
      <tr>
        <td>{{ $account->start_date }}</td>
        <td>{{ $account->end_date }}</td>
        <td>{{ $account->amount_received }}</td>
        <td>{{ $account->current_amount }}</td>
        <td>{{ $account->tenure_display }}</td>
        <td>{{ $account->interest_rate}} %</td>
        <td>{{ $account->total_amount}}</td>
        <td>{{ $account->commission_type_display}}</td>
        <td><button @if($account->active) style="color:green;" @else style="color:red;"@endif >{{$account->status}}</button></td>
      </tr>
      @endforeach
    </table>
  </div>
</body>
</html>

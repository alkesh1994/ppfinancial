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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>

  <div class="row">

    <div class="col-xs-3">
      <div style="text-align:center;">
        <img src="{{asset('images/ppflogo.png')}}" class="rounded" alt="pp financial solutions logo" width="100" height="80">
      </div>

      <p style="font-size:14px;text-align:center;"> <strong>Address:</strong> 510 Vision Vatika,Vitthalwadi, Akurdi,Pune 411035 </p>

    </div>

    <div class="col-xs-9">

      <div class="input-group mb-3" >
        <div class="input-group-prepend">
          <span class="input-group-text"><strong>Name:</strong> {{$client->client_full_name}}</span>&nbsp;&nbsp;&nbsp;&nbsp;

          <span class="input-group-text"><strong>Phone No.:</strong> {{$client->client_phone_number}}</span>
          <br>

          <span class="input-group-text" ><strong>Address:</strong> {{$client->client_permanent_address}}</span>
        </div>

      </div>
      <br> <br>

      <div class="input-group mb-3" >
        <div class="input-group-prepend">

          <span class="input-group-text"><strong>Bank Name:</strong> {{$client->client_bank_name}}</span>&nbsp;&nbsp;&nbsp;&nbsp;

          <span class="input-group-text"><strong>Account No:</strong> {{$client->client_bank_account_number}}</span>


        </div>

      </div>

      <div class="input-group mb-3" >
        <div class="input-group-prepend">

          <span class="input-group-text"><strong>IFS Code:</strong> {{$client->client_bank_ifsc_code}}</span> &nbsp;&nbsp;&nbsp;&nbsp;

          <span class="input-group-text"><strong>Period:</strong> {{\Carbon\Carbon::parse($account->start_date)->format('j F Y')}} to {{\Carbon\Carbon::parse($account->end_date)->format('j F Y')}}</span>

        </div>

      </div>



    </div>
  </div>
  <div class="container-fluid">

    <p style="text-align:center;font-size:18px;">------------ <strong>Passbook</strong> ------------</p>
    <span class="input-group-text">Base Amount : {{$account->amount_received}}</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="input-group-text">Tenure : {{$account->tenure_display}}</span>
    <table id="customers" style="font-size:10px;">
      <tr>
        <th>Date</th>
        <th>Interest %</th>
        <th>Interest Amt</th>
        <th>Current Amt</th>
        <th>Total Amt</th>
        <th>W/D Date</th>
        <th>W/D Amt</th>
        <th>Penalty</th>
        <th>Referred By</th>
        <th>Comm Type</th>
        <th>Comm %</th>
        <th>Comm Amt</th>
        <th>Comm Total Amt</th>
      </tr>
      @foreach($passbookEntries as $passbookEntry)
      <tr>
        <td>{{ $passbookEntry->date }}</td>
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
    </table>
  </div>
</body>
</html>

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
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
</style>
</head>
<body>
<h1>{{$client->client_full_name}}</h1>
<table id="customers">
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
      <td><button @if($account->active) style="color:green;" @else style="color:red;" @endif >{{$account->status}}</button></td>
      </tr>

      @endforeach
  </table>
</body>
</html>

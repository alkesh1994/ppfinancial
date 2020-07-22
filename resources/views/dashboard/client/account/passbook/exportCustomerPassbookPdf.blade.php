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
<h2>{{$reportType}}</h2>
<h5>{{$reportRange}}</h5>
  <table id="customers">
      <tr>
        <th>Date</th>
        <th>Base Amt</th>
        <th>Tenure</th>
        <th>Interest %</th>
        <th>Interest Amt</th>
        <th>Current Amt</th>
        <th>Total Amt</th>
        <th>W/D Date</th>
        <th>W/D Amt</th>
        <th>Penalty</th>
      </tr>
      @foreach($passbookEntries as $passbookEntry)
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
        </tr>
        @endforeach
    </table>
</body>
</html>

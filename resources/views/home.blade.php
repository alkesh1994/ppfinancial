@extends('layouts.app')

@section('content')
<section class="content-header">
  <h4>
    Welcome ,
    <small>{{Auth::user()->name}}!!</small>
  </h4>
  <ol class="breadcrumb">
    <li><a href="{{route('dashboard.home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
  </ol>
</section>
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-4 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>{{$totalClients->count()}}</h3>

          <p>Total clients</p>
        </div>
        <div class="icon">
          <i class="fa fa-taxi"></i>
        </div>
        <a href="{{route('dashboard.clients.list')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3>{{$thisMonthClients->count()}}</h3>

          <p>Clients registered in {{\Carbon\Carbon::now()->format('F Y')}}</p>
        </div>
        <div class="icon">
          <i class="fa fa-car"></i>
        </div>
        <a href="{{route('dashboard.clients.registered_this_month')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3>{{$thisMonthExpiringAccounts->count()}}</h3>

          <p>Accounts expiring in {{\Carbon\Carbon::now()->format('F Y')}}</p>
        </div>
        <div class="icon">
          <i class="fa fa-rupee"></i>
        </div>
        <a href="{{route('dashboard.clients.accounts.expiring_accounts_this_month')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->

  <div class="row">
    <!-- Recent Accounts -->
    <div class="col-md-6">

      <!-- TABLE: LATEST ORDERS -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Recent Accounts</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table id="example2" class="table no-margin">
              <thead>
                <tr>
                  <th>Start Date</th>
                  <th>Name</th>
                  <th>Phone No</th>
                  <th>Amount Received</th>
                  <th>Interest Rate</th>
                  <th>Tenure</th>
                  <th>View</th>
                </tr>
              </thead>
              <tbody>
                @if($recentAccounts->count() > 0)

                @foreach($recentAccounts as $recentAccount)
                <tr>
                  <td>{{$recentAccount->start_date}}</td>
                  <td>{{$recentAccount->client->client_full_name}}</td>
                  <td>{{$recentAccount->client->client_phone_number}}</td>
                  <td>{{$recentAccount->amount_received}}</td>
                  <td>{{$recentAccount->interest_rate}} %</td>
                  <td>{{$recentAccount->tenure_display}}</td>
                  <td>
                    <a href="{{ route('dashboard.clients.accounts.passbook.show',['clientSlug'=> $recentAccount->client->slug,'accountSlug'=> $recentAccount->slug]) }}"><span class="label label-primary"><i class="glyphicon glyphicon-eye-open"></i></span></a>
                  </td>
                </tr>
                @endforeach

                @else

                <tr>
                  <th colspan="5" class="text-center">No Recent Accounts</th>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
          <!-- /.table-responsive -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
    <!-- Expiring Accounts -->
    <div class="col-md-6">

      <!-- TABLE: LATEST ORDERS -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Expiring Accounts</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table id="example2" class="table no-margin">
              <thead>
                <tr>
                  <th>End Date</th>
                  <th>Name</th>
                  <th>Phone No</th>
                  <th>Days Left</th>
                  <th>View</th>
                </tr>
              </thead>
              <tbody>
                @if($expiringAccounts->count() > 0)

                @foreach($expiringAccounts as $expiringAccount)
                <?php
                $expiringAccountEndDate = $expiringAccount->end_date;
                $expiringAccountCurrentDate = date("Y-m-d");
                $expiringAccountEndDateTime = new DateTime($expiringAccountEndDate);
                $expiringAccountCurrentDateTime = new DateTime($expiringAccountCurrentDate);
                $expiringAccountInterval = $expiringAccountEndDateTime->diff($expiringAccountCurrentDateTime);
                $expiringAccountDaysLeft = $expiringAccountInterval->format('%a');
                ?>
                <tr>
                  <td>{{$expiringAccount->end_date}}</td>
                  <td>{{$expiringAccount->client->client_full_name}}</td>
                  <td>{{$expiringAccount->client->client_phone_number}}</td>
                  <td><span class="label label-success">{{$expiringAccountDaysLeft}}</span></td>
                  <td>
                    <a href="{{ route('dashboard.clients.accounts.passbook.show',['clientSlug'=> $expiringAccount->client->slug,'accountSlug'=> $expiringAccount->slug]) }}"><span class="label label-primary"><i class="glyphicon glyphicon-eye-open"></i></span></a>
                  </td>
                </tr>
                @endforeach

                @else

                <tr>
                  <th colspan="5" class="text-center">No Expiring Accounts</th>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
          <!-- /.table-responsive -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
          <a href="{{route('dashboard.clients.accounts.expiring_accounts_list')}}" class="btn btn-sm btn-primary btn-flat pull-left">View All Expiring Accounts</a>
        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
  <div class="row">
    <!-- Elapsing Accounts -->
    <div class="col-md-6">

      <!-- TABLE: LATEST ORDERS -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Elapsing Accounts</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table id="example2" class="table no-margin">
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
              <tbody>
                @if($elapsingAccounts->count() > 0)

                @foreach($elapsingAccounts as $elapsingAccount)
                <?php
                $elapsingAccountNextDate = \Carbon\Carbon::parse($elapsingAccount->next_date)->subDays(1)->format('Y-m-d');
                $elapsingAccountCurrentDate = date("Y-m-d");
                $elapsingAccountNextDateTime = new DateTime($elapsingAccountNextDate);
                $elapsingAccountCurrentDateTime = new DateTime($elapsingAccountCurrentDate);
                $elapsingAccountInterval = $elapsingAccountNextDateTime->diff($elapsingAccountCurrentDateTime);
                $elapsingAccountDaysLeft = $elapsingAccountInterval->format('%a');
                ?>
                <tr>
                  <td>{{\Carbon\Carbon::parse($elapsingAccount->next_date)->subDays(1)->format('Y-m-d')}}</td>
                  <td>{{$elapsingAccount->client->client_full_name}}</td>
                  <td>{{$elapsingAccount->client->client_phone_number}}</td>
                  <td>{{$elapsingAccount->interest_amount}}</td>
                  <td><span class="label label-success">{{$elapsingAccountDaysLeft}}</span></td>
                  <td>
                    <a href="{{ route('dashboard.clients.accounts.passbook.show',['clientSlug'=> $elapsingAccount->client->slug,'accountSlug'=> $elapsingAccount->slug]) }}"><span class="label label-primary"><i class="glyphicon glyphicon-eye-open"></i></span></a>
                  </td>
                </tr>
                @endforeach

                @else

                <tr>
                  <th colspan="5" class="text-center">No Elapsinng Accounts</th>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
          <!-- /.table-responsive -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
          <a href="{{route('dashboard.clients.accounts.elapsing_accounts_list')}}" class="btn btn-sm btn-primary btn-flat pull-left">View All Elapsing Accounts</a>
        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
    <!-- Elapsing Commissions -->
    <div class="col-md-6">

      <!-- TABLE: LATEST ORDERS -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Elapsing Commissions</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table id="example2" class="table no-margin">
              <thead>
                <tr>
                  <th>Pay Date</th>
                  <th>Name</th>
                  <th>Referred By</th>
                  <th>Commission Amount</th>
                  <th>Days Left</th>
                  <th>View</th>
                </tr>
              </thead>
              <tbody>
                @if($elapsingCommissions->count() > 0)

                @foreach($elapsingCommissions as $elapsingCommission)
                <?php
                $elapsingCommissionNextDate = \Carbon\Carbon::parse($elapsingCommission->next_date)->subDays(1)->format('Y-m-d');
                $elapsingCommissionCurrentDate = date("Y-m-d");
                $elapsingCommissionNextDateTime = new DateTime($elapsingCommissionNextDate);
                $elapsingCommissionCurrentDateTime = new DateTime($elapsingCommissionCurrentDate);
                $elapsingCommissionInterval = $elapsingCommissionNextDateTime->diff($elapsingCommissionCurrentDateTime);
                $elapsingCommissionDaysLeft = $elapsingCommissionInterval->format('%a');
                ?>
                <tr>
                  <td>{{\Carbon\Carbon::parse($elapsingCommission->next_date)->subDays(1)->format('Y-m-d')}}</td>
                  <td>{{$elapsingCommission->client->client_full_name}}</td>
                  <td>{{$elapsingCommission->client->referred_by}}</td>
                  <td>{{$elapsingCommission->commission_amount}}</td>
                  <td><span class="label label-success">{{$elapsingCommissionDaysLeft}}</span></td>
                  <td>
                    <a href="{{ route('dashboard.clients.accounts.passbook.show',['clientSlug'=> $elapsingCommission->client->slug,'accountSlug'=> $elapsingCommission->slug]) }}"><span class="label label-primary"><i class="glyphicon glyphicon-eye-open"></i></span></a>
                  </td>
                </tr>
                @endforeach

                @else

                <tr>
                  <th colspan="5" class="text-center">No Elapsing Commissions</th>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
          <!-- /.table-responsive -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
          <a href="{{route('dashboard.clients.accounts.elapsing_commissions_list')}}" class="btn btn-sm btn-primary btn-flat pull-left">View All Elapsing Commissions</a>
        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
@endsection

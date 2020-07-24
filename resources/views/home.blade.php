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
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-4 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <h3>{{$thisMonthClients->count()}}</h3>

        <p>Clients registered this month</p>
      </div>
      <div class="icon">
        <i class="fa fa-car"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-4 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3>{{$thisMonthExpiringAccounts->count()}}</h3>

        <p>Accounts expiring this month</p>
      </div>
      <div class="icon">
        <i class="fa fa-rupee"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
                <th>Date</th>
                <th>Name</th>
                <th>Phone No</th>
                <th>Amount Received</th>
                <th>Interest Rate(%)</th>
                <th>Tenure(months)</th>
                <th>Action</th>
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
                <td>{{$recentAccount->interest_rate}}</td>
                <td>{{$recentAccount->tenure}}</td>
                <td>
                  <a href="#"><span class="label label-primary"><i class="glyphicon glyphicon-eye-open"></i></span></a>
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
        <div class="box-footer clearfix">
          <a href="#" class="btn btn-sm btn-primary btn-flat pull-left">View All Recent Accounts</a>
        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
    <!-- Recent Accounts -->
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
                <th>Date</th>
                <th>Name</th>
                <th>Phone No</th>
                <th>Days Left</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
                @if($expiringAccounts->count() > 0)

                @foreach($expiringAccounts as $expiringAccount)
                <?php
                  $expiry_date = $insurance->policy_expiry_date;
                  $current_date = date("Y-m-d");
                  $expiry_date_time = new DateTime($expiry_date);
                  $current_date_time = new DateTime($current_date);
                  $interval = $expiry_date_time->diff($current_date_time);
                  $days = $interval->format('%a');

                  if($days<=31 && $current_date<=$expiry_date){
                 ?>
              <tr>
                <td>{{$expiringAccount->start_date}}</td>
                <td>{{$expiringAccount->client->client_full_name}}</td>
                <td>{{$expiringAccount->client->client_phone_number}}</td>
                <td><span class="label label-success">{{$daysLeftExpiringAccount}}</span></td>
                <td>
                  <a href="#"><span class="label label-primary"><i class="glyphicon glyphicon-eye-open"></i></span></a>
                </td>
              </tr>
                 <?php } ?>
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
          <a href="#" class="btn btn-sm btn-primary btn-flat pull-left">View All Expiring Accounts</a>
        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

    <!-- Used Car and New car Latest five row -->
    <div class="row">
      <!-- Left col -->
      <div class="col-md-6">

        <!-- TABLE: used car -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Latest UsedCar Enquiries</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table class="table no-margin">
                <thead>
                <tr>
                  <th>Enquiry Date</th>
                  <th>Name</th>
                  <th>Contact</th>
                  <th>Brand</th>
                  <th>Model</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @if($usedcars_enquiries->count() > 0)

                  @foreach($usedcars_enquiries as $usedcar_enquiry)

                <tr>
                  <td>
                    {{$usedcar_enquiry->vehicle_enquiry_date}}
                  </td>
                  <td>{{$usedcar_enquiry->purchaser_name}}</td>
                  <td>
                    {{$usedcar_enquiry->purchaser_contact_one}}
                  </td>
                  <td>{{$usedcar_enquiry->vehicle_brand}}</td>
                  <td>{{$usedcar_enquiry->vehicle_model}}</td>
                  <td>
                    <a href="{{ route('usedcar.enquiry.show',['id'=> $usedcar_enquiry->id]) }}"><span class="label label-primary"><i class="glyphicon glyphicon-eye-open"></i></span></a>
                  </td>
                </tr>

                   @endforeach

                   @else

                <tr>

                   <th colspan="5" class="text-center">No UsedCar Enquiries added yet</th>

                </tr>
                   @endif
                </tbody>
              </table>
            </div>
            <!-- /.table-responsive -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer clearfix">
            <a href="{{route('usedcars')}}" class="btn btn-sm btn-info btn-flat pull-left">View All UsedCar Enquiriess</a>
          </div>
          <!-- /.box-footer -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
      <div class="col-md-6">

        <!-- TABLE: used car -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Latest NewCar Enquiries</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table class="table no-margin">
                <thead>
                <tr>
                  <th>Enquiry Date</th>
                  <th>Name</th>
                  <th>Contact</th>
                  <th>Brand</th>
                  <th>Model</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @if($newcars->count() > 0)

                  @foreach($newcars as $newcar)

                <tr>
                  <td>
                    {{$newcar->enquiry_date}}
                  </td>
                  <td>{{$newcar->name}}</td>
                  <td>
                    {{$newcar->contact1}}
                  </td>
                  <td>{{$newcar->vehicle_brand}}</td>
                  <td>{{$newcar->vehicle_model}}</td>
                  <td>
                    <a href="{{ route('newcar.show',['id'=> $newcar->id]) }}"><span class="label label-primary"><i class="glyphicon glyphicon-eye-open"></i></span></a>
                  </td>
                </tr>

                   @endforeach

                   @else

                <tr>

                   <th colspan="5" class="text-center">No NewCar Enquiry added Yet</th>

                </tr>
                   @endif
                </tbody>
              </table>
            </div>
            <!-- /.table-responsive -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer clearfix">
            <a href="{{route('newcars')}}" class="btn btn-sm btn-success btn-flat pull-left">View All NewCar Enquiries</a>
          </div>
          <!-- /.box-footer -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->


        <!-- Used Car and New car Latest five row -->
        <div class="row">
          <!-- Left col -->
          <div class="col-md-6">

            <!-- TABLE: used car -->
            <div class="box box-warning">
              <div class="box-header with-border">
                <h3 class="box-title">Latest Refinance Enquiries</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="table-responsive">
                  <table class="table no-margin">
                    <thead>
                    <tr>
                      <th>Enquiry Date</th>
                      <th>Name</th>
                      <th>Contact</th>
                      <th>Brand</th>
                      <th>Model</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                      @if($refinancecars->count() > 0)

                      @foreach($refinancecars as $refinancecar)

                    <tr>
                      <td>
                        {{$refinancecar->enquiry_date}}
                      </td>
                      <td>{{$refinancecar->owner_name}}</td>
                      <td>
                        {{$refinancecar->owner_contact_one}}
                      </td>
                      <td>{{$refinancecar->vehicle_brand}}</td>
                      <td>{{$refinancecar->vehicle_model}}</td>
                      <td>
                        <a href="{{ route('refinancecar.show',['id'=> $refinancecar->id]) }}"><span class="label label-primary"><i class="glyphicon glyphicon-eye-open"></i></span></a>
                      </td>
                    </tr>

                       @endforeach

                       @else

                    <tr>

                       <th colspan="5" class="text-center">No RefinanceCar Enquiries added Yet</th>

                    </tr>
                       @endif
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.box-body -->
              <div class="box-footer clearfix">
                <a href="{{route('refinancecars')}}" class="btn btn-sm btn-warning btn-flat pull-left">View All RefinanceCar Enquiries</a>
              </div>
              <!-- /.box-footer -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
          <div class="col-md-6">

            <!-- TABLE: used car -->
            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title">Latest Insurance Enquiries</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="table-responsive">
                  <table class="table no-margin">
                    <thead>
                    <tr>
                      <th>Enquiry Date</th>
                      <th>Name</th>
                      <th>Contact</th>
                      <th>Brand</th>
                      <th>Model</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                      @if($insurances->count() > 0)

                      @foreach($insurances as $insurance)

                    <tr>
                      <td>
                        {{$insurance->enquiry_date}}
                      </td>
                      <td>{{$insurance->name}}</td>
                      <td>
                        {{$insurance->contact1}}
                      </td>
                      <td>{{$insurance->vehicle_brand}}</td>
                      <td>{{$insurance->vehicle_model}}</td>
                      <td>
                        <a href="{{ route('insurance.show',['id'=> $insurance->id]) }}"><span class="label label-primary"><i class="glyphicon glyphicon-eye-open"></i></span></a>
                      </td>
                    </tr>

                       @endforeach

                       @else

                    <tr>

                       <th colspan="5" class="text-center">No Insurance Enquiry added yet</th>

                    </tr>
                       @endif
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.box-body -->
              <div class="box-footer clearfix">
                <a href="{{route('insurances')}}" class="btn btn-sm btn-danger btn-flat pull-left">View All Insurance Enquiries</a>
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

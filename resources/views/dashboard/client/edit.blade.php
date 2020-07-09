@extends('layouts.app')

@section('content')

<section class="content-header">
  <h1>
    Edit Client
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('dashboard.home')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{route('dashboard.clients.list')}}">Clients</a></li>
    <li class="active">Edit Client</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- form begin -->
      <form role="form" method="POST" enctype="multipart/form-data">
        {{ csrf_field()}}
        <!-- Personal Details begin -->
        <div class="box box-primary" style="padding-bottom:0px;margin-bottom:0px;">
          <div class="box-header with-border">
            <h3 class="box-title">Personal Details</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="client_first_name">Client First Name<span style="color:red;">*</span></label>
                  <input type="text" id="client_first_name" name="client_first_name" class="form-control" value="{{old('client_first_name') ? old('client_first_name') : $client->client_first_name}}" placeholder="Enter Client First Name">
                  <span data-name="client_first_name" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="client_middle_name">Client Middle Name<span style="color:red;">*</span></label>
                  <input type="text" id="client_middle_name" name="client_middle_name" class="form-control" value="{{old('client_middle_name') ? old('client_middle_name') : $client->client_middle_name}}" placeholder="Enter Client Middle Name">
                  <span data-name="client_middle_name" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="client_last_name">Client Last Name<span style="color:red;">*</span></label>
                  <input type="text" id="client_last_name" name="client_last_name" class="form-control" value="{{old('client_last_name') ? old('client_last_name') : $client->client_last_name}}" placeholder="Enter Client Last Name">
                  <span data-name="client_last_name" class="error" style="color:red;"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="nominee_first_name">Nominee First Name<span style="color:red;">*</span></label>
                  <input type="text" id="nominee_first_name" name="nominee_first_name" class="form-control" value="{{old('nominee_first_name') ? old('nominee_first_name') : $client->nominee_first_name}}" placeholder="Enter Nominee First Name">
                  <span data-name="nominee_first_name" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="nominee_middle_name">Nominee Middle Name<span style="color:red;">*</span></label>
                  <input type="text" id="nominee_middle_name" name="nominee_middle_name" class="form-control" value="{{old('nominee_middle_name') ? old('nominee_middle_name') : $client->nominee_middle_name}}" placeholder="Enter Nominee Middle Name">
                  <span data-name="nominee_middle_name" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="nominee_last_name">Nominee Last Name<span style="color:red;">*</span></label>
                  <input type="text" id="nominee_last_name" name="nominee_last_name" class="form-control" value="{{old('nominee_last_name') ? old('nominee_last_name') : $client->nominee_last_name}}" placeholder="Enter Nominee Last Name">
                  <span data-name="nominee_last_name" class="error" style="color:red;"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="client_dob">Client Date of Birth<span style="color:red;">*</span></label>
                  <input type="date" id="client_dob" name="client_dob" class="form-control" value="{{old('client_dob') ? old('client_dob') : $client->client_dob}}" placeholder="Enter Date of Birth">
                </div>
                <span data-name="client_dob" class="error" style="color:red;"></span>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="client_phone_number">Client Phone Number<span style="color:red;">*</span></label>
                  <input type="number" id="client_phone_number" name="client_phone_number" class="form-control" value="{{old('client_phone_number') ? old('client_phone_number') : $client->client_phone_number}}" placeholder="Enter Client Phone Number">
                </div>
                <span data-name="client_phone_number" class="error" style="color:red;"></span>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="client_alternate_phone_number">Alternate Phone Number</label>
                  <input type="number" id="client_alternate_phone_number" name="client_alternate_phone_number" class="form-control" value="{{old('client_alternate_phone_number') ? old('client_alternate_phone_number') : $client->client_alternate_phone_number}}" placeholder="Enter Alternate Phone Number">
                </div>
                <span data-name="client_alternate_phone_number" class="error" style="color:red;"></span>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="referred_by">Referred By</label>
                  <input type="text" id="referred_by" name="referred_by" class="form-control" value="{{old('referred_by') ? old('referred_by') : $client->referred_by}}" placeholder="Enter Referred By">
                </div>
                <span data-name="referred_by" class="error" style="color:red;"></span>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="commission_of_referral">Commission of Referral</label>
                  <input type="text" id="commission_of_referral" name="commission_of_referral" class="form-control" value="{{old('commission_of_referral') ? old('commission_of_referral') : $client->commission_of_referral}}" placeholder="Enter Commission of Referral">
                </div>
                <span data-name="commission_of_referral" class="error" style="color:red;"></span>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="client_permanent_address">Client Permanent Address<span style="color:red;">*</span></label>
                  <textarea id="client_permanent_address" name="client_permanent_address" class="form-control" placeholder="Enter Client Permanent Address">{{old('client_permanent_address') ? old('client_permanent_address') : $client->client_permanent_address}}</textarea>
                </div>
                <span data-name="client_permanent_address" class="error" style="color:red;"></span>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="client_alternate_address">Client Alternate Address</label>
                  <textarea id="client_alternate_address" name="client_alternate_address" class="form-control" placeholder="Enter Client Alternate Address">{{old('client_alternate_address') ? old('client_alternate_address') : $client->client_alternate_address}}</textarea>
                </div>
                <span data-name="client_alternate_address" class="error" style="color:red;"></span>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="client_aadhar_card_photo">Client Aadhar Card Photo<span style="color:red;">*</span></label>
                  <input type="file" id="client_aadhar_card_photo" name="client_aadhar_card_photo" onchange="validateImage('client_aadhar_card_photo')" class="form-control" placeholder="Choose Client Aadhar Card Photo">
                </div>
                <span data-name="client_aadhar_card_photo" class="error" style="color:red;"></span>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="client_pan_card_photo">Client Pan Card Photo<span style="color:red;">*</span></label>
                  <input type="file" id="client_pan_card_photo" name="client_pan_card_photo" onchange="validateImage('client_pan_card_photo')" class="form-control" placeholder="Choose Client Pan Card Photo">
                </div>
                <span data-name="client_pan_card_photo" class="error" style="color:red;"></span>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="client_personal_photo">Client Personal Photo<span style="color:red;">*</span></label>
                  <input type="file" id="client_personal_photo" name="client_personal_photo" onchange="validateImage('client_personal_photo')" class="form-control" placeholder="Choose Client Personal Photo">
                </div>
                <span data-name="client_personal_photo" class="error" style="color:red;"></span>
              </div>
            </div>
          </div>
        </div>
        <!-- Personal Details end -->
        <!-- Bank Details begin -->
        <div class="box box-primary" style="padding-top:0px;margin-top:0px;padding-bottom:0px;margin-bottom:0px;">
          <div class="box-header with-border">
            <h3 class="box-title">Bank Details</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="client_bank_name">Bank Name<span style="color:red;">*</span></label>
                  <input type="text" id="client_bank_name" name="client_bank_name" class="form-control" value="{{old('client_bank_name') ? old('client_bank_name') : $client->client_bank_name}}" placeholder="Enter Bank Name">
                  <span data-name="client_bank_name" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="client_bank_branch">Bank Branch<span style="color:red;">*</span></label>
                  <input type="text" id="client_bank_branch" name="client_bank_branch" class="form-control" value="{{old('client_bank_branch') ? old('client_bank_branch') : $client->client_bank_branch}}" placeholder="Enter Bank Branch">
                  <span data-name="client_bank_branch" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="client_bank_ifsc_code">IFSC Code<span style="color:red;">*</span></label>
                  <input type="text" id="client_bank_ifsc_code" name="client_bank_ifsc_code" class="form-control" value="{{old('client_bank_ifsc_code') ? old('client_bank_ifsc_code') : $client->client_bank_ifsc_code}}" placeholder="Enter IFSC Code">
                  <span data-name="client_bank_ifsc_code" class="error" style="color:red;"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="client_bank_micr_code">MICR Code<span style="color:red;">*</span></label>
                  <input type="text" id="client_bank_micr_code" name="client_bank_micr_code" class="form-control" value="{{old('client_bank_micr_code') ? old('client_bank_micr_code') : $client->client_bank_micr_code}}" placeholder="Enter MICR Code">
                  <span data-name="client_bank_micr_code" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="client_bank_account_number">Account Number<span style="color:red;">*</span></label>
                  <input type="text" id="client_bank_account_number" name="client_bank_account_number" class="form-control" value="{{old('client_bank_account_number') ? old('client_bank_account_number') : $client->client_bank_account_number}}" placeholder="Enter Account Number">
                  <span data-name="client_bank_account_number" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="client_bank_cheque_photo">Cheque Photo<span style="color:red;">*</span></label>
                  <input type="file" id="client_bank_cheque_photo" name="client_bank_cheque_photo" onchange="validateImage('client_bank_cheque_photo')" class="form-control" placeholder="Choose Cheque Photo">
                </div>
                <span data-name="client_bank_cheque_photo" class="error" style="color:red;"></span>
              </div>
            </div>
          </div>
        </div>
        <!-- Bank Details End -->
        <!-- Form submit begin -->
        <div class="row" style="padding-top:0px;margin-top:0px;">
          <div class="col-md-12">
            <!-- /.box-body -->
            <div class="text-center box-footer" style="padding-top:40px;">
              <button type="submit" name="action" class="btn btn-primary btn-lg dis" value="Update" style="  box-shadow: 2px 5px #888888;">Update</button>
            </div>
          </div>
        </div>
        <!-- Form submit End -->
      </div>
    </form>
  </div>
</section>

@endsection

@section('scripts')

<script type="text/javascript">
function validateImage(id) {
  var formData = new FormData();

  var file = document.getElementById(id).files[0];

  formData.append("Filedata", file);
  var t = file.type.split('/').pop().toLowerCase();
  if (t != "jpeg" && t != "jpg" && t != "png" && t != "bmp" && t != "gif") {
    alert('Please select a valid image file');
    document.getElementById(id).value = '';
    return false;
  }
  if (file.size > 1024000) {
    alert('Max Upload size is 1MB only');
    document.getElementById(id).value = '';
    return false;
  }
  return true;
}
</script>

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

  $.ajax({
    url: "{{route('dashboard.clients.update',['id' => $client->id])}}",
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

      window.location.replace("{{route('dashboard.clients.list')}}");
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

@stop

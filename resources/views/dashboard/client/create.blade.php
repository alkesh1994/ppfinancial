@extends('layouts.app')

@section('content')

<section class="content-header">
  <h1>
    Create Client
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('dashboard.home')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{route('dashboard.clients.list')}}">Clients</a></li>
    <li class="active">Create Client</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- form begin -->
      <form role="form" method="post" enctype="multipart/form-data">
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
                  <input type="text" id="client_first_name" name="client_first_name" class="form-control" value="{{old('client_first_name')}}" placeholder="Enter Client First Name">
                  <span data-name="client_first_name" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="client_middle_name">Client Middle Name<span style="color:red;">*</span></label>
                  <input type="text" id="client_middle_name" name="client_middle_name" class="form-control" value="{{old('client_middle_name')}}" placeholder="Enter Client Middle Name">
                  <span data-name="client_middle_name" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="client_last_name">Client Last Name<span style="color:red;">*</span></label>
                  <input type="text" id="client_last_name" name="client_last_name" class="form-control" value="{{old('client_last_name')}}" placeholder="Enter Client Last Name">
                  <span data-name="client_last_name" class="error" style="color:red;"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="client_dob">Client Date of Birth<span style="color:red;">*</span></label>
                  <input type="date" id="client_dob" name="client_dob" class="form-control" value="{{old('client_dob')}}" placeholder="Enter Date of Birth">
                  <span data-name="client_dob" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="client_phone_number">Client Phone Number (enter +91)<span style="color:red;">*</span></label>
                  <input type="text" id="client_phone_number" name="client_phone_number" class="form-control" value="{{old('client_phone_number')}}" placeholder="Enter Client Phone Number">
                  <span data-name="client_phone_number" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="client_alternate_phone_number">Alternate Phone Number (enter +91)</label>
                  <input type="text" id="client_alternate_phone_number" name="client_alternate_phone_number" class="form-control" value="{{old('client_alternate_phone_number')}}" placeholder="Enter Alternate Phone Number">
                  <span data-name="client_alternate_phone_number" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="referred_by">Referred By</label>
                  <input type="text" id="referred_by" name="referred_by" class="form-control" value="{{old('referred_by')}}" placeholder="Enter Referred By">
                  <span data-name="referred_by" class="error" style="color:red;"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="client_permanent_address">Client Permanent Address<span style="color:red;">*</span></label>
                  <textarea id="client_permanent_address" name="client_permanent_address" class="form-control" placeholder="Enter Client Permanent Address">{{old('client_permanent_address')}}</textarea>
                  <span data-name="client_permanent_address" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="client_alternate_address">Client Alternate Address</label>
                  <textarea id="client_alternate_address" name="client_alternate_address" class="form-control" placeholder="Enter Client Alternate Address">{{old('client_alternate_address')}}</textarea>
                  <span data-name="client_alternate_address" class="error" style="color:red;"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="client_aadhar_card_photo">Client Aadhar Card Photo<span style="color:red;">*</span></label>
                  <input type="file" id="client_aadhar_card_photo" name="client_aadhar_card_photo" onchange="validateImage('client_aadhar_card_photo')" class="form-control" placeholder="Choose Client Aadhar Card Photo">
                  <span data-name="client_aadhar_card_photo" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="client_pan_card_photo">Client Pan Card Photo<span style="color:red;">*</span></label>
                  <input type="file" id="client_pan_card_photo" name="client_pan_card_photo" onchange="validateImage('client_pan_card_photo')" class="form-control" placeholder="Choose Client Pan Card Photo">
                  <span data-name="client_pan_card_photo" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="client_personal_photo">Client Personal Photo<span style="color:red;">*</span></label>
                  <input type="file" id="client_personal_photo" name="client_personal_photo" onchange="validateImage('client_personal_photo')" class="form-control" placeholder="Choose Client Personal Photo">
                  <span data-name="client_personal_photo" class="error" style="color:red;"></span>
                </div>
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
                  <input type="text" id="client_bank_name" name="client_bank_name" class="form-control" value="{{old('client_bank_name')}}" placeholder="Enter Bank Name">
                  <span data-name="client_bank_name" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="client_bank_branch">Bank Branch<span style="color:red;">*</span></label>
                  <input type="text" id="client_bank_branch" name="client_bank_branch" class="form-control" value="{{old('client_bank_branch')}}" placeholder="Enter Bank Branch">
                  <span data-name="client_bank_branch" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="client_bank_ifsc_code">IFSC Code<span style="color:red;">*</span></label>
                  <input type="text" id="client_bank_ifsc_code" name="client_bank_ifsc_code" class="form-control" value="{{old('client_bank_ifsc_code')}}" placeholder="Enter IFSC Code">
                  <span data-name="client_bank_ifsc_code" class="error" style="color:red;"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="client_bank_micr_code">MICR Code<span style="color:red;">*</span></label>
                  <input type="number" id="client_bank_micr_code" name="client_bank_micr_code" class="form-control" value="{{old('client_bank_micr_code')}}" placeholder="Enter MICR Code" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength = "9" min = "1" max = "999999999">
                  <span data-name="client_bank_micr_code" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="client_bank_account_number">Account Number<span style="color:red;">*</span></label>
                  <input type="number" id="client_bank_account_number" name="client_bank_account_number" class="form-control" value="{{old('client_bank_account_number')}}" placeholder="Enter Account Number">
                  <span data-name="client_bank_account_number" class="error" style="color:red;"></span>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="client_bank_cheque_photo">Cheque Photo<span style="color:red;">*</span></label>
                  <input type="file" id="client_bank_cheque_photo" name="client_bank_cheque_photo" onchange="validateImage('client_bank_cheque_photo')" class="form-control" placeholder="Choose Cheque Photo">
                  <span data-name="client_bank_cheque_photo" class="error" style="color:red;"></span>
                </div>
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
              <button type="submit" name="action" class="btn btn-primary btn-lg dis" value="draft" style="  box-shadow: 2px 5px #888888;">Submit</button>
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
<script>
  function maxLengthCheck(object) {
    if (object.value.length > object.maxLength)
      object.value = object.value.slice(0, object.maxLength)
  }

  function isNumeric (evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode (key);
    var regex = /[0-9]|\./;
    if ( !regex.test(key) ) {
      theEvent.returnValue = false;
      if(theEvent.preventDefault) theEvent.preventDefault();
    }
  }
</script>
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
    url: "{{route('dashboard.clients.store')}}",
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

@extends('layouts.app')

@section('content')

<section class="content-header">
  <h1>
    Clients
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('dashboard.home')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{route('dashboard.clients.create_client')}}">Clients</a></li>
    <li class="active">Create Client</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Create Client</h3>
        </div>
        <div class="box-body">

          <form role="form" method="post" enctype="multipart/form-data">
            {{ csrf_field()}}

            <div class="row" style="padding:10px;">
              <div class="col-md-12">
                <div class="box box-primary box-solid">
                  <!-- /.box-header -->
                  <div class="box-body">
                    <div class="row" style="padding:5px;">
                      <div class="col-sm-8">
                        <div class="form-group">
                          <label for="post_title">Post Title<span style="color:red;">*</span></label>
                          <input type="text" id="post_title" name="post_title" class="form-control" value="{{old('post_title')}}" placeholder="Enter Title">
                          <span data-name="post_title" class="error" style="color:red;"></span>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label for="publish_on">Publish On<span style="color:red;">*</span></label>
                              <input type="date" id="publish_on" name="publish_on" class="form-control" value="{{old('publish_on') ? old('publish_on') : date('Y-m-d') }}" placeholder="Enter Date">
                            </div>
                            <span data-name="publish_on" class="error" style="color:red;"></span>
                          </div>
                        </div>
                        <div class="row" style="padding:5px;">
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label for="post_short_description">Short Description<span style="color:red;">*</span></label>
                              <textarea id="post_short_description" name="post_short_description" class="form-control" placeholder="Enter Short Description">{!!old('post_short_description')!!}</textarea>
                            </div>
                            <span data-name="post_short_description" class="error" style="color:red;"></span>
                          </div>

                        </div>
                        <div class="row" style="padding:5px;">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label for="original_cover_image">Cover Image<span style="color:red;">*</span> <small>(825px x 450px)</small></label>
                              <input type="file" id="original_cover_image" name="original_cover_image" onchange="validateImage('original_cover_image')" class="form-control" placeholder="Choose Image">
                            </div>
                            <span data-name="original_cover_image" class="error" style="color:red;"></span>
                          </div>
                        </div>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <!-- /.col -->
                </div>

                <!-- /*******************************/
                //Submit Form
                /******************************/ -->
                <div class="row">
                  <div class="col-md-12">
                    <!-- /.box-body -->
                    <div class="text-center box-footer">
                      <button type="submit" name="action" class="btn btn-primary btn-lg dis" value="draft" style="  box-shadow: 2px 5px #888888;">Submit</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
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
var resize = $('#upload-image').croppie({

    enableExif: true,

    enableOrientation: true,

    viewport: {

        width: 350,

        height: 186,

        type: 'square'

    },

    boundary: {

        width: 350,

        height: 250

    }

});

var imageResponse="";

$('#post_cover_image').on('change', function () {

  var reader = new FileReader();

    reader.onload = function (e) {

      resize.croppie('bind',{

        url: e.target.result

      }).then(function(res){

        console.log('jQuery bind complete',res);

      });

    }
    reader.readAsDataURL(this.files[0]);
});



$('button[type=submit]').on('click', function () {

  var $this = $(this);

  resize.croppie('result', {

    type: 'base64',
    quality:0.3,
    size: {width:350,height:186}

  }).then(function (img) {
    imageResponse=img;


        if($this.attr("value") == "save"){
          status = 1;
        }else if($this.attr("value") == "draft"){
          status=0;
        }

    var form=$this.closest('form'),
    error=form.find('span.error');
    error.map(function(elem){
      $(this).html("")
    })
    var formData = new FormData(form[0]);

      formData.append('post_cover_image',imageResponse);
      formData.append('status',status);
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
});

</script>

    @stop

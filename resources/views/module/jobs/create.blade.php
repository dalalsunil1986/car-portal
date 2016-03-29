<!doctype html>
<html>
<head>
<!--
                                        Designed, Developed and Maintained by Dakort Techologies ( Copyright 2014)
                                                     Website: wwww.dakort.com  Email: info@dakort.com
 -->

<title>Kuwaitii - Sumbit Page</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="stylesheet" href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' type='text/css'>
<!--Vendor CSS -->
<link rel="stylesheet" href="../css/bootstrap.min.css" type='text/css'>
<link rel="stylesheet" href="../vendors/slidebars/slidebars.min.css" >
<link rel="stylesheet" href="../vendors/jquery-ui/themes/base/jquery.ui.all.css" type='text/css'>
<link rel="stylesheet" href="../vendors/jquery-ui/demos.css" type='text/css'>
<link rel="stylesheet" href="../css/select2.css" type='text/css'>
<link rel="stylesheet" href="../css/bs-wizard.css"  type="text/css">
<link rel="stylesheet" href="../css/dropzone.css"  type="text/css">
<link rel="stylesheet" href="../css/jasny-bootstrap.min.css"  type="text/css">
<link rel="stylesheet" type="text/css" href="../vendors/Bootstrap Tags/bootstrap-tagsinput.css">
<!--Global Styles-->
<link rel="stylesheet" type="text/css" href="../css/style-global.css">
<!--Page Styles-->
<link rel="stylesheet" type="text/css" href="../css/style-job-submit.css">
<link rel="stylesheet" href="../css/layout-submit-page.css" type="text/css"/>
<!--Other-->
<link rel="shortcut icon" href="../img/icons/favicon.ico">
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
</head>
<body>
<?php include_once ('../layouts/navbar.php');?>
<?php include_once ('../layouts/lang-bar.php');?>
<div class="container">
  <div class="col-md-10 col-sm-12">
    <div class="row bs-wizard">
      <div class="col-lg-3">
        <ol class="bs-wizard-sidebar text-center">
          <li class="bs-wizard-todo bs-wizard-active"><a href="javascript:void(0)"> Detials</a></li>
          <li class="bs-wizard-todo"><a href="javascript:void(0)">Optional</a></li>
        </ol>
      </div>
      <div class="col-lg-9" >
        <form method="get" name="car-submission" id="car-submission" action="/uploads" accept-charset="UTF-8" >
          <fieldset>
            <div class="bs-step inv shadow">
              <div class="panel panel-default">
                <div class="panel-body bs-step-inner">
                  <h3>Step 1: Fill in all the inputs.</h3>
                  
                  <div class="row">
                    <div class="form-group col-lg-12 col-sm-12">
                      <label class="pull-left col-sm-2 col-xs-3">Title</label>
                      <input  placeholder="Ex. Hiring Driver Full Time" type="text" onkeyup="textCounter(this,'counter', 50);"  class="col-xs-8 col-sm-8" id="message">
                      <input disabled  maxlength="3" size="3" value="50" id="counter" class="pull-left counter col-xs-1 col-sm-1">
                    </div>
                  </div>
                  
                  <!--Industry Row-->
                  
                  <div class="row">
                    <div class="form-group col-lg-12 col-sm-12">
                      <label class="pull-left col-sm-2 col-xs-3">Industry</label>
                      <select class="populate placeholder select2-offscreen pull-left col-sm-8 col-xs-8 input"id="industry" tabindex="-1">
                        <option value="AK"> Alaska </option>
                        <option value="HI"> Hawaii </option>
                      </select>
                      <span class="glyphicon glyphicon-question-sign hint" data-toggle="tooltip" data-placement="bottom" title="Simply pick the appropriate industry for your job. Ex. 'Food Industry'"></span> </div>
                  </div>
                  
                  <!--Industry Row--> 
                  
                  <!--Postion Row-->
                  
                  <div class="row">
                    <div class="form-group col-lg-12 col-sm-12 ">
                      <label class="pull-left col-sm-2 col-xs-3">Position</label>
                      <select class="populate placeholder select2-offscreen pull-left col-sm-8 col-xs-8 input" id="position"  tabindex="-1">
                        <option value="AK"> Alaska </option>
                        <option value="HI"> Hawaii </option>
                      </select>
                      <span class="glyphicon glyphicon-question-sign hint" data-toggle="tooltip" data-placement="bottom" title="Simply pick the appropriate industry for your job. Ex. 'Food Industry'"></span> </div>
                  </div>
                  
                  <!--Postion Row--> 
                  
                  <!--Industry Row-->
                  
                  <div class="row">
                    <div class="form-group col-lg-12 col-sm-12">
                      <label class="pull-left col-sm-2 col-xs-3">Location</label>
                      <select class="populate placeholder select2-offscreen pull-left col-sm-8 col-xs-8 input" id="location"  tabindex="-1">
                        <option value="AK"> Alaska </option>
                        <option value="HI"> Hawaii </option>
                      </select>
                      <span class="glyphicon glyphicon-question-sign hint" data-toggle="tooltip" data-placement="bottom" title="Simply pick the appropriate industry for your job. Ex. 'Food Industry'"></span> </div>
                  </div>
                  <!--Industry Row--> 
                  
                  <!--Salery Row-->
                  
                  <div class="row">
                    <div class="form-group col-lg-12 col-sm-12 ">
                      <label class="pull-left col-sm-2 col-xs-3">Salery</label>
                      <select class="populate placeholder select2-offscreen pull-left col-sm-8 col-xs-8 input" id="salery"  tabindex="-1">
                        <option value="AK"> Alaska </option>
                        <option value="HI"> Hawaii </option>
                      </select>
                      <span class="glyphicon glyphicon-question-sign hint" data-toggle="tooltip" data-placement="bottom" title="Simply pick the appropriate industry for your job. Ex. 'Food Industry'"></span> </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-10">
                      <div class="pull-right"> Keep Salery Hidden?
                        <input type="checkbox" data-toggle="tooltip" data-placement="bottom" title="Simply pick the appropriate industry for your job. Ex. 'Food Industry'">
                      </div>
                    </div>
                  </div>
                  
                  <!--Salery Row--> 
                  
                </div>
              </div>
            </div>
            <div class="bs-step inv">
              <div class="panel panel-default">
                <div class="panel-body bs-step-inner">
                  <h3>Step 2: These are optional.</h3>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-xs-2">Descriptoin</label>
                      <textarea class="col-xs-8"  placeholder="Enter Job Description.(Optional)"></textarea>
                      <span class="glyphicon glyphicon-question-sign hint" data-toggle="tooltip" data-placement="bottom" title="Simply pick the appropriate industry for your job. Ex. 'Food Industry'"></span> </div>
                    <div class="form-group">
                      <div class="row tags">
                        <label class="col-xs-2">Skills</label>
                        <input type="text col-xs-8" class="tags" value="Photoshop, Web Design" data-role="tagsinput" placeholder="Add tags" />
                        <span class="glyphicon glyphicon-question-sign hint" data-toggle="tooltip" data-placement="bottom" title="Simply pick the appropriate industry for your job. Ex. 'Food Industry'"></span> </div>
                    </div>
                    <div class="row">
                      <div class="form-group">
                        <label class="pull-left col-xs-2">Company</label>
                        <input  placeholder="Enter Company Name (Optional) " type="text"  class="col-xs-8 col-sm-8" id="companyName">
                        <span class="glyphicon glyphicon-question-sign hint" data-toggle="tooltip" data-placement="bottom" title="Simply pick the appropriate industry for your job. Ex. 'Food Industry'"></span> </div>
                    </div>
                    <div class="row">
                      <div class="form-group">
                        <label class="col-xs-2">About us</label>
                        <textarea class=" col-xs-8"  placeholder="Enter Company Descritpion (Optional)."></textarea>
                        <span class="glyphicon glyphicon-question-sign hint" data-toggle="tooltip" data-placement="bottom" title="Simply pick the appropriate industry for your job. Ex. 'Food Industry'"></span> </div>
                    </div>
                    <div class="form-group">
                      <div class="row ">
                        <label class="col-xs-2">Location </label>
                        <div id="map-canvas" class="col-xs-8" style=" height:400px;"></div>
                        <span class="glyphicon glyphicon-question-sign hint" data-toggle="tooltip" data-placement="bottom" title="Simply pick the appropriate industry for your job. Ex. 'Food Industry'"></span> </div>
                    </div>
                    <div class="row">
                      <label class="col-xs-2">Upload File</label>
                      <div class="dropzone dropzone-previews img-responsive col-xs-8" id="my-awesome-dropzone"></div>
                      <span class="glyphicon glyphicon-question-sign hint" data-toggle="tooltip" data-placement="bottom" title="Simply pick the appropriate industry for your job. Ex. 'Food Industry'"></span> </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="bs-step inv">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Pleaes review your details and sign up</h3>
                </div>
                <div class="panel-body bs-step-inner">
                  <div>
                    <h3 class="with-underline">Your Account Details</h3>
                    <table class="table table-condensed info-table">
                      <tbody>
                        <tr>
                          <td class="info-td">Email</td>
                          <td><span id="r-email" class="label label-success"></span></td>
                        </tr>
                        <tr>
                          <td class="info-td">Password</td>
                          <td><span id="r-password" class="label label-success"></span></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div>
                    <h3 class="with-underline">Your Website Details</h3>
                    <table class="table table-condensed info-table">
                      <tbody>
                        <tr>
                          <td class="info-td">Website Address</td>
                          <td><span id="r-address" class="label label-success"></span></td>
                        </tr>
                        <tr>
                          <td class="info-td">Supportted languages</td>
                          <td id="r-locales"></td>
                        </tr>
                        <tr>
                          <td class="info-td">Default language</td>
                          <td><span id="r-dlocale" class="label label-success"></span></td>
                        </tr>
                        <tr>
                          <td class="info-td">Website Pages</td>
                          <td id="r-pages"></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="clearfix pull-right"></div>
                  <button id="last-back" type="reset" class="btn btn-default pull-right">Go Back</button>
                  <button id="btn-signup" type="submit" class="btn btn-primary submit-btn pull-right">Sumbit Car</button>
                  <input type="checkbox" data-popover-offset="-10,-6" name="agreeToTheTerms" id="agreeToTheTerms" class="required terms_checkbox">
                  <span id="termsLabel">I agree to <a id="termLink" href="" target="_blank">Terms of Service</a></span> </div>
              </div>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
  <?php include_once ('../layouts/sidebar-left.php');?>
  <?php include_once ('../layouts/sidebar-right.php');?>
  <?php include_once ('../layouts/sidebar-left-mob.php');?>
  <?php include_once ('../layouts/sidebar-right-mob.php');?>
  <?php include_once ('../layouts/footer-links.php');?>
</div>

<!-- jQuery --> 
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> --> 
<!-- HTML5 shim, for IE6-8 support of HTML5 elements --> 
<!--[if lt IE 9]>
	<script type="text/javascript" src="js/html5shiv.js"></script>
	<![endif]--> 

<script src="../js/jquery.min.js" type="text/javascript"></script> 
<script src="../js/bootstrap.min.js" type="text/javascript"></script> 
<script src="../js/scripts.js" type="text/javascript"></script> 
<script src="../js/select2.js" type="text/javascript"></script> 
<script src="../vendors/slidebars/slidebars.min.js"></script> 
<script src="../js/bs-wizard.js"></script> 
<script src="../js/jquery.validate.js"></script> 
<script src="../js/jquery.popover.js"></script> 
<script src="../js/dropzone.js"></script> 
<script src="../js/jasny-bootstrap.min.js"></script> 
<script type="text/javascript" src="../vendors/ionRangeSlider-1.9.0/js/ion-rangeSlider/ion.rangeSlider.min.js"></script> 
<script src="../vendors/autogrow-master/autogrow.min.js"></script> 
<script src="../vendors/Bootstrap Tags/bootstrap-tagsinput.min.js"></script> 
<script>
function textCounter(field,field2,maxlimit)
{
 var countfield = document.getElementById(field2);
 if ( field.value.length > maxlimit ) {
  field.value = field.value.substring( 0, maxlimit );
  return false;
 } else {
  countfield.value = maxlimit - field.value.length;
 }
}
</script> 
<script type="text/javascript">
      function validate_fields(fields, step) {
          var error_step, field, _i, _len;
          for (_i = 0, _len = fields.length; _i < _len; _i++) {
              field = fields[_i];
              if (!form_validator().element(field)) {
                  error_step = step;
              }
          }
          return error_step != null ? error_step : true;
      }
  
      function form_validator() {
          return $('#car-submission').validate();
      }
  
      function current_step() {
          return $(".bs-wizard").bs_wizard('option', 'currentStep');
      }
  
      function build_span_label(lable) {
          return "<span class='label label-success'>" + lable + "</span>";
      }
  
      function before_next() {
          if (current_step() == 1) return validate_fields($('#year, #mileage, #model,#thumbnail'), 1) === true;
          if (current_step() == 2) {
  
          }
          return false;
      }
  
  
      function submit_signup(ev) {
          validate_fields($('#agreeToTheTerms'), 4);
      }
  
  
      $(function() {
          $(".bs-wizard").bs_wizard({beforeNext: before_next});
          $('#last-back').click($(".bs-wizard").bs_wizard('go_prev'));
          $('#signup_form').validate_popover({
              onsubmit: false,
              rules: {
                  'client[password]': {
                      required: true,
                      minlength: 6,
                      maxlength: 20
                  },
                  'client[password_confirmation]': {
                      required: true,
                      equalTo: "#client_password"
                  },
                  'website[sub_name]': {
                      required: true,
                      minlength: 5,
                      maxlength: 20
                  },
                  'website[locales][]': {
                      required: true,
                      minlength: 1
                  }
              }
          });
  
          $(".submit-btn").click(function(ev) {
              ev.preventDefault();
              return false;
          });
  
  
          $('#btn-signup').click(submit_signup);
          $(window).keydown(function(event) {
              if (event.keyCode === 13) {
                  return submit_signup(event);
              }
          });
  
          $(window).resize(function() {
              $.validator.reposition();
          });
  
      });
  
  
  </script> 
<script> 
//Slide Info Function 
$(document).ready(function(){
$('.flip').on('click', function() {
        $(this).prev().slideToggle(500);
	   });
	   
	   $("#experience-slide").ionRangeSlider({
		   
    min: 0,
    max: 10,
    from: 0,
    to: 3,
    type: 'double',
    step: 1,
    postfix: " Years",

		   
		   
		 });
	   
	   $("#salery-slide").ionRangeSlider({
	min: 0,
    max: 3000,
    from: 250,
    to: 800,
    type: 'double',
    step: 50,
    postfix: " KD",
	});


});
</script> 
<script>
      $('document').ready(function () {
          runSlidebars(); // Initially call the function.
          $(window).resize(runSlidebars); // Call the function again when teh screen is resized.
  
          $("#industry").select2()
          $("#position").select2();
		  $("#location").select2();
		  $("#salery").select2();
		  $("#comonayName").select2();
		  
		  
		  
          $(function() {
              $(".bs-wizard").bs_wizard({beforeNext: before_next});
          });
         
      });
	  
  
  //ToolTip
 $(function () {
        $("[data-toggle='tooltip']").tooltip();
    });

  </script> 
<script>
      var FormDropzone = function () {
  
          return {
              //main function to initiate the module
              init: function () {
  
                  Dropzone.options.myAwesomeDropzone = { // The camelized version of the ID of the form element
  
  //                    // The configuration we've talked about above
  //                    autoProcessQueue: false,
  //                    uploadMultiple: true,
  //                    parallelUploads: 100,
  //                    maxFiles: 100,
  //                    previewsContainer: ".dropzone-previews",
                      url: '/uploads',
                      previewsContainer: ".dropzone-previews",
                      uploadMultiple: true,
                      parallelUploads: 100,
                      maxFiles: 5,
  
  
                      // The setting up of the dropzone
                      init: function() {
                          var myDropzone = this;
  
                          // First change the button to actually tell Dropzone to process the queue.
                          this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
                              // Make sure that the form isn't actually being sent.
                              e.preventDefault();
                              e.stopPropagation();
                              myDropzone.processQueue();
                          });
  
                          // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
                          // of the sending event because uploadMultiple is set to true.
                          this.on("sendingmultiple", function() {
                              // Gets triggered when the form is actually being sent.
                              // Hide the success button or the complete form.
                          });
                          this.on("successmultiple", function(files, response) {
                              // Gets triggered when the files have successfully been sent.
                              // Redirect user or notify of success.
                          });
                          this.on("errormultiple", function(files, response) {
                              // Gets triggered when there was an error sending the files.
                              // Maybe show form again, and notify user of error
                          });
                      }
  
                  }
              }
          };
      }();
  
  
      $('document').ready(function () {
          runSlidebars(); // Initially call the function.
          $(window).resize(runSlidebars); // Call the function again when teh screen is resized.
  
          $("#model").select2({
              placeholder: "Select a Type",
              allowClear: true
          });
          $("#year").select2();
          $(function() {
              $(".bs-wizard").bs_wizard({beforeNext: before_next});
          });
          FormDropzone.init();
          $('.fileinput').fileinput()
  
  
      });
      function initialize() {
          var mapOptions = {
              center: new google.maps.LatLng(29.357, 47.951),
              zoom: 8
          };
          var map = new google.maps.Map(document.getElementById("map-canvas"),
                  mapOptions);
      }
      google.maps.event.addDomListener(window, 'load', initialize);
  
  
  </script> 
<script>
    // makes page fade to white when a link is clicked
    $(document).on("click", "a", function () {
        var newUrl = $(this).attr("href");
        if (!newUrl || newUrl[0] === "#") {
            location.hash = newUrl;
            return;
        }
        $("html").fadeOut(function () {
            location = newUrl;
        });
        return false;
      });
    
    </script> 
<script>
$('textarea').autogrow();
</script>
</body>
</html>
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

<link rel="stylesheet" type="text/css" href="../css/style-job-view.css">
<link rel="stylesheet" href="../css/layout-job-view-page.css" type="text/css"/>

<!--Other-->
<link rel="shortcut icon" href="../img/icons/favicon.ico">
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
</head>
<body>
<?php include_once ('../layouts/navbar.php');?>
<?php include_once ('../layouts/lang-bar.php');?>
<div class="container">

      <div class="row clearfix job-title-row">
           <div class="col-md-9 col-sm-9 column title-color">
           <h3> <span class="glyphicon glyphicon-briefcase"></span>Senior Sales Manager Needed</h3>
           </div>
        <div class="col-md-3 col-sm-3 column salery-color">
          <div class="price-cost text-center">Apply Now</div>
        </div>
      </div>

	  <div class="row clearfix apply-box">
  		 <div class="col-md-6 column">
      <div class="text-center">
        <h3>Apply now for this postion:</h3>
      </div>
       <div class="text-center"><span><a href="#">Build/Edit your CV</a></span></div>
    </div>
  		 <div class="col-md-6 column">
      <div class="text-center">
        <button class="btn btn-block btn-default cv-btn"> Send CV</button>
      </div>
    </div>
  	  </div>

      <div class="row clearfix job-summary">
        <div class="col-md-3 column">
            <label>Industry</label>
            <p>Sales</p>
          </div>
          <div class="col-md-3 column">
            <label>Position</label>
            <p>Manager</p>
          </div>
          <div class="col-md-3 column">
            <label>Location</label>
            <p>Kuwait City</p>
          </div>
          <div class="col-md-3 column">
            <label>Salery</label>
            <p>750KD</p>
          </div>
      </div>
      
   
      <div class="row clearfix full-info">
         <div class="col-md-9 main-info column">
              <div class="row clearfix">
                <div class="col-md-3 column">
                  <label>Description</label>
                </div>
                <div class="col-md-9 column">
                  <p>We are looking for a talanted sales manger to lead our hardworking team of salesmen. Come join us and you will make so much
                    money that you will not know what to do with it. Woek for us and become your own boss, drive a lamborgini if you want we dont care
                    how you pay for it is non of our business, apply now.</p>
                </div>
              </div>
              <div class="row clearfix">
                <div class="col-md-3 column">
                  <label>Skills</label>
                </div>
                  <div class="col-md-9 column">
                  <p>Sales, English, Arabic, Microsoft Office, Excel </p>
                </div>
              </div>
              <div class="row clearfix">
                <div class="col-md-3 column">
                  <label>Message</label>
                </div>
                 <div class="col-md-9 column">
                   <p>Have a question about the job?</p>
                   <textarea></textarea>
                   <div><button class="btn btn-default hidden-sm hidden-xs pull-right" >Send</button></div>
                   <div><button class="btn btn-default btn-block  visible-xs visible-sm  pull-right">Send</button></div>
                </div>
              </div>
            </div>
            <div class="col-md-3 column">
               <div class="row clearfix">
                <div class="col-md-12 column">
                  <label>Company</label>
                  <p>Sales United</p>
                  <label>About</label>
                  <p>We are the leading sales traning company in Kuwait.</p>
                </div>
               </div>
                <div class="row clearfix">
                <div class="col-md-12 column">
                  <label>Location</label>
                  <p>Samsung Building, Floor 57, Kuwait City </p>
                  <button class="btn btn-default btn-block map-btn pull-right">Show Map</button>
                </div>
              </div>
            </div>
          </div>
         
      <div class="row clearfix">
         <div class="col-md-12 column">
              <div id="map-canvas" class="col-xs-8" style=" height:400px; width: 100%;"></div>
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
<script>


$(document).ready(function(){
  $(".apply-box").hide();
  $(".price-cost").click(function(){
    $(".apply-box").slideToggle(200);
  });
  
    $("#map-canvas").hide();
  $(".map-btn").click(function(){
    $("#map-canvas").slideToggle(200);
  });
});


</script>
</body>
</html>
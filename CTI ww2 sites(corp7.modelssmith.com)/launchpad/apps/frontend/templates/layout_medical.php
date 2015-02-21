<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
	
	<!-- following copied from original pages  -->
  <title>Medical Information Form &amp; Release of Liability
  (SQ)</title>
  <meta http-equiv="content-type" content=
  "text/html; charset=utf-8" />

<?php echo javascript_include_tag('/launchpad/js/jquery.min.js') ?>
<?php echo javascript_include_tag('/launchpad/js/jquery.validate.js') ?>
<?php echo javascript_include_tag('/launchpad/js/jquery.history.js') ?>

<!--
<?php echo javascript_include_tag('/launchpad/js/externalPage.js') ?>
<?php echo javascript_include_tag('/launchpad/js/FusionCharts.js') ?>
<?php echo javascript_include_tag('/launchpad/js/AnyChart.js') ?>
-->

<script>
$(document).ready(function() {

// add 'required' to all inputs/textareas in 'dabblePageFormItemRequired'
$('.dabblePageFormItemRequired input').addClass('required');
$('.dabblePageFormItemRequired textarea').addClass('required');
$('#w28846').addClass('required');
jQuery.validator.addMethod("notEqual", function(value, element, param) {
  return this.optional(element) || value != param;
}, "Please indicate your acceptance");

$('#dabblePageForm').validate({
  'rules': {
   'release_of_liability': { notEqual:"I do not accept" }
  }
});
$('.w1312').each( function(index){
  $(this).rules("add", {
    maxlength: 25,
    messages: { maxlength: jQuery.format("Please limit your response to 25 characters") }
  });
});

});
</script>
<style>
.error { color:#a00; }
</style>


<!--[if IE 6]><link rel="stylesheet" type="text/css" href="/launchpad/css/externalPage-ie6.css"/><![endif]--><!--[if IE 7]><link rel="stylesheet" type="text/css" href="/launchpad/css/externalPage-ie7.css"/><![endif]-->

  <style type="text/css">
/*<![CDATA[*/
  .dabblePageHeader {
  background-color: #ffffff;
  }
  .dabblePageLogo {
  background-color: #ffffff;
  }

  .dabblePageMenu a:hover, .dabblePageMenu li.selected a {
  background-color: #988e77;
  color: #000000;
  }

  .dabblePageNavigation { 
        padding-top: 109px;
  }

  .dabblePageHeader h1, .dabblePageUserMenu a:link, .dabblePageUserMenu a:visited {
  border-color: #988e77;
  background-color: #988e77;
  color: white;
  }

  .dabblePageSectionFormActions {
  background-color: #988e77;
  border-left-color: #988e77;
  color: black;
  }
  /*]]>*/
  </style>
  <meta name="viewport" content=
  "width=device-width; initial-scale=1.0; maximum-scale=1.0" />
  <link media="only screen and (max-device-width: 480px)" href=
  "./css/externalPage-mobile.css" type="text/css" rel=
  "stylesheet" /> <!-- /web20100316/css/externalPage-mobile.css -->
	<!-- end copied from original pages -->
	
  </head>
  <body>
    <?php echo $sf_content ?>
  </body>
</html>

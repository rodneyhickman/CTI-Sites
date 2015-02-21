<!DOCTYPE html>
<html>
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
	
	<!-- following copied from original pages  -->
  <title>Coaches Training Institute Application</title>
  <meta http-equiv="content-type" content=
  "text/html; charset=utf-8" />

<?php echo javascript_include_tag('/js/jquery.min.js') ?>
<?php echo javascript_include_tag('/js/jquery.validate.js') ?>
<?php echo javascript_include_tag('/js/jquery.history.js') ?>

<style>
textarea { min-height:100px; }
</style>
<script>
$(document).ready(function() {

// add 'required' to all inputs/textareas in 'dabblePageFormItemRequired'
$('.dabblePageFormItemRequired input').addClass('required');
$('.dabblePageFormItemRequired textarea').addClass('required');
$('#dabblePageForm').validate();
$('.w1312').each( function(index){
  $(this).rules("add", {
    maxlength: 25,
    messages: { maxlength: jQuery.format("Please limit your response to 25 characters") }
  });
});

});
</script>



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

.dabblePageText h2 {font-size:18px}
.dabblePageText h3 {font-size:14px}
.dabblePageFormItem h3 {font-size:12px}

  /*]]>*/
  </style>
  <meta name="viewport" content=
  "width=device-width; initial-scale=1.0; maximum-scale=1.0" />
<style>
.error { color:#a00; }
h1 { margin-bottom:20px !important; }
</style>
  </head>
  <body>
    <?php echo $sf_content ?>
  </body>
</html>

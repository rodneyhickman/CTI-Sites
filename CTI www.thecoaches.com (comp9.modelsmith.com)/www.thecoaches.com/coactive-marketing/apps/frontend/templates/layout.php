<!DOCTYPE html>
<html lang="en">
<head>

<?php include_http_metas() ?>
<?php include_metas() ?>
<?php include_title() ?>

<link rel="icon" href="/favicon.ico" />
<link rel="shortcut icon" href="/favicon.ico" />
<link rel="stylesheet" type="text/css" href="/res/css/coaches-training-institute.css" />
<link rel="stylesheet" type="text/css" href="/res/css/section_coach-training.css" />
<link rel="stylesheet" type="text/css" href="/res/css/content_internal_11c.css" /> 
<link rel="stylesheet" type="text/css" href="/res/css/mentor.css" />
<link rel="stylesheet" type="text/css" href="/leadership/conference/colorbox.css"/>
<link rel="stylesheet" type="text/css" href="/coactive-sales-class/css/main.css"/>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.8.20/themes/base/jquery-ui.css" type="text/css" media="all" />

<script src="http://www.google.com/jsapi"></script>
<script>google.load("jquery", "1.4.2");</script>
<script src="/res/js/jquery.validate.js"></script>
<script src="/res/js/jquery.colorbox-min.js"></script>
<script src="/res/js/jquery-ui-1.8.20.datepicker.min.js"></script>
<script>
google.setOnLoadCallback(function() {
 $('#group-select').change( function(){
   $('#group-form').submit();
 });
 $('.delete').click( function(){
   return confirm('Are you show you want to delete this item?');
 });
 $('#have-audio-url').click( function(){
   if($(this).attr('checked')){
     $('#audio-url').show();
     $('#audio-file').hide();
   }
   else {
     $('#audio-url').hide();
     $('#audio-file').show();
   }
 });
 $('.cancelbtn').click( function(){
 id = $(this).attr('id');
 window.location.href = "cancel?e="+id;
 });
 $('.regbtn').click( function(){
 id = $(this).attr('id');
 window.location.href = "register?e="+id;
 });
 $('.regassistbtn').click( function(){
 id = $(this).attr('id');
 window.location.href = "regAssist?e="+id;
});
$(".info-popup").colorbox({width:"60%"});
});
</script>
<style>
table.events { width: 525px; }
table.events th { text-align:left; font-size:1.1em; }


table.events tr:nth-child(even) { background-color: #F0F5F8; border: solid 1px #AAD }
table.events tr:nth-child(odd) { background-color: #D9E6EE; }
table.events tr:first-child { background-color: #EBE9DA; }

table.account-edit { width: 400px; } 
table.account td:nth-child(odd) { text-align:right; }
table.account input { width:170px; }
a.info-popup { font-size:90%; }
form.upload-form {
  margin-top:0;
  border-top: solid 2px #555;
  background-color: #D9E6EE;
  padding:10px;
}
form.upload-form textarea {
  width:450px;
  height:100px;
}
form.upload-form label,
form.upload-form textarea {
  display:block;
}
form.upload-form input {
  margin:5px 10px;
}
#audio-url {
display:none;
}
#audio-url input {
width:450px;
}
</style>
</head>
<body>
<div id="page">
  <!--<img id="portraits" src="/docs/images/course-materials-portraits.png" />-->
<div id="tools">
  <!-- generalID --><!-- -->
  <!-- eCommerceID --><!-- -->
  <!-- courseMaterialsID --><ul id="ecommerce">
<li><!--<a href="/" class="offsite">CTI <b>Home</b></a> &raquo;--> </li>

</ul>
<!-- -->
</div>
<div id="primary">
  <!-- contactNavID --><!-- -->
  <ul id="main-nav">
  </ul>
  
<div id="broadcast" style="padding:0 0 25px 0;">
  <img style="margin-top: -50px" src="/docs/images/content_marketing_hub.png" width="920" height="212" alt="Coach Training" usemap="#logobutton" />
  <map id="logobutton" name="logobutton">
  <area shape="rect" coords="790,0,850,103" href="/" title="CTI Home" alt="CTI Home" />
  </map>
</div>

<div id="content">

<div id="main">
  <div id="breadcrumbs">
  </div>
<div class="rightside">&raquo; <a href="<?php echo url_for('main/home') ?>">Home</a>&nbsp;&nbsp;&nbsp;&raquo; <a href="<?php echo url_for('main/logout'); ?>">Logout</a></div>

<div class="sec">
<ul class="bulleted-arrowed">
 
</ul>    
</div>


<div class="pri">
<p style="font-size:1.1em"><b>Welcome <?php echo $sf_user->getProfile()->getName(); ?></b><br />
<em>"<?php echo $sf_user->getProfile()->getPurpose(); ?>"</em>
  
</p>
  
  <?php echo $sf_content ?>

</div>

</div>

</p>


<!-- ctaAreaId -->

<div id="cta-area">

</div>

<!-- -->

</div>


<!-- used for cross-browser stabilizion of layout -->
<div class="pageclear"></div>
</div>
<div id="footer">
  <img id="cti-logo-tagged" src="/res/img/cti-changing-business-transforming-lives.gif" width="176" height="57" alt="cit: changing business. transforming lives."/>
<div id="footer-content">
  <!-- footerNavId --><div id="footer-nav">
<div id="footer-legal">Copyright &#169; <?php echo date('Y'); ?> The Coaches Training Institute. All rights reserved. <a id="privacy-link" href="http://www.thecoaches.com/legal/privacy.html">Privacy Policy</a><span class="divider">&#160;|&#160;</span><a href="http://www.thecoaches.com/legal/disclosure.html">Disclosure</a></div>
<ul id="quick-nav">
</ul>
</div>
<!-- -->
  <img id="icf-logo" src="/res/img/icf-logo.gif" width="74" height="57" alt="International Coach Federation"/>
</div>
</div>
</div>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-5715102-1");
pageTracker._trackPageview();
} catch(err) {}</script>
</body>
</html>

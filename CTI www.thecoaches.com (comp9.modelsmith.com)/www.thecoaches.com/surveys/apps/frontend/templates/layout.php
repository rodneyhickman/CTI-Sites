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
<link rel="stylesheet" type="text/css" href="/surveys/css/ui-lightness/jquery-ui-1.8.21.custom.css"/>

<script type="text/javascript" src="/data/_leaders.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script src="/res/js/jquery.validate.js"></script>
<script src="/res/js/jquery.colorbox-min.js"></script>
<script src="/res/js/jquery-ui-1.8.21.autocomplete.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$(".leader").autocomplete({ source: leaders, minLength: 0 }).focus(function(){ $(this).trigger('keydown.autocomplete'); });
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

textarea {
width:500px;
height:100px;
margin-top:8px;
}
input.text {
width: 500px;
margin-top: 8px;
}
.range { float:left; min-width: 50px; margin:20px 0; text-align:center;}

.submit { text-align:center; }
.submit input { width:150px; }
#survey-wrapper h2 { color:#444 }
div#content h2 { color:#222 }
.rightside {
float:right;
}
</style>
</head>
<body>
<div id="page">
  <img id="portraits" src="/docs/images/course-materials-portraits.png" />
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
  
<div id="broadcast">
  <img src="/docs/images/content_surveys.png" width="920" height="166" alt="Coach Training" usemap="#logobutton" style="margin-top:-35px" />
  <map id="logobutton" name="logobutton">
  <area shape="rect" coords="822,0,899,103" href="/" title="CTI Home" alt="CTI Home" />
  </map>
</div>


<div id="content">

<div id="main">
  <div id="breadcrumbs">
  </div>


<div class="sec">
<ul class="bulleted-arrowed">
 
</ul>    
</div>


<div class="pri">
<p style="font-size:1.1em"><!-- <b>Welcome <?php echo $sf_user->getProfile()->getName(); ?></b>
  <br />&raquo; <a href="<?php echo url_for('main/logout'); ?>">Logout</a> -->
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

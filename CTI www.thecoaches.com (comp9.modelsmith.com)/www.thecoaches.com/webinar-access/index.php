<?php

	ini_set("include_path",".:../docs/res/inc/:../../docs/res/inc/:../../../docs/res/inc/:../../../../docs/res/inc/"); ?>

<?php include 'webinar-access-login-check.php'; ?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>

<title>CTI: Webinar Access </title>

<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />

<meta http-equiv="Content-Language" content="en" />

<meta name="language" content="en" />

<meta name="keywords" content="" />

<meta name="description" content="" />

<meta name="author" content="The Coaches Training Institute (CTI)" />

<meta name="copyright" content="Copyright &#169; 2013 The Coaches Training Institute. All rights reserved." />

<link rel="icon" href="/favicon.ico" />

<link rel="shortcut icon" href="/favicon.ico" />

<link rel="stylesheet" type="text/css" href="/res/css/coaches-training-institute.css" />

<link rel="stylesheet" type="text/css" href="/res/css/section_coach-training.css" />



<link rel="stylesheet" type="text/css" href="/res/css/content_internal_11c.css" /> 

<link rel="stylesheet" type="text/css" href="http://www.thecoaches.com/assets/css/footer.css" /> 



<style media="screen" type="text/css">

.hidden { display:none; }

</style>



<script src="http://www.google.com/jsapi"></script>

<script>

google.load("jquery", "1.4.2");

google.setOnLoadCallback(function() {

});

</script>

<script type="text/javascript" src="http://www.ctifrance.fr/res/js/jquery.cookie.js"> </script>

<!-- <script type="text/javascript" src="http://www.ctifrance.fr/res/js/jquery.language.js"> </script> -->



<script type="text/javascript" src="/res/js/coaches-training-institute.js"> </script>



<script type="text/javascript">

<!--

//v1.7

// Flash Player Version Detection

// Detect Client Browser type

// Copyright 2005-2008 Adobe Systems Incorporated.  All rights reserved.

var isIE  = (navigator.appVersion.indexOf("MSIE") != -1) ? true : false;

var isWin = (navigator.appVersion.toLowerCase().indexOf("win") != -1) ? true : false;

var isOpera = (navigator.userAgent.indexOf("Opera") != -1) ? true : false;

function ControlVersion()

{
	debugger;
	var version;

	var axo;

	var e;

	// NOTE : new ActiveXObject(strFoo) throws an exception if strFoo isn't in the registry

	try {

		// version will be set for 7.X or greater players

		axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.7");

		version = axo.GetVariable("$version");

	} catch (e) {

	}

	if (!version)

	{

		try {

			// version will be set for 6.X players only

			axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.6");

			

			// installed player is some revision of 6.0

			// GetVariable("$version") crashes for versions 6.0.22 through 6.0.29,

			// so we have to be careful. 

			

			// default to the first public version

			version = "WIN 6,0,21,0";

			// throws if AllowScripAccess does not exist (introduced in 6.0r47)		

			axo.AllowScriptAccess = "always";

			// safe to call for 6.0r47 or greater

			version = axo.GetVariable("$version");

		} catch (e) {

		}

	}

	if (!version)

	{

		try {

			// version will be set for 4.X or 5.X player

			axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.3");

			version = axo.GetVariable("$version");

		} catch (e) {

		}

	}

	if (!version)

	{

		try {

			// version will be set for 3.X player

			axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.3");

			version = "WIN 3,0,18,0";

		} catch (e) {

		}

	}

	if (!version)

	{

		try {

			// version will be set for 2.X player

			axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash");

			version = "WIN 2,0,0,11";

		} catch (e) {

			version = -1;

		}

	}

	

	return version;

}

// JavaScript helper required to detect Flash Player PlugIn version information

function GetSwfVer(){

	// NS/Opera version >= 3 check for Flash plugin in plugin array

	var flashVer = -1;

	

	if (navigator.plugins != null && navigator.plugins.length > 0) {

		if (navigator.plugins["Shockwave Flash 2.0"] || navigator.plugins["Shockwave Flash"]) {

			var swVer2 = navigator.plugins["Shockwave Flash 2.0"] ? " 2.0" : "";

			var flashDescription = navigator.plugins["Shockwave Flash" + swVer2].description;

			var descArray = flashDescription.split(" ");

			var tempArrayMajor = descArray[2].split(".");			

			var versionMajor = tempArrayMajor[0];

			var versionMinor = tempArrayMajor[1];

			var versionRevision = descArray[3];

			if (versionRevision == "") {

				versionRevision = descArray[4];

			}

			if (versionRevision[0] == "d") {

				versionRevision = versionRevision.substring(1);

			} else if (versionRevision[0] == "r") {

				versionRevision = versionRevision.substring(1);

				if (versionRevision.indexOf("d") > 0) {

					versionRevision = versionRevision.substring(0, versionRevision.indexOf("d"));

				}

			}

			var flashVer = versionMajor + "." + versionMinor + "." + versionRevision;

		}

	}

	// MSN/WebTV 2.6 supports Flash 4

	else if (navigator.userAgent.toLowerCase().indexOf("webtv/2.6") != -1) flashVer = 4;

	// WebTV 2.5 supports Flash 3

	else if (navigator.userAgent.toLowerCase().indexOf("webtv/2.5") != -1) flashVer = 3;

	// older WebTV supports Flash 2

	else if (navigator.userAgent.toLowerCase().indexOf("webtv") != -1) flashVer = 2;

	else if ( isIE && isWin && !isOpera ) {

		flashVer = ControlVersion();

	}	

	return flashVer;

}

// When called with reqMajorVer, reqMinorVer, reqRevision returns true if that version or greater is available

function DetectFlashVer(reqMajorVer, reqMinorVer, reqRevision)

{

	versionStr = GetSwfVer();

	if (versionStr == -1 ) {

		return false;

	} else if (versionStr != 0) {

		if(isIE && isWin && !isOpera) {

			// Given "WIN 2,0,0,11"

			tempArray         = versionStr.split(" "); 	// ["WIN", "2,0,0,11"]

			tempString        = tempArray[1];			// "2,0,0,11"

			versionArray      = tempString.split(",");	// ['2', '0', '0', '11']

		} else {

			versionArray      = versionStr.split(".");

		}

		var versionMajor      = versionArray[0];

		var versionMinor      = versionArray[1];

		var versionRevision   = versionArray[2];

        	// is the major.revision >= requested major.revision AND the minor version >= requested minor

		if (versionMajor > parseFloat(reqMajorVer)) {

			return true;

		} else if (versionMajor == parseFloat(reqMajorVer)) {

			if (versionMinor > parseFloat(reqMinorVer))

				return true;

			else if (versionMinor == parseFloat(reqMinorVer)) {

				if (versionRevision >= parseFloat(reqRevision))

					return true;

			}

		}

		return false;

	}

}

function AC_AddExtension(src, ext)

{

  if (src.indexOf('?') != -1)

    return src.replace(/\?/, ext+'?'); 

  else

    return src + ext;

}

function AC_Generateobj(objAttrs, params, embedAttrs) 

{ 

  var str = '';

  if (isIE && isWin && !isOpera)

  {

    str += '<object ';

    for (var i in objAttrs)

    {

      str += i + '="' + objAttrs[i] + '" ';

    }

    str += '>';

    for (var i in params)

    {

      str += '<param name="' + i + '" value="' + params[i] + '" /> ';

    }

    str += '</object>';

  }

  else

  {

    str += '<embed ';

    for (var i in embedAttrs)

    {

      str += i + '="' + embedAttrs[i] + '" ';

    }

    str += '> </embed>';

  }

  document.write(str);

}

function AC_FL_RunContent(){

  var ret = 

    AC_GetArgs

    (  arguments, ".swf", "movie", "clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"

     , "application/x-shockwave-flash"

    );

  AC_Generateobj(ret.objAttrs, ret.params, ret.embedAttrs);

}

function AC_SW_RunContent(){

  var ret = 

    AC_GetArgs

    (  arguments, ".dcr", "src", "clsid:166B1BCA-3F9C-11CF-8075-444553540000"

     , null

    );

  AC_Generateobj(ret.objAttrs, ret.params, ret.embedAttrs);

}

function AC_GetArgs(args, ext, srcParamName, classid, mimeType){

  var ret = new Object();

  ret.embedAttrs = new Object();

  ret.params = new Object();

  ret.objAttrs = new Object();

  for (var i=0; i < args.length; i=i+2){

    var currArg = args[i].toLowerCase();    

    switch (currArg){	

      case "classid":

        break;

      case "pluginspage":

        ret.embedAttrs[args[i]] = args[i+1];

        break;

      case "src":

      case "movie":	

        args[i+1] = AC_AddExtension(args[i+1], ext);

        ret.embedAttrs["src"] = args[i+1];

        ret.params[srcParamName] = args[i+1];

        break;

      case "onafterupdate":

      case "onbeforeupdate":

      case "onblur":

      case "oncellchange":

      case "onclick":

      case "ondblclick":

      case "ondrag":

      case "ondragend":

      case "ondragenter":

      case "ondragleave":

      case "ondragover":

      case "ondrop":

      case "onfinish":

      case "onfocus":

      case "onhelp":

      case "onmousedown":

      case "onmouseup":

      case "onmouseover":

      case "onmousemove":

      case "onmouseout":

      case "onkeypress":

      case "onkeydown":

      case "onkeyup":

      case "onload":

      case "onlosecapture":

      case "onpropertychange":

      case "onreadystatechange":

      case "onrowsdelete":

      case "onrowenter":

      case "onrowexit":

      case "onrowsinserted":

      case "onstart":

      case "onscroll":

      case "onbeforeeditfocus":

      case "onactivate":

      case "onbeforedeactivate":

      case "ondeactivate":

      case "type":

      case "codebase":

      case "id":

        ret.objAttrs[args[i]] = args[i+1];

        break;

      case "width":

      case "height":

      case "align":

      case "vspace": 

      case "hspace":

      case "class":

      case "title":

      case "accesskey":

      case "name":

      case "tabindex":

        ret.embedAttrs[args[i]] = ret.objAttrs[args[i]] = args[i+1];

        break;

      default:

        ret.embedAttrs[args[i]] = ret.params[args[i]] = args[i+1];

    }

  }

  ret.objAttrs["classid"] = classid;

  if (mimeType) ret.embedAttrs["type"] = mimeType;

  return ret;

}

// -->

</script>



</head>

<body>

<div id="page">
  
<div id="tools">

  <!-- generalID --><!-- -->

  <!-- eCommerceID --><!-- -->

  <!-- courseMaterialsID --><!-- -->

</div>

<div id="primary">

  <!-- contactNavID --><!-- -->

  <ul id="main-nav">

  </ul>

  

<div id="broadcast-lh">

  <img src="/res/img/page-banners/content_webinar_access.png" width="920" height="124" alt="Coach Training" usemap="#logobutton" />

  <map id="logobutton" name="logobutton">

  <area shape="rect" coords="822,0,899,103" href="/" title="CTI Home" alt="CTI Home" />

  </map>

</div>









<div id="content">



<div id="main">



<div id="breadcrumbs">

<div style="margin: -5px 0 0px 0px; float: right; "></div>

</div>



  <div class="sec">  <!-- start left side nav -->



  <!-- <ul class="bulleted-arrowed">

    <li><a href="/docs/webinar-access/fundamentals/"><strong class="psuedo-head">Fundamentals</strong></a><br />

   <a href="bda.html#before"> &raquo; Before your course</a>

  </ul> -->

	<p>&nbsp;&nbsp;</p>



  </div>  <!-- end left side nav -->



  <div class="pri">



	<div class="en" style=""><!-- display:none -->

	<h1>Session One - September 25, 2013</h1>

	</div>

	

<script language="JavaScript" type="text/javascript">

AC_FL_RunContent(

'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0',

'width', '640',

'height', '400',

'src', 'moovee_player',

'quality', 'high',

'pluginspage', 'http://www.adobe.com/go/getflashplayer',

'align', 'middle',

'play', 'true',

'loop', 'true',

'scale', 'showall',

'wmode', 'window',

'devicefont', 'false',

'id', 'moovee_player',

'bgcolor', '#ffffff',

'name', 'moovee_player',

'menu', 'false',

'allowFullScreen', 'false',

'allowScriptAccess','sameDomain',

'movie', '/res/swf/moovee_player',

'flashvars','swfMovie=http://s3.amazonaws.com/ctivideo/2013-09-25_10_02_The_Neuroscience_of_the_Co-Active_Model.flv&swfThumb=http://www.thecoaches.com/webinar-access/webinars/neuroscience_260913_640_by_360.png&control_placement=1&bar_color=802D2F&bar_alpha=.7&progress_color=4889B2&timeline_color=3A2726&rollover_color=4889B2&text_color=3A2726&pop_color=4889B2&clock_color=FFFFFF&loaded_color=EAE9DA',

'salign', ''

); //end AC code

</script>



	<br />

	<div class="en" style=""><!-- display:none -->

	<h1>Session One Slides</h1>

	</div>

	<p><a href="/webinar-access/webinars/Neursocience of the Co-Active Model REV2.pdf">Session One Slides</a><br/>This download of the presentation slides are for your personal educational use only. You may not copy, reproduce, distribute or sell any material herein.</p>

	<br /><br />

	

	<div class="en" style=""><!-- display:none -->

	<h1>Session Two - October 02, 2013</h1>

	</div>

	

<script language="JavaScript" type="text/javascript">

AC_FL_RunContent(

'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0',

'width', '640',

'height', '400',

'src', 'moovee_player',

'quality', 'high',

'pluginspage', 'http://www.adobe.com/go/getflashplayer',

'align', 'middle',

'play', 'true',

'loop', 'true',

'scale', 'showall',

'wmode', 'window',

'devicefont', 'false',

'id', 'moovee_player',

'bgcolor', '#ffffff',

'name', 'moovee_player',

'menu', 'false',

'allowFullScreen', 'false',

'allowScriptAccess','sameDomain',

'movie', '/res/swf/moovee_player',

'flashvars','swfMovie=http://s3.amazonaws.com/ctivideo/2013-10-02_10_02_The_Neuroscience_of_the_Co-Active_Model.flv&swfThumb=http://www.thecoaches.com/webinar-access/webinars/neuroscience_260913_640_by_360.png&control_placement=1&bar_color=802D2F&bar_alpha=.7&progress_color=4889B2&timeline_color=3A2726&rollover_color=4889B2&text_color=3A2726&pop_color=4889B2&clock_color=FFFFFF&loaded_color=EAE9DA',

'salign', ''

); //end AC code

</script>



	<br />

	<div class="en" style=""><!-- display:none -->

	<h1>Session Two Slides</h1>

	</div>

	<p><a href="/webinar-access/webinars/Neuroscience Webinar Session Two AB rev2.pdf">Session Two Slides</a><br/>This download of the presentation slides are for your personal educational use only. You may not copy, reproduce, distribute or sell any material herein.</p>

	

	<div class="en" style=""><!-- display:none -->

	<h1>Session Three - October 09, 2013</h1>

	</div>

	

<script language="JavaScript" type="text/javascript">

AC_FL_RunContent(

'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0',

'width', '640',

'height', '400',

'src', 'moovee_player',

'quality', 'high',

'pluginspage', 'http://www.adobe.com/go/getflashplayer',

'align', 'middle',

'play', 'true',

'loop', 'true',

'scale', 'showall',

'wmode', 'window',

'devicefont', 'false',

'id', 'moovee_player',

'bgcolor', '#ffffff',

'name', 'moovee_player',

'menu', 'false',

'allowFullScreen', 'false',

'allowScriptAccess','sameDomain',

'movie', '/res/swf/moovee_player',

'flashvars','swfMovie=http://s3.amazonaws.com/ctivideo/2013-10-09_10_04_The_Neuroscience_of_the_Co-Active_Model.flv&swfThumb=http://www.thecoaches.com/webinar-access/webinars/neuroscience_260913_640_by_360.png&control_placement=1&bar_color=802D2F&bar_alpha=.7&progress_color=4889B2&timeline_color=3A2726&rollover_color=4889B2&text_color=3A2726&pop_color=4889B2&clock_color=FFFFFF&loaded_color=EAE9DA',

'salign', ''

); //end AC code

</script>



	<br />

	<div class="en" style=""><!-- display:none -->

	<h1>Session Three Slides</h1>

	</div>

	<p><a href="/webinar-access/webinars/Neuroscience Webinar Session Three AB rev2.pdf">Session Three Slides</a><br/>This download of the presentation slides are for your personal educational use only. You may not copy, reproduce, distribute or sell any material herein.</p>

	

	<div class="en" style=""><!-- display:none -->

	<h1>Session Four - October 16, 2013</h1>

	</div>

	

<script language="JavaScript" type="text/javascript">

AC_FL_RunContent(

'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0',

'width', '640',

'height', '400',

'src', 'moovee_player',

'quality', 'high',

'pluginspage', 'http://www.adobe.com/go/getflashplayer',

'align', 'middle',

'play', 'true',

'loop', 'true',

'scale', 'showall',

'wmode', 'window',

'devicefont', 'false',

'id', 'moovee_player',

'bgcolor', '#ffffff',

'name', 'moovee_player',

'menu', 'false',

'allowFullScreen', 'false',

'allowScriptAccess','sameDomain',

'movie', '/res/swf/moovee_player',

'flashvars','swfMovie=http://s3.amazonaws.com/ctivideo/2013-10-16_10_02_The_Neuroscience_of_the_Co-Active_Model.flv&swfThumb=http://www.thecoaches.com/webinar-access/webinars/neuroscience_260913_640_by_360.png&control_placement=1&bar_color=802D2F&bar_alpha=.7&progress_color=4889B2&timeline_color=3A2726&rollover_color=4889B2&text_color=3A2726&pop_color=4889B2&clock_color=FFFFFF&loaded_color=EAE9DA',

'salign', ''

); //end AC code

</script>



	<br />

	<div class="en" style=""><!-- display:none -->

	<h1>Session Four Slides</h1>

	</div>

	<p><a href="/webinar-access/webinars/Session Four AB3.pdf">Session Four Slides</a><br/>This download of the presentation slides are for your personal educational use only. You may not copy, reproduce, distribute or sell any material herein.</p>

	

	<br /><br />

	<a href="http://www.thecoaches.com/webinar-access/loginWA.php?logout=1">Logout</a>

	<br /><br /><br /><br /><br />

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

<?php include 'id_footer-nav-webinar-access.php'; ?>

</div>  <!-- end footer -->

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
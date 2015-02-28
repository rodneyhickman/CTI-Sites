<?php
/*  variable to section key
Career ........................ sec 1 ... q81 - q85 
Friends ....................... sec 7 ... q61 - q65 
Family ........................ sec 8 ... q71 - q74 
Significant Other/Romance ..... sec 9 ... q91 - q94 
Fun &amp; Recreation .......... sec 2 ... q11 - q14
Health ........................ sec 6 ... q41 - q45 
Money ......................... sec 3 ... q51 - q54 
Personal Growth ............... sec 5 ... q31 - q34 
Physical Environment .......... sec 4 ... q21 - q24 
*/
$Career = round( 1.07526 * ($_POST['q81'] + $_POST['q82'] + $_POST['q83'] + $_POST['q84'] + $_POST['q85']) / 5);
$FriendsFamily = round( 1.07526 * ($_POST['q61'] + $_POST['q62'] + $_POST['q63'] + $_POST['q64'] + $_POST['q65'] + $_POST['q71'] + $_POST['q72'] + $_POST['q73'] + $_POST['q74']) / 9);
$SigOther = round( 1.01 * ($_POST['q91'] + $_POST['q92'] + $_POST['q93'] + $_POST['q94']) / 4);
$FunRec = round( 1.07526 * ($_POST['q11'] + $_POST['q12'] + $_POST['q13'] + $_POST['q14']) / 4);
$Health = round( 1.07526 * ($_POST['q41'] + $_POST['q42'] + $_POST['q43'] + $_POST['q44'] + $_POST['q45']) / 5);
$Money = round( 1.07526 * ($_POST['q51'] + $_POST['q52'] + $_POST['q53'] + $_POST['q54']) / 4);
$Personal = round( 1.07526 * ($_POST['q31'] + $_POST['q32'] + $_POST['q33'] + $_POST['q34']) / 4);
$Physical = round( 1.07526 * ($_POST['q21'] + $_POST['q22'] + $_POST['q23'] + $_POST['q24']) / 4);

 ?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<META HTTP-EQUIV="Description" CONTENT="The Coaches Training Institute">
<META HTTP-EQUIV="Keywords" CONTENT="Coaching, Co-Active Coaching, Coach Training, Leadership, Relationship Coaching, Co-Active Network">
<title>Wheel of life</title>
<link rel="stylesheet" type="text/css" href="/css/main.css" />
<link rel="stylesheet" href="/docs/css/flora.all.css" type="text/css" media="screen" title="Flora (Default)">
<script type="text/javascript" src="/docs/js/jquery.js"></script>
<script type="text/javascript" src="/docs/js/jquery.dimensions.js"></script>
<script type="text/javascript" src="/docs/js/ui.mouse.js"></script>
<script type="text/javascript" src="/docs/js/ui.slider.js"></script>
<script type="text/javascript">
$(document).ready( function(){

  // initialize document
  $('.ui-slider-1').slider();  // create all sliders 
  $('.section').hide();        // hide all sections ( '.section' means all elements with class="section" )
  $('#section1').show();       // show section 1    ( '#section1' means element with id="section1" )

  // attach button event handlers
  $('.next-btn').click( // when clicked, do the following
    function() {
      var parentId = $(this).parent().attr('id'); // get the parent id ie. 'section1'

      var myRe = /section(\d+)/;              // capture the numeric portion of the id 
      var myArray = myRe.exec(parentId);      // put capture into array
      var nextNum = parseInt(myArray[1]) + 1; // increment it
 
      var section = '#section' + nextNum;     // create new id

      $(this).parent().hide();                // hide current section
      $(section).show();                      // show next section
    });

  $('.prev-btn').click(
    function() {
      var parentId = $(this).parent().attr('id'); // get the parent id ie. 'section2'

      var myRe = /section(\d+)/;              // capture the numeric portion of the id
      var myArray = myRe.exec(parentId);      // put capture into array
      var prevNum = parseInt(myArray[1]) - 1; // increment it

      var section = '#section' + prevNum;     // create new id

      $(this).parent().hide();                // hide current section
      $(section).show();                      // show next section
    });

    $('#wolForm').submit( function(){
      // alert('submitting...');
      // populate all .slider-values
      $('.slider-value').each( function(){
         var value = $(this).parent().find('.ui-slider-1').slider('value');
         $(this).attr('value',value);
      });
    });

    $('#check').click( function() {
      alert('foo: '+$('#foo').slider('value'));
    });
});
</script>
<style type="text/css">
h1 {
	color:#689BBC;
	font-size:22px;
	}
.section-table {
   width:700px;
	 padding: 0 5px 0 5px;
   }
.headrow {
   text-align:left;
   }
.tdright {
	text-align:right;
	}
.tdleft {
	text-align:left;
	}
.mono {
	font-family:"Courier New",Courier,monospace;
	text-align:right;
	display:inline;
	float:right;
	}
#resultstext {
	 width:250px;
   }
#resultsbox {
	 width:250px;
   }
</style> 
</head>
<body style="font-family: arial,helvetica,sans-serif;width:680px;">  <!-- shelly width:920px; -->

   <!-- Begin Wrapper -->
   <div id="wrapper">
   
		 <!-- Begin Header   remove style for shelly width -->
		 <!-- <div id="header" style="overflow:hidden;width:670px;">
			<img src="/docs/res/img/page-banners/content-assessment-wheel.jpg" width="920" height="123" alt="assessment wheel banner" />
		 </div>  remove for now per Kevin, this page only accessed from toolkit page -->
		 <!-- End Header -->
		 
		 <!-- Begin Left Column  empty for now -->
		 <div id="leftcolumn">
     </div>
		 <!-- End Left Column -->
		 
		 <!-- Begin Right Column-->
		 <div id="rightcolumn">
                
					<!-- Begin Interiortop empty for now-->
					<div id="interiortop"  style="border-bottom: 0px">
					</div>
					<!-- End Interiortop -->
				 <div class="clear"></div>
				 
         <div id="maincontent">
         <div id="wheeltool">
<!-- <a style="float:right" href="http://www.thecoaches.com/">Return to CTI home »</a> -->	

<div>  <!-- div for canvas -->
	<canvas id="wolCanvas" width="425" height="420" style="padding-left:5px;float:right;">
	</canvas> 
</div>		
 
<div id="resultstext">
<h1>Your Assessment Wheel Results!</h1> 
         
<p style="font-size: 11px; border-bottom: 0px solid #ccc; margin-bottom: 10px"><i>
The percentages below represent a snapshot of your life; the higher the percentage the more satisfied you are in that particular area of your life. As you read over the percentages you will find areas where you can acknowledge yourself for the success you have created and areas where you may want to improve your level of satisfaction. Look at your completed Wheel; if your life is riding on this Wheel, how bumpy is the ride?
</i></p>
<br />
<div id="resultsbox">
    <table style="padding:10px;border:solid;border-color:#689BBC;font-size: 11px;">   <!--  -->
				<tr>
<td class="tdleft">Career<span class="mono">&nbsp; .................&nbsp;</span></td><td class="tdright"><?php echo $Career ?>%</td>
				</tr><tr>
<td class="tdleft">Family &amp; Friends<span class="mono">&nbsp;..........&nbsp;</span></td><td class="tdright"><?php echo $FriendsFamily ?>%</td>
				</tr><tr>
<td class="tdleft">Significant Other/Romance<span class="mono">&nbsp;...&nbsp;</span></td><td class="tdright"><?php echo $SigOther ?>%</td>
				</tr><tr>
<td class="tdleft">Fun &amp; Recreation<span class="mono">&nbsp;..........&nbsp;</span></td><td class="tdright"><?php echo $FunRec ?>%</td>
				</tr><tr>
<td class="tdleft">Health<span class="mono">&nbsp;..................&nbsp;</span></td><td class="tdright"><?php echo $Health ?>%</td>
				</tr><tr>
<td class="tdleft">Money<span class="mono">&nbsp;.................&nbsp;</span></td><td class="tdright"><?php echo $Money ?>%</td>
				</tr><tr>
<td class="tdleft">Personal Growth<span class="mono">&nbsp;..........&nbsp;</span></td><td class="tdright"><?php echo $Personal ?>%</td>
				</tr><tr>
<td class="tdleft">Physical Environment<span class="mono">&nbsp;.......&nbsp;</span></td><td class="tdright"><?php echo $Physical ?>%</td>
				</tr>
    </table>
</div>
</div>  <!-- end result text -->

<!-- old coding here in case we need it
<iframe src="http://www.thecoaches.com/docs/wol_frame.html?<?php echo 'q11='.$_POST['q11'].'&q12='.$_POST['q12'].'&q13='.$_POST['q13'].'&q14='.$_POST['q14'].'&q21='.$_POST['q21'].'&q22='.$_POST['q22'].'&q23='.$_POST['q23'].'&q24='.$_POST['q24'].'&q31='.$_POST['q31'].'&q32='.$_POST['q32'].'&q33='.$_POST['q33'].'&q34='.$_POST['q34'].'&q41='.$_POST['q41'].'&q42='.$_POST['q42'].'&q43='.$_POST['q43'].'&q44='.$_POST['q44'].'&q45='.$_POST['q45'].'&q51='.$_POST['q51'].'&q52='.$_POST['q52'].'&q53='.$_POST['q53'].'&q54='.$_POST['q54'].'&q61='.$_POST['q61'].'&q62='.$_POST['q62'].'&q63='.$_POST['q63'].'&q64='.$_POST['q64'].'&q65='.$_POST['q65'].'&q71='.$_POST['q71'].'&q72='.$_POST['q72'].'&q73='.$_POST['q73'].'&q74='.$_POST['q74'].'&q81='.$_POST['q81'].'&q82='.$_POST['q82'].'&q83='.$_POST['q83'].'&q84='.$_POST['q84'].'&q85='.$_POST['q85'].'&q91='.$_POST['q91'].'&q92='.$_POST['q92'].'&q93='.$_POST['q93'].'&q94='.$_POST['q94'] ?>" width="670" height="350" style="border:none;">
</iframe> 
-->

<br /><br /><br /><br /><br />

 
           </div>
           <!-- End Wheel Tool -->
           
           </div>
           <!-- End Main Content -->
         
		 </div>
	 <!-- End Right Column -->
     
   </div>
   <!-- End Wrapper -->
	<script>
		// setup wolcanvas
		// image circle is 192px in diameter
		var onepct = 1.92;
		var FunRecRadius = <?php echo $FunRec ?>  * onepct;
		var HealthRadius = <?php echo $Health ?>  * onepct;
		var MoneyRadius = <?php echo $Money ?>  * onepct;
		var PersonalRadius = <?php echo $Personal ?>  * onepct;
		var PhysicalRadius = <?php echo $Physical ?>  * onepct;
		var CareerRadius = <?php echo $Career ?>  * onepct;
		var FriendsFamilyRadius = <?php echo $FriendsFamily ?>  * onepct;
		var SigOtherRadius = <?php echo $SigOther ?>  * onepct;
		var c=document.getElementById("wolCanvas");
		var ctx=c.getContext("2d");
		var img = new Image();      // Create new img element
		img.src = '/docs/res/img/wol-canvas-image420.jpg';   // Set image source path
		ctx.lineWidth=3;  // set line width to 3px
		img.onload = function(){
			// execute drawImage statements here
			ctx.drawImage(img,5,5);
			ctx.beginPath();  // start drawing circle segments
			if (FunRecRadius > 0) {           // first segment
			// draw arc at actual radius
				ctx.arc(215,211,FunRecRadius,0,.25*Math.PI);
			} else {
			// draw zero radius arc at 1% radius (much easier than adding lines to center point
				ctx.arc(215,211,1,0,.25*Math.PI);
			}
			if (HealthRadius > 0) {           // second segment
			// draw arc at actual radius
				ctx.arc(215,211,HealthRadius,.25*Math.PI,.5*Math.PI);
			} else {
			// draw zero radius arc at 1% radius (much easier than adding lines to center point
				ctx.arc(215,211,1,.25*Math.PI,.5*Math.PI);
			}
			if (MoneyRadius > 0) {           // third segment
			// draw arc at actual radius
				ctx.arc(215,211,MoneyRadius,.5*Math.PI,.75*Math.PI);
			} else {
			// draw zero radius arc at 1% radius (much easier than adding lines to center point
				ctx.arc(215,211,1,.5*Math.PI,.75*Math.PI);
			}
			if (PersonalRadius > 0) {           // forth segment
			// draw arc at actual radius
				ctx.arc(215,211,PersonalRadius,.75*Math.PI,1*Math.PI);
			} else {
			// draw zero radius arc at 1% radius (much easier than adding lines to center point
				ctx.arc(215,211,1,.75*Math.PI,1*Math.PI);
			}
			if (PhysicalRadius > 0) {           // fifth segment
			// draw arc at actual radius
				ctx.arc(215,211,PhysicalRadius,1*Math.PI,1.25*Math.PI);
			} else {
			// draw zero radius arc at 1% radius (much easier than adding lines to center point
				ctx.arc(215,211,1,1*Math.PI,1.25*Math.PI);
			}
			if (CareerRadius > 0) {           // sixth segment
			// draw arc at actual radius
				ctx.arc(215,211,CareerRadius,1.25*Math.PI,1.5*Math.PI);
			} else {
			// draw zero radius arc at 1% radius (much easier than adding lines to center point
				ctx.arc(215,211,1,1.25*Math.PI,1.5*Math.PI);
			}
			if (FriendsFamilyRadius > 0) {           // seventh segment
			// draw arc at actual radius
				ctx.arc(215,211,FriendsFamilyRadius,1.5*Math.PI,1.75*Math.PI);
			} else {
			// draw zero radius arc at 1% radius (much easier than adding lines to center point
				ctx.arc(215,211,1,1.5*Math.PI,1.75*Math.PI);
			}
			if (SigOtherRadius > 0) {           // eigth segment
			// draw arc at actual radius
				ctx.arc(215,211,SigOtherRadius,1.75*Math.PI,2*Math.PI);
			} else {
			// draw zero radius arc at 1% radius (much easier than adding lines to center point
				ctx.arc(215,211,1,1.75*Math.PI,2*Math.PI);
			}
			if (SigOtherRadius < FunRecRadius) {
				//  draw final line out to FunRec radius
				ctx.lineTo(215+FunRecRadius,211);
			} else if (SigOtherRadius > FunRecRadius) {
				//  draw final in to FunRec radius
				ctx.lineTo(215+FunRecRadius,211);
			} else {
				//  do nothing, arc already meet
			}
			ctx.stroke();
		};
	</script> 
</body>
</html>

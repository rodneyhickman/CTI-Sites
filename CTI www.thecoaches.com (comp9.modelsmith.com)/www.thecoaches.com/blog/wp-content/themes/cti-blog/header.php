<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

	<head>

		<title><?php wp_title(':', true, 'right'); ?> Coaches Training Institute : Transforum</title>
		<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Language" content="en" />
		<meta name="language" content="en" />
		<meta name="keywords" content="coach training, leadership training, organizational coach training, co-active, become a coach, training coaching, coach certification, coaching certification, coach training, coaching as a career, transformational learning, in person training, face to face training, mentoring, business coaching, business transformation, personal transformation, worldwide coaching, change career, improve career, help people, people to people, active listening, Henry Kimsey-House, Karen Kimsey-House, CPCC, Co-Active Coaching, co-Active model, co-Active Leadership" />
		<meta name="description" content="CTI, The Coaches Training Institute trains more coaches around the world than any other training group. Using our Co-Active model, we helped establish the coach training industry and were a founder of the ICF. Through our coach training, you can become an ICF certified coach. Through our Leadership training, you can raise your leadership skills to new and unexpected heights. Our Organizational training helps companies train their managers to get the most out of happy employees." />
		<meta name="author" content="The Coaches Training Institute (CTI)" />
		<meta name="copyright" content="Copyright &#169; 2009 The Coaches Training Institute. All rights reserved." />
		<meta name="googlebot" content="" />
                <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
		<link rel="icon" href="http://www.thecoaches.com/favicon.ico" />
		<link rel="shortcut icon" href="http://www.thecoaches.com/favicon.ico" />
		<link rel="stylesheet" type="text/css" href="http://www.thecoaches.com/res/css/coaches-training-institute.css" />
		<link rel="stylesheet" type="text/css" href="http://www.thecoaches.com/res/css/section_coach-training.css" />
		<link rel="stylesheet" type="text/css" href="http://www.thecoaches.com/res/css/content_internal_11.css" />
		<script type="text/javascript" src="http://www.thecoaches.com/res/js/coaches-training-institute.js"> </script>
		
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
        <?php
	

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
<style>
#special {
  padding:30px;
}
.postEntry { max-width: 645px;  }
ul.headerNav {
width: 740px;
}

.gsc-input{padding:0px;  !important;}
.gsc-search-button{padding:0px;  !important;}

@media screen and (-webkit-min-device-pixel-ratio:0) {
 .gsc-input{padding:0px !important;}
.gsc-search-button{padding:0px !important;}
}
.gsc-search-box-tools .gsc-search-box .gsc-input{padding-right:0px !important;}
td.gsc-search-button{width:0px !important;}
table.gsc-search-box{ width:95% !important; }

.gsib_b, .gsib_a{padding:0px !important;}
.gsc-control-cse{background:none !important;}
.cse .gsc-control-cse, .gsc-control-cse{padding:0px !important; border:0px !important;}
.cse .gsc-search-button input.gsc-search-button-v2, input.gsc-search-button-v2{padding:6px 10px !important;}
#gsc-i-id1{background:none !important;}
</style>
	<script type="text/javascript">
		function show(object,val) {
			document.getElementById(object).style.visibility = val;
		}
	</script>
    <link rel="stylesheet" type="text/css" href="http://www.thecoaches.com/res/css/home-footer.css" />
	<script type="text/javascript" src="http://www.thecoaches.com/res/js/coaches-training-institute.js"> </script>
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
	<script type="text/javascript" src="http://www.thecoaches.com/res/js/specials.js"> </script>
	<script type="text/javascript" src="http://www.thecoaches.com/res/js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="http://www.thecoaches.com/res/js/jquery.expire.js"> </script>
	<script language="JavaScript" type="text/javascript">
	var html = '';
	var count = 0;
	google.setOnLoadCallback(function(){
	jQuery.contentExpirator('expire');
	  $.get('/blog/feed/', function(xml){
	        $("item", xml).each(function(){
	                count++;
	                if(count > 3) return false;
	                $(this).find("link").each(function(){
	                        html += "<div class='blog-entry'><strong><a href='" + getNodeText(this) +"'> ";
	                }).end().find("title").each(function(){
	                        html += getNodeText(this) + "</a></strong>";
	                }).end().find("description").each(function(){
	                        html += "<p style='font-size: 12px;'>" + getNodeText(this).substring(0, 150) +" […]<br />";
	                }).end().find("link").each(function(){
	                        html += "<a href='" +getNodeText(this) + "'>Continue reading &raquo;</a></p></div>";
	                });
	        });
	        $("#home-news").html(html);
           });
           $.get('/_special.html', function(data){
               $('#special').html(data);
           });
	});
	
	function getNodeText(node)
	{
	        var text = "";
	        if(node.text) text = node.text;
	        if(node.firstChild) text = node.firstChild.nodeValue;
	        return text;
	}
	</script>
    <style type="text/css">
    .box{
       
        display: none;
      
    }
  
</style>
    <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("select").change(function(){
            $( "select option:selected").each(function(){
                if($(this).attr("value")=="red"){
                    $(".box").hide();					
                    $(".red").show();
                }
                if($(this).attr("value")=="green"){
                    $(".box").hide();
                    $(".green").show();
                }
                if($(this).attr("value")=="blue"){
                    $(".box").hide();
                    $(".blue").show();
                }
				if($(this).attr("value")=="all"){
               		 $(".box").hide();
               		 $(".all").show();
				}
				 if($(this).attr("value")=="edomain"){
					 
					 $(".box").hide();
					$(".edomain").show();
					/* $('.edomain').each(function() {
					var text = $(this).text();
					$(this).html(text.replace('newmi', '&lt;?php include("includes/entire1.php"); &gt;')); 
				});
					$(".edomain").show(); */
					// $(".red").remove( ":contains(include('includes/entire1.php');)" );
					//$(".green").remove( ":contains(include('includes/entire2.php');)" );				
					//$(".edomain").show();
					
				}		
            });
        }).change();
    });


  
</script>
	<link rel="stylesheet" href="http://www.thecoaches.com/assets/css/style.css">
	<link rel="stylesheet" href="http://www.thecoaches.com/assets/css/blogNav.css">
	<!--[if IE 7]><link rel="stylesheet" href="http://www.thecoaches.com/assets/css/ie7.css"><![endif]-->
	<script type="text/javascript">
		function show(object,val) {
			document.getElementById(object).style.visibility = val;
		}
	</script>
    
	<!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->
	
	<!-- All JavaScript at the bottom, except this Modernizr build.
	     Modernizr enables HTML5 elements & feature detects for optimal performance.
	     Create your own custom Modernizr build: www.modernizr.com/download/ -->
	<!-- script type="text/javascript" src="http://www.thecoaches.com/assets/js/libs/modernizr-2.5.2.min.js"></script -->
	
	<script type="text/javascript" src="http://use.typekit.com/guz2yef.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<style>
div#tools ul.headerNav li, ul#ecommerce li {
float: left;
padding-top: 6px;
}
div#tools ul.headerNav li a, ul#ecommerce li a {
font-family: "Georgia", serif;
display: block;
color: #32110A;
margin: 0;
font-weight: 300;
padding: 0 10px;
text-transform: none;
font-size: 11px;
text-align: left;
text-decoration: none;
width: auto;
border-right: 1px solid black;
}

div#tools  li.last a,
div#tools  li.intl a{
border-right: none !important;
}

/*---------------- MAINNAV -----------------*/
div#tools li.intl { 
    position: relative;
                                border-right: none;
}

div#tools li.intl:hover { 
    position: relative;
    background-color: #f3f3ea;
}
div#tools ul li.intl:hover ul.cti-intl {
    display: block;
}

div#tools ul.cti-intl { 
    position: absolute; 
    list-style: none; 
    padding: 0; 
    margin: 0; 
    z-index: 1000; 
    padding: 25px 0 15px; 
    border-bottom: 8px solid #dcd8cc; 
    background-color: #f3f3ea; 
    width: 247px; 
    display: none; 
}

div#tools ul.cti-intl li {
    display: block;
    padding-top: 0;
border-right: 0 solid black;
}
div#tools ul.cti-intl li a {
    display: block;
    font-family: "Arial",sans-serif;
    font-size: 13px;
    font-weight: normal;
    padding-left: 36px;
    padding-right: 8px; 
    width: 180px; 
    
}

div#tools ul.cti-intl li.dynamic a { 
    display: block; 
    line-height: 26px; 
    height: 26px; 
    border-bottom: 1px solid #BBBBBB; 
    background: transparent 6px center no-repeat;
}
div#tools ul.cti-intl li.static a { 
    display: block; 
    background: none; 
    color: #32110A; 
    font-family: Arial,sans-serif; 
    font-size: 13px; 
    font-weight: normal; 
    height: 26px; 
    line-height: 26px; 
    padding: 0 15px; 
    text-decoration: none; 
    text-transform: none; 
    border-bottom: 1px solid #BBBBBB; 
    margin: 0 10px; 
    width: 195px;
}
div#tools ul.cti-intl li.dynamic a:hover,
div#tools ul.cti-intl li.static a:hover { color: #000000; background: #D6D5C1 6px center no-repeat; text-decoration: none; }


li#nav-sub-community:hover { border-top: 4px solid #7f9d39; }
li#nav-sub-community:hover ul { border-bottom: 8px solid #7f9d39; }


</style>
                             
</head>

	<body>

		<div id="page">

			<div id="tools" style="padding: 10px 20px 4px 10px;">

				<!-- generalID --><ul class="headerNav">

<li><a href="http://www.thecoaches.com/">Home</a></li>
			<li><a href="http://www.coactivenetwork.com/" target="_blank" class="offsite">Co-Active Network</a></li>
			<li><a href="http://www.coactivenetwork.com/webx?ctiFindACoach@@" target="_blank" class="offsite">Find A Coach</a></li>
			<li><a href="http://www.thecoaches.com/contact-us/newsletter">e-Newsletter</a></li>
			<li><a href="/blog/">Blog</a></li>
			<li><a href="http://www.thecoaches.com/pressroom">Press Room</a></li>
			<li><a href="http://www.thecoaches.com/contact-us">Contact Us</a></li>
			<li class="last intl">
				<a href="http://www.thecoaches.com/why-cti/cti-international" id="ctiIntl" class="">CTI International</a>
				<ul class="cti-intl" id="selectCountry">
						<li class="dynamic">
		<a href="http://www.coactivecoaching.be/" target="_blank" style="background-image: url(http://www.thecoaches.com/ee_newsletter/images/uploads/img_flag_belgium.png);">Belgium</a>
	</li>

	<li class="dynamic">
		<a href="http://www.augere.es/" target="_blank" style="background-image: url(http://www.thecoaches.com/ee_newsletter/images/uploads/img_flag_brazil.png);">Brazil</a>
	</li>

	<li class="dynamic">
		<a href="http://www.thecoaches.com/"   onClick="document.getElementById('ctiIntl').className=this.title; document.getElementById('inputBox').value=this.title" title="canada" style="background-image: url(http://www.thecoaches.com/ee_newsletter/images/uploads/img_flag_canada.png);">Canada</a>
	</li>

	<li class="dynamic">
		<a href="http://www.co-activity.cn/" target="_blank" style="background-image: url(http://www.thecoaches.com/ee_newsletter/images/uploads/img_flag_china.png);">China</a>
	</li>

	<li class="dynamic">
		<a href="http://www.ctinordic.dk/" target="_blank" style="background-image: url(http://www.thecoaches.com/ee_newsletter/images/uploads/img_flag_denmark.png);">Denmark</a>
	</li>

	<li class="dynamic">
		<a href="http://www.ctifrance.fr/index.html" target="_blank" style="background-image: url(http://www.thecoaches.com/ee_newsletter/images/uploads/img_flag_france.png);">France</a>
	</li>

	<li class="dynamic">
		<a href="http://www.co-active-coaching.de/" target="_blank" style="background-image: url(http://www.thecoaches.com/ee_newsletter/images/uploads/img_flag_germany.png);">Germany</a>
	</li>

	<li class="dynamic">
		<a href="http://www.thecoaches.co.jp/" target="_blank" style="background-image: url(http://www.thecoaches.com/ee_newsletter/images/uploads/img_flag_japan.png);">Japan</a>
	</li>

	<li class="dynamic">
		<a href="http://www.augere.es/" target="_blank" style="background-image: url(http://www.thecoaches.com/ee_newsletter/images/uploads/img_flag_mexico.png);">Mexico</a>
	</li>

	<li class="dynamic">
		<a href="http://www.ctinordic.no/" target="_blank" style="background-image: url(http://www.thecoaches.com/ee_newsletter/images/uploads/img_flag_norway.png);">Norway</a>
	</li>

	<li class="dynamic">
		<a href="http://www.koreacti.com/" target="_blank" style="background-image: url(http://www.thecoaches.com/ee_newsletter/images/uploads/img_flag_s-korea.png);">South Korea</a>
	</li>

	<li class="dynamic">
		<a href="http://www.augere.es/" target="_blank" style="background-image: url(http://www.thecoaches.com/ee_newsletter/images/uploads/img_flag_spain.png);">Spain</a>
	</li>

	<li class="dynamic">
		<a href="http://www.ctinordic.se/" target="_blank" style="background-image: url(http://www.thecoaches.com/ee_newsletter/images/uploads/img_flag_sweden.png);">Sweden</a>
	</li>

	<li class="dynamic">
		<a href="http://www.coactivecoaching.ch" target="_blank" style="background-image: url(http://www.thecoaches.com/ee_newsletter/images/uploads/img_flag_switzerland.png);">Switzerland</a>
	</li>

	<li class="dynamic">
		<a href="http://www.ctinederland.nl/" target="_blank" style="background-image: url(http://www.thecoaches.com/ee_newsletter/images/uploads/img_flag_netherlands.png);">The Netherlands</a>
	</li>

	<li class="dynamic">
		<a href="https://elemental-v.com/default.aspx" target="_blank" style="background-image: url(http://www.thecoaches.com/ee_newsletter/images/uploads/img_flag_turkey.png);">Turkey</a>
	</li>

	<li class="dynamic">
		<a href="http://www.thecoachesdubai.com/" target="_blank" style="background-image: url(http://www.thecoaches.com/ee_newsletter/images/uploads/img_flag_uae.png);">United Arab Emirates</a>
	</li>

	<li class="dynamic">
		<a href="http://www.coaching-courses.com/" target="_blank" style="background-image: url(http://www.thecoaches.com/ee_newsletter/images/uploads/img_flag_uk.png);">United Kingdom</a>
	</li>

	<li class="dynamic">
		<a href="http://www.thecoaches.com/"   onClick="document.getElementById('ctiIntl').className=this.title; document.getElementById('inputBox').value=this.title" title="united-states" style="background-image: url(http://www.thecoaches.com/ee_newsletter/images/uploads/img_flag_usa.png);">United States</a>
	</li>

	<li class="static">
		<a href="http://www.thecoaches.com/why-cti/cti-international">All International Locations</a>
	</li>
				</ul>
			</li>
		</ul>



<script type="text/javascript">

	$(document).ready(function(){
		
		var cookie = $.cookie('setCountry');
		
		// If the cookie has been set in a previous page load, show it in the div directly:
		if(!cookie) $('#ctiIntl').addClass("united-states").show();
		if(cookie) $('#ctiIntl').addClass(cookie).show();
		// if(cookie) $('.ctiIntl').text(cookie).show();
							   
		$('#selectCountry2 li a[title]').click(function(){
			var text = $('#inputBox').val();
			
			// Setting a cookie with a 7 day validity:
			$.cookie('setCountry',text,{expires: 7, path: '/', domain: 'www.thecoaches.com'});
			
			// $('.country').addClass(text);
				$('#ctiIntl').removeClass(cookie);
				$('#ctiIntl').addClass(text);
			
			// e.preventDefault();
		});
		
		$('#form1').submit(function(e){e.preventDefault();})
		
	})
	
</script>

<!-- -->

				<!-- eCommerceID --><ul id="ecommerce" style="padding-top: 0;">
<li><a href="http://www.amerisites.com/sc/cart.cgi?item=a-6814" class="offsite">My Cart</a><span class="divider"></li>
<li class="last"><a id="checkout" href="http://www.amerisites.com/sc/gt.cgi?item=a-6814" class="offsite">Checkout</a></li>
</ul>
<!-- -->

			</div>

			<div id="primary">

				<!-- contactNavID
				<ul id="contact-nav">
				<li id="contacttop"><a href="http://www.thecoaches.com/contact/schedule-a-call/" class="arrowlink">Contact a Program Advisor: <span class="bold black">1.800.691.6008</span></a></li>
				<li><a href="http://www.thecoaches.com/contact/conference/" class="arrowlink">Join Us for a <span class="bold black">Free Info Call</span></a></li>
				<li><a href="http://www.thecoaches.com/international/" class="arrowlink"><abbr title="Coaches Training Institute">CTI</abbr> <span class="bold black">International</span></a></li>
				</ul>
				 -->

				<div id="broadcast">

					<img src="http://www.thecoaches.com/res/img/page-banners/content-blog-new.gif" alt="CTI blog" usemap="#logobutton" style="margin-top: -8px;" />
					<map id="logobutton" name="logobutton">
				 	<area shape="rect" coords="775,0,850,103" href="/" title="CTI Home" alt="CTI Home" />
					</map>

				</div>
				
				<!-- <iframe src="http://www.thecoaches.com/layout/blog_nav" width="760" style="padding: 0; margin: 0; border-width: 0; overflow: hidden; float: left; height: 400px; position: absolute; z-index: 1000;"></iframe> -->
  				<ul class="blogNav" style="float: left; width: 760px; padding-top: 10px;">
  					<li class="level-1 first" id="nav-sub-why-cti"><a href="http://www.thecoaches.com/why-cti">Why CTI?</a>
						<ul>
							<li class="level-2 first" id="nav-sub-about-cti"><a href="http://www.thecoaches.com/why-cti/about-cti">About CTI</a></li>
							<li class="level-2" id="nav-sub-what-is-co-active"><a href="http://www.thecoaches.com/why-cti/what-is-co-active">What is Co-Active?</a></li>
							<li class="level-2" id="nav-sub-management"><a href="http://www.thecoaches.com/why-cti/management">Management Team</a></li>
							<li class="level-2" id="nav-sub-buy-the-book"><a href="http://www.thecoaches.com/why-cti/buy-the-book">Buy the Book</a></li>
							<li class="level-2 last" id="nav-sub-accreditation-faqs"><a href="http://www.thecoaches.com/why-cti/accreditation-faqs">Accreditation FAQs</a></li>
						</ul>
					</li>
					<li class="level-1" id="nav-sub-coach-training"><a href="http://www.thecoaches.com/coach-training">Coach Training</a>
						<ul>
							<li class="level-2 first" id="nav-sub-courses"><a href="http://www.thecoaches.com/coach-training/courses">Courses</a></li>
							<li class="level-2" id="nav-sub-certification"><a href="http://www.thecoaches.com/coach-training/certification">Certification</a></li>
							<li class="level-2" id="nav-sub-dates-locations"><a href="http://www.thecoaches.com/coach-training/dates-locations">Dates & Locations</a></li>
							<li class="level-2" id="nav-sub-pricing-registration"><a href="http://www.thecoaches.com/coach-training/pricing-registration">Pricing & Registration</a></li>
							<li class="level-2" id="nav-sub-faculty"><a href="http://www.thecoaches.com/coach-training/faculty">Faculty</a></li>
							<li class="level-2" id="nav-sub-faqs"><a href="http://www.thecoaches.com/coach-training/faqs">FAQs</a></li>
							<li class="level-2" id="nav-sub-profiles-testimonials"><a href="http://www.thecoaches.com/coach-training/profiles-testimonials">Profiles</a></li>
							<li class="level-2" id="nav-sub-resources"><a href="http://www.thecoaches.com/coach-training/resources">Resources</a></li>
							<li class="level-2" id="nav-sub-building-business"><a href="http://www.thecoaches.com/coach-training/building-business">Building Business</a></li>
							<li class="level-2 last" id="nav-sub-assisting"><a href="http://www.thecoaches.com/coach-training/assisting">Assisting</a></li>
						</ul>
					</li>
					<li class="level-1" id="nav-sub-leadership"><a href="http://www.thecoaches.com/leadership">Leadership</a>
						<ul>
							<li class="level-2 first" id="nav-sub-program-overview"><a href="http://www.thecoaches.com/leadership/program-overview">Program Overview</a></li>
							<li class="level-2" id="nav-sub-retreats"><a href="http://www.thecoaches.com/leadership/retreats">Retreats</a></li>
							<li class="level-2" id="nav-sub-dates-locations"><a href="http://www.thecoaches.com/leadership/dates-locations">Dates & Locations</a></li>
							<li class="level-2" id="nav-sub-faqs"><a href="http://www.thecoaches.com/leadership/faqs">FAQs</a></li>
							<li class="level-2" id="nav-sub-pricing-registration"><a href="http://www.thecoaches.com/leadership/pricing-registration">Pricing & Registration</a></li>
							<li class="level-2" id="nav-sub-faculty"><a href="http://www.thecoaches.com/leadership/faculty">Faculty</a></li>
							<li class="level-2" id="nav-sub-accreditation-faqs"><a href="http://www.thecoaches.com/leadership/accreditation-faqs">Accreditation</a></li>
							<li class="level-2" id="nav-sub-profiles-testimonials"><a href="http://www.thecoaches.com/leadership/profiles-testimonials">Profiles</a></li>
							<li class="level-2" id="nav-sub-creating-from-self"><a href="http://www.thecoaches.com/leadership/creating-from-self">Creating from Self</a></li>
							<li class="level-2 last" id="nav-sub-resources"><a href="http://www.thecoaches.com/leadership/resources">Resources</a></li>
						</ul>
					</li>
					<li class="level-1" id="nav-sub-for-organizations"><a href="http://www.thecoaches.com/for-organizations">For Organizations</a>
						<ul>
							<li class="level-2 first" id="nav-sub-internal-co-active-coach"><a href="http://www.thecoaches.com/for-organizations/internal-co-active-coach">Internal Co-Active Coach</a></li>
							<li class="level-2" id="nav-sub-talent-champions"><a href="http://www.thecoaches.com/for-organizations/talent-champions">Talent Champions</a></li>
							<li class="level-2" id="nav-sub-leadership-advantage"><a href="http://www.thecoaches.com/for-organizations/leadership-advantage">Leadership Advantage</a></li>
							<li class="level-2" id="nav-sub-relationship-agility"><a href="http://www.thecoaches.com/for-organizations/relationship-agility">Relationship Agility</a></li>
							<li class="level-2" id="nav-sub-client-list"><a href="http://www.thecoaches.com/for-organizations/client-list">Client List</a></li>
							<li class="level-2" id="nav-sub-profiles-testimonials"><a href="http://www.thecoaches.com/for-organizations/profiles-testimonials">Profiles</a></li>
							<li class="level-2 last" id="nav-sub-resources"><a href="http://www.thecoaches.com/for-organizations/resources">Resources</a></li>
						</ul>
					</li>
<li class="level-1 last" id="nav-sub-community"><a href="http://www.thecoaches.com/community">Community</a>
<ul>
<li class="level-2 first" id="nav-sub-connect-locally"><a href="http://www.thecoaches.com/community/connect-locally">Connect Locally</a></li>
<li class="level-2" id="nav-sub-events-calendar"><a href="http://www.thecoaches.com/community/events-calendar">Events Calendar</a></li>
<li class="level-2" id="nav-sub-2014-summit"><a href="http://www.thecoaches.com/community/2014-summit">2014 Co-Active Summit</a></li>
<li class="level-2" id="nav-sub-institute-of-coaching"><a href="http://www.thecoaches.com/community/institute-of-coaching">Institute of Coaching</a></li>
<li class="level-2" id="nav-sub-henry-on-the-radio"><a href="http://www.thecoaches.com/community/henry-on-the-radio">Henry on the Radio</a></li>
<li class="level-2" id="nav-sub-disrupt-your-life-in-a-good-way"><a href="http://www.thecoaches.com/community/disrupt-your-life-in-a-good-way">Disrupt Your Life in a Good Way</a></li>
<li class="level-2 last" id="nav-sub-co-active-global-newsletter"><a href="http://www.thecoaches.com/community/co-active-global-newsletter">Co-Active Global Newsletter</a></li>
</ul>
</li>
                  
				</ul>
				<ul id="main-nav" style="width: 200px; float: right;">

					<!-- li><a href="http://www.thecoaches.com/why-coaches-training-institute/">Why <abbr title="Coaches Training Institute">CTI</abbr>?</a></li>
					<li><a href="http://www.thecoaches.com/coach-training/">Coach Training</a></li>
					<li><a href="http://www.thecoaches.com/leadership/">Leadership</a></li>
					<li><a href="http://www.thecoaches.com/organizations/">For Organizations</a></li -->
					<!-- li><a href="http://www.thecoaches.com/leaders/">Our Faculty</a></li>
					<li><a href="http://www.thecoaches.com/resources/">Resources</a></li -->
					<li id="socbook" style="position: relative; left: 0; top: -3px;">
					<script type="text/javascript">insert_social_bookmarking();</script>
					<noscript><a href="#main-headline" class="accessibility-hide">Headline</a><span class="divider accessibility-hide">&#160;|&#160;</span></noscript>
					
					</li>

				</ul>
				
				
				<div style="clear: both;"></div>
				<div style="height: 10px; background: #7db2ce; display: block; width: 692px; float: left;"></div><div style="height: 10px; background: #311109; display: block; width: 228px; float: left;"></div>

				<!--
<div id="sub-nav">

					<ul id="section-nav">

						<li><a href="http://www.thecoaches.com/resources/multimedia/">Multimedia</a></li>
						<li><a href="http://www.thecoaches.com/resources/business-development-programs/"><abbr title="Business">Biz</abbr> <abbr title="Development">Dev</abbr> Programs</a></li>
						<li><a href="/resources/tools/">Tools</a></li>
						<li><a href="http://www.thecoaches.com/resources/books/">Books</a></li>
						<li><a href="http://www.thecoaches.com/resources/news-and-events/">News &#38; Events</a></li>
						<li class="current"><a href="http://www.thecoaches.com/blog/">Blog</a></li>

					</ul>

				</div>
-->


				<!-- BEGIN #content -->
				<div id="content">

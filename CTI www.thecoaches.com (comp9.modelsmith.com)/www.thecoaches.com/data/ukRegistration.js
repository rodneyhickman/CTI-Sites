/* ukRegistration.js

   by Doraraj B for Coaches Training Institute

   Copyright 2013 Coaches Training Institute

*/

<?php



// NOTE: Prices are set in CoursePackage.prototype.renderHeader



header('Cache-Control: no-cache, must-revalidate');

header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

header('Content-type: text/javascript');



$course_number = @$_GET['num'];



$username = "cticoaches";

$password = "";

$hostname = "localhost"; 



//connection to the database

$dbh = mysql_connect($hostname, $username, $password) 

  or die("Unable to connect to MySQL");



//select a database to work with 

$selected = mysql_select_db("CTIDATABASE",$dbh) 

  or die("Could not select examples");





//$result = mysql_query("UPDATE event_calendar SET  edate = '04/27/2014' WHERE  event_calendar.fmid =20935");



$locations = array( );

$result = mysql_query('SELECT region,site_code,city,region_name FROM site_data,regions WHERE site_data.region = regions.region_code');

while($row=mysql_fetch_assoc($result)){

    $locations[$row['site_code']] = $row['city']; // create array of region_names and cities

}





$fun = mysql_query("SELECT fmid,location,start_date_formatted,end_date_formatted FROM event_calendar WHERE (course_type_id='3' or course_type_id='139') and event_calendar.location NOT LIKE '%HOLD' and event NOT LIKE '%FAST%' and (event_calendar.location LIKE 'LON%' OR location LIKE 'MAN%' OR location LIKE 'Luxumbourg') and (TO_DAYS(start_date)-TO_DAYS(NOW()))>0 ORDER BY start_date");

$fun_courses = array( );

while($row=mysql_fetch_assoc($fun)){

    $row['location'] = $locations[$row['location']]; // change location code into something more meaningful, like the region_name and city (see above)

    $fun_courses[] = $row;

}





$ful = mysql_query("SELECT fmid,location,start_date_formatted,end_date_formatted FROM event_calendar WHERE (course_type_id='4' or course_type_id='140') and event_calendar.location NOT LIKE '%HOLD' and event NOT LIKE '%FAST%' and (event_calendar.location LIKE 'LON%' OR location LIKE 'MAN%' OR location LIKE 'Luxumbourg') and (TO_DAYS(start_date)-TO_DAYS(NOW()))>0 ORDER BY start_date");

$ful_courses = array( );

while($row=mysql_fetch_assoc($ful)){

    $row['location'] = $locations[$row['location']];

    $ful_courses[] = $row;

}



$bal = mysql_query("SELECT fmid,location,start_date_formatted,end_date_formatted FROM event_calendar WHERE (course_type_id='5' or course_type_id='141') and event_calendar.location NOT LIKE '%HOLD' and event NOT LIKE '%FAST%' and (event_calendar.location LIKE 'LON%' OR location LIKE 'MAN%' OR location LIKE 'Luxumbourg') and (TO_DAYS(start_date)-TO_DAYS(NOW()))>0 ORDER BY start_date");

$bal_courses = array( );

while($row=mysql_fetch_assoc($bal)){

    $row['location'] = $locations[$row['location']];

    $bal_courses[] = $row;

}



$pro = mysql_query("SELECT fmid,location,start_date_formatted,end_date_formatted FROM event_calendar WHERE (course_type_id='6' or course_type_id='142') and event_calendar.location NOT LIKE '%HOLD' and event NOT LIKE '%FAST%' and (event_calendar.location LIKE 'LON%' OR location LIKE 'MAN%' OR location LIKE 'Luxumbourg') and (TO_DAYS(start_date)-TO_DAYS(NOW()))>0 ORDER BY start_date");

$pro_courses = array( );

while($row=mysql_fetch_assoc($pro)){

    $row['location'] = $locations[$row['location']];

    $pro_courses[] = $row;

}



$syn = mysql_query("SELECT fmid,location,start_date_formatted,end_date_formatted FROM event_calendar WHERE (course_type_id='7' or course_type_id='143') and event_calendar.location NOT LIKE '%HOLD' and event NOT LIKE '%FAST%' and (event_calendar.location LIKE 'LON%' OR location LIKE 'MAN%' OR location LIKE 'Luxumbourg') and (TO_DAYS(start_date)-TO_DAYS(NOW()))>0 ORDER BY start_date");

$syn_courses = array( );

while($row=mysql_fetch_assoc($syn)){

    $row['location'] = $locations[$row['location']];

    $syn_courses[] = $row;

}



$courses = array(

    'fun' => $fun_courses,

    'ful' => $ful_courses,

    'bal' => $bal_courses,

    'pro' => $pro_courses,

    'syn' => $syn_courses

);



$courses_json = json_encode($courses);



$fun_ft = mysql_query("SELECT id,fmid,location,start_date_formatted,end_date_formatted FROM event_calendar WHERE (course_type_id='3' or course_type_id='139') and event LIKE '%FAST%' and (location LIKE 'LON%' OR location LIKE 'MAN%' OR location LIKE 'Luxumbourg') and (TO_DAYS(start_date)-TO_DAYS(NOW()))>0 ORDER BY start_date");



$fun_ft_courses = array( );

while($row=mysql_fetch_assoc($fun_ft)){

    $row['location'] = $locations[$row['location']]; // change location code into something more meaningful, like the region_name and city (see above)

    $fun_ft_courses[] = $row;

}



$ful_ft = mysql_query("SELECT id,fmid,location,start_date_formatted,end_date_formatted FROM event_calendar WHERE (course_type_id='4' or course_type_id='140') and event LIKE '%FAST%' and (location LIKE 'LON%' OR location LIKE 'MAN%' OR location LIKE 'Luxumbourg') and (TO_DAYS(start_date)-TO_DAYS(NOW()))>0 ORDER BY start_date");

$ful_ft_courses = array( );

while($row=mysql_fetch_assoc($ful_ft)){

    $row['location'] = $locations[$row['location']]; // change location code into something more meaningful, like the region_name and city (see above)

    $ful_ft_courses[] = $row;

}



$bal_ft = mysql_query("SELECT id,fmid,location,start_date_formatted,end_date_formatted FROM event_calendar WHERE (course_type_id='5' or course_type_id='141') and event LIKE '%FAST%' and (location LIKE 'LON%' OR location LIKE 'MAN%' OR location LIKE 'Luxumbourg') and (TO_DAYS(start_date)-TO_DAYS(NOW()))>0 ORDER BY start_date");

$bal_ft_courses = array( );

while($row=mysql_fetch_assoc($bal_ft)){

    $row['location'] = $locations[$row['location']]; // change location code into something more meaningful, like the region_name and city (see above)

    $bal_ft_courses[] = $row;

}



$pro_ft = mysql_query("SELECT id,fmid,location,start_date_formatted,end_date_formatted FROM event_calendar WHERE (course_type_id='6' or course_type_id='142') and event LIKE '%FAST%' and (location LIKE 'LON%' OR location LIKE 'MAN%' OR location LIKE 'Luxumbourg') and (TO_DAYS(start_date)-TO_DAYS(NOW()))>0 ORDER BY start_date");

$pro_ft_courses = array( );

while($row=mysql_fetch_assoc($pro_ft)){

    $row['location'] = $locations[$row['location']]; // change location code into something more meaningful, like the region_name and city (see above)

    $pro_ft_courses[] = $row;

}



$syn_ft = mysql_query("SELECT id,fmid,location,start_date_formatted,end_date_formatted FROM event_calendar WHERE (course_type_id='7' or course_type_id='143') and event LIKE '%FAST%' and (location LIKE 'LON%' OR location LIKE 'MAN%' OR location LIKE 'Luxumbourg') and (TO_DAYS(start_date)-TO_DAYS(NOW()))>0 ORDER BY start_date");

$syn_ft_courses = array( );

while($row=mysql_fetch_assoc($syn_ft)){

    $row['location'] = $locations[$row['location']]; // change location code into something more meaningful, like the region_name and city (see above)

    $syn_ft_courses[] = $row;

}



// {"fmid":"19198","location":"Hawaii (City-TBA)","start_date_formatted":"Jul 26-28, 2013","end_date_formatted":"July 28, 2013"}

// {"id":"1606641","serial_number":"40874","region":"DC","course1_id":"19565","course2_id":"21414","course3_id":"21412","course4_id":"21415","course5_id":"21413","is_fast_track":"1","created":"2012-10-05 13:54:03"}



$fasttracks = array( );

$ft = mysql_query('SELECT * FROM course_series WHERE is_fast_track=1');

while($row=mysql_fetch_assoc($ft)){

    $id         = $row['id'];

    $course_id1 = $row['course1_id'];

    $course_id2 = $row['course2_id'];

    $course_id3 = $row['course3_id'];

    $course_id4 = $row['course4_id'];

    $course_id5 = $row['course5_id'];

    $course1  = '';

    $course2  = '';

    $course3  = '';

    $course4  = '';

    $course5  = '';

    $location = '';



    foreach($fun_ft_courses as $course){

        if($course['id'] == $course_id1){

            $course1 = '1st: Fundamentals - '.$course['location'].' - '.$course['start_date_formatted'];

            $location = $course['location'];

        }

    }



    foreach($ful_ft_courses as $course){

        if($course['id'] == $course_id2){

            $course2 = '2nd: Fulfillment - '.$course['location'].' - '.$course['start_date_formatted'];

        }

    }



    foreach($bal_ft_courses as $course){

        if($course['id'] == $course_id3){

            $course3 = '3rd: Balance - '.$course['location'].' - '.$course['start_date_formatted'];

        }

    }



    foreach($pro_ft_courses as $course){

        if($course['id'] == $course_id4){

            $course4 = '4th: Process - '.$course['location'].' - '.$course['start_date_formatted'];

        }

    }



    foreach($syn_ft_courses as $course){

        if($course['id'] == $course_id5){

            $course5 = '5th: Synergy - '.$course['location'].' - '.$course['start_date_formatted'];

        }

    }



    $fasttracks[] = array( 'id'=>$id, 

                           'location'=>$location,

                           'course_id1'=>$course_id1, 'course1'=>$course1, 

                           'course_id2'=>$course_id2, 'course2'=>$course2, 

                           'course_id3'=>$course_id3, 'course3'=>$course3, 

                           'course_id4'=>$course_id4, 'course4'=>$course4, 

                           'course_id5'=>$course_id5, 'course5'=>$course5 ); 



}



$fasttrack_json = json_encode($fasttracks);



//$fun_ft_json = json_encode($fun_ft_courses);





// ============ SERVER CODE ABOVE, CLIENT CODE BELOW ============

?>

// ------------------------------------



function Dropdown(name, id, options){

    this.name = name;

    this.id = id;

    this.options = options; // array [ { 'value':'option' }, {...} ]

}



Dropdown.prototype.render = function() {

    var html = '<select name="' + this.name + '" id="' + this.id + '">';

    for(var i = 0; i < this.options.length; i++){

        var option = this.options[i];

        for( var key in option ){

            if (key === 'length' || !option.hasOwnProperty(key)) continue; // check that key is not coming from prototype

            html += '<option value="' + key + '">' + option[key] + '</option>';

        }

    }

    html += '</select>';

    return html;

}



// ------------------------------------



function CoursePackage(courses,fasttrack){

	this.number = <?php echo $course_number; ?>;

    window.console && console.log('course number: '+this.number);



    this.pkg_number = this.number < 10 ? '0'+this.number : this.number;

    this.courses = courses;

    this.fasttrack_courses = fasttrack;

}



CoursePackage.prototype.renderHeader = function() {

    // NOTE: Prices are set here.

    var html = '';

    if(this.number == 1){

        html += this.header('Course 1: Co-Active Fundamentals','475','','475.00',''); //Individual Course: Fundamentals

    }

    if(this.number == 2 || this.number == 10){

        html += this.header('Package A: Co-Active Coaching Skills Pathway (Fundamentals Complete Core Series)','4,475','1,920 ','795.00',''); //Package A: Co-Active Coaching Skills Pathway (Fundamentals Complete Core Series)

    }

   

    if(this.number == 4){

        html += this.header('Package C: Co-Active Coaching Skills Pathway (Complete Core Series)','4,200','1,200 ','800.00',''); //Package C: Co-Active Coaching Skills Pathway (Complete Core Series)

    }

    if(this.number == 5){

        html += this.header('Package D: Co-Active Coaching Skills Pathway (Split Core Series)','4,500','840 ','800.00',''); //Package D: Co-Active Coaching Skills Pathway (Split Core Series)

    }

    if(this.number == 6){

        html += this.header('Individual Course: Fulfillment','1,400','','1400.00',''); //Individual Course: Fulfillment

    }

    if(this.number == 7){

        html += this.header('Individual Course: Balance','1,400','','1400.00',''); //Individual Course: Balance

    }

    if(this.number == 8){

        html += this.header('Individual Course: Process','1,400','','1400.00',''); //Individual Course: Process

    }

    if(this.number == 9){

		html += this.header('Individual Course: Synergy','1,400','','1400.00',''); //Individual Course: Synergy

    }

    //if(this.number == 10){

		//html += this.header('Co-Active Certification Program (� la carte)','5,650','','1200.00','$');

    //}



    return html;

}



CoursePackage.prototype.header = function(course,price,savings,deposit,currency){

	if (currency == '') {

		currency = '&pound;';

	}

	

	//price = price + price * 0.2;  // vat rate is 20%

    var html = '<div>';

	html +='<form action="http://store5126.americommerce.com/store/addtocart.aspx" method="POST" id="form2" onsubmit="return hasAgreed(this);">';

	html += '<input type="hidden" name="clear" value="true">';

	html += '<input type="hidden" name="itemid" value="-1">';

	html += '<input type="hidden" name="itemname" value="' + course + ' ' + currency + price + '">';

//	html += '<input type="hidden" name="itemnr" value="' + course + ' ' + currency + price + '">';

	html += '<input type="hidden" name="desc" value="' + course + ' ' + currency + price + '">';

	html += '<input type="hidden" name="qty" value="1">';

	html += '<input type="hidden" name="price" value="' + deposit + '">';

	html += '<input type="hidden" name="admincomments" value="' + course + ' ' + currency + price + '">';

	html += '<input type="hidden" name="nonshippingitem" value="true">';

	html += '<input type="hidden" name="nodiscount" value="false">';

	html += '<input type="hidden" name="return" value="http://www.coaching-courses.com/coach-training/courses/pricing.html">';

	html += '<input type="hidden" name="continueshopping" value="http://www.coaching-courses.com/coach-training/courses/pricing.html">';

   

    //html += '<input type="hidden" name="item" value="">';

    html += '<h2>'+course+'</h2>';

    html += '<p><br/><br/><strong>'+currency+price+'</strong> + VAT';

    if(savings){

      html += '<br/><strong>(Savings of '+currency+savings+'!)</strong>';

    }

	html += '</p>';

    return html;



}



CoursePackage.prototype.renderAdvisor = function() {

    var html = '<div><table><tr class="alt"><td>Please tell us which Program Advisor<br/>assisted you: </td><td>';

    var dropdown1 = new Dropdown('op30','op30',[ 

        {' none':'Please Select'},

        {' No one assisted':'-- No one assisted me --'},

        {' Assisted by Rachel Suckle':'Rachel Suckle'},

        {' Assisted by Ben Gill':'Ben Gill'},

        {' Assisted by James Acres':'James Acres'}

    ] );

    html += dropdown1.render();

    html += '</td></tr>';

	html += '<tr class="alt"><td colspan="2"><hr></td></tr>';

    return html;

}





CoursePackage.prototype.renderCourses = function() {

    var html = '';

    //window.console && console.log(this.courses);

	html = html + '<tr><td>Course</td><td>Dates & Locations</td></tr>';

    if(this.number == 1){

        html += this.course('/coach-training/courses/#course_fundamentals',

                            'Fundamentals',

                            'Course 1: Co-Active Fundamentals',

                            '<span>Course Dates</span>',

                            'op1',

                            this.courses['fun']

                           );

    }



    if(this.number == 2 || this.number == 3 || this.number == 4 || this.number == 5){

		if (this.number < 4) {

			html += this.course('/coach-training/courses/#course_fundamentals',

								'Fundamentals',

								'Course 1: Co-Active Fundamentals',

								'<span>Course Dates</span>',

								'op1',

								this.courses['fun']

							   );

		}

        html += this.course('/coach-training/courses/#course_fulfillment',

                            'Fulfillment',

                            'Course 2: Fulfillment',

                            '<span>Course Dates</span>',

                            'op3',

                            this.courses['ful']

                           );

        html += this.course('/coach-training/courses/#course_balance',

                            'Balance',

                            'Course 3: Balance',

                            '<span>Course Dates</span>',

                            'op5',

                            this.courses['bal']

                           );

        html += this.course('/coach-training/courses/#course_process',

                            'Process',

                            'Course 4: Process',

                            '<span>Course Dates</span>',

                            'op7',

                            this.courses['pro']

                           );

        html += this.course('/coach-training/courses/#course_synergy',

                            'Synergy',

                            'Course 5: Synergy',

                            '<span>Course Dates</span>',

                            'op9',

                            this.courses['syn']

                           );

    }



   if(this.number == 6){

        html += this.course('/coach-training/courses/#course_fulfillment',

                            'Fulfillment',

                            'Course 2: Fulfillment',

                            '<span>Course Dates</span>',

                            'op1',

                            this.courses['ful']

                           );

    }

   if(this.number == 7){

        html += this.course('/coach-training/courses/#course_balance',

                            'Balance',

                            'Course 3: Balance',

                            '<span>Course Dates</span>',

                            'op1',

                            this.courses['bal']

                           );

    }

   if(this.number == 8){

        html += this.course('/coach-training/courses/#course_process',

                            'Process',

                            'Course 4: Process',

                            '<span>Course Dates</span>',

                            'op1',

                            this.courses['pro']

                           );

    }

   if(this.number == 9){

        html += this.course('/coach-training/courses/#course_synergy',

                            'Synergy',

                            'Course 5: Synergy',

                            '<span>Course Dates</span>',

                            'op1',

                            this.courses['syn']

                           );

    }

   if(this.number == 10){

        html += this.fasttrack( );

    }



    return html;

}



CoursePackage.prototype.course = function(link,title,legend,label,op,courses) {

    var html = '<tr class="alt"><td>';

    html += '<a href="'+link+'">'+legend+'</a>';

    html += '</td><td>';

    html += '<select id="fundloc1" name="'+op+'"><option value="">You have not made a course location selection.</option>';

    for(var i = 0; i < courses.length; i++){

        course = courses[i];

        html += '<option value="'+title+' - '+course['location']+' - '+course['start_date_formatted']+'">'+title+' - '+course['location']+' - '+course['start_date_formatted']+'</option>';

    }

    html += '</select></td></tr>';

    return html;

}



CoursePackage.prototype.fasttrack = function( ){

	

    var html = '<div>';

    html += '<div>Fast Track Series</div>';

    html += '<label id="l_fundloc1" for="fundloc1">Please select a series...<br />&nbsp;</span></label>';

    html += '<input type="hidden" name="op1" id="op1" value="" />';

    html += '<input type="hidden" name="op2" id="op2" value="" />';

    html += '<input type="hidden" name="op3" id="op3" value="" />';

    html += '<input type="hidden" name="op4" id="op4" value="" />';

    html += '<input type="hidden" name="op5" id="op5" value="" />';

    for(i=0;i<this.fasttrack_courses.length;i++){

        var ft = this.fasttrack_courses[i];

        html += '<input onclick="setops('+ft['id']+')" type="radio" name="series_selection" value="'+ft['id']+'">';

        html += '<b>'+ft['location']+'</b><br />';

        html += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+ft['course1']+'<br />';

        html += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+ft['course2']+'<br />';

        html += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+ft['course3']+'<br />';

        html += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+ft['course4']+'<br />';

        html += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+ft['course5']+'<br />';

        html += '<input type="hidden" name="op1_'+ft['id']+'" id="op1_'+ft['id']+'" value="'+ft['course1']+'" />';

        html += '<input type="hidden" name="op2_'+ft['id']+'" id="op2_'+ft['id']+'" value="'+ft['course2']+'" />';

        html += '<input type="hidden" name="op3_'+ft['id']+'" id="op3_'+ft['id']+'" value="'+ft['course3']+'" />';

        html += '<input type="hidden" name="op4_'+ft['id']+'" id="op4_'+ft['id']+'" value="'+ft['course4']+'" />';

        html += '<input type="hidden" name="op5_'+ft['id']+'" id="op5_'+ft['id']+'" value="'+ft['course5']+'" />';

        html += '<br />&nbsp;';

    }

    html += '</div>';

    return html;

}



CoursePackage.prototype.renderPolicies = function() {

    var html = '<div>';

    html += '<p><br/><input id="agree" name="agree_to_policies" type="checkbox"> Yes, I have read and agree to ';

    html += '<a class="pricingdetails" href="/coach-training/_policy_2013.html" rel="lyteframe" rev="width: 800px; height: 500px; scrolling: auto;" title="CTI Policies">CTI Policies</a></p>';

	html += '<br/></div>';

    return html;

}





CoursePackage.prototype.renderCartButton = function() {

    var html = '';

    html += '<input id="addtocart" name="addtocart" type="image" src="/res/img/submit_add_to_cart.gif" alt="Add to Cart" />';

    html += '</form></div>';

    return html;

}



CoursePackage.prototype.renderCertification = function() {

    var html = '';

    if(this.number == 2 || this.number == 3 || this.number == 4 || this.number == 5){

        html += this.certification();

    }

	html += '</table></div>';

    return html;

}



CoursePackage.prototype.certification = function() {

    var html = '';

    var dd = new Dropdown('op11','op11',[{'none':'Please Select'},{'Yes':'Yes'},{'No':'No'}]);

	html += '<tr class="alt"><td colspan="2"><hr></td></tr>';

    html += '<tr class="alt"><td>Would you like to pay the $200 deposit in order to lock into the discounted rate for Certification?</td><td>';

    html += dd.render();

    html += '</td></tr>';

    return html;

}



CoursePackage.prototype.certificationMonths = function() {

    // returns months

    var months = [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ];

    var d = new Date();

    var mn = d.getMonth();

    var yr = d.getFullYear();

    var month_select = [ ];

    var mon = 0;

    mn += 2;



    for(var i=0;i<=9;i++) {

        mon = mn + i;

        if (mon > 11) {

            yr++;

            mn -= 12;

            mon -= 12;

        }

        var option = months[mon]+' '+yr;

        var assoc = { };

        assoc[option] = option;

        month_select.push( assoc );

    }

    window.console && console.log( month_select );

    month_select.push({'I will decide later':'I will decide later'});

    return month_select;

}

// ------------------------------------

// Price functions, copied from old registration pages



 function hasAgreed(form) {

  		 var sel = ""; 
		 
   		if(document.getElementsByName("op1").length!=0)
	  	if(document.getElementsByName("op1")[0].value!=''){
		 sel += document.getElementsByName("op1")[0].value+'\n';   
	  	}
		  
 		if(document.getElementsByName("op3").length!=0)
		if(document.getElementsByName("op3")[0].value!=''){
	   		sel += document.getElementsByName("op3")[0].value+'\n';   
	  	}
		
		if(document.getElementsByName("op5").length!=0)
		if(document.getElementsByName("op5")[0].value!=''){
	  		 sel += document.getElementsByName("op5")[0].value+'\n';   
	  	}
	  
		if(document.getElementsByName("op7").length!=0)
		if(document.getElementsByName("op7")[0].value!=''){
	  		 sel += document.getElementsByName("op7")[0].value+'\n';   
	  	}
	  
		if(document.getElementsByName("op9").length!=0)
		if(document.getElementsByName("op9")[0].value!=''){
	   		sel += document.getElementsByName("op9")[0].value+'\n';   
	  	}  

 



var iname = document.getElementsByName("itemname")[0].value;

var split = document.getElementsByName("itemname")[0].value.split('-Dates:');

var cname = split[0]; 
 
document.getElementsByName("itemname")[0].value = cname +' -Dates:('+ sel +')';

    if(form.agree_to_policies.checked == false) {

      alert("Please read the CTI Policies and indicate your agreement by checking the checkbox.");

      return false;

    }





  adjustTotalPrice(form);

  return true;

 }





function adjustTotalPrice(form){

 /* Normal package price is just the deposits added together. Here we add

    the full price delta to those courses that are within 21 days. CTI

    reserves the right to verify final price before student is admitted

    to course(s).

 */

 var additional_deposit=0;

 var package_deposit=0;



 var fun_price; var fun_discount;

 var ful_price; var ful_discount;

 var bal_price; var bal_discount;

 var pro_price; var pro_discount;

 var itb_price; var itb_discount;

 var cert_price; var cert_discount;



//1. Individual Course: Fundamentals

//2. Package A: Co-Active Coaching Skills Pathway (Fundamentals Complete Core Series)

//3. Package B: Co-Active Coaching Skills Pathway (Fundamentals and Split Core Series)

//4. Package C: Co-Active Coaching Skills Pathway (Complete Core Series)

//5. Package D: Co-Active Coaching Skills Pathway (Split Core Series)

//6. Individual Course: Fulfillment

//7. Individual Course: Balance

//8. Individual Course: Process

//9.Individual Course: Synergy





//1. Fundamentals

 if(form.pkg && (form.pkg.value=="01")){

   package_deposit = 475;

   fun_price = 475; fun_discount = 0;

   ful_price = 0; ful_discount = 0;

   bal_price = 0; bal_discount = 0;

   pro_price = 0; pro_discount = 0;

   itb_price = 0; itb_discount = 0;

 }

//2. Package A: Co-Active Coaching Skills Pathway

else if(form.pkg && (form.pkg.value=="02")){

   package_deposit = 800;

   fun_price = 0; fun_discount = 0;

   ful_price = 0; ful_discount = 0;

   bal_price = 0; bal_discount = 0;

   pro_price = 0; pro_discount = 0;

   itb_price = 0; itb_discount = 0;

 }

//3. Package B: Co-Active Coaching Skills Pathway

else if(form.pkg && (form.pkg.value=="03")){

   package_deposit = 800;

   fun_price = 0; fun_discount = 0;

   ful_price = 0; ful_discount = 0;

   bal_price = 0; bal_discount = 0;

   pro_price = 0; pro_discount = 0;

   itb_price = 0; itb_discount = 0;

 }

//4. Package C: Co-Active Coaching Skills Pathway

else if(form.pkg && (form.pkg.value=="04")){

   package_deposit = 800;

   fun_price = 0; fun_discount = 0;

   ful_price = 0; ful_discount = 0;

   bal_price = 0; bal_discount = 0;

   pro_price = 0; pro_discount = 0;

   itb_price = 0; itb_discount = 0;

 }

//5. Package D: Co-Active Coaching Skills Pathway

else if(form.pkg && (form.pkg.value=="05")){

   package_deposit = 800;

   fun_price = 0; fun_discount = 0;

   ful_price = 0; ful_discount = 0;

   bal_price = 0; bal_discount = 0;

   pro_price = 0; pro_discount = 0;

   itb_price = 0; itb_discount = 0;

 }

//Fulfillment (Paid in Full)

 else if(form.pkg && form.pkg.value=="06"){

   package_deposit = 1300;

   ful_price = 1300; ful_discount = 0;

 }

//Balance (Paid in Full)

 else if(form.pkg && form.pkg.value=="07"){

   package_deposit = 1300;

   bal_price = 1300; bal_discount = 0;

 }

//Process (Paid in Full)

 else if(form.pkg && form.pkg.value=="08"){

   package_deposit = 1300;

   pro_price = 1300; pro_discount = 0;

 }

//Synergy (Paid in Full)

 else if(form.pkg && form.pkg.value=="09"){

   package_deposit = 1300;

   itb_price = 1300; itb_discount = 0;

 }

//Co-Active Certification Program (� la carte)

 else if(form.pkg && form.pkg.value=="11"){

   package_deposit = 1200;

   cert_price = 5650; cert_discount = 0;

 }

 if(isLessThan3Weeks(form.op1 ? form.op1.value : '')){

   additional_deposit = additional_deposit + 0; // fundamentals already in full price

 }

 if(isLessThan3Weeks(form.op3 ? form.op3.value : '')){

   additional_deposit = additional_deposit + (ful_price - ful_discount); 

 }

 if(isLessThan3Weeks(form.op5 ? form.op5.value : '')){

   additional_deposit = additional_deposit + (bal_price - bal_discount); 

 }

 if(isLessThan3Weeks(form.op7 ? form.op7.value : '')){

   additional_deposit = additional_deposit + (pro_price - pro_discount); 

 }

 if(isLessThan3Weeks(form.op9 ? form.op9.value : '')){

   additional_deposit = additional_deposit + (itb_price - itb_discount); 

 }



 //alert( form.price.value );

 form.price.value = setPrice( form.price.value, package_deposit, additional_deposit );

 //alert( form.price.value );





}



function setPrice( sel, package_price, delta ){

 // Example: store5126^A1FUL^Course 2: Fulfillment USD $1,250^250.00^1^^^^^

 var total = package_price + delta;

 return sel.replace(/(([0-9]+)\,)?([0-9]+)([^\^0-9]*)\^(\d+)\.00/,"$1$3$4^" + total + ".00");

}







function isLessThan3Weeks( val ){

var today=new Date();

//var today=new Date(2009,9,5); // for testing



// get year, month, day from val

// example:  <option value="1st Fundamentals: Boston Metro, MA - September 11, 2009">Fundamentals - Boston Metro, MA - September 11, 2009</option>



var myregex = new RegExp(/([A-Za-z]+)\s+(\d+),\s+(\d+)/);

var matches = myregex.exec( val );

//alert(matches);

if(matches != null){

var year  = matches[3];

var month = convertMonth(matches[1]);

var day   = matches[2];

var selDate=new Date(year,month,day) //Month is 0-11 in JavaScript





//Set 3 weeks in milliseconds

var three_weeks=1000*60*60*24*21  // 1000 msec * 60 secs * 60 mins * 24 hours * 21 days





//alert("today: "+today+"  selection: "+selDate+"  t/f: "+(( selDate.getTime()-today.getTime() ) < three_weeks));



//Calculate difference btw the two dates, and convert to days

return ( ( selDate.getTime()-today.getTime() ) < three_weeks );

}



return null;



}



function convertMonth( month ){

if(month.match(/jan/i)){ return 0; }

if(month.match(/feb/i)){ return 1; }

if(month.match(/mar/i)){ return 2; }

if(month.match(/apr/i)){ return 3; }

if(month.match(/may/i)){ return 4; }

if(month.match(/jun/i)){ return 5; }

if(month.match(/jul/i)){ return 6; }

if(month.match(/aug/i)){ return 7; }

if(month.match(/sep/i)){ return 8; }

if(month.match(/oct/i)){ return 9; }

if(month.match(/nov/i)){ return 10; }

if(month.match(/dec/i)){ return 11; }

return 0;

}



function setops(track_id){

document.getElementById('op1').value=document.getElementById('op1_'+track_id).value;

document.getElementById('op2').value=document.getElementById('op2_'+track_id).value;

document.getElementById('op3').value=document.getElementById('op3_'+track_id).value;

document.getElementById('op4').value=document.getElementById('op4_'+track_id).value;

document.getElementById('op5').value=document.getElementById('op5_'+track_id).value;

}



// ------------------------------------------------------------------------------------------------------------

//alert("Course number in js = " + <?= $course_number ?>);

var url = document.URL;

 

var html = '';



courses = <?php echo $courses_json ?>;



fasttrack = <?php echo $fasttrack_json ?>;



var course_package = new CoursePackage(courses,fasttrack);



html += course_package.renderHeader();

html += course_package.renderAdvisor();

html += course_package.renderCourses();

html += course_package.renderCertification();

html += course_package.renderPolicies();

html += course_package.renderCartButton();



document.write(html);


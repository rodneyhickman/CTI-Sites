/* registration.js
   by Thomas Beutel for Coaches Training Institute
   Copyright 2012 Coaches Training Institute
*/
<?php

// NOTE: Prices are set in CoursePackage.prototype.renderHeader

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: text/javascript');

$username = "cticoaches";
$password = "";
$hostname = "localhost";  

//connection to the database
$dbh = mysql_connect($hostname, $username, $password) 
  or die("Unable to connect to MySQL");

//select a database to work with 
$selected = mysql_select_db("CTIDATABASE",$dbh) 
  or die("Could not select examples");

$locations = array( );
$locationsStates = array( );
$locationsCities = array( );
$locationsCountry = array( );
$locationsRegionCode = array( );
$result = mysql_query('SELECT region,site_code,city,state,region_name,regions.country,region_code FROM site_data,regions WHERE site_data.region=regions.region_code');
while($row=mysql_fetch_assoc($result)){
   
    $locations[$row['site_code']] = $row['state'].' ('.$row['city'].')'; // create array of region_names and cities
    $locationsStates[$row['site_code']] = $row['state'];
    $locationsCities[$row['site_code']] = $row['city'];   
    $locationsCountry[$row['site_code']] = $row['country'];   
    $locationsRegionCode[$row['site_code']] = $row['region_code'];   
}

$fun = mysql_query("SELECT fmid,location,start_date_formatted,end_date_formatted FROM event_calendar WHERE (course_type_id='3' or course_type_id='139') and event_calendar.location NOT LIKE '%HOLD' AND location NOT LIKE 'SG%' AND location NOT LIKE 'MAN%' AND location NOT LIKE 'Luxumbourg' AND location NOT LIKE 'Beijing' and event NOT LIKE '%FAST%' and region NOT LIKE 'GB' and (TO_DAYS(start_date)-TO_DAYS(NOW()))>0 ORDER BY start_date");
$fun_courses = array( );
while($row=mysql_fetch_assoc($fun)){
    
    $row['state'] = $locationsStates[$row['location']];
    $row['city'] = $locationsCities[$row['location']];
    $row['country'] = $locationsCountry[$row['location']];
    $row['region_code'] = $locationsRegionCode[$row['location']];
          
    $row['location'] = $locations[$row['location']]; // change location code (site_code) into something more meaningful, like the region_name and city (see above)
         
    $switchString = $row['city'];

    switch(true) {
        case stristr($switchString, 'Charlotte'):
        case stristr($switchString, 'Philadelphia'):
        case stristr($switchString, 'Dallas/Fort Worth'):
        case stristr($switchString, 'Ft. Lauderdale'):
        case stristr($switchString, 'Seattle'):
        case stristr($switchString, 'Edmonton'):
        case stristr($switchString, 'Halifax'):
        case stristr($switchString, 'London'):
        case stristr($switchString, 'San Diego'):
            //case "New Jersey (city TBD)":
            $row['price'] = "$699"; // price must match the price in renderCourses
            break;
        default:
            $row['price'] = "$925"; // price must match the price in renderCourses
            break;
    }

    $fun_courses[] = $row;    
}


$ful = mysql_query("SELECT fmid,location,start_date_formatted,end_date_formatted FROM event_calendar WHERE (course_type_id='4' or course_type_id='140') and event_calendar.location NOT LIKE '%HOLD' AND location NOT LIKE 'SG%' AND location NOT LIKE 'MAN%' AND location NOT LIKE 'Luxumbourg' and event NOT LIKE '%FAST%' and (TO_DAYS(start_date)-TO_DAYS(NOW()))>0 ORDER BY start_date");
$ful_courses = array( );
while($row=mysql_fetch_assoc($ful)){
    $row['location'] = $locations[$row['location']];
    $ful_courses[] = $row;
}

$bal = mysql_query("SELECT fmid,location,start_date_formatted,end_date_formatted FROM event_calendar WHERE (course_type_id='5' or course_type_id='141') and event_calendar.location NOT LIKE '%HOLD' AND location NOT LIKE 'SG%' AND location NOT LIKE 'MAN%' AND location NOT LIKE 'Luxumbourg' and event NOT LIKE '%FAST%' and (TO_DAYS(start_date)-TO_DAYS(NOW()))>0 ORDER BY start_date");
$bal_courses = array( );
while($row=mysql_fetch_assoc($bal)){
    $row['location'] = $locations[$row['location']];
    $bal_courses[] = $row;
}

$pro = mysql_query("SELECT fmid,location,start_date_formatted,end_date_formatted FROM event_calendar WHERE (course_type_id='6' or course_type_id='142') and event_calendar.location NOT LIKE '%HOLD' AND location NOT LIKE 'SG%' AND location NOT LIKE 'MAN%' AND location NOT LIKE 'Luxumbourg' and event NOT LIKE '%FAST%' and (TO_DAYS(start_date)-TO_DAYS(NOW()))>0 ORDER BY start_date");
$pro_courses = array( );
while($row=mysql_fetch_assoc($pro)){
    $row['location'] = $locations[$row['location']];
    $pro_courses[] = $row;
}

$syn = mysql_query("SELECT fmid,location,start_date_formatted,end_date_formatted FROM event_calendar WHERE (course_type_id='7' or course_type_id='143') and event_calendar.location NOT LIKE '%HOLD' AND location NOT LIKE 'SG%' AND location NOT LIKE 'MAN%' AND location NOT LIKE 'Luxumbourg' and event NOT LIKE '%FAST%' and (TO_DAYS(start_date)-TO_DAYS(NOW()))>0 ORDER BY start_date");
$syn_courses = array( );
while($row=mysql_fetch_assoc($syn)){
    $row['location'] = $locations[$row['location']];
    $syn_courses[] = $row;
}


$cas = mysql_query("SELECT fmid,location,start_date_formatted,end_date_formatted FROM event_calendar WHERE  course_type_id='156' and event_calendar.location NOT LIKE '%HOLD' and (TO_DAYS(start_date)-TO_DAYS(NOW()))>0 ORDER BY start_date");
$cas_courses = array( );
while($row=mysql_fetch_assoc($cas)){
    $row['location'] = $locations[$row['location']];
    $cas_courses[] = $row;
}

$cam = mysql_query("SELECT fmid,location,start_date_formatted,end_date_formatted FROM event_calendar WHERE  course_type_id='173' and event_calendar.location NOT LIKE '%HOLD' and (TO_DAYS(start_date)-TO_DAYS(NOW()))>0 ORDER BY start_date");
$cam_courses = array( );
while($row=mysql_fetch_assoc($cam)){
    $row['location'] = $locations[$row['location']];
    $cam_courses[] = $row;
}

$courses = array(
    'fun' => $fun_courses,
    'ful' => $ful_courses,
    'bal' => $bal_courses,
    'pro' => $pro_courses,
    'syn' => $syn_courses,
    'cas' => $cas_courses,
    'cam' => $cam_courses
);

$courses_json = json_encode($courses);





$fun_ft = mysql_query("SELECT id,fmid,location,start_date_formatted,end_date_formatted FROM event_calendar WHERE (course_type_id='3' or course_type_id='139') and event_calendar.location NOT LIKE '%HOLD' AND location NOT LIKE 'LON%' AND location NOT LIKE 'MAN%' AND location NOT LIKE 'Luxumbourg' and event LIKE '%FAST%' and (TO_DAYS(start_date)-TO_DAYS(NOW()))>0 ORDER BY start_date");
$fun_ft_courses = array( );
while($row=mysql_fetch_assoc($fun_ft)){
    $row['location'] = $locations[$row['location']]; // change location code into something more meaningful, like the region_name and city (see above)
    $fun_ft_courses[] = $row;
}

$ful_ft = mysql_query("SELECT id,fmid,location,start_date_formatted,end_date_formatted FROM event_calendar WHERE (course_type_id='4' or course_type_id='140') and event_calendar.location NOT LIKE '%HOLD' AND location NOT LIKE 'LON%' AND location NOT LIKE 'MAN%' AND location NOT LIKE 'Luxumbourg' and event LIKE '%FAST%' and (TO_DAYS(start_date)-TO_DAYS(NOW()))>0 ORDER BY start_date");
$ful_ft_courses = array( );
while($row=mysql_fetch_assoc($ful_ft)){
    $row['location'] = $locations[$row['location']]; // change location code into something more meaningful, like the region_name and city (see above)
    $ful_ft_courses[] = $row;
}

$bal_ft = mysql_query("SELECT id,fmid,location,start_date_formatted,end_date_formatted FROM event_calendar WHERE (course_type_id='5' or course_type_id='141') and event_calendar.location NOT LIKE '%HOLD' AND location NOT LIKE 'LON%' AND location NOT LIKE 'MAN%' AND location NOT LIKE 'Luxumbourg' and event LIKE '%FAST%' and (TO_DAYS(start_date)-TO_DAYS(NOW()))>0 ORDER BY start_date");
$bal_ft_courses = array( );
while($row=mysql_fetch_assoc($bal_ft)){
    $row['location'] = $locations[$row['location']]; // change location code into something more meaningful, like the region_name and city (see above)
    $bal_ft_courses[] = $row;
}

$pro_ft = mysql_query("SELECT id,fmid,location,start_date_formatted,end_date_formatted FROM event_calendar WHERE (course_type_id='6' or course_type_id='142') and event_calendar.location NOT LIKE '%HOLD' AND location NOT LIKE 'LON%' AND location NOT LIKE 'MAN%' AND location NOT LIKE 'Luxumbourg' and event LIKE '%FAST%' and (TO_DAYS(start_date)-TO_DAYS(NOW()))>0 ORDER BY start_date");
$pro_ft_courses = array( );
while($row=mysql_fetch_assoc($pro_ft)){
    $row['location'] = $locations[$row['location']]; // change location code into something more meaningful, like the region_name and city (see above)
    $pro_ft_courses[] = $row;
}

$syn_ft = mysql_query("SELECT id,fmid,location,start_date_formatted,end_date_formatted FROM event_calendar WHERE (course_type_id='7' or course_type_id='143') and event_calendar.location NOT LIKE '%HOLD' AND location NOT LIKE 'LON%' AND location NOT LIKE 'MAN%' AND location NOT LIKE 'Luxumbourg' and event LIKE '%FAST%' and (TO_DAYS(start_date)-TO_DAYS(NOW()))>0 ORDER BY start_date");
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
    this.url = document.URL;
    var regex = /(\d+)([a-z])?$/;
    var match = regex.exec(this.url);
    this.number = match ? parseInt(match[0],10) : 0; // assign 0 if no number found
    this.location = match.length > 2 ? match[2] : ''; // assign location, if any
    //alert(this.number+' '+this.url+' '+match[0]);
    window.console && console.log('number: '+this.number);
    window.console && console.log('location: '+this.location);

    this.pkg_number = this.number < 10 ? '0'+this.number : this.number;
    this.courses = courses;
    this.fasttrack_courses = fasttrack;
}



CoursePackage.prototype.renderCourses = function() {
    var html = '';
    
    window.console && console.log(this.courses);
    

    if(this.number == 1 || this.number == 2 || this.number == 10){
        html += this.course('/coach-training/courses/#course_fundamentals',
                            'Fundamentals',
                            'Course 1: Co-Active Fundamentals',
                            'Co-Active Fundamentals -- <span>Course Dates</span>',
                            'op1',
                            this.courses['fun']
                           );
        html += this.course('/coach-training/courses/#course_fulfillment',
                            'Fulfillment',
                            'Course 2: Fulfillment',
                            'Fulfillment -- <span>Course Dates</span>',
                            'op3',
                            this.courses['ful']
                           );
        html += this.course('/coach-training/courses/#course_balance',
                            'Balance',
                            'Course 3: Balance',
                            'Balance -- <span>Course Dates</span>',
                            'op5',
                            this.courses['bal']
                           );
        html += this.course('/coach-training/courses/#course_process',
                            'Process',
                            'Course 4: Process',
                            'Process -- <span>Course Dates</span>',
                            'op7',
                            this.courses['pro']
                           );
        html += this.course('/coach-training/courses/#course_synergy',
                            'Synergy',
                            'Course 5: Synergy',
                            'Synergy -- <span>Course Dates</span>',
                            'op9',
                            this.courses['syn']
                           );
    }
    if(this.number == 3){
        html += this.course('/coach-training/courses/#course_fundamentals',
                            'Fundamentals',
                            'Course 1: Co-Active Fundamentals',
                            'Co-Active Fundamentals -- <span>Course Dates</span>',
                            'op1',
                            this.courses['fun']
                           );
   }
   if(this.number == 4){
        html += this.course('/coach-training/courses/#course_fulfillment',
                            'Fulfillment',
                            'Course 2: Fulfillment',
                            'Fulfillment -- <span>Course Dates</span>',
                            'op1',
                            this.courses['ful']
                           );
    }
   if(this.number == 5){
        html += this.course('/coach-training/courses/#course_balance',
                            'Balance',
                            'Course 3: Balance',
                            'Balance -- <span>Course Dates</span>',
                            'op1',
                            this.courses['bal']
                           );
    }
   if(this.number == 6){
        html += this.course('/coach-training/courses/#course_process',
                            'Process',
                            'Course 4: Process',
                            'Process -- <span>Course Dates</span>',
                            'op1',
                            this.courses['pro']
                           );
    }
   if(this.number == 7){
        html += this.course('/coach-training/courses/#course_synergy',
                            'Synergy',
                            'Course 5: Synergy',
                            'Synergy -- <span>Course Dates</span>',
                            'op1',
                            this.courses['syn']
                           );
    }
   if(this.number == 8 || this.number == 9 || this.number == 11){
        html += this.fasttrack( );
    }

    return html;
}

//custom compare function
function courseCompareByLocation(a,b)
{
    // Checks the country first
    if (a.country > b.country)
        return -1;
    if (a.country < b.country)
        return 1;

    // Checks the states first
    if (a.state < b.state)
        return -1;
    if (a.state > b.state)
        return 1;

    // If state is equal sort by city. 
    if (a.city < b.city)
        return -1;
    if (a.city > b.city)
        return 1;
}

CoursePackage.prototype.course = function(link,title,legend,label,op,courses) {
    var html = '<div class="fieldset">';
    html += '<fieldset class="courseunit">';
    html += '<div class="legend"><a href="'+link+'">'+legend+'</a></div>';
    html += '<div><label id="l_fundloc1" for="fundloc1">'+label+'</label>';
    html += '<select id="fundloc1" name="'+op+'"><option value="">You have not made a course location selection.</option>';

    // Sort by location
    courses.sort(courseCompareByLocation);

    for(var i = 0; i < courses.length; i++){
        course = courses[i];
        html += '<option value="'+title+' - '+course['location']+' - '+course['start_date_formatted']+' - '+course['price']+'">'+title+' - '+course['location']+' - '+course['start_date_formatted']+' - '+course['price']+'</option>';
        //html += '<option value="'+title+' - '+course['location']+' - '+course['start_date_formatted']+'">'+title+' - '+course['location']+' - '+course['start_date_formatted']+'</option>';
    }
    html += '</select></div></fieldset></div>';
    return html;
}

CoursePackage.prototype.fasttrack = function( ){
    var html = '';
    html += '<div class="fieldset"><fieldset class="courseunit"><div class="legend">Fast Track Series</div><div>';
    html += '<label id="l_fundloc1" for="fundloc1">Please select a series...<br />&nbsp;</span></label>';
    html += '<input type="hidden" name="op1" id="op1" value="" />';
    html += '<input type="hidden" name="op2" id="op2" value="" />';
    html += '<input type="hidden" name="op3" id="op3" value="" />';
    html += '<input type="hidden" name="op4" id="op4" value="" />';
    html += '<input type="hidden" name="op5" id="op5" value="" /></div>';
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
    html += '</fieldset></div>';
    return html;
}

CoursePackage.prototype.renderHeader = function(sing) {
    // NOTE: Prices are set here.
    var html = '';
    if(sing){ // singapore prices
    if(this.number == 1 || this.number == 8){
        html += this.header('Package A: Co-Active Coaching Skills Pathway','$6,700','$1,800','1060.00','a-6814'); //Package A: Co-Active Coaching Skills Pathway
    }
    if(this.number == 2 || this.number == 9){
        html += this.header('Package B: Certified Professional Co-Active Coach Pathway','$12,055','$1,835','2000.00','a-6814'); //Package B: Certified Professional Co-Active Coach Pathway
    }
    if(this.number == 3){
        html += this.header('Individual Course: Fundamentals','$1,000','','1000.00','a-6814'); //Individual Course: 
    }
    if(this.number == 4){
        html += this.header('Individual Course: Fulfillment','$1,600','','250.00','a-6814'); //Individual Course: 
    }
    if(this.number == 5){
        html += this.header('Individual Course: Balance','$1,600','','250.00','a-6814'); //Individual Course: 
    }
    if(this.number == 6){
        html += this.header('Individual Course: Process','$1,600','','250.00','a-6814'); //Individual Course: 
    }
    if(this.number == 7){
        //html += this.header('Individual Course: Synergy','$1,600','','250.00','cart1161');
        html += this.header('Individual Course: Synergy','$1,600','','250.00','a-6814'); //Individual Course: 
    }
    }
    else { // USA prices
    if(this.number == 1 || this.number == 8){
        html += this.header('Package A: Co-Active Coaching Skills Pathway','$5,665','$1,520','1325.00','a-6814'); //Package A: Co-Active Coaching Skills Pathway
    }
    if(this.number == 2 || this.number == 9){
        html += this.header('Package B: Certified Professional Co-Active Coach Pathway','$10,900','$2,275','1425.00','a-6814'); //Package B: Certified Professional Co-Active Coach Pathway
    }
    if(this.number == 10 || this.number == 11 ){
        html += this.header('Package E: Co-Active Entrepreneur Pathway','$11,420','$2,445','1185.00','a-6814'); //Package E: Co-Active Entrepreneur Pathway
    }
    if(this.number == 3){
        html += this.header('Individual Course: Fundamentals','','','925.00','a-6814'); //Individual Course: 
    }
    if(this.number == 4){
        html += this.header('Individual Course: Fulfillment','$1,565','','315.00','a-6814'); //Individual Course: 
    }
    if(this.number == 5){
        html += this.header('Individual Course: Balance','$1,565','','315.00','cart1161'); //Individual Course: 
    }
    if(this.number == 6){
        html += this.header('Individual Course: Process','$1,565','','315.00','cart1161'); //Individual Course: 
    }
    if(this.number == 7){
	html += this.header('Individual Course: Synergy','$1,565','','315.00','cart1161');
    }
    if(this.number == 12){
        html += this.header('Individual Course: Co-Active Sales','$795','','205.00','cart1161'); //Individual Course: 
    }
    if(this.number == 13){
        html += this.header('Individual Course: Co-Active Marketing','$795','','205.00','cart1161'); //Individual Course: 
    }
    if(this.number == 14){
        html += this.header('Entrepreneur Combo: Co-Active Sales and Co-Active Marketing','$1,395','$195','205.00','cart1161'); //Individual Course: 
    }
    }

    return html;
}

CoursePackage.prototype.header = function(course,price,savings,deposit,cart){
    var html = '';
    if(cart == 'cart1161'){
        html +='<form action="http://cart1161.cartserver.com/store/addToCart.aspx" method="POST" id="form2" onsubmit="return hasAgreed(this);">';
        html += '<input type="hidden" name="nonshippingitem" value="1">';
    }
    else {
        html +='<form action="http://www.cartserver.com/sc/cart.cgi" method="POST" id="form2" onsubmit="return hasAgreed(this);">';
    }
    html += '<input type="hidden" name="pkg" value="'+this.pkg_number+'">';
    html += '<input type="hidden" name="item" value="'+cart+'^PKG'+this.pkg_number+'^'+course+', USD '+price+' ^'+deposit+'^1^^^^^">';
   
    //html += '<input type="hidden" name="item" value="">';
    //html += '<h2>'+course+'</h2>';
    html += '<p class="intro"><span id="packageprice">'+price+'</span>';
    if(savings){
      html += '<span id="savings"> Savings of '+savings+'!</span></p>';
    }
    return html;

}

CoursePackage.prototype.renderPolicies = function() {
    var html = '';
    html += '<p><input id="agree" name="agree_to_policies" type="checkbox"> Yes, I have read and agree to ';
    html += '<a class="pricingdetails" href="/docs/_temp/policy-2013.html" rel="lyteframe" rev="width: 800px; height: 500px; scrolling: auto;" title="CTI Policies">CTI Policies</a></p>';
    return html;
}


CoursePackage.prototype.renderCartButton = function() {
    var html = '';
    html += '<input id="addtocart" name="addtocart" type="image" src="/res/img/submit_add_to_cart.gif" alt="Add to Cart" />';
    html += '</form>';
    return html;
}

CoursePackage.prototype.renderAdvisor = function() {
    var html = '<div class="fieldset"><fieldset class="courseunit"><div class="legend">Please tell us which Program Advisor assisted you:</div><div>';
    var dropdown1 = new Dropdown('op30','op30',[ 
        {' none':'-- Please Select --'},
        {' No one assisted':'-- No one assisted me --'},
        {' Assisted by Amy Anderson':'Amy Anderson'},
        {' Assisted by Carla Hamby':'Carla Hamby'},
        {' Assisted by Dana Fulenwider':'Dana Fulenwider'},
        {' Assisted by Debra Martin':'Debra Martin'},
        {' Assisted by Jayson Krause':'Jayson Krause'},
        {' Assisted by Rachel Suckle':'Rachel Suckle'},
        {' Assisted by Sue Jordon':'Sue Jordon'},
        {' Assisted by Tammy Hibler':'Tammy Hibler'}
    ] );
    html += dropdown1.render();
    html += '</div></fieldset></div>';
    return html;
}


CoursePackage.prototype.renderCoactiveSales = function() {
    var html = '';
    if(this.number == 12){
        html += this.coactiveSales();
    }
    return html;
}

CoursePackage.prototype.coactiveSales = function() {
    var html = '';
    var courses = this.courses['cas'];
    var op = 'op12';
    html += '<div class="fieldset"><fieldset class="courseunit"><div class="legend"><strong>Co-Active Sales</strong><br />Course Dates</div><div>';
    html += '<select id="casloc1" name="'+op+'"><option value="">You have not made a course selection.</option>';
    if(courses.length < 1){
        html += '<option value="Co-Active Sales - TBD">TBD</option>';
    }
    for(var i = 0; i < courses.length; i++){
        course = courses[i];
        html += '<option value="Co-Active Sales - '+course['start_date_formatted']+'">Co-Active Sales - '+course['start_date_formatted']+'</option>';
    }
    html += '</select>';
    html += '</div></fieldset></div>';
    return html;
}

CoursePackage.prototype.renderCoactiveMarketing = function() {
    var html = '';
    if(this.number == 13){
        html += this.coactiveMarketing();
    }
    return html;
}

CoursePackage.prototype.coactiveMarketing = function() {
    var html = '';
    var courses = this.courses['cam'];
    var op = 'op12';
    html += '<div class="fieldset"><fieldset class="courseunit"><div class="legend"><strong>Co-Active Marketing</strong><br />Course Dates</div><div>';
    html += '<select id="casloc1" name="'+op+'"><option value="">You have not made a course selection.</option>';
    if(courses.length < 1){
        html += '<option value="Co-Active Marketing - TBD">TBD</option>';
    }
    for(var i = 0; i < courses.length; i++){
        course = courses[i];
        html += '<option value="Co-Active Marketing - '+course['start_date_formatted']+'">Co-Active Marketing - '+course['start_date_formatted']+'</option>';
    }
    html += '</select>';
    html += '</div></fieldset></div>';
    return html;
}

CoursePackage.prototype.renderEntrepreneur = function() {
    var html = '';
    if(this.number == 10 || this.number == 11 || this.number == 14){
        html += this.entrepreneur();
    }
    return html;
}

CoursePackage.prototype.entrepreneur = function() {
    var html = '';

    html += '<div class="fieldset"><fieldset class="courseunit"><div class="legend"><strong>Co-Active Sales</strong><br />Course Dates</div><div>';
    var courses = this.courses['cas'];
    var op = 'op12';
     html += '<select id="casloc1" name="'+op+'"><option value="">You have not made a course selection.</option>';
    if(courses.length < 1){
        html += '<option value="Co-Active Sales - TBD">TBD</option>';
    }
    for(var i = 0; i < courses.length; i++){
        course = courses[i];
        html += '<option value="Co-Active Sales - '+course['start_date_formatted']+'">Co-Active Sales - '+course['start_date_formatted']+'</option>';
    }
    html += '</select>';
    html += '</div><div class="legend">&nbsp;<br /><strong>Co-Active Marketing</strong><br />Course Dates</div><div>';
    courses = this.courses['cam'];
    op = 'op13';
    html += '<select id="casloc1" name="'+op+'"><option value="">You have not made a course selection.</option>';
    if(courses.length < 1){
        html += '<option value="Co-Active Marketing - TBD">TBD</option>';
    }
    for(var i = 0; i < courses.length; i++){
        course = courses[i];
        html += '<option value="Co-Active Marketing - '+course['start_date_formatted']+'">Co-Active Marketing - '+course['start_date_formatted']+'</option>';
    }
    html += '</select>';
    if(this.number == 10 || this.number == 11 ){
        html += '<p>The generally recommended time to take these programs is the course start date closest to the end of your Certification Program. However, we suggest you work with your Program Advisor to tailor a personalized course schedule consistent with your professional goals and preferred pace.</p>';
    }
    html += '</div></fieldset></div>';
    return html;
}

CoursePackage.prototype.renderCertification = function() {
    var html = '';
    if(this.number == 2 || this.number == 9 || this.number == 10 || this.number == 11){
        html += this.certification();
    }
    return html;
}

CoursePackage.prototype.certification = function() {
    var html = '';
    var dd = new Dropdown('op11','op11',this.certificationMonths());
    html += '<div class="fieldset"><fieldset class="courseunit"><div class="legend">Certification Starting Date</div><div>';
    html += dd.render();
    html += '</div></fieldset></div>';
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

    if(form.agree_to_policies.checked == false) {
      alert("Please read the CTI Policies and indicate your agreement by checking the checkbox.");
      return false;
    }


  adjustTotalPrice(form);
  return true;
 }

function adjustDeposit(form){
 if(isLessThan3Weeks(form.op1 ? form.op1.value : '')||
    isLessThan3Weeks(form.op3 ? form.op3.value : '')||
    isLessThan3Weeks(form.op5 ? form.op5.value : '')||
    isLessThan3Weeks(form.op7 ? form.op7.value : '')||
    isLessThan3Weeks(form.op9 ? form.op9.value : '')
    ){
   form.item.value = setFullPrice(form.item.value);
 }
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

                               
/* Singapore pricing as of ???
*/                                
 if(form.pkg && form.pkg.value=="01" && singaporeSelected(form) ){
   package_deposit = 1800;
   fun_price = 1000; fun_discount = 0;
   ful_price = 1600; ful_discount = 350;
   bal_price = 1600; bal_discount = 350;
   pro_price = 1600; pro_discount = 350;
   itb_price = 1600; itb_discount = 350;
   form.item.value = "a-6814^A2FUN^Co-Active Coaching Skills Pathway, USD $6,000 - Package A^1085.00^1^^^^^"; 
 }
 else if(form.pkg && form.pkg.value=="02" && singaporeSelected(form)){
   package_deposit = 2000;
   fun_price = 1000; fun_discount = 0;
   ful_price = 1600; ful_discount = 350;
   bal_price = 1600; bal_discount = 350;
   pro_price = 1600; pro_discount = 350;
   itb_price = 1600; itb_discount = 350;
   form.item.value = "a-6814^A3FULL^Co-Active Professional Co-Active Coach Pathway, USD $10,600 - Package B^1485.00^1^^^^^"; 
} 
 else if(form.pkg && form.pkg.value=="03" && singaporeSelected(form)){
   fun_price = 1000; fun_discount = 0;
   package_deposit = fun_price;
   form.item.value = "a-6814^A1FUN^Course 1: Fundamentals USD $1000^1000.00^1^^^^^";
 }

 else if(form.pkg && form.pkg.value=="04" && singaporeSelected(form)){
   ful_price = 1600; ful_discount = 350;
   package_deposit = ful_discount;
 form.item.value = "a-6814^A1FUL^Course 2: Fulfillment USD $1,600^350.00^1^^^^^";
 }
 else if(form.pkg && form.pkg.value=="05" && singaporeSelected(form)){
   bal_price = 1600; bal_discount = 350;
   package_deposit = bal_discount;
 form.item.value = "a-6814^A1BAL^Course 3: Balance USD $1,600^350.00^1^^^^^";
 }
 else if(form.pkg && form.pkg.value=="06" && singaporeSelected(form)){
   pro_price = 1600; pro_discount = 350;
   package_deposit = pro_discount;
 form.item.value = "a-6814^A1PRO^Course 4: Process USD $1,600^350.00^1^^^^^";
 }
 else if(form.pkg && form.pkg.value=="07" && singaporeSelected(form)){
   itb_price = 1600; itb_discount = 350;
   package_deposit = itb_discount;
 form.item.value = "a-6814^A1ITB^Course 5: Synergy USD $1,600^350.00^1^^^^^";
 } 


/* 
   North American Pricing as of July 1, 2014
*/
 else if(form.pkg && (form.pkg.value=="01" || form.pkg.value=="08")){
     /* Package A */
   package_deposit = 1325;
   fun_price = 925; fun_discount = 0;
   ful_price = 1185; ful_discount = 100; /* discount is the same as deposit in pricing table */
   bal_price = 1185; bal_discount = 100;
   pro_price = 1185; pro_discount = 100;
   itb_price = 1185; itb_discount = 100;
 }
else if(form.pkg && (form.pkg.value=="02" || form.pkg.value=="09")){
    /* Package B */
   package_deposit = 1425;
   fun_price = 925; fun_discount = 0;
   ful_price = 1155; ful_discount = 75;
   bal_price = 1155; bal_discount = 75;
   pro_price = 1155; pro_discount = 75;
   itb_price = 1155; itb_discount = 75;
 } 
else if(form.pkg && (form.pkg.value=="10" || form.pkg.value=="11")){
    /* Package ??? */
   package_deposit = 1425;
   fun_price = 925; fun_discount = 0;
   ful_price = 1155; ful_discount = 75;
   bal_price = 1155; bal_discount = 75;
   pro_price = 1155; pro_discount = 75;
   itb_price = 1155; itb_discount = 75;
 } 
 else if(form.pkg && form.pkg.value=="03"){
     var selectedCourse = form.fundloc1.value;
     var price = selectedCourse.substr(selectedCourse.length-3); // take last 3 characters as the price.
     fun_price = price; 
     fun_discount = 0;
     package_deposit = price;
     if(price == 699){                           
         form.item.value = "a-6814^PKG03^Individual Course: Fundamentals, USD $699^699.00^1^^^^^";
     }
 } 
 else if(form.pkg && form.pkg.value=="04"){
   ful_price = 1565; ful_discount = 315;
   package_deposit = ful_discount;
 } 
 else if(form.pkg && form.pkg.value=="05"){
   bal_price = 1565; bal_discount = 315;
   package_deposit = bal_discount;
 } 
 else if(form.pkg && form.pkg.value=="06"){
   pro_price = 1565; pro_discount = 315;
   package_deposit = pro_discount;
 } 
 else if(form.pkg && form.pkg.value=="07"){
   itb_price = 1565; itb_discount = 315;
   package_deposit = itb_discount;
 }
 else if(form.pkg && form.pkg.value=="12"){
   coactive_price = 795; coactive_discount = 205;
   package_deposit = coactive_discount;
 }
 else if(form.pkg && form.pkg.value=="13"){
   coactive_price = 795; coactive_discount = 205;
   package_deposit = coactive_discount;
 }
 else if(form.pkg && form.pkg.value=="14"){
   coactive_price = 1395; coactive_discount = 205;
   package_deposit = coactive_discount;
 }


/*
  Now calculate the additional deposit required if one of the courses
  is less than 3 weeks away. The additional deposit is the full price of the course
  minus the portion that is already a part of the package price. 
*/

 if(isLessThan3Weeks(form.op1 ? form.op1.value : '')){
   additional_deposit = additional_deposit; // fundamentals already in full price
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

 //alert( form.item.value );
 form.item.value = setPrice( form.item.value, package_deposit, additional_deposit );
 //alert( form.item.value );


}

function singaporeSelected(form){
  var myRegex=/Singapore/i;
  if(form.op1 && form.op1.value.match(myRegex)){ return true; }
  if(form.op3 && form.op3.value.match(myRegex)){ return true; }
  if(form.op5 && form.op5.value.match(myRegex)){ return true; }
  if(form.op7 && form.op7.value.match(myRegex)){ return true; }
  if(form.op9 && form.op9.value.match(myRegex)){ return true; }
  return false;
}

function setPrice( sel, package_price, delta ){
 // Example: a-6814^A1FUL^Course 2: Fulfillment USD $1,250^250.00^1^^^^^
    var total = package_price + delta;
    if(delta == 0){
        total = package_price;
    }
    return sel.replace(/(([0-9]+)\,)?([0-9]+)([^\^0-9]*)\^(\d+)\.00/,"$1$3$4^" + total + ".00");
}



function isLessThan3Weeks( val ){
var today=new Date();
//var today=new Date(2009,9,5); // for testing

// get year, month, day from val
// example:  <option value="1st Fundamentals: Boston Metro, MA - September 11, 2009">Fundamentals - Boston Metro, MA - September 11, 2009</option>
// example: <option value="Fundamentals - Ottawa, Ontario (Ottawa) - Nov 28-30, 2014">Fundamentals - Ottawa, Ontario (Ottawa) - Nov 28-30, 2014</option>

var myregex = new RegExp(/([A-Za-z]+)\s+(\d+)(-\d+)?,\s+(\d+)/);
var matches = myregex.exec( val );
//alert(matches);
if(matches != null){
var year  = matches[4];
var month = convertMonth(matches[1]);
var day   = matches[2];
var selDate=new Date(year,month,day) //Month is 0-11 in JavaScript

//Set 3 weeks in milliseconds
var three_weeks=1000*60*60*24*21  // 1000 msec * 60 secs * 60 mins * 24 hours * 21 days


console.log("today: "+today+"  selection: "+selDate+"  t/f: "+(( selDate.getTime()-today.getTime() ) < three_weeks));

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

function setFullPrice( sel ){
 // Example: a-6814^A1FUL^Course 2: Fulfillment USD $1,150^250.00^1^^^^^
  
 return sel.replace(/(([0-9]+)\,)?([0-9]+)([^\^0-9]*)\^(\d+)\.00/,"$1$3$4^$2$3.00");
}

function setops(track_id){
document.getElementById('op1').value=document.getElementById('op1_'+track_id).value;
document.getElementById('op2').value=document.getElementById('op2_'+track_id).value;
document.getElementById('op3').value=document.getElementById('op3_'+track_id).value;
document.getElementById('op4').value=document.getElementById('op4_'+track_id).value;
document.getElementById('op5').value=document.getElementById('op5_'+track_id).value;
}

// ------------------------------------------------------------------------------------------------------------

var sing = false;
var url = document.URL;
if (url.match(/s$/)){
    sing = true;
    window.console && console.log('Singapore');
}
 
var html = '';

courses = <?php echo $courses_json ?>;

fasttrack = <?php echo $fasttrack_json ?>;




var course_package = new CoursePackage(courses,fasttrack);

html += course_package.renderHeader(sing);
html += course_package.renderAdvisor();
html += course_package.renderCourses();
html += course_package.renderCertification();
html += course_package.renderEntrepreneur();
html += course_package.renderCoactiveSales();
html += course_package.renderCoactiveMarketing();
html += course_package.renderPolicies();
html += course_package.renderCartButton();

document.write(html);



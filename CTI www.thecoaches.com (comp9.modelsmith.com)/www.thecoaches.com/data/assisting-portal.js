/* assisting.js

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





$assisting = mysql_query("SELECT fmid,event,event_calendar.region,site_data.city,region_name,start_date_formatted,end_date_formatted 

FROM event_calendar,site_data,regions WHERE 

( course_type_id='3' OR

  course_type_id='4' OR

  course_type_id='5' OR

  course_type_id='6' OR

  course_type_id='7') AND

event_calendar.location=site_data.site_code AND

site_data.region=regions.region_code AND

site_data.region!='GB' AND

event_calendar.location NOT LIKE 'Lux%' AND

event_calendar.location NOT LIKE '%HOLD' AND

(TO_DAYS(start_date)-TO_DAYS(NOW()))>0 AND

(TO_DAYS(start_date)-TO_DAYS(NOW()))<96

ORDER BY start_date");



$city_list  = array( );

$courses = array( );

while($row=mysql_fetch_assoc($assisting)){

    $city_list[$row['region']] = $row['region_name'];

    $courses[$row['region']][] = $row;

}





asort($city_list);

$cities = array( array('none'=>'Please select a city...') );

foreach($city_list as $region => $region_name){

    $cities[] = array( $region => $region_name );

}



$courses_json = json_encode($courses);

$cities_json = json_encode($cities);





// ============ SERVER CODE ABOVE, CLIENT CODE BELOW ============

?>

// ------------------------------------------------------------------------------------------------------------



var assisting_region;



function Dropdown(name, id, options, attributes){

    this.attributes = attributes;

    this.name = name;

    this.id = id;

    this.options = options; // array [ { 'value':'option' }, {...} ]

}



Dropdown.prototype.render = function() {

    var html = '<select name="' + this.name + '" id="' + this.id + '" ' + this.attributes + '>';

    for(var i = 0; i < this.options.length; i++){

        var option = this.options[i];

        for( var key in option ){

            if (key === 'length' || !option.hasOwnProperty(key)) continue; // check that key is not coming from prototype

            // remove up to first colon, if any

            var option_text = option[key].replace(/[^:]+:/,'');

            html += '<option value="' + key + '">' + option_text + '</option>';

        }

    }

    html += '</select>';

    return html;

}



// ------------------------------------------------------------------------------------------------------------



function Courses(cities, courses){

    this.cities = cities;

    this.courses = courses;

}



Courses.prototype.render = function() {

    var html = '';



        

    

    // foreach city, create course dropdown

    for(var i=0;i<this.cities.length;i++){

        var city = this.cities[i];

        window.console && console.log(city);

        for( var region in city ){   // iterate over assoc array

            if (region === 'length' || !city.hasOwnProperty(region)) continue; 

            //window.console && console.log(region);

            if(region=='none')continue;

            var city_name = city[region];

            var courses = this.courses[region];

            //window.console && console.log(courses);

            var course_list = [ {'none':'Please select a course... '} ];

            for(var j=0;j<courses.length;j++){

                var course = courses[j];

                //window.console && console.log(course);

                if(!course)continue;

                var course_desc = course['fmid']+': '+course['event']+' - '+course['region_name']+' - '+course['start_date_formatted'];

                var assoc = { };

                assoc[course_desc] = course_desc;

                course_list.push(assoc);

            }

            //window.console && console.log(course_list);

            var course1_dd = new Dropdown('event1:'+region,'1st_choice_'+region,course_list,'');

            var course2_dd = new Dropdown('event2:'+region,'2nd_choice_'+region,course_list,'');

            var course3_dd = new Dropdown('event3:'+region,'3rd_choice_'+region,course_list,'');

            html+='<div id="montreal_pref" style="display:none;"><p> * Bilingual English/French Speaking Assistants, Preferred<br/></p></div>';

            html+='<div class="course-select" id="'+region+'" style="display:none;"><p>Select 3 courses in your area.<br />You will be scheduled into the first course that has openings for assistants.</p>';

            html+='<p><b>First Choice - '+city_name+'</b><br />';

            html+=course1_dd.render();

            html+='</p><p><b>Second Choice - '+city_name+'</b><br />';

            html+=course2_dd.render();

            html+='</p><p><b>Third Choice - '+city_name+'</b><br />';

            html+=course3_dd.render();

            html+='</p>';

            html+='</div>';

        }

    }



    return html;

}





// ------------------------------------------------------------------------------------------------------------



function getNodeText(node)

	{

	        var text = "";

	        if(node.text) text = node.text;

	        if(node.firstChild) text = node.firstChild.nodeValue;

	        return text;

	}



function showCoursesFor(region){

    // note: should be using getElementByClass here... tbeutel 4/23/13


  if(document.getElementById){

var montreal_pref='';
var coursesBlock='';
var npeBlock='';
var portalBlock='';

    montreal_pref = document.getElementById('montreal_pref');

    if (region == "MON") {

        if(montreal_pref) montreal_pref.style.display = 'block';

    } else {

        if(montreal_pref) montreal_pref.style.display = 'none';

    }



    coursesBlock = document.getElementById('ATL');

      if(coursesBlock) coursesBlock.style.display = 'none';



    coursesBlock = document.getElementById('AUS');

    if(coursesBlock)  coursesBlock.style.display = 'none';



    coursesBlock = document.getElementById('BOS');

    if(coursesBlock)  coursesBlock.style.display = 'none';



    coursesBlock = document.getElementById('CGY');

    if(coursesBlock)  coursesBlock.style.display = 'none';



    coursesBlock = document.getElementById('CHI');

    if(coursesBlock)  coursesBlock.style.display = 'none';



    coursesBlock = document.getElementById('DVR');

    if(coursesBlock)  coursesBlock.style.display = 'none';



    coursesBlock = document.getElementById('HI');

    if(coursesBlock)  coursesBlock.style.display = 'none';



    coursesBlock = document.getElementById('MN');

    if(coursesBlock)  coursesBlock.style.display = 'none';



    coursesBlock = document.getElementById('MON');

    if(coursesBlock)  coursesBlock.style.display = 'none';



    coursesBlock = document.getElementById('NY');

    if(coursesBlock)  coursesBlock.style.display = 'none';



    coursesBlock = document.getElementById('OTT');

    if(coursesBlock)  coursesBlock.style.display = 'none';



    coursesBlock = document.getElementById('PHX');

    if(coursesBlock)  coursesBlock.style.display = 'none';

    

    coursesBlock = document.getElementById('SC');

    if(coursesBlock)  coursesBlock.style.display = 'none';



    coursesBlock = document.getElementById('SR');

    if(coursesBlock)  coursesBlock.style.display = 'none';



    coursesBlock = document.getElementById('TOR');

    if(coursesBlock)  coursesBlock.style.display = 'none';



    coursesBlock = document.getElementById('VAN');

    if(coursesBlock)  coursesBlock.style.display = 'none';



    coursesBlock = document.getElementById('DC');

    if(coursesBlock)  coursesBlock.style.display = 'none';



    coursesBlock = document.getElementById('VIC');

    if(coursesBlock)  coursesBlock.style.display = 'none';

    

    if(region != "none"){

        coursesBlock = document.getElementById(region);

        coursesBlock.style.display = '';

        // if region == 'SR' hide name/phone/email

        npeBlock = document.getElementById('name-phone-email-block');

        portalBlock = document.getElementById('portal-block');



            // change assisting_region if statement below too

            npeBlock.style.display = 'none';

            portalBlock.style.display = '';



            //npeBlock.style.display = '';

            //portalBlock.style.display = 'none';



        assisting_region = region;

    }

  }

}



function hasAgreed(form) {



    var city_element = document.getElementById('city');

    if (city_element && city_element.selectedIndex == 0) {

        alert('Please select an event.');

        return false;

    }

    

    if (assisting_region) {

        //alert('assisting_region = ' + assisting_region);

        var first_choice_elementName = '1st_choice_' + assisting_region;

        var second_choice_elementName = '2nd_choice_' + assisting_region;

        var third_choice_elementName = '3rd_choice_' + assisting_region;

        

        var first_choice_element = document.getElementById(first_choice_elementName);

        var first_choice_selected = first_choice_element ? first_choice_element.selectedIndex : 0;

        

        var second_choice_element = document.getElementById(second_choice_elementName);

        var second_choice_selected = second_choice_element ? second_choice_element.selectedIndex : 0;



        var third_choice_element = document.getElementById(third_choice_elementName);

        var third_choice_selected = third_choice_element ? third_choice_element.selectedIndex : 0;



        if (first_choice_selected == 0 && second_choice_selected == 0 && third_choice_selected == 0) {

            alert('Please select an event.');

            return false;

        }

    }

    

    if(form.agree_to_requirements.checked == false) {

	alert("Please read the CTI Policies and indicate your agreement by checking the checkbox.");

	return false;

    }





        form.action = '/portal/index.php/assisting/registerStep1';

        //form.action = '/docs/form.html';

  



    //alert(form.action);

    return true;

}





// ------------------------------------------------------------------------------------------------------------





var html = '';



courses = <?php echo $courses_json ?>;



cities = <?php echo $cities_json ?>;



var cities_dd = new Dropdown('City','city', cities, 'class="city-select" onchange="showCoursesFor(this.options[this.selectedIndex].value);"');

html += cities_dd.render();



//onchange="showCoursesFor(this.options[this.selectedIndex].value);"



var courses = new Courses( cities, courses );

html += courses.render();



document.write(html);

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
            html += '<option value="' + key + '">' + option[key] + '</option>';
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
        for( var region in city ){   // iterate over assoc array
            if (region === 'length' || !city.hasOwnProperty(region)) continue; 
            //window.console && console.log(region);
            if(region=='none')continue;
            var courses = this.courses[region];
            window.console && console.log(courses);
            var course_list = [ {'none':'Please select a course... '} ];
            for(var j=0;j<courses.length;j++){
                var course = courses[j];
                window.console && console.log(course);
                if(!course)continue;
                var course_desc = course['event']+' - '+course['region_name']+' - '+course['start_date_formatted'];
                var assoc = { };
                assoc[course_desc] = course_desc;
                course_list.push(assoc);
            }
            window.console && console.log(course_list);
            var course1_dd = new Dropdown('1st_choice_'+region,'1st_choice_'+region,course_list,'');
            var course2_dd = new Dropdown('2nd_choice_'+region,'2nd_choice_'+region,course_list,'');
            var course3_dd = new Dropdown('3rd_choice_'+region,'3rd_choice_'+region,course_list,'');
            html+='<div class="course-select" id="'+region+'" style="display:none;"><p>Select 3 courses in your area beginning 4-6 weeks from now.<br />You will be scheduled into the first course that has openings for assistants.</p>';
            html+='<p><b>First Choice - '+this.cities['region']+'</b><br />';
            html+=course1_dd.render();
            html+='</p><p><b>Second Choice - '+this.cities['region']+'</b><br />';
            html+=course2_dd.render();
            html+='</p><p><b>Third Choice - '+this.cities['region']+'</b><br />';
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

  if(document.getElementById){

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

    coursesBlock = document.getElementById('DC');
    if(coursesBlock)  coursesBlock.style.display = 'none';

    coursesBlock = document.getElementById('HI');
    if(coursesBlock)  coursesBlock.style.display = 'none';

    coursesBlock = document.getElementById('MN');
    if(coursesBlock)  coursesBlock.style.display = 'none';

    coursesBlock = document.getElementById('MON');
    if(coursesBlock)  coursesBlock.style.display = 'none';

    coursesBlock = document.getElementById('NY');
    if(coursesBlock)  coursesBlock.style.display = 'none';

    coursesBlock = document.getElementById('OR');
    if(coursesBlock)  coursesBlock.style.display = 'none';

    coursesBlock = document.getElementById('SC');
    if(coursesBlock)  coursesBlock.style.display = 'none';

    coursesBlock = document.getElementById('SR');
    if(coursesBlock)  coursesBlock.style.display = 'none';

    coursesBlock = document.getElementById('TOR');
    if(coursesBlock)  coursesBlock.style.display = 'none';

    coursesBlock = document.getElementById('VAN');
    if(coursesBlock)  coursesBlock.style.display = 'none';

    if(region != "none"){
        coursesBlock = document.getElementById(region);
        coursesBlock.style.display = '';
    }
  }
}

function hasAgreed(form) {

    if(form.agree_to_requirements.checked == false) {
	alert("Please read the CTI Policies and indicate your agreement by checking the checkbox.");
	return false;
    }


 
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

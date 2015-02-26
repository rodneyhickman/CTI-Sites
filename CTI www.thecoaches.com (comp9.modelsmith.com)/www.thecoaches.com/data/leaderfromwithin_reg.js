<?php
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


$html = '';


// NORTHERN CALIFORNIA

$NA_sql = <<<EOS
SELECT id,event,start_date,start_date_formatted,end_date_formatted FROM event_calendar
WHERE (course_type_id=11 or course_type_id=12 or course_type_id=13 or course_type_id=14)
AND (location='MCC' OR location='MTree' OR location='Wildwood' OR location='Sequoia' OR location="WESTERBEKE") ORDER BY start_date ASC
EOS;

$NA_retreats = get_events( $NA_sql );
$html .= emit_registration( $NA_retreats, 
                            'Northern California, USA', 
                            'Northern California',
                            '<input type="hidden" name="itemnc" id="itemnc" value="a-6814^LP^Total Cost USD $12,900, Deposit USD $995 <br> Leadership Package Northern California^995.00^1^^^^^">',
                            'op1','op2'
);


// EAST COAST

$BOI_sql = <<<EOS
SELECT id,event,start_date,start_date_formatted,end_date_formatted FROM event_calendar
WHERE (course_type_id=11 or course_type_id=12 or course_type_id=13 or course_type_id=14)
AND location like '%BOI' ORDER BY start_date ASC
EOS;

$BOI_retreats = get_events( $BOI_sql );
$html .= emit_registration( $BOI_retreats, 
                            'East Coast, USA', 
                            'East Coast',
                            '<input type="hidden" name="itemec" id="itemec" value="a-6814^LP^Total Cost USD $12,900, Deposit USD $995 <br> Leadership Package East Coast^995.00^1^^^^^">',
                            'op3','op4'
                          );



// SPAIN

$ES_sql = <<<EOS
SELECT id,event,start_date,start_date_formatted,end_date_formatted FROM event_calendar
WHERE (course_type_id=11 or course_type_id=12 or course_type_id=13 or course_type_id=14)
AND (location='SPAIN' or location like 'ES%'  or location like 'IT%') ORDER BY start_date ASC
EOS;

$ES_retreats = get_events( $ES_sql );
$html .= emit_registration( $ES_retreats, 
                            'Sitges, Spain', 
                            'Sitges, Spain',
                            '<input type="hidden" name="itemsp" id="itemsp" value="a-6814^LP^Total Cost Euro 11,500, Deposit Euro 975 <br> Leadership Package Spain^975.00^1^^^^^">',
                            'op5','op6'
                          );



// JAPAN

$JP_sql = <<<EOS
SELECT id,event,start_date,start_date_formatted,end_date_formatted FROM event_calendar
WHERE (course_type_id=11 or course_type_id=12 or course_type_id=13 or course_type_id=14)
AND location like '%HGJC' ORDER BY start_date ASC
EOS;

//$JP_retreats = get_events( $NA_sql );
//$html .= emit_registration( $NA_retreats, 'Northern California, USA', 'Northern California' );

$html = preg_replace('/\'/'," \\'",$html);  // change \' to \\' 
$html = preg_replace('/\n/',"",$html); // remove <cr>s



function get_events( $sql ) {

    $events = array( );

    $result = mysql_query( $sql );

    while($row = mysql_fetch_array($result, MYSQL_ASSOC)){

        $event = array( );
        $event['event'] = $row['event'];

        preg_match('/(.*?) (\d)$/',$row['event'],$matches);
        $event['pod'] = $matches[1];

        $delta = $matches[2] < 3 ? 5 : 4; // +5 days for retreats 1 and 2,  +4 days for the rest

        $event['month']                = date('F Y',strtotime($row['start_date']));
        $event['sort_id']              = date('Ymd',strtotime($row['start_date']));
        $event['start_date_formatted'] = date('F j, Y',strtotime($row['start_date']));
        $event['end_date_formatted']   = date('F j, Y',strtotime($row['start_date']) + ($delta * 86400));

        $events[] = $event;
    }


    $pod_names = array_unique( 
                 array_map( 'pod_name', 
                 array_filter( $events, 'pod_one_only' ) ) );

    $months = array_unique( 
              array_map( 'month_name', 
              array_filter( $events, 'pod_one_only' ) ) );


    $retreats = array( );

    foreach($pod_names as $pod_name){
        $retreat_events = array( );
        foreach($events as $event){
            if($event['pod'] == $pod_name){
                $retreat_events[$event['sort_id']] = $event;
            }
        }
        //print_r($retreat_events);
        ksort($retreat_events); // retreat_events now contains retreats for 'pod_name' in order
   
        //echo "Retreats events:\n";
        //print_r($retreat_events);
        
        $keys = array_keys( $retreat_events );

        $retreats[] = array(
            'id'       => $retreat_events[$keys[0]]['sort_id'],
            'month'    => $retreat_events[$keys[0]]['month'],
            'pod'    => $retreat_events[$keys[0]]['pod'],
            'retreat1' => $retreat_events[$keys[0]]['start_date_formatted'] . ' - ' . $retreat_events[$keys[0]]['end_date_formatted'],
            'retreat2' => $retreat_events[$keys[1]]['start_date_formatted'] . ' - ' . $retreat_events[$keys[1]]['end_date_formatted'],
            'retreat3' => $retreat_events[$keys[2]]['start_date_formatted'] . ' - ' . $retreat_events[$keys[2]]['end_date_formatted'],
            'retreat4' => $retreat_events[$keys[3]]['start_date_formatted'] . ' - ' . $retreat_events[$keys[3]]['end_date_formatted'],
        );
    }

    return $retreats;
}


function pod_name($v){
    return $v['pod'];
}

function month_name($v){
    return $v['month'];
}

function pod_one_only($v){
    if( preg_match('/1$/',$v['event']) ){ // if event name has a '1', return pod name
        return true;
    }
    return false;
}

//locations: 
// Northern California, USA
// 
// 

// $cart_string:
//  <input type="hidden" name="itemec" id="itemec" value="a-6814^LP^Total Cost USD $11,900, Deposit USD $975 <br> Leadership Package East Coast^975.00^1^^^^^">


function emit_registration( $retreats, $sub_head, $location, $cart_string, $op1, $op2 ){
    $html = '';
    $html .= $cart_string;
    $html .= '<h2>'.$sub_head.'</h2>';
    $html .= '<p><strong>Leader Program First Choice</strong><br>';
    $html .= '<select name="'.$op1.'" id="'.$op1.'" size="1">';
    $html .= '<option value="">You have not yet made a Retreat selection.</option>';
    $html .= '<option value="">-----------------------------------------------------</option>';

    foreach($retreats as $r){
      $html .= '<option value=" 1st choice: '.$r['retreat1'].', '.$r['retreat2'].', '.$r['retreat3'].', '.$r['retreat4'].' ">';
      $html .= 'Retreats starting in '.$r['month'];
      $html .= '</option>';
    }

    $html .= '</select>';
    $html .= '<p><strong>Leader Program Second Choice</strong><br>';
    $html .= '<select name="'.$op2.'" id="'.$op2.'" size="1">';
    $html .= '<option value="">You have not yet made a Retreat selection.</option>';
    $html .= '<option value="">-----------------------------------------------------</option>';
    

    foreach($retreats as $r){
      $html .= '<option value=" 2nd choice: '.$r['retreat1'].', '.$r['retreat2'].', '.$r['retreat3'].', '.$r['retreat4'].' ">';
      $html .= 'Retreats starting in '.$r['month'];
      $html .= '</option>';
    }

    $html .= '</select>';
    $html .= '      <p>';
    $html .= '        <input type="image" border="0" name="This completes leadership download Form" src="/docs/images/button_addtocart.gif" value="Submit Form" >';
    $html .= '      </p>';
    $html .= '<p>&nbsp;</p>';

    return $html;
}

// ================== END of PHP ==================
?>



function switchDiv(id){
  //alert(val);
  document.getElementById('download').style.display="none";
  document.getElementById('online').style.display="none";
  document.getElementById(id).style.display="block";
}

function IsValidEmail(str) {
  return (str.indexOf(".") > 2) && (str.indexOf("@") > 0);
}

function IsNumeric(sText){
   var ValidChars = "0123456789.";
   var IsNumber=true;
   var Char;


   for (i = 0; i < sText.length && IsNumber == true; i++)
      {
      Char = sText.charAt(i);
      if (ValidChars.indexOf(Char) == -1)
         {
         IsNumber = false;
         }
      }
   return IsNumber;

}

function IsEmpty(aTextField) {
   if ((aTextField.value.length==0) ||
   (aTextField.value==null)) {
      return true;
   }
   else { return false; }
}


 function ValidateForm(form)
 {

   if(IsEmpty(form.name))
   {
      alert('You have not entered a name');
      form.name.focus();
      return false;
   }



   if (!IsValidEmail(form.email.value))
   {
      alert('Please enter a valid email address');
      form.email.focus();
      return false;
   }

   if(IsEmpty(form.phone))
   {
      alert('You have not entered your preferred phone number');
      form.phone.focus();
      return false;
   }


 return true;

}

function addParams(form)
{
  var redirect = 'http://www.cartserver.com/sc/cart.cgi';

  if(form.op31.checked != 1){
      alert("Please read the CTI Policies and indicate your agreement by checking the checkbox");
      form.op31.focus();
      return false;
   }


  var item = '';

  var op1 = document.getElementById('op1');
  var op2 = document.getElementById('op2');
  var op3 = document.getElementById('op3');
  var op4 = document.getElementById('op4');
  var op5 = document.getElementById('op5');
  var op6 = document.getElementById('op6');
  var op7 = document.getElementById('op7');
  var op8 = document.getElementById('op8');
  var op31 = document.getElementById('op31');

  var op1v = '';  if(op1){op1v = op1.value}
  var op2v = '';  if(op2){op2v = op2.value}
  var op3v = '';  if(op3){op3v = op3.value}
  var op4v = '';  if(op4){op4v = op4.value}
  var op5v = '';  if(op5){op5v = op5.value}
  var op6v = '';  if(op6){op6v = op6.value}
  var op7v = '';  if(op7){op7v = op7.value}
  var op8v = '';  if(op8){op8v = op8.value}

  var op31v = ''; if(op31.checked == 1){op31v = op31.value}


  if(op1v != ''){
    item=document.getElementById('itemnc').value;
  } else if(op3v != ''){
    item=document.getElementById('itemec').value;
  } else if(op5v != ''){
    item=document.getElementById('itemsp').value;
  } else if(op7v != ''){
    item=document.getElementById('itemjp').value;
  } 
  document.getElementById('onlineredir').value = redirect + "?item="+escape(item)+"&op1="+escape(op1v)+"&op2="+escape(op2v)+"&op3="+escape(op3v)+"&op4="+escape(op4v)+"&op5="+escape(op5v)+"&op6="+escape(op6v)+"&op7="+escape(op7v)+"&op8="+escape(op8v)+"&op31="+escape(op31v);
    //alert(form.redirect.value);
  return true;
}


var html = '';
html += '';
html += '<p>';
html += '       <h3>Online Registration</h3>';
html += '</p>';
html += '';
html += '<div style="float:left; width:500px;">                        ';
html += '  ';
html += '  <div id="online">';
html += '';
html += '';
html += '    <form action="/docs/form.html" method="POST" name="form2" id="form2" style="margin-bottom: 0" onsubmit="addParams(this);">';
html += '';
html += '      <p> ';
html += '        <input type="hidden" name="recipient" value="leadership@thecoaches.com">';
html += '';
html += '        <input type="hidden" name="subject" value="Leadership Registration Form">';
html += '        <input type="hidden" id="onlineredir" name="redirect" value="/leadership">';
html += '        <input type="hidden" name="Additional Note" value="Applicant should have completed a credit card payment via Amerisite Cart Server - please double check">';
html += '';
html += '        ';
html += '';
html += '        <table border="0" cellpadding="2" cellspacing="0" class="textNormal">';
html += '';
html += '';
html += '          <tr>';
html += '            <td class="right">First Name:</td>';
html += '            <td class="bodytext"><input type="text" name="First Name" tabindex="2" size="34"';
html += '                                        maxlength="25"></td>';
html += '          </tr>';
html += '';
html += '          <tr>';
html += '            <td class="right">Last Name:</td>';
html += '            <td class="bodytext"><input type="text" name="Last Name" tabindex="3" size="34"';
html += '                                        maxlength="50"></td>';
html += '          </tr>';
html += '';
html += '          <tr>';
html += '            <td class="right">Gender:</td>';
html += '            <td class="bodytext"><input type="radio" name="gender" tabindex="4" value="Male"> Male &nbsp;&nbsp;&nbsp;<input type="radio" name="gender" tabindex="4" value="Female"> Female</td>';
html += '          </tr>';
html += '';
html += '          <tr>';
html += '            <td class="right">Home Phone:</td>';
html += '            <td class="bodytext"><input type="text" value="( ) " name="Home Phone" tabindex="5"';
html += '                                        size="25" maxlength="25"></td>';
html += '          </tr>';
html += '';
html += '          <tr>';
html += '            <td class="right">Work Phone:</td>';
html += '            <td class="bodytext"><input type="text" value="( )" name="Work Phone" tabindex="6"';
html += '                                        size="25" maxlength="25"> Ext:';
html += '              <input type="text" name="Work Phone Ext." tabindex="7" size="5"';
html += '                     maxlength="15"> optional';
html += '            </td>';
html += '          </tr>';
html += '';
html += '          <tr>';
html += '            <td class="right">Mobile Phone:</td>';
html += '            <td class="bodytext"><input type="text" value="( )" name="Mobile Phone" tabindex="8"';
html += '                                        size="25" maxlength="25"> optional</td> ';
html += '          </tr>';
html += '';
html += '          <tr>';
html += '            <td class="right">Contact E-mail:</td>';
html += '            <td class="bodytext"><input type="text" name="Contact Email" tabindex="9" size="34"';
html += '                                        maxlength="100"></td>';
html += '          </tr>';
html += '';
html += '          <tr>';
html += '            <td class="right">Address Line 1:</td>';
html += '            <td class="bodytext"><input type="text" name="Address Line 1" tabindex="10" size="40"';
html += '                                        maxlength="150"></td>';
html += '          </tr>';
html += '';
html += '          <tr>';
html += '            <td class="right">Address Line 2:</td>';
html += '            <td class="bodytext"><input type="text" name="Address Line 2" tabindex="11" size="40"';
html += '                                        maxlength="150"></td>';
html += '          </tr>';
html += '';
html += '          <tr>';
html += '            <td class="right">City:</td>';
html += '            <td class="bodytext"><input type="text" name="City" tabindex="12" size="40"';
html += '                                        maxlength="75"></td>';
html += '          </tr>';
html += '';
html += '          <tr>';
html += '            <td class="right">State:</td>';
html += '            <td class="bodytext"><select name="State" size="1" tabindex="13">';
html += '';
html += '                <option selected value="">&nbsp;--Choose One--';
html += '                <option value="USA: AL">USA: Alabama';
html += '                <option value="USA: AK">USA: Alaska';
html += '                <option value="USA: AZ">USA: Arizona';
html += '                <option value="USA: AR">USA: Arkansas';
html += '                <option value="USA: CA">USA: California';
html += '                <option value="USA: CO">USA: Colorado';
html += '                <option value="USA: CT">USA: Connecticut';
html += '                <option value="USA: DE">USA: Delaware';
html += '                <option value="USA: FL">USA: Florida';
html += '                <option value="USA: GA">USA: Georgia';
html += '                <option value="USA: HI">USA: Hawaii';
html += '                <option value="USA: ID">USA: Idaho';
html += '                <option value="USA: IL">USA: Illinois';
html += '                <option value="USA: IN">USA: Indiana';
html += '                <option value="USA: IA">USA: Iowa';
html += '                <option value="USA: KS">USA: Kansas';
html += '                <option value="USA: KY">USA: Kentucky';
html += '                <option value="USA: LA">USA: Louisiana';
html += '                <option value="USA: ME">USA: Maine';
html += '                <option value="USA: MD">USA: Maryland';
html += '                <option value="USA: MA">USA: Massachusetts';
html += '                <option value="USA: MI">USA: Michigan';
html += '                <option value="USA: MN">USA: Minnesota';
html += '                <option value="USA: MS">USA: Mississippi';
html += '                <option value="USA: MO">USA: Missouri';
html += '                <option value="USA: MT">USA: Montana';
html += '                <option value="USA: NE">USA: Nebraska';
html += '                <option value="USA: NV">USA: Nevada';
html += '                <option value="USA: NH">USA: New Hampshire';
html += '                <option value="USA: NJ">USA: New Jersey';
html += '                <option value="USA: NM">USA: New Mexico';
html += '                <option value="USA: NY">USA: New York';
html += '                <option value="USA: NC">USA: North Carolina';
html += '                <option value="USA: ND">USA: North Dakota';
html += '                <option value="USA: OH">USA: Ohio';
html += '                <option value="USA: OK">USA: Oklahoma';
html += '                <option value="USA: OR">USA: Oregon';
html += '                <option value="USA: PA">USA: Pennsylvania';
html += '                <option value="USA: RI">USA: Rhode Island';
html += '                <option value="USA: SC">USA: South Carolina';
html += '                <option value="USA: SD">USA: South Dakota';
html += '                <option value="USA: TN">USA: Tennessee';
html += '                <option value="USA: TX">USA: Texas';
html += '                <option value="USA: UT">USA: Utah';
html += '                <option value="USA: VT">USA: Vermont';
html += '                <option value="USA: VA">USA: Virginia';
html += '                <option value="USA: WA">USA: Washington';
html += '                <option value="USA: DC">USA: Washington DC';
html += '                <option value="USA: WV">USA: West Virginia';
html += '                <option value="USA: WI">USA: Wisconsin';
html += '                <option value="USA: WY">USA: Wyoming';
html += '                <option value="---------------------------">';
html += '                <option value="CANADA: Alberta AB">CANADA: Alberta AB';
html += '                <option value="CANADA: British Columbia BC">CANADA: British Columbia BC';
html += '                <option value="CANADA: Manitoba MB">CANADA: Manitoba MB';
html += '                <option value="CANADA: New Brunswick NB">CANADA: New Brunswick NB';
html += '                <option value="CANADA: Newfoundland NF">CANADA: Newfoundland NF';
html += '                <option value="CANADA: Northwest Territories NT">CANADA: Northwest Territories NT';
html += '                <option value="CANADA: Nova Scotia NS">CANADA: Nova Scotia NS';
html += '                <option value="CANADA: Nunavut Territory NT">CANADA: Nunavut Territory NT';
html += '                <option value="CANADA: Ontario ON">CANADA: Ontario ON';
html += '                <option value="CANADA: Prince Edward Is. PE">CANADA: Prince Edward Is. PE';
html += '                <option value="CANADA: Quebec QC">CANADA: Quebec QC';
html += '                <option value="CANADA: Saskatchewan SK">CANADA: Saskatchewan SK';
html += '                <option value="CANADA: Yukon Territory YT">CANADA: Yukon Territory YT';
html += '                <option value="---------------------------">';
html += '                <option value="OTHER - Not Listed">OTHER - Not Listed';
html += '              </select>';
html += '            </td>';
html += '          </tr>';
html += '';
html += '';
html += '';
html += '          <tr>';
html += '            <td class="right">Region or Province:</td>';
html += '            <td class="bodytext"><input type="text" name="Region or Province"';
html += '                                        tabindex="14" size="34" maxlength="50"></td>';
html += '          </tr>';
html += '';
html += '          <tr>';
html += '            <td class="right">Zip/Postal Code:</td>';
html += '            <td class="bodytext"><input type="text" name="Zip Code/Postal Code"';
html += '                                        tabindex="15" size="34" maxlength="50"></td>';
html += '          </tr>';
html += '';
html += '          <tr>';
html += '            <td class="right">Country:</td>';
html += '            <td class="bodytext">';
html += '              <select id="Country" name="Country" tabindex="16" size="1">';
html += '';
html += '                <option value="Afghanistan">Afghanistan';
html += '                <option value="Albania">Albania';
html += '                <option value="Algeria">Algeria';
html += '                <option value="Samoa">American Samoa';
html += '                <option value="Andorra">Andorra';
html += '                <option value="Angola">Angola';
html += '                <option value="Anguilla">Anguilla';
html += '                <option value="Antigua and Barbuda">Antigua and Barbuda';
html += '                <option value="Argentina">Argentina';
html += '                <option value="Armenia">Armenia';
html += '                <option value="Aruba">Aruba';
html += '                <option value="Australia">Australia';
html += '                <option value="Austria">Austria';
html += '                <option value="Azerbaijan">Azerbaijan';
html += '                <option value="Bahamas">Bahamas';
html += '                <option value="Bahrain">Bahrain';
html += '                <option value="Bangladesh">Bangladesh';
html += '                <option value="Barbados">Barbados';
html += '                <option value="Belarus">Belarus';
html += '                <option value="Belgium">Belgium';
html += '                <option value="Belize">Belize';
html += '                <option value="Benin">Benin';
html += '                <option value="Bermuda">Bermuda';
html += '                <option value="Bhutan">Bhutan';
html += '                <option value="Bolivia">Bolivia';
html += '                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina';
html += '                <option value="Botswana">Botswana';
html += '                <option value="Brazil">Brazil';
html += '                <option value="British Virgin Islands">British Virgin Islands';
html += '                <option value="Brunei Darussalam">Brunei Darussalam';
html += '                <option value="Bulgaria">Bulgaria';
html += '                <option value="Burkina Faso">Burkina Faso';
html += '                <option value="Burundi">Burundi';
html += '                <option value="Cambodia">Cambodia';
html += '                <option value="Cameroon">Cameroon';
html += '                <option value="Canada">Canada';
html += '                <option value="Cape Verde">Cape Verde';
html += '                <option value="Cayman Islands">Cayman Islands';
html += '                <option value="Central African Republic">Central African Republic';
html += '                <option value="Chad">Chad';
html += '                <option value="Chile">Chile';
html += '                <option value="China">China';
html += '                <option value="Colombia">Colombia';
html += '                <option value="Comoros">Comoros';
html += '                <option value="Congo">Congo, Republic of';
html += '                <option value="Zaire">Congo, Democratic Republic of';
html += '                <option value="Cook Islands">Cook Islands';
html += '                <option value="Costa Rica">Costa Rica';
html += '                <option value="Ivory Coast">Cote DIvoire';
html += '                <option value="Croatia">Croatia';
html += '                <option value="Cuba">Cuba';
html += '                <option value="Cyprus">Cyprus';
html += '                <option value="Czech Republic">Czech Republic';
html += '                <option value="Denmark">Denmark';
html += '                <option value="Djibouti">Djibouti';
html += '                <option value="Dominica">Dominica';
html += '                <option value="Dominican Republic">Dominican Republic';
html += '                <option value="Ecuador">Ecuador';
html += '                <option value="Egypt">Egypt';
html += '                <option value="El Salvador">El Salvador';
html += '                <option value="Equatorial Guinea">Equatorial Guinea';
html += '                <option value="Eritrea">Eritrea';
html += '                <option value="Estonia">Estonia';
html += '                <option value="Ethiopia">Ethiopia';
html += '                <option value="Falkland Islands">Falkland Islands';
html += '                <option value="Faroe Islands">Faroe Islands';
html += '                <option value="Fiji">Fiji';
html += '                <option value="Finland">Finland';
html += '                <option value="France">France';
html += '                <option value="French Guiana">French Guiana';
html += '                <option value="French Polynesia">French Polynesia';
html += '                <option value="Gabon">Gabon';
html += '                <option value="Gambia">Gambia';
html += '                <option value="Georgia">Georgia';
html += '                <option value="Germany">Germany';
html += '                <option value="Ghana">Ghana';
html += '                <option value="Gibraltar">Gibraltar';
html += '                <option value="Greece">Greece';
html += '                <option value="Greenland">Greenland';
html += '                <option value="Grenada">Grenada';
html += '                <option value="Guadeloupe">Guadeloupe';
html += '                <option value="Guatemala">Guatemala';
html += '                <option value="Guinea">Guinea';
html += '                <option value="Guinea Bissau">Guinea Bissau';
html += '                <option value="Guyana">Guyana';
html += '                <option value="Haiti">Haiti';
html += '                <option value="Honduras">Honduras';
html += '                <option value="Hong Kong">Hong Kong';
html += '                <option value="Hungary">Hungary';
html += '                <option value="Iceland">Iceland';
html += '                <option value="India">India';
html += '                <option value="Indonesia">Indonesia';
html += '                <option value="Iran">Iran';
html += '                <option value="Iraq">Iraq';
html += '                <option value="Ireland">Ireland';
html += '                <option value="Israel">Israel';
html += '                <option value="Italy">Italy';
html += '                <option value="Jamaica">Jamaica';
html += '                <option value="Japan">Japan';
html += '                <option value="Jordan">Jordan';
html += '                <option value="Kazakhstan">Kazakhstan';
html += '                <option value="Kenya">Kenya';
html += '                <option value="Kiribati">Kiribati';
html += '                <option value="Kuwait">Kuwait';
html += '                <option value="Kyrgyzstan">Kyrgyzstan';
html += '                <option value="Laos">Laos';
html += '                <option value="Latvia">Latvia';
html += '                <option value="Lebanon">Lebanon';
html += '                <option value="Lesotho">Lesotho';
html += '                <option value="Liberia">Liberia';
html += '                <option value="Libya">Libya';
html += '                <option value="Liechtenstein">Liechtenstein';
html += '                <option value="Lithuania">Lithuania';
html += '                <option value="Luxembourg">Luxembourg';
html += '                <option value="Macau">Macau';
html += '                <option value="Macedonia">Macedonia';
html += '                <option value="Madagascar">Madagascar';
html += '                <option value="Malawi">Malawi';
html += '                <option value="Malaysia">Malaysia';
html += '                <option value="Maldives">Maldives';
html += '                <option value="Mali">Mali';
html += '                <option value="Malta">Malta';
html += '                <option value="Martinique">Martinique';
html += '                <option value="Marshall Islands">Marshall Islands';
html += '                <option value="Mauritania">Mauritania';
html += '                <option value="Mauritius">Mauritius';
html += '                <option value="Mexico">Mexico';
html += '                <option value="Micronesia">Micronesia';
html += '                <option value="Moldova">Moldova';
html += '                <option value="Monaco">Monaco';
html += '                <option value="Mongolia">Mongolia';
html += '                <option value="Montserrat">Montserrat';
html += '                <option value="Morocco">Morocco';
html += '                <option value="Mozambique">Mozambique';
html += '                <option value="Myanmar">Myanmar';
html += '                <option value="Namibia">Namibia';
html += '                <option value="Nepal">Nepal';
html += '                <option value="Netherlands">Netherlands';
html += '                <option value="Netherlands Antilles">Netherlands Antilles';
html += '                <option value="New Caledonia">New Caledonia';
html += '                <option value="New Zealand">New Zealand';
html += '                <option value="Nicaragua">Nicaragua';
html += '                <option value="Niger">Niger';
html += '                <option value="Nigeria">Nigeria';
html += '                <option value="Norfolk Island">Norfolk Island';
html += '                <option value="North Korea">North Korea';
html += '                <option value="Northern Mariana Islands">Northern Mariana Islands';
html += '                <option value="Norway">Norway';
html += '                <option value="Oman">Oman';
html += '                <option value="Pakistan">Pakistan';
html += '                <option value="Palau">Palau';
html += '                <option value="Panama">Panama';
html += '                <option value="Papua New Guinea">Papua New Guinea';
html += '                <option value="Paraguay">Paraguay';
html += '                <option value="Peru">Peru';
html += '                <option value="Philippines">Philippines';
html += '                <option value="Poland">Poland';
html += '                <option value="Portugal">Portugal';
html += '                <option value="Puerto Rico">Puerto Rico';
html += '                <option value="Qatar">Qatar';
html += '                <option value="Reunion">Reunion';
html += '                <option value="Romania">Romania';
html += '                <option value="Russia">Russia';
html += '                <option value="Rwanda">Rwanda';
html += '                <option value="Saint Helena">Saint Helena';
html += '                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis';
html += '                <option value="Saint Lucia">Saint Lucia';
html += '                <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon';
html += '                <option value="Saint Vincent/Grenadines">Saint Vincent/Grenadines';
html += '                <option value="Samoa">Samoa';
html += '                <option value="San Marino">San Marino';
html += '                <option value="Saotome and Principe">Saotome and Principe';
html += '                <option value="Saudi Arabia">Saudi Arabia';
html += '                <option value="Senegal">Senegal';
html += '                <option value="Seychelles">Seychelles';
html += '                <option value="Sierra Leone">Sierra Leone';
html += '                <option value="Singapore">Singapore';
html += '                <option value="Slovak Republic">Slovak Republic';
html += '                <option value="Slovenia">Slovenia';
html += '                <option value="Solomon Islands">Solomon Islands';
html += '                <option value="Somalia">Somalia';
html += '                <option value="South Africa">South Africa';
html += '                <option value="South Korea">South Korea';
html += '                <option value="Spain">Spain';
html += '                <option value="Sri Lanka">Sri Lanka';
html += '                <option value="Sudan">Sudan';
html += '                <option value="Suriname">Suriname';
html += '                <option value="Swaziland">Swaziland';
html += '                <option value="Sweden">Sweden';
html += '                <option value="Switzerland">Switzerland';
html += '                <option value="Syria">Syria';
html += '                <option value="Taiwan">Taiwan';
html += '                <option value="Tajikistan">Tajikistan';
html += '                <option value="Tanzania">Tanzania';
html += '                <option value="Thailand">Thailand';
html += '                <option value="Togo">Togo';
html += '                <option value="Tokelau">Tokelau';
html += '                <option value="Tonga">Tonga';
html += '                <option value="Trinidad and Tobago">Trinidad and Tobago';
html += '                <option value="Tunisia">Tunisia';
html += '                <option value="Turkey">Turkey';
html += '                <option value="Turkmenistan">Turkmenistan';
html += '                <option value="Turks and Caicos Islands">Turks and Caicos Islands';
html += '                <option value="Uganda">Uganda';
html += '                <option value="Ukraine">Ukraine';
html += '                <option value="United Arab Emirates">United Arab Emirates';
html += '                <option value="Great Britain">United Kingdom';
html += '                <option selected value="United States">United States';
html += '                <option value="United States Virgin Islands">U.S. Virgin Islands';
html += '                <option value="Uruguay">Uruguay';
html += '                <option value="Uzbekistan">Uzbekistan';
html += '                <option value="Vanuatu">Vanuatu';
html += '                <option value="Vatican City">Vatican City';
html += '                <option value="Venezuela">Venezuela';
html += '                <option value="Vietnam">Vietnam';
html += '                <option value="Western Sahara">Western Sahara';
html += '                <option value="Samoa">Western Samoa';
html += '                <option value="Yemen">Yemen';
html += '                <option value="Yugoslavia">Yugoslavia';
html += '                <option value="Zambia">Zambia';
html += '                <option value="Zimbabwe">Zimbabwe';
html += '              </select>';
html += '            </td>';
html += '          </tr>';
html += '';
html += '          <tr>';
html += '            <td class="right">Web Address:</td>';
html += '            <td class="bodytext"><input type="text" value="http://" name="Web Site Address"';
html += '                                        tabindex="17" size="34" maxlength="100"> optional</td>';
html += '          </tr>';
html += '';
html += '';
html += '          <tr>';
html += '            <td class="right">Referred by:</td>';
html += '            <td class="bodytext"><input type="text" value="" name="Referred by"';
html += '                                        tabindex="18" size="34" maxlength="100"></td>';
html += '          </tr>';
html += '';
html += '          <tr>';
html += '            <td class="right">Coupon Code:</td>';
html += '            <td class="bodytext"><input type="text" value="" name="Coupon Code"';
html += '                                        tabindex="19" size="34" maxlength="100"></td>';
html += '          </tr>';
html += '';
html += '          <tr><td>&nbsp;</td><td></td></tr>              ';
html += '';
html += '          <tr>';
html += '            <td colspan="2"><b>Deposit:</b> The Deposit of $995 (US programs) or &euro;975 (European programs) is payable at time of registration.<br />';
html += '              <b>Please select one of the following payment options for the remaining balance:</b><br /><br />';
html += '              <p  style="text-indent:-17px; padding-left:17px;">';
html += '                <input type="radio" name="Payment Option" value="in full" checked>	In Full: $12,900 (US programs) or &euro;11,500 (European programs) due 3 weeks prior to the program start date</p>';
html += '              <p  style="text-indent:-17px; padding-left:17px;">';
html += '                <input type="radio" name="Payment Option" value="quarterly">	Quarterly: $2,230 (US programs) or &euro;1,900 (European programs) due prior to the first retreat ';
html += '                and in 3 additional installments of $3,225 or &euro;2,875 3 weeks prior to each retreat start date</p>';
html += '              <p  style="text-indent:-17px; padding-left:17px;">';
html += '                <input type="radio" name="Payment Option" value="monthly">	Monthly: approximately $992 (US programs) or approximately &euro;877 (European programs) per month for 12 months, beginning 2 months prior to Retreat 1 (25% of the total program fees must be paid 3 weeks prior to each retreat start date)</p>';
html += '            </td>';
html += '          </tr>';
html += '';
html += '          <tr>';
html += '            <td colspan="2">My agreement below authorizes CTI to automatically charge my credit card. I understand that balances due will be automatically charged according to the payment option selected above.<br />';
html += '              <input type="radio" name="Does applicant agree to credit card charges?" value="Yes"> <b>I Agree</b><br />';
html += '              <input type="radio" name="Does applicant agree to credit card charges?" value="No" checked> <b>I do not agree</b>';
html += '            </td>';
html += '          </tr>';
html += '        </table>         ';
html += '';
html += '';
html += '';
html += '<p>&nbsp;</p>';
html += '';
html += '<input id="op31" name="op31" type="checkbox" value="Agreed to policies"> Yes, I have read and agree to <a class="pricingdetails" href="/_temp/policy_leadership_FOR_VALIDATION.html" rel="lyteframe" rev="width: 800px; height: 500px; scrolling: auto;" title="CTI Policies">CTI Policies</a></p>';
html += '        ';
html += '';
html += '';
html += '';
html += '';
html += '';
html += '';
html += '';

html += '<?php echo $html ?>';


html += '';
html += '';
html += '        ';
html += '    </form>';
html += '';
html += '  </div><!-- id="online" -->';
html += '</div>';
html += '';
html += '<!-- end of forms -->';

document.write(html);
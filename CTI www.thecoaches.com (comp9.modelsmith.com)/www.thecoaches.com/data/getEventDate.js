<?php

    $json_msg = file_get_contents("http://crm.thecoaches.com/fmi-test/webcomp2_newFM/getEventDate.php?event_type=CoActSales");
	//$day_of_event_date = date('l', strtotime($json_msg));
	//$event_date = $day_of_event_date.', '.date("F d, Y", strtotime($json_msg));
	//$enroll_start_date = date("m/d/Y", strtotime($json_msg."-3 month"));
	//$day_of_enroll_start_date = date('l', strtotime($enroll_start_date));
	//$enroll_date = $day_of_enroll_start_date.', '.date("F d, Y", strtotime($enroll_start_date));
	//$json_fmt_msg = '{"event_date":"'.$event_date.'","enroll_date":"'.$enroll_date.'"}';

?>
var json_obj = <?php echo $json_msg; ?>;
//alert("json_obj.event_date = " + json_obj.event_date + "\n json_obj.enroll_date = " + json_obj.enroll_date);

//alert("json_obj.event_date = " + json_obj.event_date + "\n json_obj.enroll_date = " + json_obj.enroll_date);

window.onload = function() {
	document.getElementById('event_date').innerHTML="For 16 weeks starting "+ json_obj.event_date + " from 9:30-11:30 am PST";
	document.getElementById('enroll_date').innerHTML="Discover the essential ingredient every entrepreneur needs to succeed in today&#39;s market. Learn about this and more with David and Marla Skibbins in a free teleseminar, &nbsp;<strong>Enroll New Clients Without Fear</strong>. " + json_obj.enroll_date + ", 12:30 pm PT / 3:30 pm ET. <a href=" + "http://myaccount.maestroconference.com/conference/register/9KRRBZ7U9975ZBQ" + ">Please RSVP.</a>";
	
}

#!/usr/bin/perl


$date_command = "/bin/date";

push (@INC, "/cgi-bin");
require("cgi-lib.pl");

&ReadParse(*input);

#setting information

$first_name = $input{'First Name'};
$last_name = $input{'Last Name'};
$address = $input{'Address'};
$city = $input{'City'};
$state = $input{'State'};
$zip = $input{'Zip'};
$country = $input{'Country'};
$email = $input{'Email'};
$phone = $input{'Phone'};
$fax = $input{'Fax'};
$question = $input{'Question'};



# Get the Date for Entry
$ENV{PATH}='/bin';
$date = `$date_command +"%A, %B %d, %Y at %T (%Z)"`; chop($date);
$shortdate = `$date_command +"%D %T %Z"`; chop($shortdate);



print "Content-type: text/html\n\n\n";
print "<html>";
print "<head>";
print "<title>CTI Online Form </title>";
print "</Head>";
print "<body BGCOLOR = #FFFFFF>";
print "<P><TABLE BORDER=0 WIDTH=350> <TR> <TD Width=350>";
print "<h1 align=center> CTI Request Form </h1>";
print "This is the information you entered: <BR><BR>";
print "<B>Date:</B> $date<BR>";
print "<B>First Name:</B> $first_name<BR>";
print "<B>Last Name:</B> $last_name<BR>";
print "<B>Address:</B> $address<BR>";
print "<B>City:</B> $city<BR>";
print "<B>State:</B> $state<BR>";
print "<B>Zip:</B> $zip<BR>";
print "<B>Country:</B> $country<BR>";
print "<B>Email:</B> $email<BR>";
print "<B>Phone:</B> $phone<BR>";
print "<B>Fax:</B> $fax<BR>";
print "<B>Question:</B> $question</B> <BR><BR>";
print "Your information has been sent.<BR>";
print "Thank you for your request.<BR><BR>";

print "</TD></TR></Table>";
print "</html>";






open (Mail,"| Mail Info\@thecoaches.com") ||

die "\nError: Can't start mail program - Please report this error to thecoaches\@aol.com";




print Mail "Request Information Form:\n";
print Mail "The Coaches Institute\n\n";
print Mail "Date:$date\n\n";
print Mail "First Name:$first_name\n";


print Mail "Last Name:$last_name\n";


print Mail "Address:$address\n";
print Mail "City:$city\n";
print Mail "State:$state\n";
print Mail "Zip:$zip\n";
print Mail "Country:$country\n";
print Mail "Email:$email\n";
print Mail "Phone:$phone\n";

print Mail "Fax:$fax\n";
print Mail "Question:$question\n";

close ( MAIL );

exit;

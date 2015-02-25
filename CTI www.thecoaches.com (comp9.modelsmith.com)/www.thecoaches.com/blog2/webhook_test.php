<?php

$dummy = <<<EOT

"type": "unsubscribe", 
  "fired_at": "2009-03-26 21:40:57", 
  "data[id]": "8a25ff1d98", 
  "data[list_id]": "997df0f020",
  "data[email]": "api+unsub@mailchimp.com", 
  "data[email_type]": "html", 
  "data[merges][EMAIL]": "api+unsub@mailchimp.com", 
  "data[merges][FNAME]": "MailChimp", 
  "data[merges][LNAME]": "API", 
  "data[merges][INTERESTS]": "Group1,Group2", 
  "data[ip_opt]": "10.20.10.30"
  "data[campaign_id]": "cb398d21d2"
EOT;

?>
<html>
<body>
<form action="webhook.php?key=84b5a38" method="POST">

<input type="hidden" name="type" value="unsubscribe" />
<input type="hidden" name="test" value="1" />
<input type="hidden" name="fired_at" value="2009-03-26 21:40:57" />
<input type="hidden" name="data[id]" value="8a25ff1d98" />
<input type="hidden" name="data[list_id]" value="997df0f020" />
<input type="hidden" name="data[email_type]" value="html" />
<input type="hidden" name="data[ip_opt]" value="10.20.10.30" />
<input type="hidden" name="data[campaign_id]" value="cb398d21d2" />


    Email: <input type="text" name="data[email]" value="" /><br />
    Email Again: <input type="text" name="data[merges][EMAIL]" value="" /><br />
    First Name: <input type="text" name="data[merges][FNAME]" value="" /><br />
    Last Name: <input type="text" name="data[merges][LNAME]" value="" /><br />
    Interests: <input type="text" name="data[merges][INTERESTS]" value="" /><br />

<input type="submit" name="submit1" value="Submit Test" ?>

</form>
</body>
</html>


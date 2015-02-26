<?php

$mailAuth = false;


function login_function($obj) {

    if ($obj->table=="login") { //username + password (wth MD5 Hash of password)
        $obj->logToFile("Login Attempt: " . $_POST["username"] . " / " . $_POST["password"]);
        $obj->display = 'row';
        $resource = $obj->db->getRow("users", "LOWER(username)=LOWER('$_POST[username]') AND password='$_POST[password]'");
        if ($resource) {
            if ($obj->db->numRows($resource) == 1 ) {
                //login success
                $row = $obj->db->row($resource);
                //check for default password
                if (substr($_POST["password"],0,strlen($obj->defaultPasswordHex))==$obj->defaultPasswordHex) {
                    $obj->logToFile("Login Successful.  Default Password Used.");
                    $obj->respondWithSuccessObject('true', 6, $row["username"],99, $obj->userTimeZone, $obj->userDaylightSavings);
                } else {
                    $sessionId = $obj->initiateSession($row["id"]);
                    $obj->userId = $row["id"];
                    $obj->userType = $row["userType"];
                    $obj->userTimeZone = $row["timezone"];
                    $obj->userDaylightSavings = -1;
                    if ($row["daylight_savings"]==1) $obj->userDaylightSavings = 1;
                    $obj->logToFile("Login Successful.  DS: " . $obj->userDaylightSavings);
                    $obj->respondWithSuccessObject('true', $row["userType"],$row["first_name"],$sessionId, $obj->userTimeZone, $obj->userDaylightSavings);
                }
            } else if ($obj->db->numRows($resource) ==0) {
                if (substr($_POST["password"],0,strlen($obj->defaultPasswordHex))==$obj->defaultPasswordHex) $obj->respondWithSuccessObject('false',2,"Invalid password.  Remember to use the password you created.");
                else $obj->respondWithSuccessObject('false', 2, " Incorrect username or password.  Please try again.");
            } else $obj->respondWithSuccessObject('false', 1, "System error. ");
        } else $obj->respondWithSuccessObject('false', 2, "Incorrect username or password.  Please try again.");

    } else if ($obj->table=="logout") {
        $obj->display = 'row';
        $obj->terminateSession();
        $obj->respondWithSuccessObject('true', 0,"Logout successful",'-');
    } else if ($obj->table=="forgot") { //username
        //lookup username / email and send them a link to reset
        $resource = $obj->db->executeStmt("SELECT * FROM users WHERE username='$_POST[username]'");
        if ($resource) {
            if ($obj->db->numRows($resource) == 1 ) {
                $row = $obj->db->row($resource);
                $msg = "";
                $newpass = $obj->defaultPasswordHex;
                $obj->db->executeStmt("UPDATE users SET password='" . $newpass . "' WHERE id=" . $row["id"]);

                if (!send_mail($obj, $row["id"], "forgot", $obj->defaultPassword, $msg)) {
                    $obj->respondWithSuccessObject('false', 0, $msg);
                } else {
                    $msg = "An email has been sent with instructions to reset your password.";
                    $obj->respondWithSuccessObject('true', 0, $msg);
                }

            }
        }
        $obj->respondWithSuccessObject('false', -1, "Could not find user with that email.");
    } else if ($obj->table=="update") { //username + new_password (with MD5 hash of password) + registration_code or password (with existing MD5 hash of password)
        //verify link, update password
        $sql = "SELECT * FROM users WHERE username='$_POST[username]' AND password='$_POST[password]'";

        $resource = $obj->db->executeStmt($sql);
        //echo $sql;
        if ($resource) {

            if ($obj->db->numRows($resource) == 1 ) {

                $row = $obj->db->row($resource);
                //login success
                $sql = "UPDATE users SET password='$_POST[new_password]' WHERE id=$row[id]";

                $obj->db->executeStmt($sql);
                $err = "";
                //if ($row["password"]=='') send_mail($obj, $row["id"], "registration", false, $err);
                //else


                $sessionId = $obj->initiateSession($row["id"]);
                $obj->userId = $row["id"];
                $obj->userType = $row["userType"];
                $obj->userTimeZone = $row["timezone"];
                $obj->userDaylightSavings = -1;
                if ($row["daylight_savings"]==1) $obj->userDaylightSavings = 1;
                $obj->logToFile("Update Password Successful.  DS: " . $obj->userDaylightSavings);

                send_mail($obj, $row["id"], "update", false, $err);

                $obj->respondWithSuccessObject('true', $row["userType"],$row["first_name"],$sessionId, $obj->userTimeZone, $obj->userDaylightSavings);
            }
        }
        $obj->respondWithSuccessObject('false', 0, "Invalid current password / email.");

    }
}


function send_mail($obj, $userId, $mailType, $newpass, &$err) {

    $sql = "SELECT * FROM users WHERE id=$userId";
    $res = $obj->db->executeStmt($sql);
    $resource = $obj->db->row($res, $obj->userTimeZone, $obj->userDaylightSavings);


    $from = $obj->config['mail']['from'];
    $to = "<".$resource["username"].">";
    $subject = $obj->config['mail'][$mailType."Subject"];

    $body = file_get_contents($obj->config['mail'][$mailType.'URL']);

    $fields = $obj->db->getColumns("users");

/*    if ($includeRegCode) {
        $registration_code = $obj->getGuid();
        $sql = "UPDATE users SET registration_code='$registration_code' WHERE users.id=$userId";
        $obj->db->executeStmt($sql);
        $body = str_replace('[registration_code]', $registration_code, $body);
    }
*/
    while($field = $obj->db->row($fields, $obj->userTimeZone, $obj->userDaylightSavings)) {
        $f = $field["Field"];
        $body = str_replace("[$f]", $resource[$f], $body);
    }

    if (strlen($newpass)>3) $body = str_replace("[newpassword]", $newpass, $body);

    $url = (!empty($_SERVER['HTTPS']))
        ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']
        : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

    $url = explode("/api", $url);
    $body = str_replace("[portalurl]", $url[0], $body);

    require_once "Mail.php";

    $host = $obj->config['mail']['host'];
    $port = $obj->config['mail']['port'];
    $username = $obj->config['mail']['username'];
    $password = $obj->config['mail']['password'];
    $use_auth = $obj->config['mail']['auth'];
    $headers = array (
        'From' => $from,
        'To' => $to,
        'Reply-To' => $to,
        'Subject' => $subject,
        'MIME-Version' => "1.0",
        'Content-type' => "text/html; charset=iso-8859-1"
    );

    $smtp = Mail::factory('smtp',
        array ('host' => $host,
            'port' => $port,
            'auth' => $use_auth,
            'username' => $username,
            'password' => $password
        )
    );
    $mail = $smtp->send($to, $headers, $body);

    if (PEAR::isError($mail)) {
        $err = $mail->getMessage();
        $obj->logToFile("Error sending email ($mailType) to: $to. Error: $err");

        return false;
    } else {
        $obj->logToFile("Email ($mailType) successfully sent to: $to");
        return true;
    }
}


function send_coach_client_notification_mail($obj, $clientUserId, &$err) {
    require_once "Mail.php";
    $host = $obj->config['mail']['host'];
    $port = $obj->config['mail']['port'];
    $username = $obj->config['mail']['username'];
    $password = $obj->config['mail']['password'];
    $use_auth = $obj->config['mail']['auth'];

    $sql = "SELECT co.first_name as coach_first_name, co.last_name as coach_last_name, co.email as coach_email,cl.first_name as client_first_name, cl.last_name as client_last_name, cl.email as client_email, o.organization_name as organization_name FROM coachs_users co INNER JOIN clients_users cl INNER JOIN organizations o ON cl.organization_id=o.id WHERE cl.coach_id=co.id AND cl.user_id=$clientUserId";

    $res = $obj->db->executeStmt($sql);
    $resource = $obj->db->row($res, $obj->userTimeZone, $obj->userDaylightSavings);

    $from = $obj->config['mail']['from'];

    $fields = Array("coach_first_name", "coach_last_name", "coach_email", "client_first_name", "client_last_name", "client_email", "organization_name");

    //send note to coach
    $subject = $obj->config['mail']["notifyCoachOfClientSubject"];
    $to = "<".$resource["coach_email"].">";
    $body = file_get_contents($obj->config['mail']['notifyCoachOfClientURL']);
    foreach($fields as $f) if (isset($resource[$f])) $body = str_replace("[$f]", $resource[$f], $body);

    $headers = array (
        'From' => $from,
        'To' => $to,
        'Reply-To' => $to,
        'Subject' => $subject,
        'MIME-Version' => "1.0",
        'Content-type' => "text/html; charset=iso-8859-1"
    );

    $smtp = Mail::factory('smtp',
        array ('host' => $host,
            'port' => $port,
            'auth' => $use_auth,
            'username' => $username,
            'password' => $password
        )
    );
    $mail = $smtp->send($to, $headers, $body);

    if (PEAR::isError($mail)) {
        $err = $mail->getMessage();
        $obj->logToFile("Error sending coach notify of new client email  to: $to. Error: $err");

        return false;
    } else {
        $obj->logToFile("Email coach notify of new client successfully sent to: $to");
    }

    //send note to client
    $subject = $obj->config['mail']["notifyClientOfCoachSubject"];
    $to = "<".$resource["client_email"].">";
    $body = file_get_contents($obj->config['mail']['notifyClientOfCoachURL']);
    foreach($fields as $f) if (isset($resource[$f])) $body = str_replace("[$f]", $resource[$f], $body);

    $headers = array (
        'From' => $from,
        'To' => $to,
        'Reply-To' => $to,
        'Subject' => $subject,
        'MIME-Version' => "1.0",
        'Content-type' => "text/html; charset=iso-8859-1"
    );

    $smtp = Mail::factory('smtp',
        array ('host' => $host,
            'port' => $port,
            'auth' => $use_auth,
            'username' => $username,
            'password' => $password
        )
    );
    $mail = $smtp->send($to, $headers, $body);

    if (PEAR::isError($mail)) {
        $err = $mail->getMessage();
        $obj->logToFile("Error sending email client notification of new coach to: $to. Error: $err");

        return false;
    } else {
        $obj->logToFile("Email client notification of new coach successfully sent to: $to");

    }
    return true;
}


function send_coach_organization_notification_mail($obj, $coachId, $orgId, &$err) {
    require_once "Mail.php";
    $host = $obj->config['mail']['host'];
    $port = $obj->config['mail']['port'];
    $username = $obj->config['mail']['username'];
    $password = $obj->config['mail']['password'];
    $use_auth = $obj->config['mail']['auth'];

    $sql = "SELECT first_name, last_name, email, organization_name FROM cti_corporate_engagement.organization_coachs c LEFT JOIN organizations o ON c.organization_id=o.id WHERE coach_id=$coachId AND organization_id=$orgId";

    $res = $obj->db->executeStmt($sql);
    $resource = $obj->db->row($res, $obj->userTimeZone, $obj->userDaylightSavings);

    $from = $obj->config['mail']['from'];

    $fields = Array("first_name", "last_name", "email", "organization_name");

    //send note to coach
    $subject = $obj->config['mail']["notifyCoachOfOrganizationSubject"];
    $to = "<".$resource["email"].">";
    $body = file_get_contents($obj->config['mail']['notifyCoachOfOrganizationURL']);
    foreach($fields as $f) if (isset($resource[$f])) $body = str_replace("[$f]", $resource[$f], $body);
    $headers = array (
        'From' => $from,
        'To' => $to,
        'Reply-To' => $to,
        'Subject' => $subject,
        'MIME-Version' => "1.0",
        'Content-type' => "text/html; charset=iso-8859-1"
    );

    $smtp = Mail::factory('smtp',
        array ('host' => $host,
            'port' => $port,
            'auth' => $use_auth,
            'username' => $username,
            'password' => $password
        )
    );
    $mail = $smtp->send($to, $headers, $body);

    if (PEAR::isError($mail)) {
        $err = $mail->getMessage();
        $obj->logToFile("Error sending coach notify of new organization email  to: $to. Error: $err");

        return false;
    } else {
        $obj->logToFile("Email coach notify of new organization successfully sent to: $to");
    }

    return true;
}
?>
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

// get results
$result = mysql_query("SELECT idx,html,location FROM calendar_cache WHERE id=9");

// get row
$row = mysql_fetch_array($result);

$scripts = '';

if(array_key_exists('mode',$_GET) && $_GET['mode'] == 'index'){
    $html = $row['idx'];
    $html = preg_replace('/h2>/','h3>',$html);
}
else if(array_key_exists('mode',$_GET) && $_GET['mode'] == 'cities'){
    $html = '';
    $city_array = explode("\n", $row['idx'] );
    $sorted_city_array = array( );
    foreach($city_array as $city){
        if(preg_match('/#([^"]*)".*?>([^<]+)</',$city,$matches)){
            $sorted_city_array[$matches[2]] = $matches[1];
        }
    }
    ksort($sorted_city_array);
    foreach($sorted_city_array as $city => $code){
        $city = preg_replace('/-.*/','',$city); // remove anything after a dash
        $html .= '<option value="#'.$code.'">'.$city."</option>\n";
    }    
}
else if(array_key_exists('mode',$_GET) && $_GET['mode'] == 'location'){
    $html = $row['location'];
}
else {
    //$html = $row['html'];
    $html = file_get_contents("/www/www.thecoaches.com/calendar_cache/9-cache.html");
    $html = preg_replace('/h2>/','h3>',$html);
    $html_minus_scripts = '';
    $script_flag = 0;
    // split out the HTML and javascript portions
    foreach(preg_split("/((\r?\n)|(\r\n?))/", $html) as $line){
        if($script_flag == 0 && !preg_match('/<script/',$line)){
            $html_minus_scripts .= $line."\n";
        }
        if(preg_match('/<\/script/',$line)){
            $script_flag = 0;
        }
        if($script_flag == 1 && !preg_match('/^\/\//',$line) && preg_match('/[\w\}]/',$line)){
            $scripts .= $line."\n";
        }
        if(preg_match('/<script/',$line)){
            $script_flag = 1;
        }
    } 
    $html = $html_minus_scripts;
}


$html = preg_replace('/\n/'," \\\n",$html); // change <cr> to \<cr>
$html = preg_replace('/\'/'," \\'",$html);  // change \' to \\'   

?>
<!-- generated: <?php echo date('Y-m-d H:i:s') ?> -->
document.write('<?php echo $html ?>');
<?php echo $scripts; ?>

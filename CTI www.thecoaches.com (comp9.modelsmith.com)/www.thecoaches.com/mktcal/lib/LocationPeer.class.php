<?php

class LocationPeer 
{

  public static function getLocationName( $location ){
    $location_name = '';

    $server   = sfConfig::get('app_ctidatabase_server');  // see apps/frontend/config/app.yml
    $port     = sfConfig::get('app_ctidatabase_port');
    $user     = sfConfig::get('app_ctidatabase_user');
    $password = sfConfig::get('app_ctidatabase_password');
    $rdbh = mysql_connect( $server.':'.$port, $user, $password ); // make sure this server has DB grant

    if($rdbh){
      $query = sprintf( "SELECT site_name,address,city,state,zip FROM site_data WHERE site_code='%s' LIMIT 1", mysql_real_escape_string($location) );
      $result = mysql_query( $query, $rdbh );

      if($result){
        $row = mysql_fetch_row($result);
      $location_name = implode(', ',$row);
    }
    else {
      $location_name = "Unassigned ($location)";
    }
  }
  else {
    $location_name = "connection failure";
  }
  mysql_close($rdbh);

  return $location_name;
}


}



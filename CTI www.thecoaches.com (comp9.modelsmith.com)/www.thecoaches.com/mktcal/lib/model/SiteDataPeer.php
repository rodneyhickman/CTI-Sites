<?php

class SiteDataPeer extends BaseSiteDataPeer
{

  public static function updateSites( $params )
  {
    commonTools::logMessage( "updateSites starting" );
    $count = 0;
    $json = @$params['json'];
    if($json != ''){
      $incoming_sites = json_decode($json, true); // decode as assoc array
      $incoming_count = 0 + count($incoming_sites);
      foreach($incoming_sites as $incoming_site){
        //commonTools::logMessage($incoming_site['site_code']);
        $site_code = iconv('UTF-8', 'ASCII//TRANSLIT', $incoming_site['site_code']);
        // find site by fmid
        if(isset($site_code)){
          $c = new Criteria();
          $c->add(SiteDataPeer::SITE_CODE, $site_code);
          $site_data = SiteDataPeer::doSelectOne( $c );
          
          // if found, update
          if(!isset($site_data)){
            $site_data = new SiteData();
            $site_data->setSiteCode( $site_code );
          }

          $site_data->setSiteName( @$incoming_site['site_name'] );
          $site_data->setAddress( @$incoming_site['address'] );
          $site_data->setCity( @$incoming_site['city'] );
          $site_data->setState( @$incoming_site['state'] );
          $site_data->setZip( @$incoming_site['zip'] );
          $site_data->setRegion( @$incoming_site['region'] );
          $site_data->setHotelPhone( @$incoming_site['hotel_phone'] );
          $site_data->setSiteUrl( @$incoming_site['site_url'] );
          $site_data->setCountry( @$incoming_site['country'] );
          $site_data->setDirections( @$incoming_site['directions'] );
          $site_data->setDirectionsUrl( @$incoming_site['directions_url'] );
          $site_data->save();
          $count++;
        }
      }

      commonTools::logMessage( "Site data count: $incoming_count $count" );
    }
  }


   public static function getLocationName( $site_code ){
     $name = array( );
     $c = new Criteria();
     $c->add(SiteDataPeer::SITE_CODE, $site_code );
     $site = SiteDataPeer::doSelectOne( $c );

     if(isset($site)){
       if($site->getSiteName() != ''){
         $name[] = $site->getSiteName();
       }
       if($site->getAddress() != ''){
         $name[] = $site->getAddress();
       }
       if($site->getCity() != ''){
         $name[] = $site->getCity();
       }
       if($site->getState() != ''){
         $name[] = $site->getState();
       }
       if($site->getZip() != ''){
         $name[] = $site->getZip();
       }
       $location_name = implode(', ',$name);
     } 
     else {
       $location_name = "Unassigned ($site_code)";
     }
     return $location_name;
   }
}

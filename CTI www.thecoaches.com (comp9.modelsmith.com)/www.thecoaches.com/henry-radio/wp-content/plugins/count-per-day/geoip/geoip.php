<?php
/**
 * Filename: geoip.php
 * Count Per Day - GeoIP Addon
 */

/**
 */
if (!class_exists('GeoIp'))
	include_once('geoip.inc');

class CpdGeoIp
{

/**
 * gets country of ip adress
 * @param $ip IP
 * @return array e.g. ( 'de', image link to easywhois.com , 'Germany' )
 */
function getCountry( $ip )
{
	global $cpd_path;
	
	$gi = geoip_open($cpd_path.'/geoip/GeoIP.dat', GEOIP_STANDARD);
	$c = strtolower(geoip_country_code_by_addr($gi, $ip));
	
	if ( empty($c) )
		$c = 'unknown';
	$cname = geoip_country_name_by_addr($gi, $ip);
	$country = array( $c, '<div class="cpd-flag cpd-flag-'.$c.'" title="'.$cname.'"></div>', $cname );
	geoip_close($gi);
	
	return $country;
}



/**
 * updates CountPerDay table
 */
function updateDB()
{
	global $count_per_day;
	global $cpd_path;
	global $wpdb;
	
	$count_per_day->getQuery("SELECT country FROM `".CPD_C_TABLE."`", 'GeoIP updateDB Table');
	if ((int) mysql_errno() == 1054)
		// add row "country" to table
		$count_per_day->getQuery("ALTER TABLE `".CPD_C_TABLE."` ADD `country` CHAR( 2 ) NOT NULL", 'GeoIP updateDB create column');
	
	$limit = 10;
	$res = $count_per_day->getQuery("SELECT ip, INET_NTOA(ip) AS realip FROM ".CPD_C_TABLE." WHERE country LIKE '' GROUP BY ip LIMIT $limit;", 'GeoIP updateDB');
	$gi = geoip_open($cpd_path.'/geoip/GeoIP.dat', GEOIP_STANDARD);
	
	if ( @mysql_num_rows($res) )
		while ( $r = mysql_fetch_array($res) )
		{
			$c = '';
			$ip = explode('.', $r['realip']);
			if ( $ip[0] == 10
				|| $ip[0] == 127
				|| ($ip[0] == 169 && $ip[1] == 254)
				|| ($ip[0] == 172 && $ip[1] >= 16 && $ip[1] <= 31)
				|| ($ip[0] == 192 && $ip[1] == 168) )
				// set local IPs to '-'
				$c = '-';
			else
				// get country
				$c = strtolower(geoip_country_code_by_addr($gi, $r['realip']));
			
			if ( !empty($c) )
				$count_per_day->getQuery("UPDATE ".CPD_C_TABLE." SET country = '".$c."' WHERE ip = '".$r['ip']."'", 'GeoIP updateDB');
		}

	geoip_close($gi);
	
	$res = $count_per_day->getQuery("SELECT count(*) FROM ".CPD_C_TABLE." WHERE country like ''", 'GeoIP updateDB');
	if ( @mysql_num_rows($res) )
	{
		$row = mysql_fetch_array($res);
		$rest = (!empty($row[0])) ? $row[0] : 0;
	}
	else
		$rest = 0;

	return $rest;
}



/**
 * updates the GeoIP database file
 * works only if directory geoip has rights 777, set it in ftp client
 */
function updateGeoIpFile()
{
	global $cpd_path;
	
	// set directory mode
	@chmod($cpd_path.'/geoip', 0777);
	
	// function checks
	if ( !ini_get('allow_url_fopen') )
		return 'Sorry, <code>allow_url_fopen</code> is disabled!';
		
	if ( !function_exists('gzopen') )
		return __('Sorry, necessary functions (zlib) not installed or enabled in php.ini.', 'cpd');
	
	$gzfile = 'http://geolite.maxmind.com/download/geoip/database/GeoLiteCountry/GeoIP.dat.gz';
	$file = $cpd_path.'/geoip/GeoIP.dat';

	// get remote file
	$h = gzopen($gzfile, 'rb');
	$content = gzread($h, 1500000);
	fclose($h);

	// delete local file
	if (is_file($file))
		unlink($file);
		
	// file deleted?
	$del = (is_file($file)) ? 0 : 1;

	// write new locale file
	$h = fopen($file, 'wb');
	fwrite($h, $content);
	fclose($h);
	
	@chmod($file, 0777);
	if (is_file($file) && $del)
		return __('New GeoIP database installed.', 'cpd');
	else
		return __('Sorry, an error occurred. Try again or check the access rights of directory "geoip" is 777.', 'cpd');
}


}
?>
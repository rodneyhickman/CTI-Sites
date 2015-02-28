<html>
<?php
if(isset($_POST['file']) && isset($_POST['bucket']) && $_POST['bucket'] == 'cti-fm-videos') {
	

	        $file      = $_POST['file'];
	        $key       = '0MFR8Q5CWR8H4J420WR2';
	        $secret    = 'o4gmUzZVwy4Z+8YV0onqHnTQfNpzVVOTzP+tECkm';
                $bucket = 'cti-fm-videos';
	        $time      = time()+$_POST['expiration'];
	        $string    = "GET\n\n\n{$time}\n/{$bucket}/{$file}";
	        $signature = urlencode(base64_encode((hash_hmac("sha1",utf8_encode($string),$secret,TRUE))));
	        $link      = "http://s3.amazonaws.com/{$bucket}/{$file}?AWSAccessKeyId=$key&Expires=$time&Signature=$signature";
	        $flashvar  = urlencode($link);
?>
<head>
	        <title>Video</title>
    <meta http-equiv="refresh" content="0;url=<?=$link?>">
	</head>
	<body>
	
	


	
	                <h1>Please view the video by pressing the following link:</h1>
	                <ul>
	                        <li>Link:<br /><a href="<?=$link?>"><?=$link?></a></li>

	                </ul>

	

<?php } ?>
	
	</body>
</html>

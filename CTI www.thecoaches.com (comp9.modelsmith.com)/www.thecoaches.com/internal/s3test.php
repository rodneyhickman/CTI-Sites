<html>
	<head>
	        <title>Generate S3 Signature</title>
	</head>
	<body>
	
	
	<?php
   if(isset($_POST['file'])) {
	
	        $bucket    = $_POST['bucket'];
	        $file      = $_POST['file'];
	        $key       = $_POST['key'];
	        $secret    = $_POST['secret'];
	
	        $time      = time()+$_POST['expiration'];
	        $string    = "GET\n\n\n{$time}\n/{$bucket}/{$file}";
	        $signature = urlencode(base64_encode((hash_hmac("sha1",utf8_encode($string),$secret,TRUE))));
	        $link      = "http://s3.amazonaws.com/{$bucket}/{$file}?AWSAccessKeyId=$key&Expires=$time&Signature=$signature";
	        $flashvar  = urlencode($link);
?>

	
	                <h1>Your generated URL:</h1>
	                <ul>
	                        <li>Link:<br /><a href="<?=$link?>"><?=$link?></a></li>
	                        <li>Flashvar:<br /><?=$flashvar?></li>
	                </ul>
	                <p><a href="./s3test.php">retry</a></p>
	

	<?php } else { ?>
          
	<h1>Generate Signed S3 URL</h1>
	<p>This form will generate a URL with <a href="http://docs.amazonwebservices.com/AmazonS3/2006-03-01/RESTAuthentication.html">S3's query string authentication mechanism</a>.</p>
	
	<form action="./s3test.php" method="post">
	        <fieldset>
	                <label>Amazon S3 Bucket</label>
	                <input type="text" name="bucket" value="" />
	                <br />
	                <label>File to stream</label>
	                <input type="text" name="file" value="" />
	                <br />
	                <label>Amazon S3 Key</label>
	                <input type="text" name="key" value="" />
	                <br />
	                <label>Amazon S3 Secret</label>
	                <input type="text" name="secret" />
	                <br />
	                <label>Expiration (in seconds)</label>
	                <input type="text" name="expiration" value="86400"/>
	                <br />
	                <button type="submit">generate</button>
	        </fieldset>
	</form>
<?php } ?>
	
	</body>
</html>

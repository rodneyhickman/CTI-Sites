<html>
<head>
<script src="http://www.google.com/jsapi"></script><!-- load jsapi from Google's CDN -->
<script>google.load("jquery", "1.4.2");</script><!-- load jQuery -->
<script>google.setOnLoadCallback(function() { 
$('#form1').submit();
});
</script>

<body>
<form action="filemaker_video.php" id="form1" method="POST">
<input type="hidden" name="expiration" value="86400" />
<input type="hidden" name="bucket" value="cti-fm-videos"><br /><br />
<input type="text" name="file" value="<?php echo $_GET['file'] ?>"><br /><br />
<input type="submit" name="go" value="Submit">
</form>
</body>
</html>

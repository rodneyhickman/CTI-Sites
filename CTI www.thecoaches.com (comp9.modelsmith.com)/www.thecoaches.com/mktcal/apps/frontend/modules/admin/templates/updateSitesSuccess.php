
<form action="<?php echo url_for('admin/updateSites') ?>" method="post">

<textarea name="json" style="width:400px;height:200px;"></textarea>
<br /><br />
<input type="submit" name="submit-btn" value="Submit" />
</form>


<pre>
   Params:

<?php print_r($params); ?>

</pre>

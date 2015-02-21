<?php if($adminpid > 0): ?>
<div style="margin:20px;">
<form action="<?php echo url_for('ctiforms/readDietaryCSVProcess') ?>" action="post" enctype="multipart/form-data">
<input type="hidden" name="adminpid" value="1" />

<input type="file" name="csv_file" />

<input type="submit" value="Go!" name="go" />

</form>
</div>
<?php endif ?>


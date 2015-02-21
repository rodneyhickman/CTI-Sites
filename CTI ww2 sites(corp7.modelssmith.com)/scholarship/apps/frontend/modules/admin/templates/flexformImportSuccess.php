<h1>Flexform Import</h1>

<?php if($msg != ''): ?>
<p style="color:red"><?= $msg ?></p>
<?php endif; ?>

<form action="<?php echo url_for('admin/flexformImport') ?>" method="post">

<textarea name="formtext" style="width:500px;height:200px;"><?php echo $formtext ?></textarea>

   <p>&nbsp;</p>

   <input type="checkbox" name="import" value="1"> Import<br /><br />
   Form Name <input type="text" name="formname" style="width:500px;" value="<?php echo $formname ?>"><br /><br />
<input type="submit" name="submit-btn" value="Submit" />

</form>

<pre>
   <?php if(isset($sections)){ print_r($sections); } ?>

</pre>
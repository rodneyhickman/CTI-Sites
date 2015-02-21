<h1>Flexform Reader Test</h1>

<form action="<?php echo url_for('admin/flexformReader') ?>" method="post">

<textarea name="formtext" style="width:500px;height:200px;"><?php echo $formtext ?></textarea>

   <p>&nbsp;</p>

<input type="submit" name="submit-btn" value="Submit" />

</form>

<pre>
   <?php if(isset($sections)){ print_r($sections); } ?>

</pre>
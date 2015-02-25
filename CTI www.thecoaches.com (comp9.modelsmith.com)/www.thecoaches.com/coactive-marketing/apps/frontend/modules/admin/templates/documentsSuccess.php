<h1>Administration: Manage Coaching Sales Program Forms</h1>

<?php if($msg){ echo "<p class=\"alert\">$msg</p>"; } ?>

<h2>New Document</h2>
<form id="document-form" class="upload-form" action="<?php echo url_for('admin/documentUpload') ?>" method="POST" enctype="multipart/form-data">
<fieldset>
   <label for="description">Description</label>
<textarea name="description"></textarea>
</fieldset>

<p id="document-file"><input type="file" name="document_file" /> Choose an document file on your computer</p>

<p><input type="submit" name="upload" value="Upload Document" /></p>
</form>


<p>&nbsp;</p>
<p>&nbsp;</p>


<table class="listen">
<tr><th>Description</th><th>Download Link</th><th></th></tr>

<?php foreach($documents as $document): ?>

<tr>
   <td><?php echo $document->getDescription(); ?></td>
   <td><a href="<?php echo $document->getUrl(); ?>" target="_blank">Download</a></td>
   <td><a class="delete" href="<?php echo url_for('admin/documentDelete').'?document_id='.$document->getId() ?>">Delete</a></td>
</tr>

   <?php endforeach; ?>

</table>

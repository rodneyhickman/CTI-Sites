<h1>Get Coaching Marketing Program Documents</h1>

<p>Download these documents to help you achieve your marketing goals.</p>


<p>&nbsp;</p>


<table class="listen">
<tr><th>Description</th><th>Download Link</th></tr>

<?php foreach($documents as $document): ?>

<tr>
   <td><?php echo $document->getDescription(); ?></td>
   <td><a href="<?php echo $document->getUrl(); ?>" target="_blank">Download</a></td>
</tr>

   <?php endforeach; ?>

</table>

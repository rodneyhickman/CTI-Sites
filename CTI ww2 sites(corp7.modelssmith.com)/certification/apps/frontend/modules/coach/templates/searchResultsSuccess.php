


<?php include_partial('nav') ?>
<h1>
<?php echo $type ?> Coach Search Results
</h1>
  <!-- cg:<?php echo $cg ?> -->

<h2>Search Query: <?php echo $words ?></h2>

<div id="coachlist">
<table>
<?php $count = 0 ?>
<?php foreach($records as $r): ?>
<?php $count++ ?>
<tr>
<td><?php echo $count ?>.</td>
<td><?php echo $r->name ?><br />
    <?php echo $r->location ?><br />
    <?php echo $r->niche ?><br />
    <?php echo $r->expertise ?><br />
  <?php echo link_to('Contact this coach','coach/contact?id='.$r->id) ?>
</tr>

<?php endforeach ?>
</table>
</div>

<div>
<?php if($count == 0): ?>
<p>No matches found. Please try again.</p>
<?php endif ?>

   <p>&nbsp;</p>
<h2>Search again:</h2>
<p><?php echo link_to('Return to search page','coach/search') ?></p>
</div>

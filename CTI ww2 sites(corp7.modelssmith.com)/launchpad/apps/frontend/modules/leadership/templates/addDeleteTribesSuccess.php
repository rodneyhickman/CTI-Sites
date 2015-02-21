<?php use_helper('Object'); ?>

<?php include_partial('nav') ?>
<h1>Launchpad Administration - Add/Delete Tribe</h1>

<script>
  function deleteTribe(name) {
    var response = confirm("Are you sure you want to delete the tribe "+name);
    return response;
  }
</script>

<h2>Current Tribes</h2>
<table class="alt">
<tr><th>Tribe Name</th><th>Location</th><th>Retreat 1 Date</th><th>Filemaker ID</th><th></th></tr>
  <?php foreach($current_tribes as $tribe): ?>
  <tr>
<td><?php echo $tribe->getName() ?></td>
<td><?php echo $tribe->getLocation() ?></td>
<td><?php echo $tribe->getRetreat1Date() ?></td>
<td><?php echo $tribe->getExtra1() ?></td>
<td>
  <?php if($tribe->getName() != 'Unassigned' && $tribe->getName() != 'Other'): ?>
<a onclick="return deleteTribe('<?php echo $tribe->getName() ?>')" href="<?php echo url_for('leadership/deleteTribe?id='.$tribe->getId()) ?>">Delete</a>
   <?php endif; ?>
</td>
</tr>
  <?php endforeach; ?>
</table>

<p>&nbsp;</p>

<h2>Launched Tribes</h2>
<table class="alt">
<tr><th>Tribe Name</th><th>Location</th><th>Retreat 1 Date</th><th>Filemaker ID</th><th></th></tr>
  <?php foreach($launched_tribes as $tribe): ?>
  <tr>
<td><?php echo $tribe->getName() ?></td>
<td><?php echo $tribe->getLocation() ?></td>
<td><?php echo $tribe->getRetreat1Date() ?></td>
<td><?php echo $tribe->getExtra1() ?></td>
<td>
  <?php if($tribe->getName() != 'Unassigned' && $tribe->getName() != 'Other'): ?>
<a onclick="return deleteTribe('<?php echo $tribe->getName() ?>')" href="<?php echo url_for('leadership/deleteTribe?id='.$tribe->getId()) ?>">Delete</a>
   <?php endif; ?>
</td>
</tr>
  <?php endforeach; ?>
</table>

<p>&nbsp;</p>
<h2>Add a Tribe</h2>
<form action="<?php echo url_for('leadership/addTribe') ?>" action="POST" class="simple">
<label for="name">Name</label>
<input type="text" name="name" value="" />

<label for="location">Location</label>
<input type="text" name="location" value="" />

<label for="r1_date">Retreat 1 Date<br /><span style="font-size:0.9em;">MM/DD/YYYY</span></label>
<input type="text" name="r1_date" value="" />
<div style="clear:both;"></div>
<label for="fmid">Filemaker ID</label>
<input type="text" name="fmid" value="" />

    <label>&nbsp;</label>
<input type="submit" value="Add Tribe">

</form>

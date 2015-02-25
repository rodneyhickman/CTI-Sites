<h1>Administration: Add New Group Starting Date</h1>

<p>Current groups:</p>
<ul>
<?php foreach($groups as $group): ?>
<li><?php echo $group->getName() ?>: <?php echo $group->getStartDate() ?></li>
<?php endforeach; ?>
</ul>


<p>&nbsp;</p>
<h2>New Group</h2>

<p>All new reports on this date or after will be grouped together for reporting purposes.</p>

<form action="<?php echo url_for('admin/groupDateProcess') ?>" method="POST" />

<script>
	$(function() {
		$( "#datepicker" ).datepicker();
	});
	</script>
<p>The new group starting date is: <input type="text" name="date" value="" id="datepicker" /></p>

<p><input type="submit" name="save_date" value="Save New Date" /></p>


</form>
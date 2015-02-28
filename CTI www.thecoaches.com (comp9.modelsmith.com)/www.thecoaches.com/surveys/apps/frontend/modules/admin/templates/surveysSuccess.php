<div class="rightside">&raquo; <a href="<?php echo url_for('admin/index'); ?>">Home</a>&nbsp;&nbsp;&nbsp;&raquo; <a href="<?php echo url_for('main/logout'); ?>">Logout</a></div>

<h1>Manage Surveys</h1>

<p>Please select a survey:</p>

<?php foreach($surveys as $s): ?>
<p><a href="<?php echo url_for('admin/leaders'); ?>?survey_id=<?php echo $s->getId(); ?>"><?php echo $s->getTitle(); ?></a></p>
<?php endforeach; ?>


<div class="rightside">
&raquo; <a href="<?php echo url_for('admin/index'); ?>">Home</a>
&nbsp;&nbsp;&nbsp;&raquo; <a href="<?php echo url_for('main/logout'); ?>">Logout</a>
</div>
                    
<h1>Survey: <?php echo $survey->getTitle() ?></h1>


<table class="events">
<tr>
<th>Name</th><th>Email</th>
</tr>
<?php foreach($profiles as $p): ?>
<tr>
<td><?php echo $p->getName() ?></td>
<td><?php echo $p->getEmail() ?></td>
</tr>
                    <?php endforeach; ?>
</table>


        

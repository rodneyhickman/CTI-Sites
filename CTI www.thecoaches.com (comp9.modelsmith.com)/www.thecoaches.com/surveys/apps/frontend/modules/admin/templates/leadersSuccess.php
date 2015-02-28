<div class="rightside">
&raquo; <a href="<?php echo url_for('admin/index'); ?>">Home</a>
&nbsp;&nbsp;&nbsp;&raquo; <a href="<?php echo url_for('main/logout'); ?>">Logout</a>
</div>
                    
<h1>Survey: <?php echo $survey->getTitle() ?></h1>

<p><a href="<?php echo url_for('admin/leaders?survey_id='.$survey_id.'&alpha_sort=1') ?>">&raquo; Sort by first name</a></p>
<p><a href="<?php echo url_for('admin/leaders?survey_id='.$survey_id.'&alpha_sort=0') ?>">&raquo; Sort by most recent</a></p>
<p><a href="<?php echo url_for('admin/archive?survey_id='.$survey_id.'&alpha_sort=1') ?>">&raquo; View All Archive Leader/Co-Leader Feedback</a></p>
<p><a href="<?php echo url_for('admin/archive?survey_id=1') ?>">&raquo; View All Archive Journey Leader to Journey Lead Trainer</a></p>
 

<table class="events">
<tr>
<th>Name</th><th>Number of surveys</th>
</tr>
<?php 
foreach($leaders as $name => $value): ?>
<tr>
<td><a href="<?php echo url_for('admin/leader') ?>?key=<?php echo $value['leader_retrieval_key'] ?>&survey_id=<?php echo $survey_id ?>"><?php echo $name ?></a></td>
<td><?php echo count($value['answer_set_keys']) ?></td>
</tr>
                    <?php endforeach; ?>
</table>

<pre>

</pre>
        

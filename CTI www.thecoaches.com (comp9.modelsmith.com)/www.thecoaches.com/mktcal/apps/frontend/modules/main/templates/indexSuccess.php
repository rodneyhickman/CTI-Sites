<p>&nbsp;</p>

<h1>By Year</h1>
 


<?php foreach($years as $year): ?>
<p><a href="<?php echo url_for('main/year?y='.$year.'-1') ?>"><?php echo $year ?></a></p>
<?php endforeach ?>


<h1>By Quarters</h1>
  
<?php foreach($quarters as $quarter): ?>
<p><a href="<?php echo url_for('main/quarter?q='.$quarter) ?>"><?php echo $quarter ?></a></p>
<?php endforeach ?>





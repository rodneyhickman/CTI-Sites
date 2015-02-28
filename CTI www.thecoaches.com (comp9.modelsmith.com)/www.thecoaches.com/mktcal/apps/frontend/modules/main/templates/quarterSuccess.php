<p>&nbsp;</p>
<p>&nbsp;</p>

<h1><?php echo $quarter ?></h1>

<div style="float:left;margin:0 20px 0 20px;"><?php echo $cal1->showcal(); ?></div>
<div style="float:left;margin:0 20px 0 20px;"><?php echo $cal2->showcal(); ?></div>
<div style="float:left;margin:0 20px 0 20px;"><?php echo $cal3->showcal(); ?></div>

<div style="clear:both;"></div>
<p>&nbsp;</p>

<h2>By Year</h2>
 


<?php foreach($years as $year): ?>
<p><a href="<?php echo url_for('main/year?y='.$year.'-1') ?>"><?php echo $year ?></a></p>
<?php endforeach ?>


<h2>By Quarters</h2>
  
<?php foreach($quarters as $quarter): ?>
<p><a href="<?php echo url_for('main/quarter?q='.$quarter) ?>"><?php echo $quarter ?></a></p>
<?php endforeach ?>


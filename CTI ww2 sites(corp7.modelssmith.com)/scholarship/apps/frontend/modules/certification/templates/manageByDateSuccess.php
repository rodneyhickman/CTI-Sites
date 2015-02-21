<?php use_helper('Object'); ?>

<?php include_partial('nav') ?>
<h1>Certification Administration - Pod</h1>


<form action="<?php echo url_for('certification/manageByDate') ?>" method="post">
  Choose a date: <select name="date" onChange="this.form.submit()">
  <?php foreach($date_list as $d): ?>
  <option value="<?php echo $d ?>" <?php if($date == $d){ echo 'SELECTED'; } ?>><?php echo $d ?></option>
  <?php endforeach ?>
</select>
</form>


    <p>&nbsp;</p>


<table>
<tr>
<td style="font-size:1.2em"><strong><?php echo $date ?></strong></td>
<td colspan="1">Forms Completed</td>
</tr>
<tr>
<td>Name</td>
<td>Application</td>
</tr>
<tr class="lightbg">
<td class="btop bleft bright"><strong>Participants</strong></td>
<td class="btop bright"></td>
</tr>



<?php $alt=1 ?>
    <?php foreach($participants as $p): ?>
<?php $alt++?>
<tr class="<?php echo $alt % 2 ? 'altbg' : '' ?>">
    <td class="bleft bright"><?php echo link_to($p->getName(),'certification/participant?id='.$p->getId() ) ?></td>
    <td class="bright"><?php echo $p->getDidFinishApplication()  ?></td>
</tr>
<?php endforeach ?>



<tr>
<td colspan="2" class="btop">Click on a name above to EDIT</td>
</tr>

<tr>
<td colspan="2">&nbsp;</td>
</tr>

<tr>
<td colspan="2"><?php echo link_to('Export Applications in Spreadsheet','certification/exportMonthApplications?date='.$date) ?></td>
</tr>

<tr>
<td colspan="2">&nbsp;</td>
</tr>


</table>

<?php use_helper('Object'); ?>

<?php include_partial('nav') ?>
<h1>Certification Administration - Pod</h1>

<form action="<?php echo url_for('certification/pod') ?>" method="post">
  Choose a pod: <select name="pod_id" onChange="this.form.submit()">
<?php echo objects_for_select($pods, 'getId', 'getName', $pod_id) ?>
</select>
</form>


    <p>&nbsp;</p>


<table>
<tr>
<td style="font-size:1.2em"><strong><?php echo $pod_name ?> Pod</strong></td>
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
    <td class="bleft bright"><?php echo link_to($p->getName(),'certification/participant?id='.$p->getId().'&pod_id='.$pod_id ) ?></td>
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
<td colspan="2">&nbsp;</td>
</tr>


</table>

<?php use_helper('Object'); ?>

<?php include_partial('nav') ?>
<h1>Launchpad Administration - Tribe</h1>

<form action="<?php echo url_for('leadership/launchedTribe') ?>" method="post">
<select name="tribe_id" onChange="this.form.submit()">
<?php echo objects_for_select($tribes, 'getId', 'getNameDateLocation', $tribe_id) ?>
</select>
</form>


    <p>&nbsp;</p>


<table>
<tr>
<td><strong><?php echo $tribe_name ?></strong></td>
    <td colspan="3">Forms Completed (Date Completed)</td>
</tr>
<tr>
<td>Name</td>
<td>Questionnaire</td>
<td>Medical</td>
<td>Diet</td>
</tr>
<tr class="lightbg">
<td class="btop bleft bright"><strong>Participants</strong></td>
<td class="btop bright"></td>
<td class="btop bright"></td>
<td class="btop bright"></td>
</tr>

<?php $alt=1 ?>
    <?php foreach($participants as $p): ?>
<?php $alt++?>
<tr class="<?php echo $alt % 2 ? 'altbg' : '' ?>">
    <td class="bleft bright"><?php echo link_to($p->getName(),'leadership/participant?id='.$p->getId().'&tribe_id='.$tribe_id ) ?></td>
    <td class="bright"><?php echo $p->getFinishedQuestionnaireWithDate() ?></td>
<td class="bright"><?php echo $p->getFinishedMedicalWithDate() ?></td>
<td class="bright"><?php echo $p->getFinishedDietaryWithDate() ?></td>
</tr>
<?php endforeach ?>


<tr class="lightbg">
<td class="btop bleft bright"><strong>Assistants</strong></td>
<td class="btop bright"></td>
<td class="btop bright"></td>
<td class="btop bright"></td>
</tr>

<?php $alt=1 ?>
    <?php foreach($assistants as $p): ?>
<?php $alt++?>
<tr class="<?php echo $alt % 2 ? 'altbg' : '' ?>">
    <td class="bleft bright"><?php echo link_to($p->getName(),'leadership/participant?id='.$p->getId().'&tribe_id='.$tribe_id ) ?></td>
<td class="bright"><?php echo $p->getFinishedQuestionnaireWithDate() ?></td>
<td class="bright"><?php echo $p->getFinishedMedicalWithDate() ?></td>
<td class="bright"><?php echo $p->getFinishedDietaryWithDate() ?></td>

</tr>
<?php endforeach ?>



<tr class="lightbg">
<td class="btop bleft bright"><strong>Leaders</strong></td>
<td class="btop bright"></td>
<td class="btop bright"></td>
<td class="btop bright"></td>
</tr>

<?php $alt=1 ?>
    <?php foreach($leaders as $p): ?>
<?php $alt++?>
<tr class="<?php echo $alt % 2 ? 'altbg' : '' ?>">
<td class="bleft bright"><?php echo link_to($p->getName(),'leadership/leader?id='.$p->getId().'&tribe_id='.$tribe_id ) ?></td>
<td class="bright"><?php echo $p->getFinishedQuestionnaireWithDate() ?></td>
<td class="bright"><?php echo $p->getFinishedMedicalWithDate() ?></td>
<td class="bright"><?php echo $p->getFinishedDietaryWithDate() ?></td>

</tr>
<?php endforeach ?>




<tr>
<td colspan="4" class="btop">Click on a name above to EDIT</td>
</tr>

<tr>
<td colspan="4">&nbsp;</td>
</tr>

<tr>
<td colspan="4"><?php echo link_to('Export Tribe Questionnaire Release Spreadsheet','leadership/exportTribeQuestionnaire?id='.$tribe_id) ?></td>
</tr>

<tr>
<td colspan="4"><?php echo link_to('Export Tribe Medical/Liability Info Spreadsheet','leadership/exportTribeMedical?id='.$tribe_id) ?></td>
</tr>


<tr>
<td colspan="4"><?php echo link_to('Export Tribe Dietary Spreadsheet','leadership/exportTribeDietary?id='.$tribe_id) ?></td>
</tr>

<tr>
<td colspan="4"><?php echo link_to('Export Influencer Report Spreadsheet','leadership/exportTribeInf?id='.$tribe_id) ?></td>
</tr>

<tr>
<td colspan="4">&nbsp;</td>
</tr>


</table>

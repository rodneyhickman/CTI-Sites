
<h1>Administration Reports</h1>

<h2>Homework Report</h2>

<p>&nbsp;</p>
<p>Notes:
<ul>
<li>To see the complete Program Goal, <b>hover</b> over the goal and wait for the popup</li>

</ul>
</p>
   <p>&nbsp;</p>
<p>
<input style="float:right;" type="button" value="Download as CSV File" onclick="window.location='<?php echo url_for('admin/homeworkCsv'); ?>';" />
<form id="group-form" action="<?php echo url_for('admin/reports'); ?>" method="get">
<select id="group-select" name="group_id">
   <?php foreach($groups as $group): ?>
   <option value="<?php echo $group->getId() ?>"><?php echo $group->getDisplayName() ?></option>
   <?php endforeach; ?>
</select>
</form>


</p>

<div class="relbox-container">
<div class="relbox">
<div class="scrolltable">
<!--Begin Left Side Table Headers-->
<table class="thead">
<tr>
<th scope="row">Participants Name</th>
</tr>

<!-- foreach participant -->
<?php foreach($group_homework as $row): ?>
<tr>
<td scope="row"><?php echo $row['name'] ?></td>
</tr>
<?php endforeach; ?>


</table>
<!--Begin Scrolling-->
<div class="scrolling">
<table>


<?php 
// header row (grab headers from first participant)
foreach($group_homework as $row){
  echo '<tr>';
  $columns = $row['columns'];
  foreach($columns as $column){
    echo '<th>'.$column[0].'</th>';
  }
  echo '</tr>';
  break;
}

// data rows
foreach($group_homework as $row){
  echo '<tr>';
  $columns = $row['columns'];
  foreach($columns as $column){
    echo '<td>'.$column[1].'</td>';
  }
  echo '</tr>';
}
?>

</table>
<!--end scrolling --></div>


<!--clear floats here with a br, p or hr clearing class-->
<p class="clearing" style="clear:both;">&nbsp;</p>
</div>
</div>
</div>


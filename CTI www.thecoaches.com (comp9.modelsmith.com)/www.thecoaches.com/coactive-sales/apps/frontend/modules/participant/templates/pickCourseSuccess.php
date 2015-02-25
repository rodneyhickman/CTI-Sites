<div style="float:left;width:450px;">

<form action="<?php echo url_for('participant/pickCourseProcess') ?>" method="POST">
 <table style="width:445px;">
    <tr>
  <th><label for="course">Please select a course</label></th>
  <td>
<select name="course">
   <?php foreach($groups as $group): ?>
    <option value="<?php echo $group->getId() ?>">Co-Active Sales, starting on <?php echo $group->getStartDateFormatted() ?></option>
    <?php endforeach; ?>
</select>
</td>
</tr>
  <tr><td></td><td>
  <input type="submit" value="Continue" />
  </td></tr>
 
  </table>

</form>
</div>
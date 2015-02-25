<h1 class="short">Homework</h1>
<h2>Week of <?php echo $homework->getWeekStartingFormatted() ?></h2>

   <p>&nbsp;<br />Complete this homework everyweek to track your progress</p>

<form class="homework-form" action="<?php echo url_for('participant/homeworkProcess') ?>" method="POST">

<fieldset>
   <label>Short Bio (less than 75 chars)</label>
<textarea class="w500" name="homework[short_bio]"><?php echo $profile->getShortBio() ?></textarea>
</fieldset>

<fieldset>
<label>My purpose</label>
<input class="w500" type="text" name="homework[purpose]" value="<?php echo $profile->getPurpose() ?>" />
</fieldset>

<fieldset>
<label>Program Goal</label>
<input class="w500" type="text" name="homework[program_goal]" value="<?php echo $profile->getProgramGoal() ?>" />
</fieldset>

<fieldset>
<label>Total Clients, so far</label>
<input type="text" name="homework[total_clients]" value="<?php echo $homework->getTotalClients() ?>" />
</fieldset>


<fieldset>
   <label>I commit to giving the following number of Sample Sessions in the next week:</label>
<input type="text" name="homework[ss_commit]" value="<?php echo $homework->getSsCommit() ?>" />
</fieldset>

<fieldset>
   <label>Number of Sample Sessions I completed in the past week:</label>
<input type="text" name="homework[ss_completed]" value="<?php echo $homework->getSsCompleted() ?>" />
</fieldset>

<fieldset>
   <label>I commit to adding the following number of clients to my practice this week:</label>
<input type="text" name="homework[clients_commit]" value="<?php echo $homework->getClientsCommit() ?>" />
</fieldset>

<fieldset>
   <label>Number of clients I added to my practice in the last week:</label>
<input type="text" name="homework[clients_completed]" value="<?php echo $homework->getClientsCompleted() ?>" />
</fieldset>

<fieldset>
   <label>I commit to earning the following number of points in Success Coach 100 in the next week:</label>
<input type="text" name="homework[points_commit]" value="<?php echo $homework->getPointsCommit() ?>" />
</fieldset>

<fieldset>
   <label>Number of Success Coach 100 points I earned in the past week:</label>
<input type="text" name="homework[points_earned]" value="<?php echo $homework->getPointsEarned() ?>" />
</fieldset>



   <p>&nbsp;</p>
<fieldset>
   
<input class="w100" type="submit" name="save" value="Save" />
</fieldset>

</form>

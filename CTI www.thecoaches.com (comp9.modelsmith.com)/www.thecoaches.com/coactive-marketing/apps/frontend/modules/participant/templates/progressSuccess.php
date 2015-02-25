<p>Program Goal: <?php echo $program_goal ?></p>

<h2>My Progress</h2>


<div class="basic-table">

<table class="listen">
<tr>
<th style="width:100px">Date</th>
<th>Total Clients</th>
<th>S.S. Commit</th>
<th>S.S. Done</th>
<th>Clients Commit</th>
<th>Clients Done</th>
<th>#100 Commit</th>
<th>#100 Earned</th>
</tr>

   <?php foreach($homeworks as $h): ?>
<tr>
   <td><?php echo $h->getWeekStarting('M d, Y') ?></td>
   <td><?php echo $h->getTotalClients() ?></td>
   <td><?php echo $h->getSsCommit() ?></td>
   <td><?php echo $h->getSsCompleted() ?></td>
   <td><?php echo $h->getClientsCommit() ?></td>
   <td><?php echo $h->getClientsCompleted() ?></td>
   <td><?php echo $h->getPointsCommit() ?></td>
   <td><?php echo $h->getPointsEarned() ?></td>

</tr>
   <?php endforeach; ?>
</table>

</div>
<!-- This file contains a starting point for a templte page   -->

<?php include_partial('nav') ?>

<h1>
Search For A Coach
</h1>

<h4>CTI Coach Match connects Synergy graduates with Fundamentals course participants for free coaching.  If you would like to provide feedback, send us a message from the Account Page.</h4>
<div style="float:left;">

<form action="<?php echo url_for('coach/searchResults') ?>" method="POST">
  <table>
    <?php echo $form ?>
    <tr>
      <td></td>
      <td>
        <input type="submit" name="submit" value="Search" />
      </td>
    </tr>
  <tr><td></td><td><?php echo link_to('Show all coaches','coach/searchAll'); ?></td></tr>
  </table>
</form>
</div>

<div style="float:left;margin-left:30px;">


   <p>Examples:</p>

<p>
<ul>

<li>Growth</li>
<li>Transition</li>
<li>Balance</li>
<li>Life</li>
</ul>
</p>
</div>

<!-- This file contains a starting point for a templte page   -->

<?php include_partial('nav') ?>
<h1>
Contact A Coach
</h1>

<form action="<?php echo url_for('coach/contact') ?>" method="POST">
<input type="hidden" name="id" value="<?php echo $coach_id ?>" />
  <table>
   <tr>
   <td>To:</td>
   <td><?php echo $to_name ?></td>
   </tr>
   <tr>
   <td>From:</td>
   <td><?php echo $from_name ?></td>
   </tr>
   <tr>
   <td>Subject:</td>
   <td>I would like to have you coach me</td>
   </tr>

    <?php echo $form ?>

    <tr>
      <td></td>
      <td>
        <input type="submit" name="submit" value="Send Message" />
      </td>
    </tr>
<?php if(isset($message)): ?>
    <tr>
      <td></td>
      <td style="color:#f00;"><?php echo $message ?></td>
    </tr>
<?php endif ?>

  </table>
</form>


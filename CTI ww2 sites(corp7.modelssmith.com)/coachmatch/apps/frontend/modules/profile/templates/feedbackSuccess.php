<!-- This file contains a starting point for a templte page   -->

<?php include_partial('nav') ?>

<h1>
Provide Feedback
</h1>

<form action="<?php echo url_for('profile/feedback') ?>" method="POST" id="feedback-form">
  <table>
    <tr>
      <td>Date</td>
  <td><?php echo date('M d, Y') ?></td>
    </tr>
    <?php echo $form ?>
    <tr>
      <td></td>
      <td>
        <input type="submit" name="submit" value="Send Feedback" />
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
       <p>&nbsp;</p>
       <h2>Previous Feedback</h2>
       <p>&nbsp;</p>
       <?php foreach($feedbacks as $f): ?>
       <p>Date: <?php echo $f->getFeedbackDate('M d, Y H:i') ?><br/>
       <?php echo $f->getValue() ?>
</p>
<?php endforeach ?>


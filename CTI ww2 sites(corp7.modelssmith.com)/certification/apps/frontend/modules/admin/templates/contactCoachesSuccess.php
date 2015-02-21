<!-- This file contains a starting point for a templte page   -->

<?php include_partial('nav') ?>
<h1>
  Administration: Contact ITB Coaches Via Email
</h1>



<form action="<?php echo url_for('admin/contactCoaches') ?>" method="POST">

  <table style="width:400px">
   <tr>
   <td>To:</td>
   <td>All ITB Coaches</td>
   </tr>

    <?php echo $form ?>

    <tr>
      <td></td>
      <td>
        <input type="submit" name="submit" value="Send Message" />
      </td>
    </tr>
<?php if(isset($msg)): ?>
    <tr>
      <td></td>
      <td style="color:#f00;"><?php echo $msg ?></td>
    </tr>
<?php endif ?>

  </table>
</form>

       <?php if($total_emails > 0): ?>
       <p>Total emails sent: <?php echo $total_emails ?></p>
       <?php endif ?>

<!-- This file contains a starting point for a templte page   -->

<h1>
Unable to Register
</h1>


<?php if($msg){ ?>
   <p><?php echo $msg ?></p>
<?php } else { ?>
   <p>The email address that you entered is already registered in this program. Please <?php echo link_to('sign in','main/index') ?>.</p>
<?php } ?>

<p>
  If you feel this was in error, please contact CTI Customer Service at 1-800-691-6008 x701
</p>


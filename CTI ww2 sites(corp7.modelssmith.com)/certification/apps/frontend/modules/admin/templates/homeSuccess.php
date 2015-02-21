<!-- This file contains a starting point for a templte page   -->

<h1>
Administration Home Page
</h1>

<p>
What would you like to do?
</p>

<p>&raquo; <?php echo link_to('Manage Users','admin/manageUsers') ?></p>    

<p>&raquo; <?php echo link_to('Contact ITB Coaches via Email','admin/contactCoaches') ?></p>    
<p>&raquo; <?php echo link_to('Download List of Users','admin/listOfUsers') ?></p>    
<p>&raquo; <?php echo link_to('View Feedback','admin/viewFeedback') ?></p>
<p>&raquo; <?php echo link_to('View Activity Reports','admin/activityReports') ?></p>
<p>&raquo; <?php echo link_to('Sign out','/certification/index.php/logout') ?></p>



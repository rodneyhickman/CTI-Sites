<!-- This file contains a starting point for a templte page   -->

<h1>
Account Home Page
</h1>

<p>
What would you like to do?
</p>

<p>&raquo; <?php echo link_to('Edit my Profile','profile/edit') ?></p>    
<p>&raquo; <?php echo link_to('Change my Email Address','profile/requestEmailChange') ?></p>    

<p>&raquo; <?php echo link_to('Search for a coach','coach/search') ?></p>    
<p>&raquo; <?php echo link_to('Provide feedback to CTI','profile/feedback') ?></p>
<p>&raquo; <?php echo link_to('Sign out','/certification/index.php/logout') ?></p>


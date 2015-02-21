<?php include_partial('nav') ?>

<h1>
List of Users
</h1>

<p>
  The list of users contains user names, email addresses, and group type. Group 1=student, group 2=coach, group 3 = administrator.</p>

  <p>Download the list, save it as <b>Coach-Match-User-List.csv</b> and open it up in Excel.</p>

<p>
<?php echo  button_to('Download US/Can (ITB) List', 'admin/doListOfUsers?countryGroup=0'); ?>
</p>

<p>
<?php echo  button_to('Download UK (ITB) List', 'admin/doListOfUsers?countryGroup=1'); ?>
</p>

<p>&nbsp;</p>

<p>
<?php echo  button_to('Download US/Can (Synergy) List', 'admin/doListOfUsers?countryGroup=2'); ?>
</p>

<p>
<?php echo  button_to('Download UK (Synergy) List', 'admin/doListOfUsers?countryGroup=3'); ?>
</p>




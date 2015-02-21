<?php include_partial('nav') ?>

<h1>
List of Users
</h1>

<p>
  The list of users contains user names, email addresses, and group type. Group 1=student, group 2=coach, group 3 = administrator.</p>

  <p>Download the list, save it as <b>Coach-Match-User-List.csv</b> and open it up in Excel.</p>

<p>
<?php echo  button_to('Download List', 'admin/doListOfUsers'); ?>
</p>




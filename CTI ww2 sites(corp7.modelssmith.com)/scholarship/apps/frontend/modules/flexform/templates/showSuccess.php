
<!-- <?php echo "profile_id: $profile_id flexform_submission_id: ".$flexform_submission->getId() ?> -->

 <div class="dabblePageContainer dabblePageNoNavigation">
    <div class="dabblePageLeftShadow">
      <div class="dabblePageRightShadow">
        <div class=
        "dabblePage dabblePageWithLogo dabbleSearchPage">
          <div class="dabblePageHeader" id="dabblePageTop">
            <div class="dabblePageLogo">
             <img alt="" height="57" width="176" class="png24bit" src="/launchpad/images/logo250857176.png" />
            </div>


    <h1>&nbsp;</h1>

   <div id="dabblePageContent">


<div style="padding:20px;">
    <p style="font-size:11px;"><!-- Welcome! &nbsp;&nbsp;&raquo;  <a href="<?php echo url_for('flexform/logout') ?>">Sign out without saving answers</a> --></p>

    <h2><?php echo $flexform->getTitle() ?></h2>


<?php if($msg): ?>
<p class="alert"><?php echo $msg ?></p>
<?php endif ?>

<?php if($admin == 1): ?>
   <form action="<?php echo url_for('flexform/editProcess') ?>" enctype="multipart/form-data" method="POST">
   <input type="hidden" name="profile_id" value="<?php echo $profile_id ?>" />
<?php else: ?>
   <form action="<?php echo url_for('flexform/showProcess') ?>" enctype="multipart/form-data" method="POST">
<?php endif; ?>
  <input type="hidden" name="redirect" value="<?php echo $redirect ?>" />
  <input type="hidden" name="id" value="<?php echo $flexform_id ?>" />
  



<div class="dabblePageSection dabblePageSectionFull">
<div class="dabblePageColumn dabblePageColumn1">

<?php if($msg != ''): ?>
  <p class="error"><?php echo $msg; ?></p>
<?php endif; ?>

<!-- audition form here -->
<?php 
foreach($answers as $answer){
      echo $answer->getHtml( ESC_RAW ); 
}
?>

</div>
</div>

<div class= "dabblePageFormItem">
   <div class="dabblePageFormLabel">
   </div>
   <div class="dabblePageFormField dabblePageFormItemRequired"  style="padding-left:20px">
     <p>
     <input type="submit" name="submit-btn" value="Submit Form" />
     <input type="button" value="Cancel" onclick="window.location.href='<?php echo url_for('flexform/logout') ?>'" />
     Submitting this form may take several minutes to complete
     </p>
   </div>
</div>

     <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>

</form>
</div><!-- dabblePageContent -->




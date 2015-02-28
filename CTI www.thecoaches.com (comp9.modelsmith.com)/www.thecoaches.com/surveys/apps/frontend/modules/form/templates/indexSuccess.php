<div id="survey-wrapper">
<h1><?php echo $survey->getTitle() ?></h1>


<form action="<?php echo url_for('form/surveyProcess'); ?>" method="POST" onsubmit="return validateForm(this);" />
<input type="hidden" name="id" value="<?php echo $survey_id ?>" />

<script>
function validateForm(myForm){
   if(<?php echo $survey_id ?> == 2){
     //alert( myForm.elements['question[Q2]'].value );                             
     if(myForm.elements['question[Q2]'].value == ''){
       alert('Please enter the name of the leader who is receiving your feedback');
       return false;
     }
     if(myForm.elements['question[Q3]'].value == ''){
       alert('Please enter your name');
       return false;
     }
     if(myForm.elements['question[Q4]'].value == ''){
       alert('Please enter course date. The date must be in the format shown.');
       return false;
     }
     if(myForm.elements['question[Q5]'].value == ''){
       alert('Please enter course type');
       return false;
     }
     if(myForm.elements['question[Q6]'].value == ''){
       alert('Please enter course location');
       return false;
     }
   }
   return true;
}
</script>
<?php foreach($survey->getQuestionSet() as $q): ?>
<h2><?php echo $q['heading']; ?></h2>

<div class="survey-content"><?php echo $q['content']; ?></div>

<div style="clear:both;">&nbsp;</div>

<?php endforeach; ?>

<!-- submit button here -->
<div class="submit">
<input type="submit" name="survey_submit" value="Submit Survey" />
</div>
</form>

</div>

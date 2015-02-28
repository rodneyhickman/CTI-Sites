<div class="container">
<h1>Survey Results for <?php echo $leader_name ?></h1>
 
<?php foreach($collated_answers as $ca): ?>
<?php
$question           = $ca['question'];
$content            = preg_replace('/<[^>]*>/',' ', $question['content']);
$answers            = $ca['answers'];
$formmatted_answers = @$ca['formatted_answers'];
?>
<div class="question">
<h2><?php echo $question['heading'] ?></h2>
<p><?php echo $content ?></p>


<?php if(count($answers) > 0): ?>
<div class="answer">
   <?php echo $formmatted_answers; ?>
</div>
<?php endif; ?>

</div>

<?php endforeach; ?>


</div>

<pre>
                   <!-- <?php print_r( $collated_answers); ?> -->
<pre>
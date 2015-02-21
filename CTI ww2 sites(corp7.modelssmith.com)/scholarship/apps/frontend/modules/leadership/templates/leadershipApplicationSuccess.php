<h1>CTI Leadership Program Scholarship Application</h1>



<h2>Section A</h2>
<p>&nbsp;</p>
<p><strong>Name:</strong> <?php echo $profile->getFirstName(); ?> <?php echo $profile->getLastName(); ?></p>
 
<p><strong>Email Address:</strong> <?php echo $profile->getEmail1(); ?></p>
 
<p><strong>Permanent Address:</strong><br />
<?php echo $profile->getPermAddress1(); ?><br />
<?php echo $profile->getPermAddress2(); ?><br />
<?php echo $profile->getPermCity(); ?>, <?php echo $profile->getPermStateProv(); ?> <?php echo $profile->getPermZipPostcode(); ?><br />
<?php echo $profile->getPermCountry(); ?></p>
 
<p><strong>Other Address:</strong><br />
<?php if($profile->getOtherAddress1() != ''): ?>
<?php echo $profile->getOtherAddress1(); ?><br />
<?php echo $profile->getOtherAddress2(); ?><br />
<?php echo $profile->getOtherCity(); ?>, <?php echo $profile->getOtherStateProv(); ?> <?php echo $profile->getOtherZipPostcode(); ?><br />
<?php echo $profile->getOtherCountry(); ?>
<?php endif; ?>
</p>
 
<p><strong>Phone:</strong> <?php echo $profile->getTelephone1(); ?></p>
 
<p><strong>Mobile:</strong> <?php echo $profile->getTelephone2(); ?></p>
 
<p><strong>I was referred to the scholarship program by</strong><br />
<?php echo $profile->getReferredBy(); ?></p>


<p>&nbsp;</p>
<h2>Section B: Program Preference</h2>
<p>&nbsp;</p>

<div class="application">

<p><strong>Program Preference:</strong> <?php echo $app->getProgramPreference(); ?></p>

<p><strong>Preferred Date 1:</strong> <?php echo $app->getPreferredDate1(); ?></p>

<p><strong>Preferred Date 2:</strong> <?php echo $app->getPreferredDate2(); ?></p>

<p><strong>Preferred Date 3:</strong> <?php echo $app->getPreferredDate3(); ?></p>

<p><strong>How did you get started with CTI?  What inspired you to take CTI programs?</strong><br /><?php echo $app->getHowStarted(); ?></p>

<p><strong>What impact has your training with CTI had on you?</strong><br /><?php echo $app->getWhatImpact(); ?></p>

<p><strong>Why do you want to take the leadership program?</strong><br /><?php echo $app->getWhyTake(); ?></p>

<p><strong>What's your desired impact in the world? What would you do in the world with the training you received?</strong><!-- ' --><br /><?php echo $app->getDesiredImpact(); ?></p>

<p><strong>How will you be accountable for your impact in the world after you complete the program? How will you report that back to CTI?</strong><br /><?php echo $app->getHowAccountable(); ?></p>

<p><strong>What will you bring to the program?</strong><br /><?php echo $app->getWhatBring(); ?></p>

<p><strong>Why are you applying for the scholarship?</strong><br /><?php echo $app->getWhyApplying(); ?></p>

<p><strong>We want you to have some investment in the program. What size scholarship do you need to make this program possible for you or what percentage discount do you need?</strong><br /><?php echo $app->getWhatSize(); ?></p>

<p><strong>Please tell us about your background and-or attach a resume with your application.</strong><br /><?php echo $app->getBackground(); ?></p>

<p><strong>I have read and understood the Agreements (please insert your initials).</strong> <?php echo $app->getUnderstoodAgreements(); ?></p>





 

</div>

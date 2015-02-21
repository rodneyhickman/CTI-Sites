<h1>CTI Coach Training Program Scholarship Application</h1>

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

<p><strong>Program Preference:</strong> <?php if(preg_match('/full/',$app->getProgramPreference())): ?>I am applying for a scholarship to the full Coach Training Program which will include Core Curriculum courses and the Certification Program.<?php else: ?>I am applying for a scholarship to the Certification Program only.<?php endif; ?></p>

<p><strong>Core Curriculum course location and date, 1st Choice</strong>
<?php echo $app->getCorePreferredDate1(); ?></p>
 
<p><strong>Core Curriculum course location and date, 2nd Choice </strong>
<?php echo $app->getCorePreferredDate2(); ?></p>
 
<p><strong>Core Curriculum course location and date, 3rd Choice </strong>
<?php echo $app->getCorePreferredDate3(); ?></p>
 
<p><strong>Certification Program start month, 1st Choice </strong>
<?php echo $app->getCertPreferredDate1(); ?></p>
 
 
<p><strong>Certification Program start month, 2nd Choice </strong>
<?php echo $app->getCertPreferredDate2(); ?></p>
 
 
<p><strong>Certification Program start month, 3rd Choice </strong>
<?php echo $app->getCertPreferredDate3(); ?></p>
 
 
<p><strong>What had you choose CTI's Coach Training Program? </strong>
<?php echo $app->getWhatChoose(); ?></p>
 
 
<p><strong>Tell us about your Co-Active Coaching Fundamentals course experience. </strong>
<?php echo $app->getFundamentalsExp(); ?></p>
 
 
<p><strong>What's your vision for becoming a Co-Active Coach? What's the impact you want to have in the world? </strong>
<?php echo $app->getYourVision(); ?></p>
 
 
<p><strong>How will CTI training support you in creating your vision? </strong>
<?php echo $app->getHowSupport(); ?></p>
 
 
<p><strong>Why are you applying for the scholarship? </strong>
<?php echo $app->getWhyApplying(); ?></p>
 
 
<p><strong>We want you to have some investment in the program. What size scholarship do you need to make this program possible for you or what percentage discount do you need? </strong>
<?php echo $app->getWhatSize(); ?></p>
 
 
<p><strong>Please tell us about your background and/or attach a resume with your application. </strong>
<?php echo $app->getBackground(); ?></p>
 

<p><strong>Is there anything else you want us to know about you?</strong>
<?php echo $app->getAnythingElse(); ?></p>
 

</div>

<!-- If No Event is selected -->
<?php if ($sf_user->getAttribute('event1') == 'break' && $sf_user->getAttribute('event2') == 'break' && $sf_user->getAttribute('event3') == 'break') : ?>
    <br/>
    <h3>No event is selected.</h3>
    <br/>
<?php endif; ?>
<!-- If Event 1 is selected -->
<?php if($sf_user->getAttribute('event1') == 'continue'): ?>
    <?php if($sf_user->getAttribute('event1_status') == 'REGISTERED_OR_WAITLISTED'): ?>
        <br/>
        <h3>First Choice</h3><br/>
        <h3>Thank You!</h3><br/>
        <p>You have been <?= $sf_user->getAttribute('event1_enrollment_status') ?> in the following course. 
           <?php if(preg_match('/Reg/', $sf_user->getAttribute('event1_enrollment_status'))): ?>
        As an assistant you must arrive one (1) hour early. Please refer to your CTI registration confirmation email for additional information.
           <?php endif; ?>
        <p>

        <p>Name: <b><?= $sf_user->getAttribute('event1_name') ?></b><br />
           Date: <b><?= $sf_user->getAttribute('event1_startdate') ?></b><br />
          <?php if($sf_user->getAttribute('event1_location') != '' && $sf_user->getAttribute('event1_location') != 'Bridge'): ?>
           Location: <b><?= $sf_user->getAttribute('event1_location') ?></b><br />
           <?php endif; ?>

        </p>
    <?php endif; ?>

    <?php if($sf_user->getAttribute('event1_status') == 'ERROR_OCCURED'): ?>
        <br/>
        <h3>First Choice</h3><br/>
        <p>An error has occurred with your account.  Please contact CTI Customer Service at 1-800-691-6008, option 1 for assistance.<p>

        <?php if(sfConfig::get('sf_environment') == 'dev'): ?>
            <p class="alert">
            <?php echo $diagnostics ?>
            </p>
        <?php endif; ?>
    <?php endif; ?>

    <?php if($sf_user->getAttribute('event1_status') == 'ALREADY_REGISTERED'): ?>
        <br/>
        <h3>First Choice</h3><br/>
        <p>You have already registered for this event.<p>

        <?php if(sfConfig::get('sf_environment') == 'dev'): ?>
            <p class="alert">
            <?php echo $diagnostics ?>
            </p>
        <?php endif; ?>
    <?php endif; ?>

    <?php if($sf_user->getAttribute('event1_status') == 'COURSE_NOT_TAKEN'): ?>
        <br/>
        <h3>First Choice</h3><br/>
        <p>You can only register to assist for courses you have completed<p>

        <?php if(sfConfig::get('sf_environment') == 'dev'): ?>
            <p class="alert">
            <?php echo $diagnostics ?>
            </p>
        <?php endif ?>
    <?php endif; ?>

    <?php if($sf_user->getAttribute('event1_status') == 'COURSE_LEVEL_NOT_MATCHED'): ?>
        <br/>
        <h3>First Choice</h3><br/>
        <p>Your course completion level does not match with the level required for assisting the event.  Please contact CTI Customer Service at 1-800-691-6008, option 1.<p>

        <?php if(sfConfig::get('sf_environment') == 'dev'): ?>
            <p class="alert">
            <?php echo $diagnostics ?>
            </p>
        <?php endif; ?>
    <?php endif; ?>
    <hr>
<?php endif; ?>

<!-- If Event 2 is selected -->
<?php if($sf_user->getAttribute('event2') == 'continue'): ?>
    <?php if($sf_user->getAttribute('event2_status') == 'REGISTERED_OR_WAITLISTED'): ?>
        <br/>
        <h3>Second Choice</h3><br/>
        <h3>Thank You!</h3><br/>
        <p>You have been <?= $sf_user->getAttribute('event2_enrollment_status') ?> in the following course. 
           <?php if(preg_match('/Reg/', $sf_user->getAttribute('event2_enrollment_status'))): ?>
        As an assistant you must arrive one (1) hour early. Please refer to your CTI registration confirmation email for additional information.
           <?php endif; ?>
        <p>

        <p>Name: <b><?= $sf_user->getAttribute('event2_name') ?></b><br />
           Date: <b><?= $sf_user->getAttribute('event2_startdate') ?></b><br />
          <?php if($sf_user->getAttribute('event2_location') != '' && $sf_user->getAttribute('event2_location') != 'Bridge'): ?>
           Location: <b><?= $sf_user->getAttribute('event2_location') ?></b><br />
           <?php endif; ?>

        </p>
    <?php endif; ?>

    <?php if($sf_user->getAttribute('event2_status') == 'ERROR_OCCURED'): ?>
        <br/>
        <h3>Second Choice</h3><br/>
        <p>An error has occurred with your account.  Please contact CTI Customer Service at 1-800-691-6008, option 1 for assistance.<p>

        <?php if(sfConfig::get('sf_environment') == 'dev'): ?>
            <p class="alert">
            <?php echo $diagnostics ?>
            </p>
        <?php endif; ?>
    <?php endif; ?>

    <?php if($sf_user->getAttribute('event2_status') == 'ALREADY_REGISTERED'): ?>
        <br/>
        <h3>Second Choice</h3><br/>
        <p>You have already registered for this event.<p>

        <?php if(sfConfig::get('sf_environment') == 'dev'): ?>
            <p class="alert">
            <?php echo $diagnostics ?>
            </p>
        <?php endif; ?>
    <?php endif; ?>

    <?php if($sf_user->getAttribute('event2_status') == 'COURSE_NOT_TAKEN'): ?>
        <br/>
        <h3>Second Choice</h3><br/>
        <p>You can only register to assist for courses you have completed<p>

        <?php if(sfConfig::get('sf_environment') == 'dev'): ?>
            <p class="alert">
            <?php echo $diagnostics ?>
            </p>
        <?php endif ?>
    <?php endif; ?>

    <?php if($sf_user->getAttribute('event2_status') == 'COURSE_LEVEL_NOT_MATCHED'): ?>
        <br/>
        <h3>Second Choice</h3><br/>
        <p>Your course completion level does not match with the level required for assisting the event.  Please contact CTI Customer Service at 1-800-691-6008, option 1.<p>

        <?php if(sfConfig::get('sf_environment') == 'dev'): ?>
            <p class="alert">
            <?php echo $diagnostics ?>
            </p>
        <?php endif; ?>
    <?php endif; ?>
    <hr>
<?php endif; ?>

<!-- If Event 3 is selected -->
<?php if($sf_user->getAttribute('event3') == 'continue'): ?>
    <?php if($sf_user->getAttribute('event3_status') == 'REGISTERED_OR_WAITLISTED'): ?>
        <br/>
        <h3>Third Choice</h3><br/>
        <h3>Thank You!</h3><br/>
        <p>You have been <?= $sf_user->getAttribute('event3_enrollment_status') ?> in the following course. 
           <?php if(preg_match('/Reg/', $sf_user->getAttribute('event3_enrollment_status'))): ?>
        As an assistant you must arrive one (1) hour early. Please refer to your CTI registration confirmation email for additional information.
           <?php endif; ?>
        <p>

        <p>Name: <b><?= $sf_user->getAttribute('event3_name') ?></b><br />
           Date: <b><?= $sf_user->getAttribute('event3_startdate') ?></b><br />
          <?php if($sf_user->getAttribute('event3_location') != '' && $sf_user->getAttribute('event3_location') != 'Bridge'): ?>
           Location: <b><?= $sf_user->getAttribute('event3_location') ?></b><br />
           <?php endif; ?>

        </p>
    <?php endif; ?>

    <?php if($sf_user->getAttribute('event3_status') == 'ERROR_OCCURED'): ?>
        <br/>
        <h3>Third Choice</h3><br/>
        <p>An error has occurred with your account.  Please contact CTI Customer Service at 1-800-691-6008, option 1 for assistance.<p>

        <?php if(sfConfig::get('sf_environment') == 'dev'): ?>
            <p class="alert">
            <?php echo $diagnostics ?>
            </p>
        <?php endif; ?>
    <?php endif; ?>

    <?php if($sf_user->getAttribute('event3_status') == 'ALREADY_REGISTERED'): ?>
        <br/>
        <h3>Third Choice</h3><br/>
        <p>You have already registered for this event.<p>

        <?php if(sfConfig::get('sf_environment') == 'dev'): ?>
            <p class="alert">
            <?php echo $diagnostics ?>
            </p>
        <?php endif; ?>
    <?php endif; ?>

    <?php if($sf_user->getAttribute('event3_status') == 'COURSE_NOT_TAKEN'): ?>
        <br/>
        <h3>Third Choice</h3><br/>
        <p>You can only register to assist for courses you have completed<p>

        <?php if(sfConfig::get('sf_environment') == 'dev'): ?>
            <p class="alert">
            <?php echo $diagnostics ?>
            </p>
        <?php endif ?>
    <?php endif; ?>

    <?php if($sf_user->getAttribute('event3_status') == 'COURSE_LEVEL_NOT_MATCHED'): ?>
        <br/>
        <h3>Third Choice</h3><br/>
        <p>Your course completion level does not match with the level required for assisting the event.  Please contact CTI Customer Service at 1-800-691-6008, option 1.<p>

        <?php if(sfConfig::get('sf_environment') == 'dev'): ?>
            <p class="alert">
            <?php echo $diagnostics ?>
            </p>
        <?php endif; ?>
    <?php endif; ?>
    <hr>
<?php endif; ?>

<p><a href="<?php echo url_for('main/mySchedule') ?>">Return to my schedule</a></p>
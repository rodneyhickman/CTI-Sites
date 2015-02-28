<br/>
<h1>Edit Event</h1>

<p>Event details</p>


<form action="<?php echo url_for('main/editEvent') ?>" method="POST">
   <input type="hidden" name="id" id="event_id" value="<?php echo $event->getId(); ?>"/>
   <table>
        <tr>
            <th><label for="event_name">Event Name</label></th>
            <td><input type="text" name="event_name" id="event_name" value="<?php echo $event->getName(); ?>"/></td>
        </tr>
        <tr>
            <th><label for="event_location">Location</label></th>
            <td><input type="text" name="event_location" id="event_location" value="<?php echo $event->getLocation(); ?>"/></td>
        </tr>
        <tr>
            <th><label for="event_date">Date</label><br><br></th>
            <td><input type="text" name="event_date" id="event_date" value="<?php echo $event->getDate(); ?>"/><br>Date format <strong>yyyy-mm-dd</strong> (eg. 2014-03-20)</td>
        </tr>
        <tr>
            <th><label for="event_time">Time</label></th>
            <td><input type="text" name="event_time" id="event_time" value="<?php echo $event->getTime(); ?>"/></td>
        </tr>
        <tr>
            <th></th>
            <td>
                <input type="submit" name="event_update" value="Update Event" />
            </td>
        </tr>
        <?php if(isset($message)): ?>
        <tr>
          <th></th>
          <td style="color:#f00;"><?php echo $message ?></td>
        </tr>
        <?php endif ?>

  </table>
</form>
<br/>
<br/>
<p>&raquo; <?php echo link_to('Add Event','main/newEvent'); ?></p>

<p>&raquo; <?php echo link_to('Manage Events','main/manageEvents'); ?></p>

<p>&raquo; <?php echo link_to('Go to Homepage','main/index'); ?></p>

<p>&raquo; <?php echo link_to('Sign out','main/logout'); ?></p>
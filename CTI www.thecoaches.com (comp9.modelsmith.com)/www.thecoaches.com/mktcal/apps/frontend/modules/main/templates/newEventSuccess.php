<br/>
<h1>New Event</h1>

<p>Please enter the New Event details</p>

<form action="<?php echo url_for('main/newEvent') ?>" method="POST">
   <table>
        <tr>
            <th><label for="event_name">Event Name</label></th>
            <td><input type="text" name="event_name" id="event_name"/></td>
        </tr>
        <tr>
            <th><label for="event_location">Location</label></th>
            <td><input type="text" name="event_location" id="event_location"/></td>
        </tr>
        <tr>
            <th>
                <label for="event_date">Date</label>
                <br>
                <br>
            </th>
            <td>
                <input type="text" name="event_date" id="event_date"/>
                <br>
                Date format <strong>yyyy-mm-dd</strong> (eg. 2014-03-20)
            </td>
        </tr>
        <tr>
            <th><label for="event_time">Time</label></th>
            <td><input type="text" name="event_time" id="event_time"/></td>
        </tr>        
        <tr>
            <td></td>
            <td>
                <input type="submit" name="event_save" value="Save New Event" />
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
<p>&raquo; <?php echo link_to('Manage Events','main/manageEvents'); ?></p>

<p>&raquo; <?php echo link_to('Go to Homepage','main/index'); ?></p>

<p>&raquo; <?php echo link_to('Sign out','main/logout'); ?></p>
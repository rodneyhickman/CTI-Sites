<h1>Marketing Calendar</h1>

<h2><?php echo $event->getName() ?></h2>

<p><?php echo Date('l M j, Y', strtotime($event->getStartDate()) ) ?><br />

<?php echo $event->getLocationName() ?></p>
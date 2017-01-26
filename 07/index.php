<link rel="stylesheet" type="text/css" href="stylesheet.css" />
<?php

// -------------------------------------
// DO NOT MAKE ANY CHANGES TO THIS FILE!
// -------------------------------------

include('calendar.php'); // <-- make all changes to this file

// 1. create a calendar

// create a new calendar for March 2016
$calendar = new Calendar(3, 2016);


// ----------------------------
// 2. fill calendar with events
// ----------------------------

// load a CSV file of event details
$data=file_get_contents("events.csv");

// split event data into array
$rows=explode("\n",$data);

// loop through event array, create one event class per row
foreach($rows as $row){
   
   // extract data from row
   $arr = str_getcsv($row);
   $title = $arr[0];
   $location = $arr[1];
   $startDateTime = ($arr[2].' '.$arr[3]);
   $endDateTime = ($arr[2].' '.$arr[4]);
   
   // create new Calendar Event
   $event = new CalendarEvent();
   
   // Set Event properties
   $event->setTitle($title);
   $event->setLocation($location);
   $event->setStart($startDateTime);
   $event->setEnd($endDateTime);
   
   // add Event to the Calendar
   $calendar->addEvent($event);

   
}

// ---------------------------
// 3. cancel the Band Practice
// ---------------------------

// get an array of all events with the name "Band Practice"
$array = $calendar->getEventsByName("Band Practice");

// loop through each event & cancel
foreach($array as $event){
   $event->setCancelled(true);
}

// --------------------
// 4. output as a table
// --------------------

echo $calendar->draw();



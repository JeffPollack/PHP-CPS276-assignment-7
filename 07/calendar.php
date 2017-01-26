<?php

/*
 * Homework  7
 * Jeff Pollack
 * Time logged on assignemt: hours 5
 */
include ('CalendarEvent.php');
// Found help with calendar on http://php.about.com/od/finishedphp1/ss/php_calendar.htm#showall
class Calendar extends CalendarEvent
{
    private $month;
    private $year;
    private $events = array();
    /**
     * Construct the month based on month, year
     * 
     * Integer type $month
     * Integer type $year
     */
    public function __construct($month, $year) {
            $this->month = $month;
            $this->year = $year;
    }
    
    // Add the events to array
    public function addEvent($event){
        $this->events[]=$event;
    }
    
    // Draw the HTML calendar
    public function draw(){
        
        // sorting the event dates
        $sf = function($a, $b){
            $startA = $a->getStart();
            $startB = $b->getStart();
            if ($startA == $startB){
                return 0;
            }elseif($startA < $startB){
                return -1;
            }else{
                return 1;
            }
        };
        usort($this->events, $sf);
        
        
        // Did this if statement incase a non number is entered or notthing is entered
        if(is_int($this->month) && is_int($this->year)){
            // http://php.net/manual/en/function.mktime.php
            // Used to find out what the first day of the month is
            $startDay = mktime(0, 0, 0, $this->month, 1, $this->year);
            $monthName = date('F',$startDay);
            // http://php.net/manual/en/function.cal-days-in-month.php
            // Used to count how many days in the month  there are, CAL_GREGORIAN is = to 0 in PHP. found that from the popup in netbeans
            $days_in_month = cal_days_in_month(0, $this->month, $this->year) ;
            $day_of_week = date('l', $startDay); 
            
            // Setting the blank days before the 1st of the month
            switch ($day_of_week){
                case "Sunday": $blankDays=0; break;
                case "Monday": $blankDays=1; break;
                case "Tuesday": $blankDays=2; break;
                case "Wednesday": $blankDays=3; break;
                case "Thursday": $blankDays=4; break;
                case "Friday": $blankDays=5; break;
                case "Saturday": $blankDays=6; break;
            }
            
            //** Dint end up using but keeping incase is needed after changes.
            switch ($this->month){
                case 1: $month = "January"; break;
                case 2: $month = "February"; break;
                case 3: $month = "March"; break;
                case 4: $month = "April"; break;
                case 5: $month = "May"; break;
                case 6: $month = "June"; break;
                case 7: $month = "July"; break;
                case 8: $month = "August"; break;
                case 9: $month = "September"; break;
                case 10: $month = "October"; break;
                case 11: $month = "November"; break;
                case 12: $month = "December"; break;
            }
            //** end the dint use switch
            
            // Drawing the header of the calendar with month and days, not much change since days are always same order
            echo "<table border=1 width=294>";
            echo "<tr><th colspan=7> $monthName $this->year </th></tr>";
            echo "<tr><th width=42>Sunday</th>
                  <th width=42>Monday</th>
                  <th width=42>Tuesday</th>
                  <th width=42>Wednesday</th>
                  <th width=42>Thursday</th>
                  <th width=42>Friday</th>
                  <th width=42>Saturday</th></tr>";
            echo "<tr>";

            // Drawing the blank days before the 1st of the month
            $dayCount=1;
            while($blankDays > 0){ 
                echo "<td></td>"; 
                $blankDays = $blankDays-1; 
                $dayCount++;
            } 

            // Get all the days in the month and draw them where they are supposed to be, 
            // will start on correct day because of the blank days that where put in before.
            $dayNum = 1;
            while($dayNum <= $days_in_month){ 
                echo "<td> $dayNum";
                
                // grabing time stamps for the days to use as references
                $dayStart = mktime(0, 0, 0, $this->month, $dayNum, $this->year);
                $dayEnd = mktime(0, 0, -1, $this->month, $dayNum+1, $this->year);
                // look at ALL events and draw them if the start of the event falls inside the time stamp of the day
                foreach($this->events as $event){
                                        
                    // grabing the start time and 
                    $start=$event->getStart();
                    //$cancelled=$event->getCancelled();
                    if($start>=$dayStart&&$start<$dayEnd){
                        echo "</br>".
                            "Event: ".$event->getTitle().
                            "</br>".
                            "Location: ".$event->getLocation().
                            "</br>".
                            "From: ".date("m/d/Y h:i:s A T",$event->getStart()).
                            "</br>".
                            "Till: ".date("m/d/Y h:i:s A T",$event->getEnd()).
                            "</br>";
                        if($event->getCancelled()==true){
                            echo "This event has been Cancelled";
                        }
                    }
                }
                //close the day and increment the counts for the day and the date number
                echo "</td>";
                $dayNum++; 
                $dayCount++;
                // Draw a new row if more days exist
                if($dayCount > 7){
                    echo "</tr><tr>";
                    $dayCount = 1;
                }
            }

            // finnish out the week with blank <td>
            while($dayCount >1 && $dayCount <=7){ 
                echo "<td> </td>"; 
                $dayCount++; 
            } 
            // Closing the table out after everything is done
            echo "</tr></table>"; 
            // if there is a bad input or notthing entered this message is thrown
        }else{echo"<br> Invalid input, must use integer for month and year </br>";}
        // create if statement for when an event is cancelled?
    }
    
    //Returns and array of events with the specified name
    public function getEventsByName($name){
        foreach($this->events as $event){
            if($event->getTitle()==$name){
                return $event;
            }
        }
    }
    
}

<?php

class CalendarEvent
{
    private $Title;
    private $Location;
    private $Start;
    private $End;
    private $Cancelled;
    
    // Get Title
    public function getTitle(){
        return $this->Title;
    }
    public function setTitle($title){
        $this->Title = $title;
    }
    
    // Get Location
    public function getLocation(){
        return $this->Location;
    }
    public function setLocation($location){
        $this->Location = $location;
    }
    
    // Get Start time
    public function getStart(){
        return $this->Start;
    }
    public function setStart($start){
        $this->Start = strtotime($start);
    }
    
    // Get End Time
    public function getEnd(){
        return $this->End;
    }
    public function setEnd($end){
        $this->End = strtotime($end);
    }
    
    // Get if it is Cancelled
    public function getCancelled(){
        return $this->Cancelled;
    }
    public function setCancelled($cancelled){
        $this->Cancelled = true;
    }
}



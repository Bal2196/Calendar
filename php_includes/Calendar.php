<?php
// Create session to retain data between pages
session_start();

class Calendar {
    // Stores current date
    var $todayDate;
    // Stores currently presented date
    var $selectedDate;
    // Stores textual representation of last month
    var $lastMonth;
    // Stores textual representation of next month
    var $nextMonth;
    // Stores number of days in presented month
    var $daysInMonth;
    
    public function __construct() {
        // Set timezone
        date_default_timezone_set('GMT');
        
        // Set to today's date
        $this->todayDate = date("Y-m-d");
        
        if (!isset($_SESSION['selectedDate'])) {
            // Set to todayDate by default
            $this->selectedDate = $this->todayDate;
            
            // Retain selectedDate as required for month navigation
            $_SESSION['selectedDate'] = $this->selectedDate;
        } else {
            $this->selectedDate = $_SESSION['selectedDate'];
        }
        
        // Set to textual representation of previous month using selectedDate
        $this->lastMonth = date("M", strtotime("last month", $this->getTimestamp($this->selectedDate)));
        // Set to textual representation of next month using selectedDate
        $this->nextMonth = date("M", strtotime("next month", $this->getTimestamp($this->selectedDate)));
        
        // Set to number of days in the month of selectedDate
        $this->daysInMonth = cal_days_in_month(CAL_GREGORIAN, $this->getMonth($this->selectedDate), 
                $this->getYear($this->selectedDate));
    }
    
    // Sets session selectedDate based on the query parameter
    function setSelectedDate($query) {
        // Update session selectedDate using query
        $_SESSION['selectedDate'] = date("Y-m-d", strtotime($query, $this->getTimestamp($this->selectedDate)));
    }
    
    // Echos a full textual representation of the month in selectedDate
    function getSelectedMonth() {
        // Store textual representation of the month using selectedDate
        echo $selectedMonth = date_format(date_create($this->selectedDate), "F");
    }
    
    // Returns a timestamp based on the date parameter
    function getTimestamp($date) {
        return date_format(date_create($date), "U");
    }
    
    // Returns the month based on the date parameter
    function getMonth($date) {
        return date_format(date_create($date), "m");
    }
    
    // Returns the year based on the date parameter
    function getYear($date) {
        return date_format(date_create($date), "Y");
    }
    
    // Returns selectedDate without the day
    function getSelectedDateNoDay() {
        return substr($this->selectedDate, 0, -2);
    }
    
    // Echos lastMonth
    function getLastMonth() {
        echo "< " . $this->lastMonth;
    }
    
    // Echos nextMonth
    function getNextMonth() {
        echo $this->nextMonth . " >";
    }
}

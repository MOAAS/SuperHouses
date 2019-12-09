<?php 
function toHTML($unfilteredString) {
    return htmlspecialchars($unfilteredString);
}

function dateString($date) {
    $day = $date->format('j');
    $monthName = substr($date->format('F'), 0, 3);
    $year = $date->format('Y');
    
    return $monthName . " " . $day . ", " . $year;
}

function monthYearString($date) {
    $monthName = substr($date->format('F'), 0, 3);
    $year = $date->format('Y');        
    return $monthName . " " . $year;
}
?>
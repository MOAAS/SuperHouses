<?php
    class Reservation {
        private $place;
        private $start;
        private $end;
        private $guest;

        private $totalNights;
        
        public function __construct($place, $start, $end, $guest) {
            $this->place = $place;
            $this->start = $start;
            $this->end = $end;
            $this->guest = $guest;

            $startTime = DateTime::createFromFormat('Y-m-d', $this->start);
            $endTime = DateTime::createFromFormat('Y-m-d', $this->end);

            $this->totalNights = $endTime->diff($startTime)->days;
        }

        public function getStartString() {
            $startTime = DateTime::createFromFormat('Y-m-d', $this->start);
            
            $day = $startTime->format('j');
            $monthName = $startTime->format('F');
            $year = $startTime->format('Y');
            
            return $monthName . " " . $day . ", " . $year;
        }

        public function getEndString() {
            $endTime = DateTime::createFromFormat('Y-m-d', $this->end);
            
            $day = $endTime->format('j');
            $monthName = $endTime->format('F');
            $year = $endTime->format('Y');
            
            return $monthName . " " . $day . ", " . $year;
        }

        public function getNights() {
            return $this->totalNights;
        }

        public function getTotalPrice() {
            return $this->place->pricePerDay * $this->getNights();
        }

        public function getPlace() {
            return $this->place;
        }

        public function getGuest() {
            return $this->guest;
        }
    }

?>
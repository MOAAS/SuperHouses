<?php
    class Reservation {
        private $id;
        private $place;
        private $start;
        private $end;
        private $guest;

        private $totalNights;
        
        public function __construct($id, $place, $start, $end, $guest) {
            $this->id = $id;
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
            $monthName = substr($startTime->format('F'), 0, 3);
            $year = $startTime->format('Y');
            
            return $monthName . " " . $day . ", " . $year;
        }

        public function getEndString() {
            $endTime = DateTime::createFromFormat('Y-m-d', $this->end);
            
            $day = $endTime->format('j');
            $monthName = substr($endTime->format('F'), 0, 3);

            $year = $endTime->format('Y');
            
            return $monthName . " " . $day . ", " . $year;
        }

        public function isApproaching() {
            $startTime = DateTime::createFromFormat('Y-m-d', $this->start);
            $endTime = DateTime::createFromFormat('Y-m-d', $this->end);
            $now = (new DateTime());
            return $now->diff($startTime)->days < 3 || $now->diff($endTime)->days < 3;
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

        public function getID() {
            return $this->id;
        }
    }

?>
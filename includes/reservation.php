<?php
    class Reservation {
        private $id;
        private $place;
        private $start;
        private $end;
        private $guest;
        private $pricePerDay;

        private $totalNights;

        public function __construct($id, $pricePerDay, $place, $start, $end, $guest) {
            $this->id = $id;
            $this->pricePerDay = $pricePerDay;
            $this->place = $place;
            $this->start = DateTime::createFromFormat('Y-m-d', $start);
            $this->end = DateTime::createFromFormat('Y-m-d', $end);
            $this->guest = $guest;

            $this->totalNights = $this->end->diff($this->start)->days;
        }

        public function getStartString() {      
            return dateString($this->start);      
        }

        public function getEndString() {
            return dateString($this->end);                  
        }

        public function isApproaching() {
            $now = new DateTime();

            $daysToStart = $now->diff($this->start)->format('%R%a');
            $daysToEnd = $now->diff($this->end)->format('%R%a');

            return ($daysToStart > 0 && $daysToStart < 3) || ($daysToEnd > 0 && $daysToEnd < 3);
        }

        public function isCancellable() {
            $now = new DateTime();
            $daysToStart = $now->diff($this->start)->format('%R%a');

            return $daysToStart >= 3;
        }

        public function hasEnded() {
            $now = new DateTime();
            $daysSinceEnd = $this->end->diff($now)->format('%R%a');
            return $daysSinceEnd >= 0;
        }

        public function hasStarted() {
            $now = new DateTime();
            $daysSinceStart = $this->start->diff($now)->format('%R%a');
            return $daysSinceStart >= 0;
        }

        public function getNights() {
            return $this->totalNights;
        }

        public function getTotalPrice() {
            return $this->pricePerDay * $this->getNights();
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
        
        public function getPricePerDay() {
            return $this->pricePerDay;
        }
    }

?>
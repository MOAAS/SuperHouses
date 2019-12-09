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
            $this->start = DateTime::createFromFormat('Y-m-d', $start);
            $this->end = DateTime::createFromFormat('Y-m-d', $end);
            $this->guest = $guest;

            $this->totalNights = $this->end->diff($this->start)->days;
        }

        public function getStartString() {            
            $day = $this->start->format('j');
            $monthName = substr($this->start->format('F'), 0, 3);
            $year = $this->start->format('Y');
            
            return $monthName . " " . $day . ", " . $year;
        }

        public function getEndString() {
            $day = $this->end->format('j');
            $monthName = substr($this->end->format('F'), 0, 3);

            $year = $this->end->format('Y');
            
            return $monthName . " " . $day . ", " . $year;
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
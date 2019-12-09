<?php
    class Notification {
        private $id;
        private $content;
        private $dateTime;
        
        public function __construct($id, $content, $dateTime) {
            $this->id = $id;
            $this->content = $content;
            $this->dateTime =  DateTime::createFromFormat('Y-m-d H:i:s', $dateTime);
        }

        public function getContent() {
            return $this->content;
        }

        public function getDateString() {
            $day = $this->dateTime->format('j');
            $monthName = substr($this->dateTime->format('F'), 0, 3);
            $year = $this->dateTime->format('Y');            
            return $monthName . " " . $day . ", " . $year;
        }

        public function getID() {
            return $this->id;
        }
    }
?>
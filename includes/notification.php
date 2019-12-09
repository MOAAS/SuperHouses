<?php
    include_once('../includes/htmlcleaner2000.php');
    
    class Notification {
        private $id;
        private $content;
        private $dateTime;
        
        public function __construct($id, $content, $dateTime) {
            $this->id = $id;
            $this->content = $content;
            $this->dateTime =  DateTime::createFromFormat('Y-m-d', $dateTime);
        }

        public function getContent() {
            return $this->content;
        }

        public function getDateString() {
            return dateString($this->dateTime);
        }

        public function getID() {
            return $this->id;
        }
    }
?>
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
            return dateString($dateTime);
        }

        public function getID() {
            return $this->id;
        }
    }
?>
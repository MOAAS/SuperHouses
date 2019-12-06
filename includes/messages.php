<?php
    class UserMessage {
        public $content;
        public $seen;
        public $sendTime;
        public $wasSent;
        public $username;
        public $otherUser;
        
        public function __construct($content, $seen, $sendTime, $wasSent, $username, $otherUser) {
            $this->content = $content;
            $this->seen = $seen;
            $this->sendTime = $sendTime;
            $this->wasSent = $wasSent;
            $this->username = $username;
            $this->otherUser = $otherUser;
        }
    }
?>
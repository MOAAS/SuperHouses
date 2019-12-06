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
            $this->sendTime = $this->makeSendTime($sendTime);
            $this->wasSent = $wasSent;
            $this->username = $username;
            $this->otherUser = $otherUser;
        }

        public function makeSendTime($sendTime) {
            $datetime = DateTime::createFromFormat('Y-m-d H:i:s', $sendTime);
            $now = new DateTime('now');
            
            
            $day = $datetime->format('j');
            $monthName = $datetime->format('F');
            $year = $datetime->format('Y');

            $hours = $datetime->format('H');
            $minutes = $datetime->format('i');
                        
            $diff = $now->diff($datetime);

            if ($diff->y > 0 || $diff->m > 0 || $diff->d > 1)
                return $day . " of " . $monthName . ", " . $year;
            if ($diff->d == 1)
                return "Yesterday at " . $hours . ':' . $minutes;
            else return $hours . ':' . $minutes;
        }
    }
?>
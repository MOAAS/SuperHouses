<?php
    class UserInfo {
        public $username;
        public $displayname;
        public $country;
        public $city;
        
        public function __construct($username, $displayname, $country, $city) {
            $this->username = $username;
            $this->displayname = $displayname;
            $this->country = $country;
            $this->city = $city;
        }
    }
?>
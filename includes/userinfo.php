<?php
    class UserInfo {
        public $username;
        public $displayname;
        public $country;
        public $city;
        public $profilePic;
        
        public function __construct($username, $displayname, $country, $city, $profilePic) {
            $this->username = $username;
            $this->displayname = $displayname;
            $this->country = $country;
            $this->city = $city;
            $this->profilePic = $profilePic;
        }
    }
?>
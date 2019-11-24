<?php
    class Place {
        public $place_id;
        public $country;
        public $city;
        public $address;
        public $owner;
        public $title;
        public $description;
        public $price;
        
        public function __construct($place_id, $country, $city, $address, $owner, $title, $description, $price) {
            $this->place_id = $place_id;
            $this->country = $country;
            $this->city = $city;
            $this->address = $address;
            $this->owner = $owner;
            $this->title = $title;
            $this->description = $description;
            $this->price = $price;
        }
    }
?>
<?php
    class Place {
        public $place_id;
        public $country;
        public $city;
        public $address;
        public $ownerUsername;
		public $ownerDisplayname;
        public $title;
        public $description;
        public $pricePerDay;
        public $capacity;
        public $numRooms;
        public $numBeds;
        public $numBathrooms;
        
        public function __construct($place_id, $country, $city, $address, $ownerUsername, $ownerDisplayname, $title, $description, $pricePerDay, $capacity, $numRooms, $numBeds, $numBathrooms) {
            $this->place_id = $place_id;
            $this->country = $country;
            $this->city = $city;
            $this->address = $address;
            $this->ownerUsername = $ownerUsername;
			$this->ownerDisplayname = $ownerDisplayname;
            $this->title = $title;
            $this->description = $description;
            $this->pricePerDay = $pricePerDay;
            $this->capacity = $capacity;
            $this->numRooms = $numRooms;
            $this->numBeds = $numBeds;
            $this->numBathrooms = $numBathrooms;
        }

        public function getLocationString() {
            return $this->city . ", " . $this->country;
        }

        public function capacityString() {
            if ($this->capacity == 1)
                return "1 guest";
            return $this->capacity . " guests";
        }

        public function numBedsString() {
            if ($this->numBeds == 1)
                return "1 bed";
            return $this->numBeds . " beds";
        }

        public function numBedroomsString() {
            if ($this->numRooms == 1)
                return "1 bedroom";
            return $this->numRooms . " bedrooms";
        }

        public function numBathroomsString() {
            if ($this->numBathrooms == 1)
                return "1 bathroom";
            return $this->numBathrooms . " bathrooms";
        }
    }
?>
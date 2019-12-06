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
        public $minPeople;
        public $maxPeople;
        
        public function __construct($place_id, $country, $city, $address, $ownerUsername, $ownerDisplayname, $title, $description, $pricePerDay, $minPeople, $maxPeople) {
            $this->place_id = $place_id;
            $this->country = $country;
            $this->city = $city;
            $this->address = $address;
            $this->ownerUsername = $ownerUsername;
			$this->ownerDisplayname = $ownerDisplayname;
            $this->title = $title;
            $this->description = $description;
            $this->pricePerDay = $pricePerDay;
            $this->minPeople = $minPeople;
            $this->maxPeople = $maxPeople;
        }

        public function getLocationString() {
            return $this->city . ", " . $this->country;
        }
    }
?>
<?php

class Map_model extends CI_Model {

	private $survei;

	public function __construct()
	{

		parent::__construct();
	}

	public function setSurvei($survei){

		$this->survei = $survei;
	}

	public function getAllPins(){

		$dataSurvei = $this->survei->getData();
		$location = array();
		foreach ($dataSurvei as $row) {

			array_push($location, $row['location']);
		}
		$location = json_encode($this->locsEncode($location));
		// $location = str_replace('"', "", $location);

		return $location;
	}

	// encode for leaflet markers -> [[lat1,lon1],[lat2,lon2],...]
	private function locsEncode($arr){

		$arrNew = array();

		foreach ($arr as $row) {

			$parts = explode(" ", $row);
			$lat = $parts[0];
			$lon = $parts[1];
			array_push($arrNew, array((float)$lat, (float)$lon));
		}

		return $arrNew;
	}

}
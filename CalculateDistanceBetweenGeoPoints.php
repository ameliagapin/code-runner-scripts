<?php

$usage = 'Usage:' . PHP_EOL . '  CalculateDistanceBetweenGeoPoints.php <latitude1> <longitude1> <latitude2> <longitude2> [units]';

// Get command line arguments
$lat1 = $argv[1];
$lon1 = $argv[2];
$lat2 = $argv[3];
$lon2 = $argv[4];
$unit = $argv[5] ? $argv[5] : 'miles';

if (
	!$lat1
	|| !$lon1
	|| !$lat2
	|| !$lon2
) {
	echo 'Missing arguments. ' . $usage . PHP_EOL;
	die;
}

// init GeoPoint objects
$point1 = new GeoPoint($lat1, $lon1);
$point2 = new GeoPoint($lat2, $lon2);

// Calculate distance
$distance = getDistanceBetweenPoints($point1, $point2, $unit);

// Output result
echo $distance . ' ' . $unit . PHP_EOL;

function getDistanceBetweenPoints($geo_point_1, $geo_point_2, $unit = 'miles')
{
	$theta = $geo_point_1->getLongitude() - $geo_point_2->getLongitude();

	$dist = sin(deg2rad($geo_point_1->getLatitude()))
		* sin(deg2rad($geo_point_2->getLatitude()))
		+ cos(deg2rad($geo_point_1->getLatitude()))
		* cos(deg2rad($geo_point_2->getLatitude()))
		* cos(deg2rad($theta));

	$dist = acos($dist);
	$dist = rad2deg($dist);
	$miles = $dist * 60 * 1.1515;

	if ($unit == 'km') {
		return ($miles * 1.609344);
	} else {
		return $miles;
	}
}

class GeoPoint
{
	private $lat = false;
	private $lon = false;
	
	public function __construct($lat, $lon)
	{
		$this->lat = $lat;
		$this->lon = $lon;
	}
	
	public function getLatitude()
	{
		return $this->lat;
	}
	
	public function getLongitude()
	{
		return $this->lon;
	}
}
?>
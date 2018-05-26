<?php
require_once ("FatchData.php");
use Lastfm\src\FatchData;
$clsFatchData = new FatchData();
$CountryName=$_POST['countryName'];
$clsFatchData->setCountryName($CountryName);
$responseBody=$clsFatchData->searchCountry();
echo $responseBody;
?>
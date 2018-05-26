<?php
require_once ("FatchData.php");
use Lastfm\src\FatchData;
$clsFatchData = new FatchData();
$ArtistName=$_POST['artistName'];
$clsFatchData->setArtistName($ArtistName);
$responseBody=$clsFatchData->getTopTracksByArtist();
echo $responseBody;
?>

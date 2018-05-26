<?php
include ("src/FatchData.php");
use Lastfm\src\FatchData;
class FatchDataTest extends PHPUnit_Framework_TestCase
{
    protected $_fatchData;

    public function setUp() {
        parent::setUp();

        $this->_fatchData = new FatchData();
    }
    public function testGetGeoSearchUrl()
    {
        $this->_fatchData->setCountryName("canada");
        $expected="http://ws.audioscrobbler.com/2.0/?method=geo.gettopartists&country=canada&api_key=ecf6927751fa4d74b943a809abf91015&format=json";
        $this->assertEquals($expected,$this->_fatchData->getGeoSearchUrl());
    }

    public function textGetTopTracksUrl()
    {
        $this->_fatchData->setArtistName("cher");
        $expected="http://ws.audioscrobbler.com/2.0/?method=artist.gettoptracks&artist=cher&api_key=ecf6927751fa4d74b943a809abf91015&format=json";
        $this->assertEquals($expected,$this->_fatchData->getTopTracksUrl());
    }
}


?>
<?php 
namespace Lastfm\src;
class FatchData {
	// lastfm base url
	const API_BASE_URL='http://ws.audioscrobbler.com/2.0/?';
	// when you search by country you need to add this after base url
	const API_GEO_COUNTRY_PARRAM='method=geo.gettopartists&country=';
    // when you search by artist you need to add this after base url
    const API_TOP_TRACKS_PARRAM='method=artist.gettoptracks&artist=';
	// API key
	const API_KEY='ecf6927751fa4d74b943a809abf91015';
	// API Output format
	const API_FORMAT='json';
	// countryName to store a country name
	protected $_countryName = 'Spain';
	// artistName to store a artist name
    protected $_artistName = 'Spain';
    // set country name
	public function setCountryName($CountryName)
    {
        $this->_countryName=$CountryName;
    }

    /**
     * @return string
     */
    public function getCountryName()
    {
        return $this->_countryName;
    }

    /**
     * @return string
     */
    public function getArtistName()
    {
        return $this->_artistName;
    }

    /**
     * @param string $artistName
     */
    public function setArtistName($artistName)
    {
        $this->_artistName = $artistName;
    }

    // get api url where we can search by country for artists list
    public function getGeoSearchUrl()
	{
		$countrySearchUrl=self::API_BASE_URL.self::API_GEO_COUNTRY_PARRAM.$this->getCountryName()."&api_key=".self::API_KEY."&format=".self::API_FORMAT;
		return $countrySearchUrl;
	}

    // get api url where we can search by artist for top tracks list
    public function getTopTracksUrl()
    {
        $topTrackUrl=self::API_BASE_URL.self::API_TOP_TRACKS_PARRAM.$this->getArtistName()."&api_key=".self::API_KEY."&format=".self::API_FORMAT;
        return $topTrackUrl;
    }

	// Get all artist list by using country name
	public function searchCountry()
	{
        $geoSearchUrl=$this->getGeoSearchUrl() ;
        $artistListResult=$this->getApiResult($geoSearchUrl);
        return $artistListResult;
	}

	// search by artist to get all top tracks list
	public function getTopTracksByArtist()
	{
        $topTrackUrl=$this->getTopTracksUrl();
        $topTrackResult=$this->getApiResult($topTrackUrl);
        return $topTrackResult;
	}

	// call api and get output

    public function getApiResult($apiUrl)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$apiUrl );
        curl_setopt($ch, CURLOPT_POST, 1);// set post data to true
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close ($ch);
        return $result;
    }


}
?>

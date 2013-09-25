<?php

//
// BandColours
//

class LastFm{
	protected $key;
	protected $domain;
	protected $artistSearchUrl;
	protected $tagSearchUrl;

	public function __construct(){
		$this->key = "03337138fe5149f05088428490c33f0b";
		$this->domain = "http://ws.audioscrobbler.com/2.0/?api_key=".$this->key;
		$this->artistSearchUrl = $this->domain."&method=artist.search&limit=100"; 
		$this->tagSearchUrl = $this->domain."&method=artist.getTags"; 
		// http://ws.audioscrobbler.com/2.0/?method=artist.getTags&artist=Red%20Hot%20Chili%20Peppers&user=RJ&api_key=03337138fe5149f05088428490c33f0b
	}

	public function searchArtist($term){
		if($term == '')
			return;
		$artists = new SimpleXMLElement(
			$this->fetch($this->artistSearchUrl."&artist=".urlencode($term)));
		print_r($artists);
	}

	public function getArtistTags($artist){
		if($artist == '')
			return;
		$tags = new SimpleXMLElement($this->fetch($this->tagSearchUrl));
		print_r($tags);
	}
	
	protected function fetch($url){
			$ch = curl_init();
			$timeout = 5;
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
			$data = curl_exec($ch);
			curl_close($ch);
			return $data;
	}
}

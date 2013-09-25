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
		$this->artistSearchUrl = $this->domain."&method=artist.search"; 
		$this->tagSearchUrl = $this->domain."&method=artist.gettoptags"; 
		// http://ws.audioscrobbler.com/2.0/?method=artist.getTags&artist=Red%20Hot%20Chili%20Peppers&user=RJ&api_key=03337138fe5149f05088428490c33f0b
	}

	public function searchArtist($term){
		$artistArray = array();
		if($term == '')
			return;
		$page=0;
		while(count($artistArray)<100){
			$artists = new SimpleXMLElement(
				$this->fetch($this->artistSearchUrl.
					"&artist=".urlencode($term).
					"&page={$page}"));
			$page++;
			foreach($artists->results->artistmatches->artist as $artist){
				$artistArray[] = $artist->name;
			}
		}
		return $artistArray;
	}

	public function getArtistTags($artist){
		$tagArray = array();
		if($artist == '')
			return;
		$tags = new SimpleXMLElement(
			$this->fetch($this->tagSearchUrl.
				"&artist=".urlencode($artist).
				"&limit=5"));
		foreach($tags->toptags->tag as $tag){
			if(count($tagArray) ==5)
				break;
			if($tag->count > 0)
				$tagArray[] = $tag->name;
		}
		return $tagArray;
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

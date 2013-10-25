<?php

include_once("class.php");
$outfile = "./output.txt";
/*
if(file_exists($outfile)){
	$array = unserialize(file_get_contents($outfile));
	foreach($array as $k=>$v){
		arsort($v);
		$out[$k] = array_slice($v, 0, 5);
	}
	print_r($out);
	exit(0);
}
*/

$lastfm = new LastFm();
$lastfm->setNumberOfArtists(100);
$lastfm->setNumberofTags(5);
$colourArray = array();

$colours = array("red", "orange", "yellow", "green", "blue",
 	"indigo", "violet", "white", "grey", "black");
				
$ignoreTags = array("All", "under 2000 listeners");			

foreach($colours as $colour){
	foreach($lastfm->searchArtist($colour) as $artist){
		if(count($colourArray[$colour]['artists']) <10)
			$colourArray[$colour]['artists'][] = $artist;
		foreach($lastfm->getArtistTags($artist) as $tag){
			if(in_array($tag, $ignoreTags))
				continue;
			$colourArray[$colour]['tags'][(string)$tag]++;
		}
	}
	sleep(1);
}

foreach($colourArray as $k=>$v){
	arsort($v);
	$colourArray[$k] = array_slice($v, 0, 5);
}
print_r($colourArray);
file_put_contents($outfile, serialize($colourArray));

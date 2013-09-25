<?php

include_once("functions.php");
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

$colours = array("red",
				"orange",
				"yellow",
				"green",
				"blue",
				"indigo",
				"violet",
				"white",
				"grey",
				"black");

foreach($colours as $colour){
	foreach($lastfm->searchArtist($colour) as $artist){
		echo $artist."\n";
		foreach($lastfm->getArtistTags($artist) as $tag){
//			print_r((string)$tag);
			$colourArray[$colour][(string)$tag]++;
		}
//		sleep(1);
	}
}

foreach($colourArray as $k=>$v){
	arsort($v);
	$colourArray[$k] = array_slice($v, 0, 5);
}
print_r($colourArray);
file_put_contents($outfile, serialize($colourArray));

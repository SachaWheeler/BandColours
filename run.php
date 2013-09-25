<?php

include_once("functions.php");

$lastfm = new LastFm();

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
		print_r($lastfm->getArtistTags($artist));
		sleep(1);
	}
}
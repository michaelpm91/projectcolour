<?php

require '../vendor/autoload.php';

Dotenv::load("../");


$lastfm = new \Dandelionmood\LastFm\LastFm( $_ENV['LAST_FM_API_Key'], $_ENV['LAST_FM_API_Secret'] );

$pink_floyd = $lastfm->artist_getInfo(
    array(
        'artist' => 'Pink Floyd'
    )
);

print_r($pink_floyd);
    
    
?>
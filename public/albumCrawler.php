<?php
/**
 * Created by PhpStorm.
 * User: pattem92
 * Date: 24/02/2015
 * Time: 14:15
 */

//set_time_limit(10);

use League\ColorExtractor\Client as ColorExtractor;

require 'import_functions.php';

function crawl($limit = 1000, $genre){
    global $lastfm;

    $albums = $lastfm->tag_getTopAlbums(
        array(
            'tag' => $genre,//Genre
            'limit' => $limit
        )
    );

    foreach($albums->topalbums->album as $album){

        $album_info = $lastfm->album_getInfo(
            array(
                //'mbid' => $album->mbid
                'artist' => $album->artist->name,
                'album' => $album->name
            )
        );
        $hexcode = getImageAverageColour(find_large_image_url($album_info->album->image));
        //print_r($album_info);
        insert_album($album_info, $hexcode);
    }


}

function getImageAverageColour($url){

    $client = new ColorExtractor;
    $ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));
    echo $ext;
    if($ext == 'jpg' || $ext == 'jpeg') {
        $image = $client->loadJpeg($url);
    }else if($ext == 'png'){
        $image = $client->loadPng($url);
    }else if($ext == 'gif'){
        $image = $client->loadGif($url);
    }
    return $image->extract()['0'];
}

crawl(10, 'blues');
<?php
/**
 * Created by PhpStorm.
 * User: pattem92
 * Date: 24/02/2015
 * Time: 14:15
 */

set_time_limit(120);

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
    file_put_contents('output_'.date('d-m-Y---h_i_s').'.json', json_encode($albums));

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
        $imageHex = $client->loadJpeg($url)->extract()['0'];
    }else if($ext == 'png'){
        $filename = rand(1,10000000000000).'.png';
        file_put_contents($filename, file_get_contents($url));
        exec('convert -strip /Users/pattem92/hackday/projectcolour/public/'.$filename.' /Users/pattem92/hackday/projectcolour/public/'.$filename);
        $imageHex = $client->loadPng($filename)->extract()['0'];

    }else if($ext == 'gif'){
        $imageHex = $client->loadGif($url)->extract()['0'];
    }
    //return $image->extract()['0'];
    return $imageHex;
}

crawl(100, 'folk');
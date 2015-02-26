<?php
/**
 * Created by PhpStorm.
 * User: pattem92
 * Date: 24/02/2015
 * Time: 12:08
 */

require '../vendor/autoload.php';

Dotenv::load("../");

use League\ColorExtractor\Client as ColorExtractor;


function getImageUrl(){

    return "http://static.deathandtaxesmag.com/uploads/2014/05/weezer-blue-album-1994.jpg";
}

function setImageAverageColour($hex){
    return true;
}

function getImageAverageColour(){
    $client = new ColorExtractor;
    $image = $client->loadJpeg(getImageUrl());
    setImageAverageColour($image->extract()['0']);

}

getImageAverageColour();
<?php

require '../vendor/autoload.php';

Dotenv::load("../");


$lastfm = new \Dandelionmood\LastFm\LastFm( $_ENV['LAST_FM_API_Key'], $_ENV['LAST_FM_API_Secret'] );

$pink_floyd = $lastfm->artist_getInfo(
    array(
        'artist' => 'Pink Floyd'
    )
);

$file_db = new PDO('sqlite:colour.sqlite3');


// Inserts Last.fm artist
// Return value: artist id
function insert_lastfm_artist($artist) {
    
    global $file_db;
            
    $insert = "INSERT INTO artists (name, mbid) 
                VALUES (:name, :mbid)";
    $stmt = $file_db->prepare($insert);

    $stmt->bindValue(':name', $artist->artist->name);
    $stmt->bindValue(':mbid', $artist->artist->mbid);
    
    $stmt->execute();
    
    return $file_db->lastInsertId();
}

// Find artist in database. If not present, inserts artist
// Return value: artist id
function find_or_insert_artist($artist_name) {
    global $file_db;
    
    $result = $file_db->query('SELECT * FROM artists WHERE name = "' . $artist_name . '"' )->fetchAll();
    
    if (sizeof($result) > 0) {
        return $result['0']['id'];
    } else {
        $artist = $lastfm->artist_getInfo(
            array(
                'artist' => $artist_name
            )
        );
        return insert_lastfm_artist($artist);
    }
}

// Find genre in database. If not present, inserts genre
// Return value: genre id
function find_or_insert_genre($genre_name) {
    global $file_db;
    
    $result = $file_db->query('SELECT * FROM genre WHERE title = "' . $genre_name . '"' )->fetchAll();
    
    if (sizeof($result) > 0) {
        return $result['0']['id'];
    } else {
        $genre = $lastfm->tag_getInfo(
            array(
                'tag' => $genre_name
            )
        );
        return insert_lastfm_genre($genre);
    }
}

// Inserts Last.fm album
// Return value: album id
function insert_lastfm_album($album) {
    
    global $file_db;
            
    // Get artist
    $artist_id = find_or_insert_artist($album->album->artist);
                
    $insert = "INSERT INTO albums (title, artist_name, artist_id, release_date, mbid, image_url, hex_value) 
                VALUES (:title, :artist_name, :artist_id, :release_date, :mbid, :image_url, :hex_value)";
    $stmt = $file_db->prepare($insert);

    $stmt->bindValue(':title', $album->album->name);
    $stmt->bindValue(':artist_name', $album->album->artist);
    $stmt->bindValue(':artist_id', $artist_id);
    $stmt->bindValue(':release_date', $album->album->releasedate);
    $stmt->bindValue(':mbid', $album->album->mbid);
    $stmt->bindValue(':image_url', find_large_image_url($album->album->image));
    $stmt->bindValue(':hex_value', '');
    
    $stmt->execute();
    
    return $file_db->lastInsertId();
}

function find_large_image_url($images) {
    foreach ($images as $image) {
        if ($image->size == "large") return $image->{'#text'};
    }
    return null;
}

//$result = find_or_insert_artist("Pink Floyd");

$pink_floyd = $lastfm->album_getInfo(
    array(
        'album' => 'Believe',
        'artist' => 'Cher'
    )
);



print_r($pink_floyd);
    
?>
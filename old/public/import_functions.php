<?php

require '../vendor/autoload.php';

Dotenv::load("../");


$lastfm = new \Dandelionmood\LastFm\LastFm( $_ENV['LAST_FM_API_Key'], $_ENV['LAST_FM_API_Secret'] );

$file_db = new PDO('sqlite:' . $_ENV['DATABASE_PATH']);


// Inserts Last.fm artist
// Return value: artist id
function insert_lastfm_artist($artist, $file_db) {
                
    $insert = "INSERT INTO artists (name, mbid) 
                VALUES (:name, :mbid)";
    $stmt = $file_db->prepare($insert);

    $stmt->bindValue(':name', $artist->artist->name);
    $stmt->bindValue(':mbid', $artist->artist->mbid);
    
    $stmt->execute();
    
    return $file_db->lastInsertId();
}

// Inserts Last.fm genre
// Return value: genre id
function insert_lastfm_genre($genre, $file_db) {
                
    $insert = "INSERT INTO genres (title, blurb) VALUES (:name, :blurb)";
    $stmt = $file_db->prepare($insert);
    
    $stmt->bindValue(':name', $genre->tag->name);

    $content = isset($genre->tag->wiki->content) ? $genre->tag->wiki->content : " ";
    $stmt->bindValue(':blurb', $content);
    
    $stmt->execute();
    
    return $file_db->lastInsertId();
}

// Find artist in database. If not present, inserts artist
// Return value: artist id
function find_or_insert_artist($artist_name, $file_db) {
    
    $lastfm = new \Dandelionmood\LastFm\LastFm( $_ENV['LAST_FM_API_Key'], $_ENV['LAST_FM_API_Secret'] );
    
    $result = $file_db->query('SELECT * FROM artists WHERE name = "' . $artist_name . '"' )->fetchAll();
    
    if (sizeof($result) > 0) {
        return $result['0']['id'];
    } else {
        $artist = $lastfm->artist_getInfo(
            array(
                'artist' => $artist_name
            )
        );
        return insert_lastfm_artist($artist, $file_db);
    }
}

// Find genre in database. If not present, inserts genre
// Return value: genre id
function find_or_insert_genre($genre_name, $file_db) {
    
    $lastfm = new \Dandelionmood\LastFm\LastFm( $_ENV['LAST_FM_API_Key'], $_ENV['LAST_FM_API_Secret'] );
    
    $result = $file_db->query('SELECT * FROM genres WHERE title = "' . $genre_name . '"' )->fetchAll();
        
    if (sizeof($result) > 0) {
        return $result['0']['id'];
    } else {
        $genre = $lastfm->tag_getInfo(
            array(
                'tag' => $genre_name
            )
        );
        return insert_lastfm_genre($genre, $file_db);
    }
}

// Inserts Last.fm album
// Return value: album id
function insert_lastfm_album($album, $hex_value, $file_db) {
    
    // Get artist
    $artist_id = find_or_insert_artist($album->album->artist, $file_db);
                
    $insert = "INSERT INTO albums (title, artist_name, artist_id, release_date, mbid, image_url, hex_value) 
                VALUES (:title, :artist_name, :artist_id, :release_date, :mbid, :image_url, :hex_value)";
    $stmt = $file_db->prepare($insert);

    $stmt->bindValue(':title', $album->album->name);
    $stmt->bindValue(':artist_name', $album->album->artist);
    $stmt->bindValue(':artist_id', $artist_id);
    $stmt->bindValue(':release_date', $album->album->releasedate);
    $stmt->bindValue(':mbid', $album->album->mbid);
    $stmt->bindValue(':image_url', find_large_image_url($album->album->image));
    $stmt->bindValue(':hex_value', $hex_value   );
    
    $stmt->execute();
    
    $album_id = $file_db->lastInsertId();
    
    // Get genres
    foreach($album->album->toptags->tag as $tag) {
        $genre_id = find_or_insert_genre($tag->name, $file_db);

        $insert = "INSERT INTO albums_genres (album_id, genre_id)
                    VALUES (:album_id, :genre_id)";
        $stmt = $file_db->prepare($insert);

        $stmt->bindValue(':album_id', $album_id);
        $stmt->bindValue(':genre_id', $genre_id);

        $stmt->execute();
    }
    
    return $album_id;
}

function find_large_image_url($images) {
    foreach ($images as $image) {
        if ($image->size == "large") return $image->{'#text'};
    }
    return null;
}

function insert_album($album, $hex_value) {
    global $file_db;
    if($hex_value != 'skip') {
        insert_lastfm_album($album, $hex_value, $file_db);
    }
}
    
?>
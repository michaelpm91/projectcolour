<?php
 
  // Set default timezone
  date_default_timezone_set('UTC');
 
  try {
    /**************************************
    * Create databases and                *
    * open connections                    *
    **************************************/
 
    // Create (connect to) SQLite database in file
    $file_db = new PDO('sqlite:colour.sqlite3');
    // Set errormode to exceptions
    $file_db->setAttribute(PDO::ATTR_ERRMODE, 
                            PDO::ERRMODE_EXCEPTION);
 

    /**************************************
    * Create tables                       *
    **************************************/
 
    // Create table messages
    $file_db->exec("CREATE TABLE IF NOT EXISTS albums (
                    id INTEGER PRIMARY KEY, 
                    title TEXT, 
                    artist_name TEXT,
                    artist_id INTEGER,
                    release_date TEXT,
                    mbid TEXT,
                    image_url TEXT,
                    hex_value TEXT)");
 
    $file_db->exec("CREATE TABLE IF NOT EXISTS artists (
                    id INTEGER PRIMARY KEY, 
                    name TEXT, 
                    mbid TEXT)");

    $file_db->exec("CREATE TABLE IF NOT EXISTS genres (
                    id INTEGER PRIMARY KEY, 
                    tite TEXT, 
                    blurb TEXT)");

    $file_db->exec("CREATE TABLE IF NOT EXISTS albums_genres (
                    id INTEGER PRIMARY KEY, 
                    album_id INT, 
                    genre_id INT)");

   // Close file db connection
    $file_db = null;
  }
  catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  }
?>
 
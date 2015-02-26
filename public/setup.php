<?php
 
  require '../vendor/autoload.php';

  Dotenv::load("../");

  // Set default timezone
  date_default_timezone_set('UTC');
 
 
  try {
    /**************************************
    * Create databases and                *
    * open connections                    *
    **************************************/
 
    // Create (connect to) SQLite database in file
    $db_directory = dirname($_ENV['DATABASE_PATH']);
    if (!is_dir($db_directory)) {
        mkdir($db_directory);
    }
    $file_db = new PDO('sqlite:' . $_ENV['DATABASE_PATH']);
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
                    title TEXT, 
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
 
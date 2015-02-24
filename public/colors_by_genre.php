<?php
    
require '../vendor/autoload.php';
    
if (isset($_GET['genre']) && $_GET['genre']) {
    
    $file_db = new PDO('sqlite:colour.sqlite3');

    $colors = array();

    $genre = $file_db->query('SELECT genres.id FROM genres WHERE genres.title = "' . htmlentities($_GET['genre']) . '"' )->fetchAll();
    
    if (sizeof($genre) > 0) {
        $genre_id = $genre['0']['id'];
        
        $albums = $file_db->query('SELECT albums.*, albums_genres.* FROM albums, albums_genres WHERE albums_genres.album_id = albums.id AND albums_genres.genre_id = ' . $genre_id . ' ORDER BY release_date ASC, hex_value ASC');
        
        foreach ($albums as $album) {
            $color = sanitize_hex($album['hex_value']);
            if ($color) {
                $colors[] = "#" . $color;
            }
        }
    }    
}

function sanitize_hex($hex) {
    return preg_replace('/#+/', '', $hex);
}

header('Content-Type: application/json');
echo json_encode(array("colors" => $colors));
    
?>
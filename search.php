<?php
session_start();

$song_search = $_POST["song_search"];
echo  $_POST["song_search"];
$_SESSION["song_value_search"] =$song_search;

?>


<style>
<?php include 'style.css'; ?>
</style>


<?php


$xml = new domdocument();
$xml->load("songs.xml");


$songs = $xml->getElementsByTagName("song");

$output = ""; 
foreach($songs as $song){


    $songNo = $song->getAttribute("song_code");
    $songTitle = $song->getElementsByTagName("title")[0]->nodeValue;
    $songGenre = $song->getElementsByTagName("genre")[0]->nodeValue;
    $songAlbum = $song->getElementsByTagName("album")[0]->nodeValue;

    $singersTemp = $song->getElementsByTagName("singer");
    $songSingersArray = [];
    foreach($singersTemp as $singer){
        $songSingers = $singer->nodeValue;
        $songSingersArray[] = $songSingers;
        
    
    }
    
    if (stripos($songNo, $song_search) !== false ||
    stripos($songTitle, $song_search) !== false ||
    stripos($songGenre, $song_search) !== false ||
    stripos($songAlbum, $song_search) !== false ||
    in_array(strtolower($song_search), array_map('strtolower', $songSingersArray)) ||
    stripos(implode(", ", $songSingersArray), $song_search) !== false) {

    // Construct HTML table row
    $output .= "<tr>
                    <td> $songNo </td>
                    <td> $songTitle </td>
                    <td> $songGenre </td>
                    <td> $songAlbum </td>
                    <td> " . implode(", ", $songSingersArray) . "</td>

                    <td>

                    <div class = 'action_button'>
                    <form action='delete.php' method='post'>
                    <input type='hidden' name='song_value_code' value='" . $_SESSION['song_value_code'] . "'>
                    <a href='delete.php'><button class='delete_button'>Delete</button></a>
                </form>
                
                <form action='update.php' >
                <input type='hidden' name='song_value_code' value='" . $_SESSION['song_value_code'] . "'>
                
                <a href='update.php'><button class='update_button'>Update</button></a>
                </form>
                
                </div>
                
                    </td>
                </tr>";
}

   
    
}
echo "<table class='song-table'>
<tr>
    <th> Song Code </th>
    <th> Title </th>
    <th> Genre </th>
    <th> Album </th>
    <th> Singers </th>
    <th> Action </th>
</tr> $output </table>";



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<!-- REQUEST SESSION GET ,SET -->
    
<div class="head">
    <a href="create.php"><button class="add_button">+ Add New Record</button></a>
    <form action="search.php" method="post">
        Search
        <input type="text" name="song_search" placeholder="Search" value="<?php echo $song_search?>">
        
        <input type="submit" value="Search">
    </form>
</div>
</body>
</html>
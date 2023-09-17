<?php
    include_once('storage.php');
    $stor = new Storage(new JsonIo('db/playlists.json'));
    
    $name = urldecode($_GET['name']) ?? -1;
    
    if ($name == -1){
        header('location: index.php');
        exit();
    }

    $playlist   = $stor -> findOne(['name' => $name]);
    $tracklists = json_decode(file_get_contents('db/tracks.json'), true);
    
    $result = [];
    $playsum = 0;

    foreach ($playlist['tracks'] as $track) {
        $result[] = $tracklists[$track];
    }

    foreach($result as $e){
        $playsum += $e['length'];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Details</title>
</head>
<body>

    <div>
        <h1> <?= $playlist['name'] ?> </h1>
        <span>Total playing time: <?=$playsum?> </span>
    </div>

    <div>
        <?php foreach ($result as $e): ?>
            <div>
                <ul>
                    <li> <?=$e['title']?> - <?=$e['artist']?></li>
                    <li> year: <?=$e['year']?> </li>
                    <li> genres: <?php echo implode(' , ', array_values($e['genres'])); ?></li>
                </ul>
            </div>
        <?php endforeach ?>
    </div>

</body>
</html>


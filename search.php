<?php 

    include_once('storage.php');
    $searched = $_GET['search'] ?? '';
    $stor = new Storage(new JsonIO('db/tracks.json'));
    $data = $stor -> findAll();

    $resault = [];

    foreach ($data as $e){
        if ($searched !== '' && strpos(strtolower($e['title']), strtolower($searched)) !== false) {

            $resault[] = [
                'title' =>  $e['title'],
                'artist'=>  $e['artist'],
                'year'  =>  $e['year'],
            ];

        }
    }


    echo json_encode($resault , JSON_PRETTY_PRINT);

?>
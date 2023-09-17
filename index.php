<?php

    session_start();
    include_once('storage.php');

    $loginButton ?? "";
    $insession = false;
    $playlists = json_decode(file_get_contents('db/playlists.json'), true);

    if(!isset($_SESSION['user_id'])){
        $loginButton = '<a class = "logButton" href="login.php">Login</a>';
        $regButton = '<a class = "logButton" href="register.php">Register</a><br>';
    } else {
        $insession = true;
        $userstor = new Storage(new JsonIO('db/users.json'));
        $user = $userstor -> findById($_SESSION['user_id']);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MUSIC</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

    <div class = "logreg_section">
        <?php if ($insession){
            echo "<span style='width:30em;'> Hello " . $user['username'] . "!</span>";
            echo "<a class = 'logButton' href="."logout.php".">Logout</a><br>";
        }else{
            echo $loginButton;
            echo $regButton;
        }
        ?>
    </div>

    <div class = "search_section">
        <input type="text" id="search" placeholder = "search tracks">
        <table></table>
    </div>

    <h1>Playlists</h1>
    
    <div class = "card_grid">

        <?php foreach ($playlists as $playlist): ?>
            <?php if ($playlist['public']) : ?>
            <div class = "card_cell">
                <a class ="link_card_cell" href="details.php?name=<?php echo urlencode($playlist['name'])?>">
                    <ul>
                        <li class="title"> <?=$playlist['name']?> </li>
                        <li> Created by <?=$playlist['created_by']?> </li>
                        <li> Number of tracks : <?=count($playlist['tracks'])?> </li>
                    </ul>
                </a>
            </div>
            <?php endif ?>
        <?php endforeach ?>

    </div>

    <script src= "ajax.js"></script>

</body>
</html>
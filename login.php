<!-- The login and registration page should be accessible from the main page.
On the login page users can identify themselves with their username and password. 
If there was an error logging in, display a message about it under the login form! 
After successful login, redirect the user to the main page.-->

<?php 
    session_start();

    $username = $_POST["username"] ?? '';
    $password = $_POST["password"] ?? '';
    $error = false;

    if($_POST){
        include_once('storage.php');
        $stor = new Storage(new JsonIO('db/users.json'));

        $user = $stor -> findOne(['username' => $username]);

        if(!$user){

            $error = true;

        } else {
            if(!password_verify($password, $user["password"])){
                $error = true;
            } else {
                $_SESSION['user_id'] = $user['id'];
                header('location: index.php');
                exit();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Login</title>
</head>

<body>

    <h1>Login</h1>

    <?php if ($error): ?>
    <span class="errors"> Invalid username or password! </span><br><br>
    <?php endif; ?>

    <form class="login_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input class="loginput" type="text" name="username" placeholder="Username"><br><br>
        <input class="loginput" type="password" name="password" placeholder="Password"><br><br>
        <button type="submit">Login</button>
    </form>

</body>

</html>
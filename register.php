<?php 
    include_once('storage.php');
    $stor = new Storage(new JsonIo('db/users.json'));
    
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $isAdmin = false;

    $errors = [];
    $error = false;

    $user = $stor -> findOne(['username' => $username]);
    $useremail = $stor -> findOne(['email' => $email]);

    if($_POST){

        if($username === ''){
            $error = true;
            $errors['username'] = "*Username required";
        }else if($user){
            $error = true;
            $errors['username'] = "*Username already picked";
        }
    
        if($email === ''){
            $error = true;
            $errors['email'] = "*Email required";
        } else if(!filter_var($email , FILTER_VALIDATE_EMAIL)){
            $error = true;
            $errors['email'] = "*Invalid email!";
        } else if($useremail){
            $error = true;
            $errors['email'] = "*Email already picked";
        }

        if($password ===  ''){
            $error = true;
            $errors['password'] = "*Password required";
        }
        
        if(!$error){
            $stor -> add([
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'email' => $email,
                'isAdmin' => $isAdmin
            ]);
            echo '<script>window.alert("Registeration successful, please login!");
            window.location.href = "login.php";
            </script>';
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
    <title>Register</title>
</head>

<body>

    <h1>Register</h1>
    <form class="reg_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input class="loginput" type="text" name="username" placeholder="*Username"><br>
        <span class="errors"><?= $errors["username"] ?? '' ?></span><br>
        <input class="loginput" type="password" name="password" placeholder="*Password"><br>
        <span class="errors"><?= $errors["password"] ?? '' ?></span><br>
        <input class="loginput" type="email" name="email" placeholder="*Email"><br>
        <span class="errors"><?= $errors["email"] ?? '' ?></span><br>
        <button type="submit">Sign Up</button>
    </form>

</body>

</html>
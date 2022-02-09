<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up</title>
    <link rel = "stylesheet" href = "style.css">
</head>
<body>
    <?php
        $new_user = $_GET['newuser'];

        if( !preg_match('/^[\w_\.\-]+$/', $new_user) ){
            echo "<h3>Invalid username.</h3>";
            echo "<br><a href='./login.html'>Go back to the login page</a>";
        } else if(is_dir("/srv/uploads/".$new_user)) {
            echo "<h3>User exists. Please choose another username.</h3>";
            echo "<br><a href='./login.html'>Go back to the login page</a>";
        } else {
            // create directory and add it to the users.txt
            mkdir("/srv/uploads/".$new_user, 0777);
            file_put_contents ("/srv/users.txt", $new_user."\n", FILE_APPEND);
            session_start();
            $_SESSION['current_user'] = $new_user;
            header("Location: login_success.php");
		    exit;
        }
    ?>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>File Sharing Site Login</title>
</head>
<body>
    <?php
        session_start();
        $_SESSION['current_user'] = $_GET['username'];
        $users = fopen("/srv/users.txt", "r");

        while( !feof($users) ) {
            $trimmed = trim(fgets($users));
            if(strcmp($_SESSION['current_user'], $trimmed) === 0) { // username matches
                fclose($users);
                header("Location: login_success.php");
                exit;
            }
        }
        // invalid user 
        session_destroy();
        fclose($users);
        header("Location: login_failure.php");
        exit;
    ?>

</body>
</html>
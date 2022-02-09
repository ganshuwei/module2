<!DOCTYPE html>
<html lang="en">
<head>
    <title>Change Username</title>
    <link rel = "stylesheet" href = "style.css">
</head>
<body>
<?php
session_start();

$username = $_SESSION['current_user'];
$new_name = $_GET['newname'];
$dir = sprintf("/srv/uploads/%s/", $username);
$new_dir = sprintf("/srv/uploads/%s/", $new_name);


if( !preg_match('/^[\w_\.\-]+$/', $new_name) ){
    echo "<h3>Invalid username.</h3>";
    echo "<br><a href='./login_success.php'>Go back to the Main page</a>";
} else if(is_dir("/srv/uploads/".$new_name)) {
    echo "<h3>Username exists. Please choose another username.</h3>";
    echo "<br><a href='./login_success.php'>Go back to the Main page</a>";
} else {
    // create directory and add it to the users.txt
    mkdir($new_dir, 0777);
    file_put_contents ("/srv/users.txt", $new_name."\n", FILE_APPEND);

    // delete original directory and its username in users.txt
    $users = file_get_contents("/srv/users.txt");
    $users = str_replace($username."\n", '', $users);
    file_put_contents("/srv/users.txt", $users);

    // copy files to new dirctory
    $files = array_diff(scandir($dir), array('.', '..'));
    foreach($files as $filename){
        $current_path=sprintf("/srv/uploads/%s/%s", $username, $filename);
        $destination_path=sprintf("/srv/uploads/%s/%s", $new_name, $filename);
        rename($current_path,$destination_path);
        unlink($current_path);
    }
    rmdir($dir);

    $_SESSION['current_user'] = $new_name;
    header("Location: login_success.php");
    exit;
}



?>
</body>
</html>
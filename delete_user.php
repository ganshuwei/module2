<?php
session_start();

$username = $_SESSION['current_user'];
$dir = sprintf("/srv/uploads/%s/", $username);

//function used from https://paulund.co.uk/php-delete-directory-and-files-in-directory
function delete_files($dirname) {
    if(is_dir($dirname)){
        $files = glob( $dirname. '*', GLOB_MARK );
        
        foreach( $files as $file ){
            delete_files($file);      
        }
        rmdir($dirname);
    } else if(is_file($dirname)) {
        unlink($dirname);  
    }
}
//deletes the user from the list

    $users = file_get_contents("/srv/users.txt");
    $users = str_replace($username."\n", '', $users);
    file_put_contents("/srv/users.txt", $users);

    delete_files($dir);
    session_destroy();
    header("Location: login.html");
    exit;

?>
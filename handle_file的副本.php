<?php
    session_start();
    $username = $_SESSION['current_user'];
    $filename = $_POST['filename'];
    $full_path = sprintf("/srv/uploads/%s/%s", $username, $filename);
    if($_POST['open']||$_POST['public_open']) {
        // We need to make sure that the filename is in a valid format; if it's not,
        // display an error and leave the script.
        // To perform the check, we will use a regular expression.
        if($_POST['public_open']){
            $full_path=sprintf("/srv/uploads/public/%s",$filename);
        }
        if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
            echo "Invalid filename";
            exit;
        }

        // Get the username and make sure that it is alphanumeric with limited other characters.
        // You shouldn't allow usernames with unusual characters anyway, but it's always best to perform a sanity check
        // since we will be concatenating the string to load files from the filesystem.
        if( !preg_match('/^[\w_\-]+$/', $username) ){
            echo "Invalid username";
            exit;
        }
            
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($full_path);

        switch($mime){
            // open in the browser
            case 'text/plain':
            case 'image/png':
            case 'image/jpeg':
            case 'image/gif':
            case 'application/pdf':     
                header("Content-Type: ".$mime);
                ob_clean();
                readfile($full_path);
                exit;
            // download
            default:
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($filename).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filename));
                readfile($filename);
                exit;
        }
    }else if($_POST['public']){
        $file_destination=sprintf("/srv/uploads/public/%s",$filename);
        if (file_exists($file_destination)){
            echo "A file with this name exists in public zone.";
            exit;
        }
        else if (copy($full_path, $file_destination)){
            header("Location: login_success.php");
            exit;
        }
        else {
            echo "Error sharing file.";
            exit;
        }
        
    }else {
        unlink($full_path);
        header("Location: login_success.php");
        exit;
    }
?>

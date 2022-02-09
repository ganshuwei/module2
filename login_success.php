<!DOCTYPE html>
<html lang="en">
<head>
	<title>File Sharing Site</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div>
        <h2>
            <?php
                session_start();
                $user = $_SESSION['current_user'];
                echo htmlentities("$user , Welcome back!");
            ?>
        </h2>
        <hr>
        <h3> Public Files </h3>
        <?php
            $dir = "/srv/uploads/public/";
            $files = array_diff(scandir($dir), array('.', '..')); 
            foreach($files as $filename) {
                echo "<form action='handle_file.php' method='POST'>
                    <input type='text' value=$filename name='filename' readonly/>
                    <input type='submit' value='Open' name='public_open' />
                </form>";
            }
        ?>
        <hr>
        <h3> Current Files </h3>
        <?php
            session_start();
            $username = $_SESSION['current_user'];
            $dir = sprintf("/srv/uploads/%s/", $username);
            $files = array_diff(scandir($dir), array('.', '..')); 
            foreach($files as $filename) {
                $mypublicpath=sprintf("/srv/uploads/public/%s", $filename);
                if(file_exists($mypublicpath)){
                    echo "<form action='handle_file.php' method='POST'>
                    <input type='text' value=$filename name='filename' readonly/>
                    <input type='submit' value='Open' name='open' />
                    <input type='submit' value='Delete' name='delete' />
                    <input type='submit' value='Public' name='public' />
                </form>";
                }else{
                    echo "<form action='handle_file.php' method='POST'>
                    <input type='text' value=$filename name='filename' readonly/>
                    <input type='submit' value='Open' name='open' />
                    <input type='submit' value='Delete' name='delete' />
                </form>";
                }
            }
        ?>
        <hr>
        <form enctype="multipart/form-data" action="upload.php" method="POST">
            <p>
                <input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
                <label for="uploadfile_input">Choose a file to upload:</label>
                <input name="uploadedfile" type="file" id="uploadfile_input" />
            </p>
            <p>
                <button type="submit">Upload File</button> 
            </p>
        </form>
        <hr>
        <form action="change_username.php" method="GET">
            <label for="newname">Enter New Username: </label>
            <input type="text" id="newname" placeholder="" name="newname" required>
            <button type="submit">Change Username</button> 
        </form>
        <hr>
        <form action="delete_user.php">
            <button type="submit" onclick="return confirm('Are you sure?')">Terminate Using</button> 
        </form>
        <hr>
        <form action="logout.php">
            <button type="submit">Save & Logout</button> 
        </form>
    </div> 
</body>
</html>
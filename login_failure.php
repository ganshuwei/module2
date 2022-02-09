<!DOCTYPE html>
<html lang="en">
<head>
	<title>File Sharing Site Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div>
        <form action="login_validation.php" method="GET">
            <h3>Sorry, we couldn't find your username:(</h2>
            <div>
                <label for="username">Enter Username: </label>
                <input type="text" id="username" placeholder="" name="username" required>
            </div>

            <button type="submit">Login</button> 
            <br>
            <br> 
        </form>
        <hr>
        <form action="signup.php" method="GET">
            <div>
                <label for="newuser">New Username: </label>
                <input type="text" id="newuser" placeholder="" name="newuser" required>
            </div>

            <button type="submit">Sign Up</button> 
            <br>
            <br> 
        </form>
    </div>

</body>
</html>
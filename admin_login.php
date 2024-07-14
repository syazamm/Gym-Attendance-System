<?php
require 'database.php';

// Start session
session_start();

// Create connection using the Database class
$conn = Database::connect();

// Check connection
if ($conn === null) {
    die("Connection failed: Unable to connect to the database.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    $sql = "SELECT * FROM admin_users WHERE username = :username AND password = :password";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $input_username);
    $stmt->bindParam(':password', $input_password);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Successful login
        $_SESSION['username'] = $input_username;
        header("Location: user data.php");
        exit();
    } else {
        // Invalid credentials
        echo "Invalid username or password.";
    }
}

Database::disconnect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <script src="jquery.min.js"></script>

    <style>
    html {
        font-family: Arial;
        display: inline-block;
        margin: 0px auto;
    }
    
    ul.topnav {
        list-style-type: none;
        margin: auto;
        padding: 0;
        overflow: hidden;
        background-color: #4CAF50;
        width: 70%;
    }

    ul.topnav li {float: left;}

    ul.topnav li a {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    ul.topnav li a:hover:not(.active) {background-color: #3e8e41;}

    ul.topnav li a.active {background-color: #333;}

    ul.topnav li.right {float: right;}

    @media screen and (max-width: 600px) {
        ul.topnav li.right, 
        ul.topnav li {float: none;}
    }
    </style>
    
    <title>Admin Login</title>
</head>
<body>
    <h2 align="center">GYM GO GENIUS</h2>
    <ul class="topnav">
        <li><a href="home.php">Home</a></li>
        <li><a class="active" href="admin_login.php">Admin</a></li>
        <li><a href="registration.php">Registration</a></li>
        <li><a href="read tag.php">Read Tag ID</a></li>
    </ul>

    <div class="container">
        <br>
        <div class="center" style="margin: 0 auto; width:495px; border-style: solid; border-color: #f2f2f2;">
            <div class="row">
                <h3 align="center">Admin Login</h3>
            </div>
            <br>
            <form class="form-horizontal" action="" method="post">
                <div class="control-group">
                    <label class="control-label">Username</label>
                    <div class="controls">
                        <input name="username" type="text" placeholder="Enter your username" required>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">Password</label>
                    <div class="controls">
                        <input name="password" type="password" placeholder="Enter your password" required>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-success">Login</button>
                </div>
            </form>
        </div>               
    </div> <!-- /container -->    
</body>
</html>

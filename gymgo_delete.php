<?php
require 'database.php';

$no = 0;
if (!empty($_GET['No'])) {
    $no = $_REQUEST['No'];
}

if (!empty($_POST)) {
    // Keep track post values
    $no = $_POST['No'];

    // Delete data
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM gymgo WHERE No = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($no));
    Database::disconnect();
    header("Location: gymgo.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <title>Delete : GymGo Database</title>
    <style>
        html {
            font-family: Arial;
            display: inline-block;
            margin: 0px auto;
        }

        textarea {
            resize: none;
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
</head>

<body>
    <h2 align="center">GymGo Database</h2>

    <div class="container">
        <div class="span10 offset1">
            <div class="row">
                <h3 align="center">Delete GymGo Entry</h3>
            </div>

            <form class="form-horizontal" action="gymgo_delete.php?No=<?php echo $no; ?>" method="post">
                <input type="hidden" name="No" value="<?php echo $no; ?>"/>
                <p class="alert alert-error">Are you sure to delete ?</p>
                <div class="form-actions">
                    <button type="submit" class="btn btn-danger">Yes</button>
                    <a class="btn" href="gymgo.php">No</a>
                </div>
            </form>
        </div>
    </div> <!-- /container -->
</body>
</html>

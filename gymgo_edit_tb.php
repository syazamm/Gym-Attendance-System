<?php
require 'database.php';

$no = null;
if (!empty($_GET['no'])) {
    $no = $_REQUEST['no'];
}

if (!empty($_POST)) {
    // Keep track of validation errors
    $dateError = null;
    $checkinError = null;
    $checkoutError = null;

    // Keep track of post values
    $date = $_POST['date'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];

    // Validate input
    $valid = true;
    if (empty($date)) {
        $dateError = 'Please enter Date';
        $valid = false;
    }
    if (empty($checkin)) {
        $checkinError = 'Please enter CheckIn time';
        $valid = false;
    }

    // Update data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE gymgo SET Date = ?, CheckIn = ?, CheckOut = ? WHERE No = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($date, $checkin, $checkout, $no));
        Database::disconnect();
        header("Location: gymgo.php");
    }
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM gymgo WHERE No = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($no));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <script src="js/bootstrap.min.js"></script>
        
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
        
        <title>Edit GymGo Entry</title>
        
    </head>
    
    <body>

        <h2 align="center">GymGo Database</h2>
        
        <div class="container">
     
            <div class="center" style="margin: 0 auto; width:495px; border-style: solid; border-color: #f2f2f2;">
                <div class="row">
                    <h3 align="center">Edit GymGo Entry</h3>
                </div>
         
                <form class="form-horizontal" action="gymgo_edit_tb.php?no=<?php echo $no?>" method="post">
                    <div class="control-group <?php echo !empty($dateError)?'error':'';?>">
                        <label class="control-label">Date</label>
                        <div class="controls">
                            <input name="date" type="date" placeholder="" value="<?php echo !empty($data['Date'])?$data['Date']:'';?>" required>
                            <?php if (!empty($dateError)): ?>
                                <span class="help-inline"><?php echo $dateError;?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="control-group <?php echo !empty($checkinError)?'error':'';?>">
                        <label class="control-label">CheckIn Time</label>
                        <div class="controls">
                            <input name="checkin" type="time" placeholder="" value="<?php echo !empty($data['CheckIn'])?$data['CheckIn']:'';?>" required>
                            <?php if (!empty($checkinError)): ?>
                                <span class="help-inline"><?php echo $checkinError;?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="control-group <?php echo !empty($checkoutError)?'error':'';?>">
                        <label class="control-label">CheckOut Time</label>
                        <div class="controls">
                            <input name="checkout" type="time" placeholder="" value="<?php echo !empty($data['CheckOut'])?$data['CheckOut']:'';?>">
                            <?php if (!empty($checkoutError)): ?>
                                <span class="help-inline"><?php echo $checkoutError;?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">Update</button>
                        <a class="btn" href="gymgo.php">Back</a>
                    </div>
                </form>
            </div>               
        </div> <!-- /container -->    
    </body>
</html>

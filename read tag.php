<?php
$servername = "sql12.freemysqlhosting.net";
$username = "sql12719550";
$password = "UmBJclHj65";
$dbname = "sql12719550";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if RFID data is sent via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['UIDresult'])) {
  // Get RFID data from the request
  $rfid = $_POST['UIDresult'];

  if (empty($rfid)) {
    die("RFID is required");
  }

  // Check if the RFID exists in the user table
  $userCheckSql = "SELECT * FROM user WHERE id = '$rfid'";
  $userCheckResult = $conn->query($userCheckSql);

  if ($userCheckResult->num_rows > 0) {
    // RFID exists in the user table, proceed with attendance check
    $sql = "SELECT * FROM gymgo WHERE id = '$rfid' ORDER BY No DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // RFID exists in gymgo table, update the checkout time if not already set
      $row = $result->fetch_assoc();
      if ($row['CheckOut'] == NULL) {
        $sql = "UPDATE gymgo SET CheckOut = NOW() WHERE No = " . $row['No'];
      } else {
        // Insert a new record with check-in time
        $sql = "INSERT INTO gymgo (id, CheckIn, date) VALUES ('$rfid', NOW(), CURDATE())";
      }
    } else {
      // RFID does not exist in gymgo table, insert new record with check-in time
      $sql = "INSERT INTO gymgo (id, CheckIn, date) VALUES ('$rfid', NOW(), CURDATE())";
    }

    if ($conn->query($sql) === TRUE) {
      echo "Record updated successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  } else {
    echo "RFID not found in the user table";
  }
}

$conn->close();
?>

<?php
  $Write="<?php $" . "UIDresult=''; " . "echo $" . "UIDresult;" . " ?>";
  file_put_contents('UIDContainer.php',$Write);
?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="js/bootstrap.min.js"></script>
  <script src="jquery.min.js"></script>
  <script>
    $(document).ready(function(){
      $("#getUID").load("UIDContainer.php");
      setInterval(function() {
        $("#getUID").load("UIDContainer.php");  
      }, 500);
    });
  </script>
  <style>
    html {
      font-family: Arial;
      display: inline-block;
      margin: 0px auto;
      text-align: center;
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
    
    td.lf {
      padding-left: 15px;
      padding-top: 12px;
      padding-bottom: 12px;
    }
  </style>
  
  <title>Read Tag</title>
</head>

<body>
  <h2 align="center">GYM GO GENIUS
</h2>
  <ul class="topnav">
    <li><a href="home.php">Home</a></li>
    <li><a href="admin_login.php">Admin</a></li>
    <li><a href="registration.php">Registration</a></li>
    <li><a class="active" href="read tag.php">Read Tag ID</a></li>
  </ul>
  
  <br>
  
  <h3 align="center" id="blink">Please Tag to Display ID or User Data</h3>
  
  <p id="getUID" hidden></p>
  
  <br>
  
  <div id="show_user_data">
    <form>
      <table  width="452" border="1" bordercolor="#10a0c5" align="center"  cellpadding="0" cellspacing="1"  bgcolor="#000" style="padding: 2px">
        <tr>
          <td  height="40" align="center"  bgcolor="#10a0c5"><font  color="#FFFFFF">
            <b>User Data</b>
            </font>
          </td>
        </tr>
        <tr>
          <td  bgcolor="#f9f9f9">
            <table width="452"  border="0" align="center" cellpadding="5"  cellspacing="0">
              <tr>
                <td width="113" align="left" class="lf">ID</td>
                <td style="font-weight:bold">:</td>
                <td align="left">--------</td>
              </tr>
              <tr bgcolor="#f2f2f2">
                <td align="left" class="lf">Name</td>
                <td style="font-weight:bold">:</td>
                <td align="left">--------</td>
              </tr>
              <tr>
                <td align="left" class="lf">Gender</td>
                <td style="font-weight:bold">:</td>
                <td align="left">--------</td>
              </tr>
              <tr bgcolor="#f2f2f2">
                <td align="left" class="lf">Email</td>
                <td style="font-weight:bold">:</td>
                <td align="left">--------</td>
              </tr>
              <tr>
                <td align="left" class="lf">Mobile Number</td>
                <td style="font-weight:bold">:</td>
                <td align="left">--------</td>
              </tr>
              <tr bgcolor="#f2f2f2">
                <td align="left" class="lf">Date</td>
                <td style="font-weight:bold">:</td>
                <td align="left">--------</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </form>
  </div>

  <script>
    var myVar = setInterval(myTimer, 1000);
    var myVar1 = setInterval(myTimer1, 1000);
    var oldID="";
    clearInterval(myVar1);

    function myTimer() {
      var getID=document.getElementById("getUID").innerHTML;
      oldID=getID;
      if(getID!="") {
        myVar1 = setInterval(myTimer1, 500);
        showUser(getID);
        clearInterval(myVar);
      }
    }
    
    function myTimer1() {
      var getID=document.getElementById("getUID").innerHTML;
      if(oldID!=getID) {
        myVar = setInterval(myTimer, 500);
        clearInterval(myVar1);
      }
    }
    
    function showUser(str) {
      if (str == "") {
        document.getElementById("show_user_data").innerHTML = "";
        return;
      } else {
        $.post('read tag.php', { UIDresult: str }, function(response) {
          alert(response);
        });
        
        if (window.XMLHttpRequest) {
          // code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp = new XMLHttpRequest();
        } else {
          // code for IE6, IE5
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("show_user_data").innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET","read tag user data.php?id="+str,true);
        xmlhttp.send();
      }
    }
    
    var blink = document.getElementById('blink');
    setInterval(function() {
      blink.style.opacity = (blink.style.opacity == 0 ? 1 : 0);
    }, 750); 
  </script>
</body>
</html>

<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.24/angular.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script type="text/javascript">
        function disableF5(e) { if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault(); };

        $(document).ready(function(){
            $(document).on("keydown", disableF5);
        });
        </script>


        <script>

            function showSwal1(){
                    swal({
            title: "Error!",
            text: "You do not have required credits in your account!",
            icon: "error",
            type: "error"
            }).then(function() {
             // Redirect the user
        
                window.location.replace("payee.php");
            });
            }


        </script>

        <style>

            .jumbotron{
                 background-color:lightseagreen;
                 color:black;
            }

             body{
                  background-color:#E6FDFE;
             }


        </style>
    </head>


<body>

<?php

session_start();

//echo $_SESSION['payerid']; 
//echo $_SESSION['payeeid'];

$amt = $_POST['amount'];
//echo "$amt";

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "root";
$dbname = "janhavi";

 // Create connection
 $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
 // Check connection
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }    

//Extract credits
$sql="SELECT * FROM users WHERE id = '".$_SESSION['payerid']."'";
$result = $conn->query($sql);

if($result->num_rows>0){
	
	while($row = $result->fetch_assoc()) {
    
    $credits1 = $row['credits'];
    //echo "$credits1";
}
	
}

else{
	echo "0 results";
	
}

$sql1="SELECT * FROM users WHERE id = '".$_SESSION['payeeid']."'";
$result1 = $conn->query($sql1);

if($result1->num_rows>0){
	
	while($row1 = $result1->fetch_assoc()) {
    
        $credits2 = $row1['credits'];
        //echo "$credits2";
}
	
}

else{
	echo "0 results";
	
}

//Transfer
if($credits1>=$amt){

    $temp = $credits1 - $amt;
    $temp2 = $credits2 + $amt;

    //echo $temp;
    //echo $temp2;

    //Writing back to DB
    $sql2 = "UPDATE users SET credits='$temp' WHERE id = '".$_SESSION['payerid']."'";
    $result2 = $conn->query($sql2);

    if($result2){
        
        //echo "Success!";
        $flag1=1;
        
    }

    else{
        echo "0 results";
        
    }

    $sql3 = "UPDATE users SET credits='$temp2' WHERE id = '".$_SESSION['payeeid']."'";
    $result3 = $conn->query($sql3);

    if($result3){
        
        //echo "Success!";
        $flag2=1;
        
    }

    else{
        echo "0 results";
        
    }

    //Updating transfer table
    $query = "insert into transfers (payerid,payeeid,credits) values (?,?,?)";
    $stmt = $conn->prepare($query);

    $stmt->bind_param("iii", $_SESSION['payerid'], $_SESSION['payeeid'], $amt);

    if($stmt->execute()){

        //echo "Success!";

    }
    else{

        echo "Fail";
        printf("Error: %s.\n", $stmt->error);

    }

    if($flag1==1 && $flag2==1){

        ?>
        <div class="jumbotron text-center">
        <div class="alert alert-info">
            <h1><strong>Successful Transaction!</strong><br/></h1>
            <h2>
        <?php

        echo "Successfully transferred ".$amt." from User ID ".$_SESSION['payerid']." to User ID ".$_SESSION['payeeid']."<br/><br/><br/>";
        echo "Remaining balance of User ID ".$_SESSION['payerid']." is ".$temp."<br/><br/>";
        echo "Remaining balance of User ID ".$_SESSION['payeeid']." is ".$temp2."<br/>";

        ?>
            </h2>
        </div>
        </div>
        <form action="index.html">
            <br/>
            <center><input type="submit" class="btn btn-primary btn-lg" value="Homepage"></center>
        </form>

        <?php
    }
}
else{

    header("Location: error.html");
   

}
$conn->close();
?>

</body>
</html>
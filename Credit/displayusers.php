
<?php

?>

<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.24/angular.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <script>
        function showSwal(){
                swal({
        title: "Selected payer",
        text: "Proceeding to transaction...",
        icon: "success",
        type: "success"
        }).then(function() {
        // Redirect the user
        
        window.location.replace("payee.php?selectuser="+radioValue);
        });
        }

        function showSwal1(){
                swal({
        title: "Error!",
        text: "You have no credits in your account!",
        icon: "error",
        type: "error"
        });
        }

        function showSwal2(){
                swal({
        title: "Attention!",
        text: "Please select a user",
        icon: "info",
        type: "info"
        });
        }

    </script>

    <script>
    var app = angular.module('myApp', []);
    app.controller('customersCtrl', function($scope, $http) {
        var x;
        var radiovalue;
        $("input[type='button']").click(function(){
                radioValue = $("input[name='selectuser']:checked").val();
        });
        $scope.login = function() {

            if(radioValue===undefined){
                showSwal2();
            }
            else{
                $http.get("database.php?selectuser="+radioValue)
                .then(function (response) {
                    $scope.names = response.data.credits;
                    //alert($scope.names);
                    if($scope.names==0){
                        showSwal1();
                    }
                    else{
                        showSwal();
                       
                    }
                    
                    });
            }
        
        }
    
    });
    </script>

    <style>

        body{

            background-color:#E3F7FA;
            

        }
    
        .container-fluid{
            width:50%;
            height:50px;
            background-color:#CAD9F6;
            font-family:Helvetica;
            font-size:35px;
            
        }

        table{
          
            font-family:Helvetica;
            height:75%;
            margin-top:20px;
            border: 1px solid grey;
            
        }
        td, th {
             border: 1px solid grey;
                        
         }
        th{
            
            font-size:25px;
            text-align:center;
            background-color:lightseagreen;
            
        }
        tr{
            
            font-size:20px;
            font-weight:bold;
        }
        
        tr:nth-child(even){
            background-color:#BAD9F7;
        }
        tr:nth-child(odd){
            background-color:#D1E3F3;
        }
        tr:hover{
            background-color:white;
        }
        input[type=radio] {
           
            width: 20px;
            height: 20px;
        }
        .badge{
            width: 45px;
            height: 25px;
            font-size:15px;
            color:black;
            background-color:white;
        }
        #mybtn{
            width:50%;
        }
    
    </style>
        
	
</head>

<body>



<?php

	if (isset($_POST['submitbtn'])) {
	echo "<div class='container-fluid' align='center'>Select a payer</div>";
}

   
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
   
   //build query
   $query = "SELECT * FROM users";
   $result = $conn->query($query);

   
   //Build Result String
   echo '<div ng-app="myApp" ng-controller="customersCtrl">';
   echo "<form method='post'>";
   echo "<table class='table table-condensed'>";
   echo "<tr>";
   echo "<th>SELECT</th>";
   echo "<th>ID</th>";
   echo "<th>NAME</th>";
   echo "<th>EMAIL</th>";
   echo"<th>CREDIT</th>";
   echo"</tr>";
   echo "</div>";
	
    //Insert a new row in the table for each person returned
    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      
        
        echo "<tr>";
        echo "";
        echo "<td align='center'><input type='radio' name='selectuser' id='selectuser' value='$row[id]'></td>";
        echo "<td>$row[id]</td>";
        echo "<td><span class='glyphicon glyphicon-user'></span>&nbsp;$row[name]</td>";
        echo "<td>$row[email]</td>";
        echo "<td><span class='badge'>$row[credits]</span></td>";
        echo "</tr>";
       
       }
        
    } else {
        echo "0 results";
    }
  
	echo "</table>";
    echo "<div align='center'><input type='button' class='btn btn-primary btn-large' value='Proceed' id='mybtn' ng-click='login()'></div>";
    echo "</form>";
    ?>

    <script>
    
</script>

    <?php
	

   $conn->close();
   
?>


</body>

</html>
    
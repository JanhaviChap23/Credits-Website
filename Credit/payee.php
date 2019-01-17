<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.24/angular.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <style>

    #dropdwn{
      width:50%;
      font-size:20px;
      text-align:center;
    }

    #txtHint{
      font-size:20px;
    }

    #amtdiv{
      font-size:20px;
    }

    #myDIV{
      display:none;
    }

    .jumbotron{
      background-color:#DEDEDE;
    }
    body{
      background-color:#F1F1F1;
    }
    input{
      text-align:center;
    }
    #finalbtn{
      width:40%;
    }

</style>

    <script>

      var flag=0;

      function showSwal1(){
                swal({
        title: "Error!",
        text: "Enter amount!",
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

     /* function showSwal3(){
       
            swal({
          title: "Confirm transfer?",
          text: "Once transfered, you will not be able to revert back!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
          
            swal("Transaction successful!", {
              icon: "success",
            });
            
          
          } else {
            swal("Transfer cancelled!");
            
          }
        });
      }
      */

      function myFunction() {
          
          var x = document.getElementById("myDIV");
        
          var ddl = document.getElementById("dropdwn");
          var selectedValue = ddl.options[ddl.selectedIndex].value;
              if (selectedValue == "none")
            {
              showSwal2();
            }
            else{
              
              if (x.style.display === "block") {
                //x.style.display = "none";
              }
              else{
                  x.style.display = "block";

              }
            }
      }

      function submitbtn(){

          var a = document.getElementById("amount").value;
          if(a==""){
            showSwal1();
            return false;
          }
          else{
            //showSwal3();
            return true;
          }
              
      }


    </script>

    <script>
    function showUser(str) {

      if (str=="") {
        document.getElementById("txtHint").innerHTML="";
        return;
      } 
      if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      } else { // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
          document.getElementById("txtHint").innerHTML=this.responseText;
        }
      }
      xmlhttp.open("GET","getuser.php?q="+str,true);
      xmlhttp.send();
    }
    </script>

      

</head>
<body>

  <div class="jumbotron text-center">
        <h1>Select a payee</h1>
   </div>

<?php

    session_start();
    $payerid= $_GET["selectuser"];

    $_SESSION['payerid'] = $_GET["selectuser"];

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
   echo "<form>";
   echo '<div align="center">';
   echo '<select name="users" onchange="showUser(this.value)" id="dropdwn">';
   echo "<option value='none'>Select a user</option>";
	
    //Insert a new row in the table for each person returned
    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      
        if($row[id] !== $_SESSION['payerid']){
          echo "<option value="."$row[id]".">".$row[name]."</option>";
        }
        else{
          //nothing
        }
        
       }
        
    } else {
        echo "0 results";
    }
  
  echo "</select>";
  echo "</div>";
	echo "</form>";
	echo "</br>";
  echo '<div id="txtHint" align="center"><b>Select a payee to view details</b></div><br/>';
  echo '<div align="center"><button onclick="myFunction()" class="btn btn-info">Proceed</button></div><br/>';
  echo "<div id='myDIV' align='center'>";
  echo "<form name='form2' method='post' action='transfer.php' onsubmit='return submitbtn()' >";
  echo '<div id="amtdiv"><b>Enter amount</b><br/>';
  echo "<input type='number' name='amount' id='amount'><br/><br/>";
  echo "<input id='finalbtn' type='submit' class='btn btn-success' value='Tranfer Credits'>";
  echo "</form>";
  echo "</div>";
  

   $conn->close();
   
?>


</body>
</html>
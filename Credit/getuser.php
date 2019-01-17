<!DOCTYPE html>
<html>
<head>
<style>
table{
          
          font-family:Helvetica;
          height:80%;
          width:100%;
          margin-top:20px;
          border: 1px solid grey;
          border-collapse:collapse;
        
          
      }
      td, th {
           border: 1px solid grey;
           padding:5px;
           text-align:center;
                      
       }
      th{
          background-color:#E3B7CC;
          font-size:20px;
          
      }
      tr{
          background-color:#FAD4E6;
          font-size:18px;
      }
      

</style>
</head>
<body>

<?php

session_start();
$q = intval($_GET['q']);

$_SESSION['payeeid'] =intval($_GET['q']);

$conn = new mysqli('localhost','root','root','janhavi');
if ($conn->connect_error) {
    die('Could not connect: ' . $conn->connect_error);
}

$sql="SELECT * FROM users WHERE id = '".$q."'";
$result = $conn->query($sql);

echo "<table>
<tr>
<th>Id</th>
<th>Name</th>
<th>Email</th>
<th>Credit</th>
</tr>";

if($result->num_rows>0){
	
	while($row = $result->fetch_assoc()) {
	
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . $row['credits'] . "</td>";
    echo "</tr>";
}
	
}

else{
	echo "0 results";
	
}

echo "</table>";
$conn->close();
?>
</body>
</html>
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli("localhost", "root", "root", "janhavi");

$q= $_GET["selectuser"];

$result = $conn->query("SELECT credits FROM users WHERE id = '".$q."'");

$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "") {$outp .= ",";}
    //$outp .= '{"id":"'  . $rs["id"] . '",';
    $outp .= '{"credits":"'   . $rs["credits"]        . '"}';
}
//$outp ='{"records":['.$outp.']}';
$conn->close();

echo($outp);
?>
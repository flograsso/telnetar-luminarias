

<!DOCTYPE html>
    <html lang="en" >
<?php
header("Content-Type: text/html;charset=utf-8");

$data = json_decode(file_get_contents('php://input'), true);
http_response_code(200);



$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$conn = new mysqli($server, $username, $password, $db);

$crudo=json_encode($data);

$deveui=$data["deveui"];
$dataFrame= bin2hex(base64_decode($data["dataFrame"]));
$port=$data["port"];
$fcnt=$data["fcnt"];
$rssi=$data["rssi"];
$snr=$data["snr"];
$sf_used=$data["sf_used"];
$id=$data["id"];

$decrypted=$data["decrypted"] ."<br>";
echo $decrypted ."<br>";
$live=$data["live"];
$timestamps=$data["timestamp"];

if ($decrypted)
    $decrypted=true;
else    
    $decrypted=false;




//$sql="INSERT INTO `orbiwise` (crudo,deveui,payload,port,fcnt,rssi,snr,sf_used,payload_id,decrypted,live,timestamp) VALUES ('$crudo','$deveui','$payload','$port','$fcnt','$rssi','$snr','$sf_used','$payload_id','$decrypted','$live','$timestamp');";

$sql="INSERT INTO `orbiwise` (crudo,deveui,payload,port,fcnt,rssi,snr,sf_used,payload_id,decrypted,live,timestamp) VALUES ('$crudo','$deveui','$dataFrame','$port','$fcnt','$rssi','$snr','$sf_used','$id','$decrypted','$live','$timestamp');";

$conn->query($sql);




?>


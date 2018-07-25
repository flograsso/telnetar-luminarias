

<!DOCTYPE html>
    <html lang="en" >
<?php
header("Content-Type: text/html;charset=utf-8");

$data = json_decode(file_get_contents('php://input'), true);
http_response_code(200);
$topic=($data["topic"]);
$resource=($data["resource"]);


$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$conn = new mysqli($server, $username, $password, $db);

$datos=json_encode($data);

$sql="INSERT INTO `orbiwise` (crudo,deveui,payload,port,fcnt,rssi,snr,sf_used,payload_id,decrypted,live,timestamp) 
VALUES (
'$datos',
'$data["deveui"]',
'$data["dataFrame"]',
'$data["port"]',
'$data["fcnt"]',
'$data["rssi"]',
'$data["snr"]',
'$data["sf_used"]',
'$data["id"]',
'$data["decrypted"]',
'$data["live"]',
'$data["timestamp"]');";

$conn->query($sql);



echo json_encode($data);
	

?>


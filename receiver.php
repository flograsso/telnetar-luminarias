

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

$sql="INSERT INTO `orbiwise` (valores) VALUES (var_dump($data);";
$conn->query($sql);
var_dump($data);
	

?>
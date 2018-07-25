<!DOCTYPE html>
<html lang="en">
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

if( isset($data["dataFrame"])) //Receive Uplink Payload Callback
{
    $deveui=$data["deveui"];
    $dataFrame= bin2hex(base64_decode($data["dataFrame"]));
    $port=$data["port"];
    $fcnt=$data["fcnt"];
    $rssi=$data["rssi"];
    $snr=$data["snr"];
    $sf_used=$data["sf_used"];
    $id=$data["id"];
    $live=$data["live"];
    $timestamp=$data["timestamp"];
    $decrypted=$data["decrypted"];

    if ($decrypted == NULL)
        $decrypted="0";
    else    
        $decrypted="1";


    $sql="INSERT INTO `orbiwise_uplink` (crudo,deveui,payload,port,fcnt,rssi,snr,sf_used,payload_id,decrypted,live,timestamp) VALUES ('$crudo','$deveui','$dataFrame','$port','$fcnt','$rssi','$snr','$sf_used','$id','$decrypted','$live','$timestamp');";
    $conn->query($sql);
}

elseif( isset($data["transmissionStatus"])) //Downlink Payload Status Callback
{
    $deveui=$data["deveui"];
    $dataDown= bin2hex(base64_decode($data["data"]));
    $port=$data["port"];
    $fcnt=$data["fcnt"];
    $id=$data["id"];
    $transmissionStatus=$data["transmissionStatus"];

    $sql="INSERT INTO `orbiwise_downlink` (deveui,data,id,fcnt,port,transmissionStatus) VALUES ('$deveui','$dataDown','$id','$fcnt','$port','$transmissionStatus');";
    $conn->query($sql);
}
else
{

    $sql="INSERT INTO `orbiwise_others` (data) VALUES ('$crudo');";
    $conn->query($sql);
}

/*
elseif( isset($data["registration_status"])) //Node Info Update Callback
{

}

elseif( isset($data["battery_status"])) //Node Status Update Callback
{

}

elseif( isset($data["join_accept"])) //Join Callback
{

}
*/







?>
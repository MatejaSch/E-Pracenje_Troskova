<?php

function getIp(){
    return $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '';
}


$ip = getIp();
$browser = $_SERVER['HTTP_USER_AGENT'];
$log_date = date('Y-m-d H:i:s');

try{
    $db = new Database();
    $conn = $db->connect();
    $stmt = $conn->prepare("INSERT INTO log_history (id_user,user_ip_address,web_browser, log_date) VALUES (:id_user,:ip_user,:browser, :log_date);");
    $stmt->bindParam(':id_user', $result->id_user);
    $stmt->bindParam(':ip_user', $ip);
    $stmt->bindParam(':browser', $browser);
    $stmt->bindParam(':log_date', $log_date);
    $stmt->execute();
}
catch(PDOException $e){
    exit(json_encode(["error" => $e ->getMessage()]));
}

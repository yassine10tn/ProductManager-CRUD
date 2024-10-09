<?php
try {

    $host = 'localhost'; 
    $dbname = 'productspanel';
    $username = 'root'; 
    $passwordd = ''; 

    
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $passwordd);
} catch (PDOException $e) {
    
    echo "Connection failed: " . $e->getMessage();
    exit();
}
function unique_id()
{
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charLength = strlen($chars);
    $randomString = '';
    for ($i = 0; $i < 20; $i++) {
        $randomString .= $chars[mt_rand(0, $charLength - 1)];
    }
    return $randomString;
}

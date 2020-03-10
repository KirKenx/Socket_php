<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST">
    <input type="text" name="message">
    <input type="submit" name="btnSend">
    </form>
</body>
</html>
<?php
$host    = "127.0.0.1";
$port    = 1111;

// echo "Message To server :".$message;
// create socket
if ( isset($_POST['btnSend']) ) {
    $message = $_POST['message'];
    $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
    // connect to server
    $result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
    // send string to server
    socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
    // get server response
    $result = socket_read ($socket, 1024) or die("Could not read server response\n");
    echo "Reply From Server  :".$result;
    // close socket
    socket_close($socket);
}
?>
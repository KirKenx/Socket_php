<?php 
$host = "127.0.0.1";
$port = 1111;

set_time_limit(0);
// create socket
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
// bind socket to port
$result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");
// start listening for connections
$result = socket_listen($socket, 3) or die("Could not set up socket listener\n");
class Chat{
    function Readline(){
        return rtrim(fgets(STDIN));
    }
}
do{
        // accept incoming connections
    // spawn another socket to handle communication
    $spawn = socket_accept($socket) or die("Could not accept incoming connection\n");
    // read client input
    $input = socket_read($spawn, 1024) or die("Could not read input\n");
    // clean up input string
    $input = trim($input);
    if ($input== "1") break;
    echo "Client Message : ".$input."<br>";
    // $line = new Chat();
    // echo("Enter reply\t ");
    // $reply = $line-->Readline();
    
    // reverse client input and send back
    $reply = strrev($input) . "\n";
    socket_write($spawn, $reply, strlen ($reply)) or die("Could not write output\n");
    // close sockets
    
}while ( true);
socket_close($spawn,$socket);
?>
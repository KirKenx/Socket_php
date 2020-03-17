<?php 
$host = "127.0.0.1";
$port = 1111;

set_time_limit(0);


function rc4($str, $key) {
	$s = array();
	for ($i = 0; $i < 256; $i++) {
		$s[$i] = $i;
	}
	$j = 0;
	for ($i = 0; $i < 256; $i++) {
		$j = ($j + $s[$i] + ord($key[$i % strlen($key)])) % 256;
		$x = $s[$i];
		$s[$i] = $s[$j];
		$s[$j] = $x;
	}
	$i = 0;
	$j = 0;
	$res = '';
	for ($y = 0; $y < strlen($str); $y++) {
		$i = ($i + 1) % 256;
		$j = ($j + $s[$i]) % 256;
		$x = $s[$i];
		$s[$i] = $s[$j];
		$s[$j] = $x;
		$res .= $str[$y] ^ chr($s[($s[$i] + $s[$j]) % 256]);
	}
	return $res;
}

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
    $input=rc4($input,"key");
    $input = trim($input);
    if ($input== "1") break;
    echo "Client Message : ".$input."<br>";
    // $line = new Chat();
    // echo("Enter reply\t ");
    // $reply = $line-->Readline();
    
    // reverse client input and send back
	$reply = strrev($input) . "\n";
	$reply = rc4( $reply,"key");
    socket_write($spawn, $reply, strlen ($reply)) or die("Could not write output\n");
    // close sockets
    
}while ( true);
socket_close($spawn,$socket);
?>
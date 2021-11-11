<?php

require __DIR__ . '/vendor/autoload.php';



// Change the following with your app details:

// Create your own pusher account @ https://app.pusher.com


$options = array(

   'cluster' => 'ap1',

   'encrypted' => true

 );

 $pusher = new Pusher\Pusher(

   'e26a7e1d8f0abe98f18d',

   'fd4c82b13cd6057f2bca',

   '1293574',

   $options

 );



// Check the receive message

if(isset($_POST['name']) and isset($_POST['msg'])) {

$name = $_POST['name'];
$msg = $_POST['msg'];


$data['message'] = array(
    'name' => $name,
    'msg' => $msg
);

$pusher->trigger( 'live-chat', 'send-message', $data );




}



<!DOCTYPE html>
<head>	
	<title>Pusher Test</title>	
<link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" type="text/javascript" ></script>	
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript" ></script>	
<script src="//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.3.0/bootbox.min.js" type="text/javascript" ></script>				
	
<style = "text/css">	
.messages_display {height: 300px; overflow: auto;}		
.messages_display .message_item {padding: 0; margin: 0; }		
.bg-danger {padding: 10px;}	
.message_item{
    background-color: #deb887;
    color: black;
    font-weight: bold;
    margin: 10px 10px !important;
    border-radius: 10px;
}
.msg{
    font-size: 16px;
    margin: 5px 10px;
    padding: 5px 10px;
}
.name{
    font-size: 12px;
    margin: 5px 10px;
    padding: 5px 10px;

}

.messages_display{
    background-image: url('bg1.jpg');
    background-repeat: no-repeat;
    background-size: cover;
}

</style>		
</head>
<body>

<br />	

<!--Form Start-->
<div class = "container">		
	<div class = "col-md-6 col-md-offset-3 chat_box" id="chatbox">						
		<div class = "form-control messages_display"></div>			
		<br />						
		<div class = "form-group">						
			<input type = "text" class = "input_name form-control" placeholder = "Enter Name" id="name"/>			
		</div>						
		<div class = "form-group">						
			<textarea class = "input_message form-control" placeholder = "Enter Message" rows="5" id="msg"></textarea>			
		</div>						
		<div class = "form-group input_send_holder">				
			<input type = "submit" value = "Send" class = "btn btn-primary btn-block input_send" id="send_msg" />			
		</div>					
	</div>	
<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    // Add API Key & cluster here to make the connection 
    var pusher = new Pusher('e26a7e1d8f0abe98f18d', {
        cluster: 'ap1'
    });

    // Enter a unique channel you wish your users to be subscribed in.
    var channel = pusher.subscribe('live-chat');

    // bind the server event to get the response data and append it to the message div
    channel.bind("send-message", (data) => {
            console.log(data);
            // alert(data);
            // $('.messages_display').append("Hello");
            if(data['message']['name'] != null){
                $('.messages_display').append('<p class = "message_item"><span class="msg">' + data['message']['msg'] + '</span><br><span class="name">'+data['message']['name']+'</span></p>');
                // $('.input_send_holder').html('<input type = "submit" value = "Send" class = "btn btn-primary btn-block input_send" />');
                $(".messages_display").scrollTop($(".messages_display")[0].scrollHeight);
            }
        });

    // check if the user is subscribed to the above channel
    channel.bind('pusher:subscription_succeeded', function(members) {
        console.log('successfully subscribed!');
        console.log(members);
    });


    $("#send_msg").click(function(){
    let name = $("#name").val();
    let msg = $("#msg").val();
    var data = [];
    data ={
        name : name,
        msg : msg
    }
    // alert(name);
    if (name === '') {
        bootbox.alert('<br /><p class = "bg-danger">Please enter a Name.</p>');
    } 

	else if (name !== '') {
        $.post('message.php', data, function(res){
            console.log(res);
        });
        $("#msg").val("");
    }
});

</script>
</div>
</body>
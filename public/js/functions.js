$(document).ready(function () {
    // FORM MESSAGE CHAT
    $('#form-message').submit(function(event){
        event.preventDefault();

        $.post(
            '/ajout-message',
            $(this).serialize(),
            function () {

            }
        );
        $('input[name="message"]',this).val('');
    });

    function getMessage(){

        var userId = $('#input_message_to').val();
        console.log(userId);

        $.get(
            '/chat-messages',
            'user=' + userId,
            function(response){
                $('#message-container').append(response);
            }
        );
    }
getMessage();
    //setInterval(getMessage, 2000);

});
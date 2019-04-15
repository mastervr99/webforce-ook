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
        $.get(
            '/chat-messages',
            function(response){
                $('#message-container').append(response);
            }
        );
    }
    if(hasUser){
        setInterval(getMessage, 2000);
    }

}
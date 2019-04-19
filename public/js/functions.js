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




// ------------ particlesJS --------------

particlesJS

("particles-js", {
    "particles": {
        "number": {"value": 80, "density": {"enable": true, "value_area": 800}},
        "color": {"value": "#ffffff"},
        "shape": {
            "type": "circle",
            "stroke": {"width": 0, "color": "#000000"},
            "polygon": {"nb_sides": 5},
            // "image": {"src": "img/github.svg", "width": 100, "height": 100}
        },
        "opacity": {
            "value": 0.5,
            "random": false,
            "anim": {"enable": false, "speed": 1, "opacity_min": 0.1, "sync": false}
        },
        "size": {"value": 3, "random": true, "anim": {"enable": false, "speed": 40, "size_min": 0.1, "sync": false}},
        "line_linked": {"enable": true, "distance": 150, "color": "#ffffff", "opacity": 0.4, "width": 1},
        "move": {
            "enable": true,
            "speed": 6,
            "direction": "none",
            "random": false,
            "straight": false,
            "out_mode": "out",
            "bounce": false,
            "attract": {"enable": false, "rotateX": 600, "rotateY": 1200}
        },
    },

    "interactivity": {
        "events": {
            "onhover": {
                "enable": false,
            },
            "onclick": {
                "enable": false,
            },
        },

    },

    "retina_detect": true
});


// // ------------ MODAL --------------


$(document).ready(function(){
    $('#MybtnModal').click(function(){
        $('#Mymodal').modal('show')
    });
});


// // ------------ TOGGLE --------------
//
//CSS
// <input type="checkbox" id="menu34" />
//     <label for="menu34">
//JS
// var inputs = document.getElementsByTagName("toggle-cross"),
//     labels = document.getElementsByTagName("toggle-cross");
//
//
// // Flashes menus on load
// document.addEventListener("DOMContentLoaded", function(event) {
//     check(true);
// });




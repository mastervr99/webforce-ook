$(document).ready(function () {
// FORM MESSAGE CHAT
// ---------------------------------------------------------
    $('#form-message').submit(function (event) {
        event.preventDefault();

        $.post(
            '/ajout-message',
            $(this).serialize(),
            function () {

            }
        );
        $('#input_message_content', this).val('');
    });

    function getMessage() {

        var userId = $('#input_message_to').val();
        console.log(userId);

        $.get(
            '/chat-messages',
            'user=' + userId,
            function (response) {
                $('#message-container').append(response);
            }
        );
    }

    //getMessage();
    setInterval(getMessage, 10000);

});


// NAVBAR
// ---------------------------------------------------------


// $(document).ready(function (navbarColorScroll) {
//     $(window).scroll(function (navbarColorScroll) {
//         if ($(document).scrollTop() < 15) {
//             $("#mainNav").css({
//                 "background-color:": "rgba(246,246,29,0.5)",
//                 "height": "100px",
//                 "transition": "0.5s"
//             })
//
//         } else {
//             $("#mainNav").css({
//                 "background-color:": "rgba(153,46,62,0.9)",
//                 "height": "50px",
//                 "transition": "0.5s"
//             })
//         }
//     });
// });


// PARTICLES JS
// ---------------------------------------------------------

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


// MODAL
// ---------------------------------------------------------


// $(document).ready(function () {
//     $('#btnModal').click(function () {
//         $('#Mymodal').modal('show')
//     });
// });
// $(document).ready(function () {
//     $('#btnModal').click(function () {
//         $('#Mymodal').modal('show')
//     });
// });
//

// bouton delete ds list-contact
//  -------------------------------


var timer;
var active;
timer = function () {

    if ($(".archive-button").hasClass("btn-success")) {
    } else {
        $(".archive-button").removeClass("btn-danger").addClass("btn-secondary");
    }
}

$(".archive-button").click(function () {
    if ($(this).hasClass("btn-secondary")) {
        $(this).addClass("btn-danger").removeClass("btn-secondary");
        setTimeout(timer, 4000);

    } else {
        if ($(this).hasClass("btn-danger")) {
            $(this).removeClass("btn-danger").addClass("btn-success");


            setTimeout(function () {
                $(".archive-button").removeClass("btn-success").addClass("btn-secondary");
            }, 1500);

            let route = "{{ path('blog_show', {'slug': 'my-blog-post'})|escape('js') }}";

        } else {
            if ($(this).hasClass("btn-success")) {
                $(this).removeClass("btn-secondary").removeClass("btn-danger");

            }
        }
    }
});


// UPLOAD DE PHOTOS
// ---------------------------------------------------------

// $(document).ready(function () {
//     var uploadPhoto = document.getElementById('photoUpload');
//     uploadPhoto.className = 'attachment_upload';
//     uploadPhoto.onchange = function () {
//         document.getElementById('fakeUploadLogo').value = this.value.substring(12);
//     };
//
//     function readURL(input) {
//         if (input.files && input.files[0]) {
//             var reader = new FileReader();
//
//             reader.onload = function (e) {
//                 $('.img-preview').attr('src', e.target.result);
//             };
//             reader.readAsDataURL(input.files[0]);
//         }
//     }
//
//     $("#photoUpload").change(function () {
//         readURL(this);
//     });
// });
//

$("input[data-preview]").change(function() {
    var input	= $(this);
    var oFReader	= new FileReader();
    oFReader.readAsDataURL(this.files[0]);
    oFReader.onload	= function(oFREvent) {
        $(input.data('preview')).attr('src', oFREvent.target.result);
    };
});

// MAP
// ---------------------------------------------------------



// On initialise la latitude et la longitude de Paris (centre de la carte)
var lat = 48.852969;
var lon = 2.349903;
var macarte = null;

// Fonction d'initialisation de la carte
function initMap() {
    // Créer l'objet "macarte" et l'insèrer dans l'élément HTML qui a l'ID "map"
    macarte = L.map('map').setView([lat, lon], 11);
    // Leaflet ne récupère pas les cartes (tiles) sur un serveur par défaut. Nous devons lui préciser où nous souhaitons les récupérer. Ici, openstreetmap.fr
    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
        // Il est toujours bien de laisser le lien vers la source des données
        attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
        minZoom: 1,
        maxZoom: 20
    }).addTo(macarte);

    //  marqueur
    var marker = L.marker([lat, lon]).addTo(macarte);
}

window.onload = function () {
    // Fonction d'initialisation qui s'exécute lorsque le DOM est chargé
    initMap();
};


// // transformer une adresse en coordonnées GPS // Google Maps Geocoder
//
// $geocoder = "http://maps.googleapis.com/maps/api/geocode/json?address=%s&sensor=false";
//
// $arrAddresses = Address::LoadAll(); // Notre collection d'objets Address
//
// foreach ($arrAddresses as $address) {
//
//     if (strlen($address->Lat) == 0 && strlen($address->Lng) == 0) {
//
//         $adresse = $address->Rue;
//         $adresse .= ', '.$address->CodePostal;
//         $adresse .= ', '.$address->Ville;
//
//         // Requête envoyée à l'API Geocoding
//         $query = sprintf($geocoder, urlencode(utf8_encode($adresse)));
//
//         $result = json_decode(file_get_contents($query));
//         $json = $result->results[0];
//
//         $adress->Lat = (string) $json->geometry->location->lat;
//         $adress->Lng = (string) $json->geometry->location->lng;
//         $adress->Save();
//
//     }
// }


// SCROLL TO TOP
// ---------------------------------------------------------

$(window).scroll(function () {
    if ($(this).scrollTop() >= 50) {
        $('#return-to-top').fadeIn(200);
    } else {
        $('#return-to-top').fadeOut(200);
    }
});
$('#return-to-top').click(function () {
    $('body,html').animate({
        scrollTop: 0
    }, 500);
});
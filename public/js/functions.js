$(document).ready(function () {

    $('.confsup').on('click', function () {  // confirmer la suppression
        return (confirm('Etes vous certain de vouloir supprimer ce produit?'));
    });


    if ($('#maModale').length == 1) {// tester la présence de ma div sur la page
        $('#maModale').modal('show'); // la modale s'affiche : petite fenetre popup
    }

    if ($('.cookies').length == 1) { // si la div est présente on anime la div avec les fonctions de jquery
       $('.cookies').animate({ bottom: 0}, 1500);

       $('#accept').on('click', function() {
           $('.cookies').animate({ bottom: '-70px'}, 1500);
           d = new Date();
           d.setTime( d.getTime() + 90*24*60*60*1000 ); // definition de la duree de vie du cookie 90 jours
           document.cookie = "acceptCookies=true;expires=" + d.toGMTString();
       });
    }

}); // FIN du Document Ready

var app = require('express')(),
    server = require('http').createServer(app),
    io = require('socket.io').listen(server),
    ent = require('ent'), // Permet de bloquer les caractères HTML (sécurité équivalente à htmlentities en PHP)

// Chargement de la page index.html
    app.get('/', function (req, res) {
    res.sendfile(__dirname + '/index.html');
});

io.sockets.on('connection', function (socket, pseudo) {
    // Dès qu'on nous donne un pseudo, on le stocke en variable de session et on informe les autres personnes
    socket.on('nouveau_client', function(pseudo) {
        pseudo = ent.encode(pseudo);
        socket.pseudo = pseudo;
        socket.broadcast.emit('nouveau_client', pseudo);
    });

    // Dès qu'on reçoit un message, on récupère le pseudo de son auteur et on le transmet aux autres personnes
    socket.on('message', function (message) {
        message = ent.encode(message);
        socket.broadcast.emit('message', {pseudo: socket.pseudo, message: message});
    });
});

server.listen(8080);

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
import '../scss/home.scss';

//On recupère l'id du bouton
var mybutton = document.getElementById("topButton");

// Quand on commence à scroller vers le bas de 20px, le bouton apparaît
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        mybutton.style.display = "block";
        mybutton.onclick = topFunction;
    } else {
        mybutton.style.display = "none";
    }
}

// Lorsqu'on clique sur le bouton, on est ramener en haut de la page
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

$(document).ready(function () {
    $(".navButton").on("click", function () {
        $("nav ul").toggleClass("open");
        $(".menu").toggleClass("open");
        $("nav a").toggleClass("open");
        $("nav").toggleClass("open");
        $(".navButton hr").toggleClass("open");
    });
});

function navBarScroll() {
    var navBar = document.getElementById('nav');
    var currentY = window.pageYOffset;
    if (currentY > 350) {
        navBar.style.opacity = "0.8";
        //navBar.style.fontSize = "8px"
    }
    else {
        navBar.style.opacity = "1";
        //navBar.style.fontSize = "11px"
    }
}
window.addEventListener("scroll", navBarScroll);
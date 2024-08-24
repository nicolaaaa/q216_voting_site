document.getElementById('sidebar-expand-toggle').addEventListener('click', function () {
    toggleSidebar();
});
document.getElementById('sidebar-close-toggle').addEventListener('click', function () {
    toggleSidebar();
});

function getCookie(name) {
    var re = new RegExp(name + "=([^;]+)");
    var value = re.exec(document.cookie);
    return (value != null) ? unescape(value[1]) : null;
}


$(function () {
    let visit = getCookie("q216_session");
    console.log(visit);

    if (visit == null) {
        let expire = new Date();
        expire = new Date(expire.getTime() + 7776000);

        let sid = (Math.random() + 1).toString(36).substring(7);
        document.cookie = "q216_session=" + sid + "; expires=" + expire;

        document.getElementById("no_cookie").value = sid;

        document.querySelector("#cookie").value = sid;

    }
});




function setVh() {
    let vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
}

window.addEventListener('resize', setVh);
window.addEventListener('orientationchange', setVh);
window.addEventListener('load', setVh);
setVh();
$('.heart.enabled').on('click', function (e) {
    console.log("heart")
    $(this).closest('form').submit();
});
$('.no.enabled').on('click', function (e) {
    console.log("no")
    $(this).closest('form').submit();
});
$('.messages').on('click', function (e) {
    console.log("ijj")
    $(this).closest('form').submit();
});


function toggleSidebar() {

    if (document.querySelector(".side").className.includes("side_mini")) {
        document.querySelector(".side").classList.remove("side_mini");
        document.querySelector(".side").className += " side_max";

        document.querySelector(".content").className += " side_max_active";

        document.querySelector(".menu_icon").classList.remove("fa-angle-double-right");

        document.querySelector(".menu_icon").className += " fa-angle-double-left";

    } else {
        document.querySelector(".side").className += " side_mini";

        document.querySelector(".side").classList.remove("side_max");

        document.querySelector(".content").classList.remove("side_max_active");

        document.querySelector(".menu_icon").classList.remove("fa-angle-double-left");

        document.querySelector(".menu_icon").className += " fa-angle-double-right";

    }

}



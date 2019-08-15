document.getElementsByClassName("episode-brick").forEach(function(element){
    element.children[0].style.backgroundImage = "url('" + element.children[0].getAttribute("data-thumb-image") +"')";
    element.children[0].addEventListener("mouseenter", function(){
        element.children[0].style.backgroundImage = "url('" + element.children[0].getAttribute("data-thumb-video") + "')";
    });
    element.children[0].addEventListener("mouseout", function(){
        element.children[0].style.backgroundImage = "url('" + element.children[0].getAttribute("data-thumb-image") +"')"
    });
});
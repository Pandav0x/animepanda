document.getElementsByClassName('episode-brick').forEach(function(element){
    let target = element.children[0];
    target.style.backgroundImage = `url('${target.getAttribute("data-thumb-image")}')`;
    target.addEventListener('mouseenter', function(){
        target.style.backgroundImage = `url('${target.getAttribute("data-thumb-video")}')`;
    });
    target.addEventListener('mouseout', function(){
        target.style.backgroundImage = `url('${target.getAttribute("data-thumb-image")}')`
    });
});
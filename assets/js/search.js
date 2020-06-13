if(document.getElementsByClassName("tag-inline-delete"))
{
    document.getElementsByClassName("tag-inline-delete").forEach(function(element){
        element.addEventListener("click", function(){
            element.parentNode.parentNode.removeChild(element.parentNode)
        });
    });
}
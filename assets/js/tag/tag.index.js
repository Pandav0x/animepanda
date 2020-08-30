'use strict';

if(document.getElementsByClassName("tag-item") !== null)
{
    document.getElementsByClassName("tag-item").forEach(function(element){
        element.addEventListener("click", function(){
            element.classList.toggle("tag-selected");
        });
    });
}

if(document.getElementById("search-tags") !== null)
{
    document.getElementById("search-tags").addEventListener("click", function(){
        let tags = [];
        document.getElementsByClassName("tag-selected").forEach(function(el){
            tags.push(el.id);
        });

        redirectPost(
            document.getElementById("search-tags").getAttribute("data-url"),
            JSON.stringify(tags)
        );
    });
}

if(document.getElementById("reset-tags") !== null)
{
    document.getElementById("reset-tags").addEventListener("click", function(){
        document.getElementsByClassName("tag-item").forEach(function(el){
            el.classList.remove("tag-selected");
        });
    });
}


function redirectPost(url, data) {
    if(document.getElementById("tags-temp-form") === null)
    {
        let form = document.createElement('form');
        document.body.appendChild(form);
        form.setAttribute("type", "hidden");
        form.method = 'post';
        form.action = url;
        form.id = "tags-temp-form";

        let input = document.createElement('input');
        input.setAttribute("type", "hidden");
        input.name = "tags";
        input.value = JSON.parse(data);
        form.appendChild(input);

        form.submit();
    }
}


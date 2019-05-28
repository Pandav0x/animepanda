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
        var tags = [];
        document.getElementsByClassName("tag-selected").forEach(function(el){
            tags.push(el.innerHTML);
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
    var form = document.createElement('form');
    document.body.appendChild(form);
    form.method = 'post';
    form.action = url;

    var input = document.createElement('input');
    input.name = "tags";
    input.value = JSON.parse(data);
    form.appendChild(input);

    form.submit();

    console.log(form);
}


'use strict';

var explodedUrl = (window.location + '').split('/');
var currentPage = explodedUrl[explodedUrl.length - 2] + "s";

if(explodedUrl.length == 4)
    currentPage= "homepage";

if(document.querySelector("[id$='" + currentPage  + "']") !== null){
    document.querySelector("[id$='" + currentPage  + "']").classList.add("top-nav-selected");
}

document.getElementById("nav-input-button").addEventListener("click", function(){
    var search = document.getElementById("nav-input-search").value.trim();
    if(search != "")
        console.log(search);
});
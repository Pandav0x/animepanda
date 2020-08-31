'use strict';

let navElement = document.getElementById("side-nav-wrapper");
let explodedUrl = (window.location + '').split('/');
let currentPage = explodedUrl[explodedUrl.length - 2] + "s";

if(explodedUrl.length === 4){
    currentPage= "homepage";
}

if(navElement.querySelector("[id$='" + currentPage  + "']") !== null){
    navElement.querySelector("[id$='" + currentPage  + "']").classList.add("top-nav-selected");
}

document.getElementById("nav-input-button").addEventListener("click", function(){
    let search = document.getElementById("nav-input-search").value.trim();
    if(search !== '')
        console.log(search);
});
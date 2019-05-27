'use strict';

var explodedUrl = (window.location + '').split('/');
var currentPage = explodedUrl[explodedUrl.length - 2] + "s";

if(explodedUrl.length == 4)
    currentPage= "homepage";

document.querySelector("[id$='" + currentPage  + "']").classList.add("top-nav-selected");
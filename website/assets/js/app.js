'use strict';

//style files
require('../css/fonts.css');
require('../css/app.less');

//pictures
require('../images/favicon.ico');
require('../images/logo.png');

//fonts
require('../fonts/notoserifjp-light.otf');
require('../fonts/notoserifjp-light.woff');
require('../fonts/notoserifjp-light.woff2');
require('../fonts/notoserifjp-medium.otf');
require('../fonts/notoserifjp-medium.woff');
require('../fonts/notoserifjp-medium.woff2');
require('../fonts/notoserifjp-regular.otf');
require('../fonts/notoserifjp-regular.woff');
require('../fonts/notoserifjp-regular.woff2');
require('../fonts/notoserifkr-light.otf');
require('../fonts/notoserifkr-light.woff');
require('../fonts/notoserifkr-light.woff2');
require('../fonts/notoserifkr-medium.otf');
require('../fonts/notoserifkr-medium.woff');
require('../fonts/notoserifkr-medium.woff2');
require('../fonts/notoserifkr-regular.otf');
require('../fonts/notoserifkr-regular.woff');
require('../fonts/notoserifkr-regular.woff2');
require('../fonts/raleway-medium.ttf');
require('../fonts/raleway-medium.woff');
require('../fonts/raleway-medium.woff2');
require('../fonts/raleway-regular.ttf');
require('../fonts/raleway-regular.woff');
require('../fonts/raleway-regular.woff2');
require('../fonts/raleway-thin.ttf');
require('../fonts/raleway-thin.woff');
require('../fonts/raleway-thin.woff2');
require('../fonts/robotoslab-light.ttf');
require('../fonts/robotoslab-light.woff');
require('../fonts/robotoslab-light.woff2');
require('../fonts/robotoslab-regular.ttf');
require('../fonts/robotoslab-regular.woff');
require('../fonts/robotoslab-regular.woff2');
require('../fonts/robotoslab-thin.ttf');
require('../fonts/robotoslab-thin.woff');
require('../fonts/robotoslab-thin.woff2');


//main functions
//TODO in future updates of JS, use the "?." operator instead of checking if the selector is null

document.addEventListener('DOMContentLoaded', function(){
    require('../js/header.js');
    require('../js/tags.js');
    require('../js/search.js');
}, false);
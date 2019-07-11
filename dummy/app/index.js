'use strict';

const app = require('express')();
const express = require('express');
const http = require('http').Server(app);
var document = require('html-element').document;
const fs = require('fs');

var config = JSON.parse(
    fs.readFileSync("../fetcher/config.test.json")
);


console.log("deleting previously generated pages");
cleanPages();


console.log("generating new pages");
createPages();
fillPages()

/*http.listen(3000, function(){
    console.log('listening on *:3001');
});*/

app.get('/*', function(request, responce){
    responce.sendFile(__dirname+  "/pages/index.html");
});

function randString(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
       result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
 }


function cleanPages()
{
    fs.readdir("./pages", (err, files) => {
        files.forEach(file => {
            fs.unlinkSync("./pages/" + file);
        });
    });
}

function createPages()
{
    var baseDocumentContent = fs.readFileSync("./app/basePage.html").toString();
    var numberFiles = Math.pow(config["websiteDummy"]["layerRedundance"],(config["websiteDummy"]["layerUrls"].length - 1));
    for(var i = 0; i < numberFiles; i++)
    {
        var fileName = randString(20);
        fs.writeFile("./pages/" + fileName + ".html",
        baseDocumentContent.replace(/%TITLE%/g, fileName),
            function(err){}
        );
    }
    console.log("number of files generated: " + numberFiles);
}

function fillPages()
{
    fs.readdir("./pages/", function(error, files){
        //console.log(files);
    });
}
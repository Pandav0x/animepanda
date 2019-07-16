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
var indexPage = fillPages();

console.log(indexPage);

/*http.listen(3000, function(){
    console.log('listening on *:3001');
});

app.get('/', function(request, responce){
    responce.sendFile(__dirname+  "/pages/" + indexPage + ".html");
});

app.get('/*', function(request, responce){
    responce.sendFile(__dirname+  "/pages/index.html");
});*/

function randString(length)
{
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
       result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

function getPages()
{
    return fs.readdirSync("./pages/");
}

function getRandomIndex(array)
{
    return array[Math.floor(Math.random() * array.length)];
}

function cleanPages()
{
    var files = getPages();
    files.forEach(file => {
        fs.unlinkSync("./pages/" + file);
    });
}

function sumPow(number, power)
{
    return (Math.pow(number,power) - 1) / (number - 1);
}

function createPages()
{
    var baseDocumentContent = fs.readFileSync("./app/basePage.html").toString();
    var numberFiles = sumPow(config["websiteDummy"]["layerRedundance"],
                        config["websiteDummy"]["layerUrls"].length);

    for(var i = 0; i < numberFiles; i++)
    {
        var fileName = randString(20);
        fs.writeFileSync("./pages/" + fileName + ".html",
            baseDocumentContent.replace(/%TITLE%/g, fileName), function(err){});
    }
}

function fillPages()
{
    var files = getPages();
    var stuffing = "";
    var index;
    for(var i = 0; i <= (config["websiteDummy"]["layerUrls"].length - 1); i++)
    {
        var baseDocumentContent;
        for(var j = 0; j < Math.pow(config["websiteDummy"]["layerRedundance"], i); j++)
        {
            var stuffingName = getRandomIndex(files);
            files.splice(files.indexOf(stuffingName), 1);
            if(j % config["websiteDummy"]["layerRedundance"] == 0)
            {
                console.log(stuffing != "");
                if(stuffing != "")
                {
                    fs.writeFileSync("./pages/" + stuffedName, baseDocumentContent.replace(/%BODY%/g, stuffing),function(err){});
                    stuffing = "";
                }
                var stuffedName = getRandomIndex(files);
                if(stuffedName == null)
                    break;
                baseDocumentContent = fs.readFileSync("./pages/" + stuffedName).toString();
                files.splice(files.indexOf(stuffedName), 1);

            }
            stuffing += "<a href='" + stuffingName + "'>" + stuffingName + "</a>";
            if(i == 0)
                index = stuffedName;
        }
        console.log("layer: " + i + " pages linked: " + j)
    }
    return index;
}
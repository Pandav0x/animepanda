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

//TODO remove comment chars to make if functional
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
    console.log(fs.existsSync("./pages"));
    fs.readdir("./pages", (err, files) => {
        files.forEach(file => {
            fs.unlinkSync("./pages/" + file);
        });
    });
}

function createPages()
{
    var files = [];
    var baseDocumentContent = fs.readFileSync("./app/basePage.html").toString();
    console.log(baseDocumentContent);
    var currentContent = "";
    for(var i = config["websiteDummy"]["layerUrls"].length; i > 0; i--)
    {
        for(var j = 0; j < Math.pow(config["websiteDummy"]["layerRedundance"], (i-1)); j++) //V fichiers
        {
            currentContent = baseDocumentContent;
            if(files[i] == undefined)
            {
                files.push(i);
                files[i] = [];
            }

            var fileName = randString(20);
            currentContent = currentContent.replace(/%TITLE%/g, fileName);
            files[i].push(fileName);
        }
    }
    for(var k = config["websiteDummy"]["layerUrls"].length - 1; k > 0; k--) //
    {
        console.log("allow ! ", k-1);
        var bodyContent = "";
        if(k-1 >= 0 && k-1 != config["websiteDummy"]["layerUrls"].length)
        {
            var index = Math.floor(Math.random()*files.length);
            console.log(files, index);
            bodyContent = "<a href='" + files[i] + "'>Link</a>";
            files.splice(index, 1);
        }
        currentContent = currentContent.replace(/%BODY%/g, bodyContent);
        fs.writeFile("./pages/" + fileName + ".html", currentContent, function(err){});
    }

}
var app = require('express')();
const fs = require('fs');
var http = require('http').Server(app);
var mysql = require('mysql');
var Crawler = require("crawler");

var animeList = [];

var rawdata = fs.readFileSync('urls.json');  
var urls = JSON.parse(rawdata); 

/**
 * DB connection
 */
var dbconn = mysql.createConnection({
    host: "127.0.0.1",
    user: "root",
    password: ""
});

dbconn.connect(function(err) {
    if (err) throw err;
    console.log("Connected to database");
});

/**
 * Crawler setup
 */
console.log("Crawler setup")
var crawler = new Crawler();

/**
 * Crawling
 */
console.log("Finding anime list");
crawler.queue([{
    uri: urls["animeList"], 
    callback: function (error, res, done) {
        if(error)
            console.log(error);
        else
        {
            var $ = res.$;
            //TODO: instert raw name in db
            animeList = $(".anm_det_pop.pop_info")
                .text()
                .toLowerCase()
                .replace(/!|:|;|\-|–|'|&|>|<|…|’|,|\?/g, '')
                .replace(/^[\ ]*/gm, '')
                .replace(/[\ ]*$/gm, '')
                .replace(/\ /g, '-')
                .split("\n")
                .filter(function(entry) { 
                    return entry.trim() != ''; 
                });
                
        }

        animeList.forEach(function(element){ //just a debug feature
            console.log(element);
        });

        done();
    }
}]);

/**
 * Routing (cause, why not ?)
 */
app.get('/', function(request, res){
    console.log("Connection from " + request.connection.remoteAddress);
    res.sendFile(__dirname+'/public/index.html');
});

/**
 * Entry point
 */
http.listen(3000, function(){
    console.clear();
    console.log('listening on *:3000');
});
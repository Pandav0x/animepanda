var app = require('express')();
const express = require("express");
var http = require('http').Server(app);
var mysql = require('mysql');
var Crawler = require("crawler");

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
var crawler = new Crawler({
    maxConnections : 10,
    // This will be called for each crawled page
    callback : function (error, res, done) {
        if(error){
            console.log(error);
        }else{
            var $ = res.$;
            // $ is Cheerio by default
            //a lean implementation of core jQuery designed specifically for the server
            console.log($("title").text());
        }
        done();
    }
});

crawler.queue(['http://google.com']);

/**
 * Routing
 */
app.get('/', function(request, res){
    console.log("Connection from " + request.connection.remoteAddress);
    res.sendFile(__dirname+'/public/index.html');
});

/**
 * Entry point
 */
http.listen(3000, function(){
    console.log('listening on *:3000');
});
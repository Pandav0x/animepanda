'use strict';

/**
 * Adding behavior
 */
String.prototype.contains = function(needles){
    var ans = false;
    if(needles != null){
      var subject = this;
      needles.forEach(function(needle){
          if(subject.includes(needle))
              ans = true;
      });
    }
    return ans;
}

/**
 * Dependencies
 */
const fs        = require('fs');
const http      = require('http').Server(app);
const mysql     = require('mysql');
const Crawler   = require("js-crawler");
var cheerio     = require("cheerio");
var Base64      = require("base-64")

/**
 * Loading conf file
 */
var config = JSON.parse(fs.readFileSync('config.json')); 

/**
 * DB connection
 */
var dbConnection = mysql.createConnection({
    host: "127.0.0.1",
    user: "root",
    password: "",
    database: "animepanda"
});

dbConnection.connect(function(err) {
    if (err)
        console.log("could not establish connection with database (" + err + ")");
    else
        console.log("Connected to database.");
});

/**
 * Crawler setup
 */
console.log("Crawler setup");
var crawlerOptions = {
    depth: 3,
    userAgent: "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)",
    maxRequestsPerSecond: 3,
    maxConcurrentRequests: 20
};
console.log("current crawler config: %j", crawlerOptions);
var crawler = new Crawler().configure(crawlerOptions);

/**
 * Crawling
 */
console.log("Finding anime list");
var startTime = new Date();

crawler.crawlFiltered({
    url: config["url"],
    includes: config["includes"],
    excludes: config["excludes"],
    success: function(page){
        onlineWrite(page.url, 50);
        var $ = cheerio.load(page.body)
        var url = null;
        url = $("iframe.metaframe.rptss").attr("src");
        if(url != null){
            var tmp = $("head>title").text();
            var animeName = tmp.substr(7, (tmp.lastIndexOf("Episode")-8))
                                .replace(/\'/gm, '\\\'');
            var episodeUrlEncoded = url.substring(url.indexOf("?p=")+3);
            var url = episodeUrlEncoded;
            try 
            {  url = Base64.decode(episodeUrlEncoded); }
            catch(error){}
            if(!url.includes("//"))
                url = (config["serverurl"] + url)
            url = url.replace(/\'/gm, '\\\'').replace(/tps:\/\//gm, "http:\/\/");;
            try{
                onlineWrite("INSERT INTO animesurls (animeurl, animename) VALUES (\'" + url + "\', \'" + animeName + "\');");
                dbConnection.query("INSERT INTO animesurls (animeurl, animename) VALUES (\'" + url + "\', \'" + animeName + "\');");
            }
            catch(err)
            {
                console.log(err);
            }
        }
    },
    failure: function(page){
        onlineWrite("status " + page.status + " for " + page.url, 70);
    }, 
    finished: function(crawledUrls){
        console.log("total: " + crawledUrls.length + " urls crawled");
        var endTime = new Date() - startTime;
        console.log("Execution time: %dms", endTime);
    }
});

function onlineWrite(string, crop = 200)
{
    process.stdout.clearLine();
    process.stdout.cursorTo(0);
    process.stdout.write((string.length > crop)? string.substring(0,crop) : string);
}

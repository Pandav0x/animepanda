'use strict';

const fs        = require('fs');
const mysql     = require('mysql');
const Crawler   = require("../node_custom/js-crawler/crawler.js");
var cheerio     = require("cheerio");
var Base64      = require("base-64");
var helpers     = require("helpers");

var config = JSON.parse(fs.readFileSync('config.json'));
var dbConnection = mysql.createConnection(config.database);
var Utils = new helpers.Utils();

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
var crawler = new Crawler().configure(config.crawler);

/**
 * Crawling
 */
console.log("Finding anime list");
var startTime = new Date();
//*
crawler.crawlFiltered({
    url: config.website.url,
    includes: config.website.includes,
    excludes: config.website.excludes,
    success: function(page){

        Utils.onlineWrite(page.url);

        var $ = cheerio.load(page.body);
        var url = $(config.website.videoselector).attr("src") || null;

        if(url != null)
        {
            var animeName = Utils.sanitizeTitle($("head>title").text());
            var episodeUrlEncoded = url.substring(url.indexOf("?p=")+3); //can be ?id= but is on the tp://upvid.eu/cup/cup.php website
            var url = episodeUrlEncoded;
            try 
            {  
                url = Base64.decode(episodeUrlEncoded); 
            }
            catch(error)
            {

            }
            if(!url.includes("//"))
                url = (config["serverurl"] + url)
            url = url.replace(/\'/gm, '\\\'').replace(/tps:\/\//gm, "http:\/\/"); //seems that tps:// is replaced with tp://
            try
            {
                dbConnection.query("INSERT INTO animesurls (animeurl, animename) VALUES (\'" + url + "\', \'" + animeName + "\');");
            }
            catch(err)
            {
                console.log(err);
            }
        }
    },
    failure: function(page){
        Utils.onlineWrite(page.status + "-" + page.url);
    }, 
    finished: function(crawledUrls){
        var endTime = new Date() - startTime;
        console.log("Execution time: %dms", endTime);
    }
});

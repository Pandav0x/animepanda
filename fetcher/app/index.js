'use strict';

var argv = [];
for(var i = 2; i < process.argv.length; i++)
    argv.push(process.argv[i]);

require("../node_custom/helpers/helpers"); //add behavior to data struct

const fs        = require('fs');
const mysql     = require('mysql');
const cheerio   = require("cheerio");

const Crawler   = require("../node_custom/js-crawler/crawler.js");
const Utilities = require("../node_custom/helpers/utilities");

var config = JSON.parse(
    fs.readFileSync("config" + ((argv[0] == "test")? ".test": "") + ".json")
);
var dbConnection = mysql.createConnection(config.database);
var utils = new Utilities();

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
    url: config.website.crawlingUrl,
    includes: config.website.includes,
    excludes: config.website.excludes,
    success: function(page){

        utils.onlineWrite(page.url);

        var $ = cheerio.load(page.body);
        var url = $(config.website.videoselector).attr("src") || null;

        if(url != null)
        {
            var animeName = utils.sanitizeTitle($("head>title").text());
            //var episodeUrlEncoded = url.substring(url.indexOf("?p=")+3); //can be ?id= but is on the tp://upvid.eu/cup/cup.php website
            //var url = episodeUrlEncoded;
            //try
            //{
            //    url = Base64.decode(episodeUrlEncoded);
            //}
            //catch(error)
            //{
            //}
            /*if(!url.includes("//"))
                url = (config["serverurl"] + url)
            url = url.replace(/\'/gm, '\\\'').replace(/tps:\/\//gm, "http:\/\/"); //seems that tps:// is replaced with tp://
            */
            try
            {
                dbConnection.query("INSERT INTO animeurls (animeurl, animename) \
                        VALUES (\'" + utils.sanitizeURL(url) + "\', \'" + animeName + "\');");
            }
            catch(err)
            {
                console.log(err);
                exit();
            }
        }
    },
    failure: function(page){
        utils.onlineWrite(page.status + "-" + page.url);
    },
    finished: function(crawledUrls){
        var endTime = new Date() - startTime;
        console.log("Execution time: %dms", endTime);
    }
});

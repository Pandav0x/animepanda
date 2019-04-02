'use strict';

var app = require('express')();
const fs = require('fs');
var http = require('http').Server(app);
var mysql = require('mysql');
var Crawler = require("js-crawler");
var Base64 = require('base-64');

var animeList = [];
var animeEpisodeList = [];

var rawdata = fs.readFileSync('urls.json');  
var urls = JSON.parse(rawdata); 

/**
 * DB connection
 */
var dbconn = mysql.createConnection({
    host: "127.0.0.1",
    user: "root",
    password: "",
    database: "animepanda"
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

function getAnimeList()
{
    //uri: urls["animeList"],
    //TODO: instert raw name in db
    animeList = $(".anm_det_pop.pop_info")
                            .text()
                            .toLowerCase()
                            .replace(/!|:|;|\-|–|'|&|>|<|…|’|,|\?|"|`|%22/g, '')
                            .replace(/^[\ ]*/gm, '')
                            .replace(/[\ ]*$/gm, '')
                            .replace(/\ /g, '-')
                            .replace(/\r/g, '')
                            .split("\n")
                            .filter(function(entry) { 
                                return entry.trim() != ''; 
                            });
    return;
}

function getEpisodeViewUrl()
{
    //element.includes("☆","♥","∞")
    //animeList.forEach(function(element){
    var $ = res.$;
    if($("article.item>div.poster>div.season_m>a") == null)
        return;
    $("article.item>div.poster>div.season_m>a").get().forEach(function(a){
        animeEpisodeList.push(a.attribs["href"]);
    });
    return;
}

function getUrls()
{
    //forEach(function(animeEp){
    var $ = res.$;
    var tmpUrl = $("iframe.metaframe", res.body).attr("src");
    var episodeUrlEncoded = tmpUrl.substring(tmpUrl.indexOf("?p=")+3);
    var episodeUrl = episodeUrlEncoded;
    try 
    {
        episodeUrl = Base64.decode(episodeUrlEncoded);
    }
    catch(error){}
    if(!episodeUrl.includes("//"))
        episodeUrl = urls["repoUrl"] + episodeUrl;    
    episodeUrl = episodeUrl.replace(/'/, "\\'")
                            .replace(/tps:\/\//g, '');
    console.log(episodeUrl);
    if(episodeUrl!= null && episodeUrl.endsWith(".mp4"))
        dbconn.query("INSERT INTO animesurls (animeurl) VALUES (\'" + urls["repoUrl"] + episodeUrl + "\');");
    return;
}

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
    console.log('listening on *:3000');
});
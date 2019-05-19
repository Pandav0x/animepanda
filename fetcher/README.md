# Fetcher

## Installation

    $git clone
    $cd animepanda_fetcher
    $npm install

- Create a `config.json` file in the root directory of the project.

        {
            "website":{
                "url": "http://yoururl.com/animeslist/" ,
                "excludes" : [],
                "includes" : [],
                "serverurl" : "http://mega.nz/",
                "videoselector" : "iframe.metaframe.rptss"
            },
            "database":{
                "host": "127.0.0.1" ,
                "port" : "3306" ,
                "user": "user",
                "password" : "password" ,
                "database" : "databasename" 
            },
            "crawler":
            {
                "depth": 1,
                "userAgent": "your user agent",
                "maxRequestsPerSecond": 5,
                "maxConcurrentRequests": 100
            }
        }
    - `url` : your anime list source
    - `excludes` : exlude path including this (pretty sure you can use PCRE)
    - `includes` : will only crawl if the url contains one of it (same as above)
    - `serverurl` : external server that physically have the videos
    - `videoselector` : css selector to get the url of the anime from
    - The other ones should be self-explanatory
- You can type `node index.js`

# Fetcher

## Installation

    $git clone
    $cd animepanda_fetcher
    $npm install

- Create a `config.json` file in the root directory of the project.

        {
            "url": "http://animesite.com/anime-list/",
            "excludes" : [""],
            "includes" : [""],
            "serverurl" : "http://openload.com/"
        }
    - `url` : your anime source
    - `excludes` : exlude path including this
    - `includes` : will only crawl if the url contains one of it
    - `serverurl` : external server that physically have the videos
- You can type `node index.js` (provided that your mysql server is runing on the `:3306` port)

I had to change the js-crawler script a bit to fix some isues I had

    Crawler.prototype.crawlFiltered = function(params) {
      params.includes || [];
      params.excludes || [];
      if(String(params.url).contains(params.includes) && !String(params.url).contains(params.excludes))
      {
          this.includes = params.includes;
          this.excludes = params.excludes;
          this.crawl(params.url, params.success, params.failure, params.finished);
      }
      return this;
    }
   
and

      if(!url.contains(self.includes) || url.contains(self.excludes)){
        return;
      }
     
this condition to place just after the `if (_.contains(self._currentUrlsToCrawl, url) || _.contains(_.keys(self.knownUrls), url)) {` statement in the `Crawler.prototype._requestUrl` method definition.


And, that's it !

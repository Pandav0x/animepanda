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

And, that's it !
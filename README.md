# Fetcher

## Installation

    $git clone
    $cd animepanda_fetcher
    $npm install

- Create a `urls.json` file in the root directory of the project.
- Write 

        {
            "animeList":       "http://animewebsite.com/animes-list",
            "animeBasePage":   "http://animewebsite.com/tvshows/",
            "animeEpPage":     "http://animewebsite.com/episodes/"
        }
    - Replace `animewebsite.com` by your source.
- You can type `node index.js` (provided that your mysql server is runing on the `:3306` port)

And, that's it !
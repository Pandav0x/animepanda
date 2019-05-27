/**
 * Utils helper
 */

const Base64 = require('base-64')

class Utilities
{
    constructor(){}

    onlineWrite(string, crop = 50)
    {
        process.stdout.clearLine();
        process.stdout.cursorTo(0);
        process.stdout.write((string.length > crop)? string.substring(0,crop) : string);
    }

    sanitizeURL(url)
    {
        var base64RegEx = new RegExp('/^http:\/\/.*hentaimama\.com/', 'gm');
        if(base64RegEx.exec(url) != null)
        {
            console.log(Base64.decode(/(?<=\?p=).*$/.exec(url)[0]));
            url = config.website.baseUrl + Base64.decode(/(?<=\?p=).*$/.exec(url)[0]);
        }
        return url;
    }

    sanitizeTitle(title)
    {
        return title.substr(7, (title.lastIndexOf("Episode")-8)).replace(/\'/gm, '\\\'');
    }

    escapeChars(string)
    {
        return string;
    }

}

module.exports = Utilities;
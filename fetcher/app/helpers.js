/**
 * Utils helper
 */

class Utils
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
        return url;
    }

    sanitizeTitle(title)
    {
        return title.substr(7, (animeTitle.lastIndexOf("Episode")-8)).replace(/\'/gm, '\\\'');
    }

    escapeChars(string)
    {
        return string;
    }

}

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

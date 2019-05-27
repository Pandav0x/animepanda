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

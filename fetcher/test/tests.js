var assert = require("assert");
var helpers = require("../app/helpers");

var Utils = new Utils();


describe("Crawler functions tests", function () {

    it("should return a sanitized episode name from a given page title", function () {
        assert.equal(
            Utils.sanitizeTitle("Stream Cowboy Bebop Episode 2 with English subbed for free online – Animemama"),
            "Cowboy Bebop"
        );
    });
    it("should return first charachter of the string", function () {
        assert.equal("Hello".charAt(0), "H");
    });
    
});
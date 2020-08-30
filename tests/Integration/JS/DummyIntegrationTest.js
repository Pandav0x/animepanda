'use strict';

const assert = require('chai').assert;

describe('String test suite', function(){
    describe('Assertion on strings', function(){
        it('Assert that two strings are equals', function(){
            assert.equal('abcdef', 'abcdef');
        });
    });
});
'use strict';

/*
    Provides the right mocha config to run the requested test suite
*/

let test_suites = [
    'unit',
    'integration'
];

let config = {
    'recursive': true,
    'diff': true,
    'extension': ['js'],
    'package': './package.json',
    'reporter': 'dot',
    'slow': 75,
    'timeout': 2000,
    'ui': 'bdd',
    'spec': []
};

let file_expression = '/JS/**/*.js';

function appendSuite(suite_name) {
    config.spec.push('./tests/' + uppercaseFirstLetter(suite_name) + file_expression);
}

function uppercaseFirstLetter(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

process.argv.forEach((value, index) => {

    let option_name = value.split('=')[0].replace('--', '').toLowerCase();

    if (option_name !== 'suite') {
        return;
    }

    let option_value = value.split('=')[1].toLowerCase() || null;

    if (option_value === null) {
        test_suites.forEach((test_suite) => {
            appendSuite(test_suite);
        });
        return;
    }

    if (test_suites.includes(option_value)) {
        appendSuite(option_value);
        return;
    }
    return;
});

module.exports = config;

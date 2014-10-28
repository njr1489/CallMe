/**
 * Created by adamc on 10/26/14.
 */
requirejs.config({
    "baseUrl": "js/lib",
    "paths": {
        "app": "../app",
        "jquery": "//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min",
        "underscore": "//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.7.0/underscore-min",
        "moment": "//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.3/moment.min"
    }
});

requirejs(["app/main"]);
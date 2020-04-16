// window._ = require('lodash');
//import modal from "jquery-modal";

window.axios = require('axios');
window.$ = window.jquery = window.jQuery = require('jquery');
import 'jquery-ui/ui/widgets/tabs.js';
require("jquery-modal");
import "./jquery-comments";
require('./components/input-char-count');
// window.popper = require('popper.js');
// require('bootstrap');


window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
//let token = document.head.querySelector('meta[name="csrf-token"]');

if (csrfToken) {
	console.log(csrfToken)
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
    axios.defaults.headers.common['Accept'] = 'application/json, text/plain, */*'
    //axios.defaults.headers.common['Access-Control-Allow-Origin'] = 'http://exegeza-biblica.epizy.com';
    //axios.defaults.headers.common['Origin'] = 'http://exegeza-biblica.epizy.com/public'
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

import debounce from 'lodash/debounce';
window.Tagify = require('@yaireo/tagify');
import autoComplete from 'js-autocomplete/auto-complete';
// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
$('.tagify-input').each(function (i, el) {
    var endpoint = el.dataset.endpoint || '';
    var isUrlEndpoint = !endpoint.includes(',');
    var pattern = el.dataset.pattern ? new RegExp(el.dataset.pattern) : null;
    // in cazul in care e url, debounce, altfel debounce cat mai mic
    var debounce_time = el.dataset.debounce || (isUrlEndpoint ? 400 : 100);
    var whitelist = isUrlEndpoint ? [] : (endpoint.split(',').map(tag => tag.trim()));
    var tagify = (new Tagify(el, { whitelist, pattern }))
        .on('input', debounce(function (e) {
            if (!endpoint || !isUrlEndpoint) return;
            let val = e.detail.value;
            if (val.length < 2) return;
            axios.get(endpoint + '?q=' + val)
                .then(function (res) {
                    tagify.settings.whitelist = res.data;
                    tagify.dropdown.show.call(tagify, val); // render the suggestions dropdown
                })
        }, debounce_time));
});

$('.autocomplete-input').each(function (i, el) {
    var endpoint = el.dataset.endpoint || '';
    if (!endpoint.length) return;
    new autoComplete({
        delay: 500,
        selector: el,
        minChars: 1,
        source: function (term, suggest) {
            try { axios.abort(); } catch (e) { }
            axios.get(endpoint + '?q=' + term).then(res => {
                suggest(res.data)
            });
        }
    });
});

$(".count-input").each(function (i, el) {
    let formGroup = $(el);
    let counter = formGroup.find(".input-char-count");
    if (!counter.length) return;
    formGroup.find("input").on("input", function(e){
        counter.html(e.target.value.length);
    });
});

$( function() {
    $(".js-hasTabs").tabs();
});
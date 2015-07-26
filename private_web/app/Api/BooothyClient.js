var $             = require('jquery')
var ApiConstants  = require('../Constant/ApiConstants');
var AppDispatcher = require('../Dispatcher/AppDispatcher');

var pending_requests = {};

function BooothyClient() {}

BooothyClient.makeUrl = function (uri) {
    return window.api_url + uri;
};

BooothyClient.abortPendingRequests = function (key) {
    if (pending_requests[key]) {
        pending_requests[key].abort();
        pending_requests[key] = null;
    }
};

BooothyClient.dispatch = function (key, response, parameters) {
    var payload = { actionType : key, response : response };

    if (parameters) {
        payload.queryParams = parameters;
    }

    AppDispatcher.dispatch(payload);
};

BooothyClient.addRequest = function (key, request) {
    pending_requests[key] = $.ajax(request);
};

BooothyClient.get = function (url, data, success, error) {
    if (window.auth) {
        data.id_token = window.auth.id_token;
    }

    return {
        url     : url,
        type    : 'GET',
        data    : data,
        async   : true,
        success : success,
        error   : error
    };
};

BooothyClient.post = function (url, data, success, error) {
    if (window.auth) {
        data.append('id_token', window.auth.id_token);
    }

    return {
        url         : url,
        type        : 'POST',
        data        : data,
        async       : true,
        success     : success,
        error       : error,
        cache       : false,
        contentType : false,
        processData : false
    };
};

module.exports = BooothyClient;
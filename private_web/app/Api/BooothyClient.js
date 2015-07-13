var AppDispatcher    = require('../Dispatcher/AppDispatcher');
var ApiConstants     = require('../Constant/ApiConstants');
var Request          = require('superagent');
var TIMEOUT          = 10000;
var pending_requests = {};

function BooothyClient() {}

BooothyClient.makeUrl = function (uri) {
    return window.api_url + uri;
};

BooothyClient.abortPendingRequests = function (key) {
    if (pending_requests[key]) {
        pending_requests[key]._callback = function () {};
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
    pending_requests[key] = request;
};

BooothyClient.get = function (url) {
    return Request
        .get(url)
        .timeout(TIMEOUT)
        .query({});
};

BooothyClient.makeDigestFun = function (key, parameters) {
    return function (error, response) {
        if (error && error.timeout === TIMEOUT) {
            BooothyClient.dispatch(key, ApiConstants.API_TIMEOUT, parameters);
        }
        else if (response.status === 400) {
            console.log('Tengo un 400!');
        }
        else if (!response.ok) {
            BooothyClient.dispatch(key, ApiConstants.API_ERROR, parameters);
        }
        else {
            BooothyClient.dispatch(key, response, parameters);
        }
    };
};

module.exports = BooothyClient;
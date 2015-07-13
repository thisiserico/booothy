var BooothyClient = require('./BooothyClient');
var ApiConstants  = require('../Constant/ApiConstants');

var PhotosClient = {
    getCollection : function () {
        var url = BooothyClient.makeUrl('photos');
        var key = ApiConstants.API_PHOTOS_GET_COLLECTION;

        BooothyClient.abortPendingRequests(key);
        BooothyClient.dispatch(key, ApiConstants.API_REQUEST_PENDING, {});

        BooothyClient.addRequest(key, BooothyClient.get(url).end(
            BooothyClient.makeDigestFun(key, {})
        ));
    }
};

module.exports = PhotosClient;
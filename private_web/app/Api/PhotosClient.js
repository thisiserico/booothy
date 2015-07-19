var BooothyClient = require('./BooothyClient');
var ApiConstants  = require('../Constant/ApiConstants');

var PhotosClient = {
    getCollection : function (page) {
        var url = BooothyClient.makeUrl('photos');
        var key = ApiConstants.API_PHOTOS_GET_COLLECTION;

        BooothyClient.abortPendingRequests(key);
        BooothyClient.dispatch(key, ApiConstants.API_PHOTOS_GET_COLLECTION_PENDING, {});

        BooothyClient.addRequest(key, BooothyClient.get(
            url,
            { page : page },
            function (data, status) {
                BooothyClient.dispatch(key, data, {});
            },
            function (xhr, error_type) {
                switch (error_type) {
                    case 'timeout':
                        BooothyClient.dispatch(key, ApiConstants.API_TIMEOUT, {});
                        break;

                    default:
                        BooothyClient.dispatch(key, ApiConstants.API_ERROR, {});
                }
            }
        ));
    },

    uploadNew : function (form_data, callback) {
        var url = BooothyClient.makeUrl('photos');
        var key = ApiConstants.API_PHOTOS_POST_COLLECTION;

        BooothyClient.abortPendingRequests(key);
        BooothyClient.dispatch(key, ApiConstants.API_PHOTOS_POST_COLLECTION_PENDING);

        BooothyClient.addRequest(key, BooothyClient.post(
            url,
            form_data,
            function (data, status) {
                BooothyClient.dispatch(key, data, {});
                callback();
            },
            function (xhr, error_type) {
                switch (error_type) {
                    case 'timeout':
                        BooothyClient.dispatch(key, ApiConstants.API_TIMEOUT, {});
                        break;

                    default:
                        BooothyClient.dispatch(key, ApiConstants.API_ERROR, {});
                }
            }
        ));
    }
};

module.exports = PhotosClient;
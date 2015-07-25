var BooothyClient = require('./BooothyClient');
var ApiConstants  = require('../Constant/ApiConstants');

var UsersClient = {
    getCollection : function () {
        var url = BooothyClient.makeUrl('users');
        var key = ApiConstants.API_USERS_GET_COLLECTION;

        BooothyClient.abortPendingRequests(key);
        BooothyClient.dispatch(key, ApiConstants.API_USERS_GET_COLLECTION_PENDING, {});

        BooothyClient.addRequest(key, BooothyClient.get(
            url,
            {},
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

    getResource : function (email) {
        var url = BooothyClient.makeUrl('users/' + email);
        var key = ApiConstants.API_USERS_GET_RESOURCE;

        BooothyClient.abortPendingRequests(key);
        BooothyClient.dispatch(key, ApiConstants.API_USERS_GET_RESOURCE_PENDING, {});

        BooothyClient.addRequest(key, BooothyClient.get(
            url,
            {},
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
    }
};

module.exports = UsersClient;
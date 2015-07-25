var ApiConstants  = require('../Constant/ApiConstants');
var AppDispatcher = require('../Dispatcher/AppDispatcher');
var assign        = require('object-assign');
var EventEmitter  = require('events').EventEmitter;

var USER_CONFIRMED_EVENT = 'change';
var _users               = [];
var _current_user        = {};

var UsersStore = assign({}, EventEmitter.prototype, {
    getCurrentUser : function () {
        return _current_user;
    },

    getUsersCollectiin : function () {
        return _users;
    },

    emitChange : function (event) {
        this.emit(event);
    },

    addUserConfirmedListener : function (callback) {
        this.on(USER_CONFIRMED_EVENT, callback);
    },

    removeUserConfirmedListener : function (callback) {
        this.removeListener(USER_CONFIRMED_EVENT, callback);
    }
});

AppDispatcher.register(function (action) {
    switch (action.actionType) {
        case ApiConstants.API_USERS_GET_COLLECTION:
            switch (action.response) {
                case ApiConstants.API_TIMEOUT:
                case ApiConstants.API_ERROR:
                case ApiConstants.API_USERS_GET_COLLECTION_PENDING:
                    break;

                default:
                    _users = action.response;
            }

            break;

        case ApiConstants.API_USERS_GET_RESOURCE:
            switch (action.response) {
                case ApiConstants.API_TIMEOUT:
                case ApiConstants.API_USERS_GET_RESOURCE_PENDING:
                    break;

                case ApiConstants.API_ERROR:
                    break;

                default:
                    _user = action.response;
                    UsersStore.emitChange(USER_CONFIRMED_EVENT);
            }

            break;
    }

    return true;
});

module.exports = UsersStore;
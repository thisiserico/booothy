var ApiConstants  = require('../Constant/ApiConstants');
var AppDispatcher = require('../Dispatcher/AppDispatcher');
var assign        = require('object-assign');
var EventEmitter  = require('events').EventEmitter;

var CHANGE_EVENT       = 'change';
var _photo             = [];
var photo_being_loaded = true;

var PhotoStore = assign({}, EventEmitter.prototype, {
    getResource : function () {
        return _photo;
    },

    photoBeingLoaded : function () {
        return photo_being_loaded;
    },

    emitChange : function () {
        this.emit(CHANGE_EVENT);
    },

    addChangeListener : function (callback) {
        this.on(CHANGE_EVENT, callback);
    },

    removeChangeListener : function (callback) {
        this.removeListener(CHANGE_EVENT, callback);
    }
});

AppDispatcher.register(function (action) {
    switch (action.actionType) {
        case ApiConstants.API_PHOTOS_GET_RESOURCE:
            switch (action.response) {
                case ApiConstants.API_TIMEOUT:
                case ApiConstants.API_ERROR:
                    break;

                case ApiConstants.API_PHOTOS_GET_RESOURCE_PENDING:
                    photo_being_loaded = true;
                    break;

                default:
                    _photo             = action.response;
                    photo_being_loaded = false;

            }

            break;
    }

    PhotoStore.emitChange();
    return true;
});

module.exports = PhotoStore;
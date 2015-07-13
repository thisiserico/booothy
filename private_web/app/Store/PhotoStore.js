var ApiConstants    = require('../Constant/ApiConstants');
var AppDispatcher   = require('../Dispatcher/AppDispatcher');
var PhotosApiClient = require('../Api/PhotosClient');
var PhotoConstants  = require('../Constant/PhotoConstants');
var assign          = require('object-assign');
var EventEmitter    = require('events').EventEmitter;

var CHANGE_EVENT         = 'change';
var _photos              = {};
var new_set_being_loaded = true;

var PhotoStore = assign({}, EventEmitter.prototype, {
    getCollection : function () {
        return _photos;
    },

    newSetBeingLoaded : function () {
        return new_set_being_loaded;
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
        case ApiConstants.API_PHOTOS_GET_COLLECTION:
            if (action.response === 'API_REQUEST_PENDING') {
                new_set_being_loaded = true;
            }
            else {
                action.response.body.map(function (photo) {
                    _photos[photo.id] = photo;
                });

                new_set_being_loaded = false;
            }

            break;
    }

    PhotoStore.emitChange();
    return true;
});

module.exports = PhotoStore;
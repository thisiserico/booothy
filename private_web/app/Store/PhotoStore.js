var ApiConstants    = require('../Constant/ApiConstants');
var AppDispatcher   = require('../Dispatcher/AppDispatcher');
var assign          = require('object-assign');
var EventEmitter    = require('events').EventEmitter;
var PhotosApiClient = require('../Api/PhotosClient');

var CHANGE_EVENT              = 'change';
var _photos                   = [];
var new_set_being_loaded      = true;
var uploading_boooth          = false;
var complete_catalogue_loaded = false;

var PhotoStore = assign({}, EventEmitter.prototype, {
    getCollection : function () {
        return _photos;
    },

    newSetBeingLoaded : function () {
        return new_set_being_loaded;
    },

    booothBeingUploaded : function () {
        return uploading_boooth;
    },

    completeCatalogueLoaded : function () {
        return complete_catalogue_loaded;
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
            switch (action.response) {
                case ApiConstants.API_TIMEOUT:
                case ApiConstants.API_ERROR:
                    break;

                case ApiConstants.API_PHOTOS_GET_COLLECTION_PENDING:
                    new_set_being_loaded = true;
                    break;

                default:
                    if (action.response.length < 1) complete_catalogue_loaded = true;

                    _photos              = _photos.concat(action.response);
                    new_set_being_loaded = false;

            }

            break;

        case ApiConstants.API_PHOTOS_POST_COLLECTION:
            if (action.response === ApiConstants.API_PHOTOS_POST_COLLECTION_PENDING) {
                uploading_boooth = true;
            }
            else {
                _photos.unshift(action.response)
                uploading_boooth = false;
            }

            break;
    }

    PhotoStore.emitChange();
    return true;
});

module.exports = PhotoStore;
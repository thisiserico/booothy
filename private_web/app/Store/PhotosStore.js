var ApiConstants   = require('../Constant/ApiConstants');
var AppDispatcher  = require('../Dispatcher/AppDispatcher');
var assign         = require('object-assign');
var EventEmitter   = require('events').EventEmitter;
var PhotoConstants = require('../Constant/PhotoConstants');

var CHANGE_EVENT              = 'change';
var _photos                   = [];
var new_set_being_loaded      = true;
var uploading_boooth          = false;
var complete_catalogue_loaded = false;
var current_filtering_user    = '';

var PhotosStore = assign({}, EventEmitter.prototype, {
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

    filteringUser : function () {
        return current_filtering_user;
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

var turnOnFilteringFor = function (user_id, photos) {
    if (current_filtering_user === '') return photos;

    photos.map(function (photo) {
        if (photo.user === user_id) {
            photo.hidden = false;
            return;
        }

        photo.hidden = true;
    });

    return photos;
};

var turnOffFiltering = function (photos) {
    photos.map(function (photo) {
        photo.hidden = false;
    });

    return photos;
};

AppDispatcher.register(function (action) {
    switch (action.actionType) {
        case PhotoConstants.FILTER_PER_USER:
            switch (action.user_id === current_filtering_user) {
                case true:
                    current_filtering_user = '';
                    _photos                = turnOffFiltering(_photos);

                    break;

                case false:
                    current_filtering_user = action.user_id;
                    _photos = turnOnFilteringFor(current_filtering_user, _photos);
            }

            break;

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

                    filtered_photos      = turnOnFilteringFor(current_filtering_user, action.response);
                    _photos              = _photos.concat(filtered_photos);
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

    PhotosStore.emitChange();
    return true;
});

module.exports = PhotosStore;
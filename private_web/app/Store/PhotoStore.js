var AppDispatcher  = require('../Dispatcher/AppDispatcher');
var EventEmitter   = require('events').EventEmitter;
var PhotoConstants = require('../Constant/PhotoConstants');
var assign         = require('object-assign');

var CHANGE_EVENT = 'change';
var _photos      = {
    '1234' : {
        id : '1234',
        quote : 'Aloha',
        upload  : {
            filename     : 'foo.png',
            mime_type    : 'image/png',
            download_url : 'http://booothy.ericlopez.me.dev/index_dev.php/u/tenth.png'
        },
        creation_date : '2015-06-26 18:13:41'
    },
    '5678' : {
        id : '5678',
        quote : 'Namaste',
        upload  : {
            filename     : 'foo.png',
            mime_type    : 'image/png',
            download_url : 'http://booothy.ericlopez.me.dev/index_dev.php/u/tenth.png'
        },
        creation_date : '2015-06-26 18:13:41'
    }
};

var PhotoStore = assign({}, EventEmitter.prototype, {
    getAll: function () {
        return _photos;
    },

    emitChange: function () {
        this.emit(CHANGE_EVENT);
    },

    addChangeListener: function (callback) {
        this.on(CHANGE_EVENT, callback);
    },

    removeChangeListener: function (callback) {
        this.removeListener(CHANGE_EVENT, callback);
    }
});

AppDispatcher.register(function (action) {
    switch (action.actionType) {
        // case PhotoConstants.PHOTO_COMMENT:
        //     raw_comment = action.raw_comment.trim();
        //     if (raw_comment !== '') {
        //         create(raw_comment);
        //         PhotoStore.emitChange();
        //     }

        //     break;

        default:
            // no op
    }
});

module.exports = PhotoStore;
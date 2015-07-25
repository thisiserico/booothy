var AppDispatcher = require('../Dispatcher/AppDispatcher');
var assign        = require('object-assign');
var EventEmitter  = require('events').EventEmitter;

var SIGN_IN_EVENT  = 'SIGN_IN';
var SIGN_OUT_EVENT = 'SIGN_OUT';
var _signed_in     = false;

var AuthStore = assign({}, EventEmitter.prototype, {
    isSignedIn : function () {
        return _signed_in;
    },

    addSignInListener : function (callback) {
        this.on(SIGN_IN_EVENT, callback);
    },

    removeSignInListener : function (callback) {
        this.removeListener(SIGN_IN_EVENT, callback);
    },

    signIn : function () {
        try {
            gapi.signin2.render('g-signin2', {
                'scope'     : 'https://www.googleapis.com/auth/plus.login',
                'width'     : 200,
                'height'    : 50,
                'longtitle' : false,
                'theme'     : 'dark',
                'onsuccess' : this.onSignIn.bind(this)
            });
        }
        catch (error) {
            setTimeout(function () {
                this.signIn();
            }.bind(this), 300);
        }
    },

    onSignIn : function (google_user) {
        window.auth = {
            id_token : google_user.getAuthResponse().id_token,
            name     : google_user.getBasicProfile().getName(),
            email    : google_user.getBasicProfile().getEmail(),
            avatar   : google_user.getBasicProfile().getImageUrl()
        };

        _signed_in = true;
        this.emit(SIGN_IN_EVENT);
    },


    addSignOutListener : function (callback) {
        this.on(SIGN_OUT_EVENT, callback);
    },

    signOut : function () {
        var auth2 = gapi.auth2.getAuthInstance();

        auth2.signOut().then(function () {
            this.emit(SIGN_OUT_EVENT);
        }.bind(this));
    }
});

module.exports = AuthStore;
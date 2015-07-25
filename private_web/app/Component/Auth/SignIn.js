var AuthStore   = require('../../Store/AuthStore');
var React       = require('react');
var SignOut     = require('./SignOut');
var UsersClient = require('../../Api/UsersClient');
var UsersStore  = require('../../Store/UsersStore');

var SignIn = React.createClass({
    getInitialState : function () {
        return {
            signed_in       : false,
            disallowed_user : false
        };
    },

    componentDidMount : function () {
        AuthStore.addSignInListener(this._onSignInCompleted);
        UsersStore.addUserConfirmedListener(this._onUserConfirmed)
        UsersStore.addUserDisallowedListener(this._onUserDisallowed)

        AuthStore.signIn();
    },

    componentWillUnmount : function () {
        AuthStore.removeSignInListener(this._onSignInCompleted);
        UsersStore.removeUserConfirmedListener(this._onUserConfirmed)
    },

    _onSignInCompleted : function () {
        UsersClient.getResource(window.auth.email);
    },

    _onUserConfirmed : function () {
        setTimeout(function () {
            this.setState({ signed_in : AuthStore.isSignedIn() });
            this.props.onSuccess();
        }.bind(this), 300);
    },

    _onUserDisallowed : function () {
        AuthStore.signOut();
        this.setState({ disallowed_user : true });
    },

    render : function() {
        if (this.state.signed_in) return (<div />);
        if (this.state.disallowed_user) {
            return (
                <div className="sign_in">
                    <div><div className="error_message">Disallowed user</div></div>
                </div>
            );
        }

        return (
            <div className="sign_in">
                <div id="g-signin2" />
            </div>
        );
    }
});

module.exports = SignIn;
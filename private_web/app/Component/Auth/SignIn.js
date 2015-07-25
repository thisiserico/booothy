var AuthStore   = require('../../Store/AuthStore');
var React       = require('react');
var UsersClient = require('../../Api/UsersClient');
var UsersStore  = require('../../Store/UsersStore');

var SignIn = React.createClass({
    getInitialState : function () {
        return { signed_in : false };
    },

    componentDidMount : function () {
        AuthStore.addSignInListener(this._onSignInCompleted);
        UsersStore.addUserConfirmedListener(this._onUserConfirmed)

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

    render : function() {
        if (this.state.signed_in) return (<div />);

        return (
            <div className="sign_in">
                <div id="g-signin2" />
            </div>
        );
    }
});

module.exports = SignIn;
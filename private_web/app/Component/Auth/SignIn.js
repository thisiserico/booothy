var AuthStore = require('../../Store/AuthStore');
var React     = require('react');

var SignIn = React.createClass({
    getInitialState : function () {
        return { signed_in : false };
    },

    componentDidMount : function () {
        AuthStore.addSignInListener(this._onSignInCompleted);
        AuthStore.signIn();
    },

    componentWillUnmount : function () {
        AuthStore.removeSignInListener(this._onSignInCompleted);
    },

    _onSignInCompleted : function () {
        this.setState({ signed_in : AuthStore.isSignedIn() });
        this.props.onSuccess();
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
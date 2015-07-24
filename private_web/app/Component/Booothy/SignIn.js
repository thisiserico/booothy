var React = require('react');

var SignIn = React.createClass({
    getInitialState : function () {
        return { signed_in : false };
    },

    componentDidMount : function () {
        gapi.signin2.render('g-signin2', {
            'scope'     : 'https://www.googleapis.com/auth/plus.login',
            'width'     : 200,
            'height'    : 50,
            'longtitle' : false,
            'theme'     : 'dark',
            'onsuccess' : this.onSignIn
        });
    },

    onSignIn : function (google_user) {
        window.google_id_token = google_user.getAuthResponse().id_token;

        this.setState({ signed_in : true });
        this.props.onSuccess();
    },

    onFailure : function (google_user) {},

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
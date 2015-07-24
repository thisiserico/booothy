var React = require('react');

var SignIn = React.createClass({
    getInitialState : function () {
        return { signed_in : false };
    },

    componentDidMount : function () {
        this.onSignIn({});
    },

    onSignIn : function (google_user) {
        this.setState({ signed_in : true });
        this.props.onSuccess();
    },

    onFailure : function (google_user) {},

    render : function() {
        if (this.state.signed_in) return (<div />);

        return (
            <div className="sign_in">
                <div
                    className="g-signin2"
                    data-onsuccess={this.onSignIn}
                    data-onfailure={this.onfailure}
                    data-theme="dark" />
            </div>
        );
    }
});

module.exports = SignIn;
var React  = require('react');
var Router = require('react-router');

var SignOut = React.createClass({
    mixins : [Router.Navigation],

    signOut : function () {
        var auth2 = gapi.auth2.getAuthInstance();

        auth2.signOut().then(function () {
            this.transitionTo('app');
            location.reload();
        }.bind(this));
    },

    render : function() {
        return (
            <a onClick={this.signOut} style={this.props.style}>
                <i className="fa fa-sign-out" />
            </a>
        );
    }
});

module.exports = SignOut;
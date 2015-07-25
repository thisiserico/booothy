var AuthStore = require('../../Store/AuthStore');
var React     = require('react');
var Router    = require('react-router');

var SignOut = React.createClass({
    mixins : [Router.Navigation],

    componentDidMount : function () {
        AuthStore.addSignOutListener(this._onSignOutCompleted);
    },

    signOut : function () {
        AuthStore.signOut();
    },

    _onSignOutCompleted : function () {
        this.transitionTo('app');
        location.reload();
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
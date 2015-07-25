var Link         = require('react-router').Link;
var Menu         = require('./Menu');
var React        = require('react');
var RouteHandler = require('react-router').RouteHandler;
var SignIn       = require('../Auth/SignIn');

var App = React.createClass({
    getInitialState : function () {
        return { load_content : false};
    },

    loadContent : function () {
        this.setState({ load_content : true });
    },

    render : function() {
        return (
            <div>
                <SignIn onSuccess={this.loadContent} />

                <header>booothy</header>
                {this.state.load_content ? <Menu /> : ''}
                {this.state.load_content ? <RouteHandler/> : ''}
            </div>
        );
    }
});

module.exports = App;
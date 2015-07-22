var Link         = require('react-router').Link;
var Menu         = require('./Menu');
var React        = require('react');
var RouteHandler = require('react-router').RouteHandler;

var App = React.createClass({
    render : function() {
        return (
            <div>
                <Menu />
                <header>booothy</header>
                <RouteHandler/>
            </div>
        );
    }
});

module.exports = App;
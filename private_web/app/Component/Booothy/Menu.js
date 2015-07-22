var Link         = require('react-router').Link;
var React        = require('react');
var RouteHandler = require('react-router').RouteHandler;

var Menu = React.createClass({
    render : function() {
        return (
            <div>
                <Link to="boooth">Boooth!</Link>
            </div>
        );
    }
});

module.exports = Menu;
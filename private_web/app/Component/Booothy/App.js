var React        = require('react');
var RouteHandler = require('react-router').RouteHandler;

var App = React.createClass({
    render : function() {
        return (
            <div>
                <header>booothy</header>
                <RouteHandler/>
            </div>
        );
    }
});

module.exports = App;
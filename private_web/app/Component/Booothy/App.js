var Link         = require('react-router').Link;
var PhotoList    = require('../PhotoStream/PhotoList.js');
var React        = require('react');
var RouteHandler = require('react-router').RouteHandler;

var App = React.createClass({
    render : function() {
        return (
            <div>
                <Link to="boooth">Boooth!</Link>
                <RouteHandler/>
                <PhotoList />
            </div>
        );
    }
});

module.exports = App;
var PhotoList    = require('../PhotoStream/PhotoList.js');
var React        = require('react');
var RouteHandler = require('react-router').RouteHandler;

var Loader = React.createClass({
    render : function() {
        return (
            <div>
                <RouteHandler/>
                <PhotoList />
            </div>
        );
    }
});

module.exports = Loader;
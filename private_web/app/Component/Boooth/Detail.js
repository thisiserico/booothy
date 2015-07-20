var Link         = require('react-router').Link;
var PhotoList    = require('../PhotoStream/PhotoList.js');
var React        = require('react');
var RouteHandler = require('react-router').RouteHandler;

var Detail = React.createClass({
    render : function() {
        return (
            <div>
                Yo {this.props.params.id}!
            </div>
        );
    }
});

module.exports = Detail;
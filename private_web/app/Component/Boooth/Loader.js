var Link         = require('react-router').Link;
var PhotoList    = require('../PhotoStream/PhotoList.js');
var React        = require('react');
var RouteHandler = require('react-router').RouteHandler;

var Loader = React.createClass({
    render : function() {
        return (
            <div>
                <Link to="boooth" params={{ page : this.props.params.page }}>Boooth!</Link>
                <RouteHandler/>
                <PhotoList page={this.props.params.page} />
            </div>
        );
    }
});

module.exports = Loader;
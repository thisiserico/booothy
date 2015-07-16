var React     = require('react');
var PhotoList = require('../PhotoStream/PhotoList.js');
var Link      = require('react-router').Link;

var App = React.createClass({
    render: function() {
        return (
            <section id="photo_list">
                <Link to={`/boooth`}>Boooth!</Link>
                <PhotoList />
            </section>
        );
    }
});

module.exports = App;
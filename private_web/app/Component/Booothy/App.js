var React     = require('react');
var PhotoList = require('../PhotoStream/PhotoList.js');

var App = React.createClass({
    render: function() {
        return (
            <section id="photo_list">
                <PhotoList />
            </section>
        );
    }
});

module.exports = App;
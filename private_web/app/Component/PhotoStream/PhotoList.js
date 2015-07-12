var React      = require('react');
var Photo      = require('./Photo.js');
var PhotoStore = require('../../Store/PhotoStore');

var PhotoList = React.createClass({
    getState: function () {
        return {
            all_photos : PhotoStore.getAll()
        };
    },

    getInitialState: function () {
        return this.getState();
    },

    componentDidMount: function () {
        PhotoStore.addChangeListener(this._onChange);
    },

    componentWillUnmount: function () {
        PhotoStore.removeChangeListener(this._onChange);
    },

    _onChange: function() {
        this.setState(this.getState());
    },

    render: function () {
        var photos     = [];
        var all_photos = this.state.all_photos;

        for (var key in all_photos) {
            photos.push(<Photo key={key} photo={all_photos[key]} />);
        }

        return (
            <div>{photos}</div>
        );
    }
});

module.exports = PhotoList;
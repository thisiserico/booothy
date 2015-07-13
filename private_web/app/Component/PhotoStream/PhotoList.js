var Photo        = require('./Photo.js');
var PhotosClient = require('../../Api/PhotosClient');
var PhotoStore   = require('../../Store/PhotoStore');
var React        = require('react');

var PhotoList = React.createClass({
    getState: function () {
        return {
            all_photos      : PhotoStore.getCollection(),
            loading_new_set : PhotoStore.newSetBeingLoaded()
        };
    },

    getInitialState: function () {
        return this.getState();
    },

    componentDidMount: function () {
        PhotoStore.addChangeListener(this._onChange);
        PhotosClient.getCollection();
    },

    componentWillUnmount: function () {
        PhotoStore.removeChangeListener(this._onChange);
    },

    _onChange: function () {
        this.setState(this.getState());
    },

    render: function () {
        var photos     = [];
        var all_photos = this.state.all_photos;

        for (var key in all_photos) {
            photos.push(<Photo key={key} photo={all_photos[key]} />);
        }

        return (
            <div>
                {photos}
                <pre>{this.state.loading_new_set ? 'Loading' : ''}</pre>
            </div>
        );
    }
});

module.exports = PhotoList;
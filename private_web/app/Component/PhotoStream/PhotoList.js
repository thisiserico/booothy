var Photo        = require('./Photo.js');
var PhotosClient = require('../../Api/PhotosClient');
var PhotoStore   = require('../../Store/PhotoStore');
var React        = require('react');

var PhotoList = React.createClass({
    getState: function () {
        return {
            all_photos       : PhotoStore.getCollection(),
            loading_new_set  : PhotoStore.newSetBeingLoaded(),
            uploading_boooth : PhotoStore.booothBeingUploaded()
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
        var photos = [];

        this.state.all_photos.map(function (photo) {
            photos.push(<Photo key={photo.id} photo={photo} />);
        })

        return (
            <div>
                <pre>{this.state.loading_new_set ? 'Loading' : ''}</pre>
                <pre>{this.state.uploading_boooth ? 'Uploading' : ''}</pre>
                {photos}
            </div>
        );
    }
});

module.exports = PhotoList;
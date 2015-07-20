var Link         = require('react-router').Link;
var PhotosClient   = require('../../Api/PhotosClient');
var PhotoStore    = require('../../Store/PhotoStore');
var React        = require('react');

var Detail = React.createClass({
    getState : function () {
        return {
            photo              : PhotoStore.getResource(),
            photo_being_loaded : PhotoStore.photoBeingLoaded()
        };
    },

    getInitialState : function () {
        return this.getState();
    },

    componentDidMount : function () {
        PhotoStore.addChangeListener(this._onChange);
        PhotosClient.getResource(this.props.params.id);
    },

    componentWillUnmount : function () {
        PhotoStore.removeChangeListener(this._onChange);
    },

    _onChange : function () {
        this.setState(this.getState());
    },

    render : function() {
        return (
            <div>
                {this.state.photo_being_loaded ? 'Loading!' : '' }
                Yo {this.props.params.id}!
            </div>
        );
    }
});

module.exports = Detail;
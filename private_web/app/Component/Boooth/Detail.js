var classNames   = require('classnames');
var Link         = require('react-router').Link;
var PhotosClient = require('../../Api/PhotosClient');
var PhotoStore   = require('../../Store/PhotoStore');
var React        = require('react');

var body_classes = [];

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

    componentWillMount : function () {
        body_classes = React.findDOMNode(window.document.body).className.split(' ');
    },

    componentDidMount : function () {
        PhotoStore.addChangeListener(this._onChange);
        PhotosClient.getResource(this.props.params.id);

        var new_classes_set = body_classes.concat(['noscroll']);
        React.findDOMNode(window.document.body).className = classNames(new_classes_set);
    },

    componentWillUnmount : function () {
        PhotoStore.removeChangeListener(this._onChange);

        React.findDOMNode(window.document.body).className = classNames(body_classes);
    },

    _onChange : function () {
        this.setState(this.getState());
    },

    render : function() {
        if (this.state.photo_being_loaded) {
            return (
                <div className="boooth_detail">
                    {this.state.photo_being_loaded ? 'Loading!' : '' }
                </div>
            );
        }

        return (
            <section className="boooth_detail">
                <div>
                    <img src={this.state.photo.upload.download_url} />
                    <span>{this.state.photo.quote}</span>
                </div>
            </section>
        );
    }
});

module.exports = Detail;
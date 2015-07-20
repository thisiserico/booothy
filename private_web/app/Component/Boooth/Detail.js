var classNames   = require('classnames');
var Link         = require('react-router').Link;
var PhotosClient = require('../../Api/PhotosClient');
var PhotoStore   = require('../../Store/PhotoStore');
var React        = require('react');
var Router       = require('react-router');

var body_classes = [];

var Detail = React.createClass({
    mixins : [Router.Navigation],

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

    closeBooothDetail : function () {
        this.transitionTo('boooth_loader');
    },

    render : function() {
        var details_content = (
            <div>
                {this.state.photo_being_loaded ? 'Loading!' : '' }
            </div>
        );

        if (!this.state.photo_being_loaded) {
            details_content = (
                <div>
                    <img src={this.state.photo.upload.download_url} />
                    <span>{this.state.photo.quote}</span>
                </div>
            );
        }

        return (
            <section className="boooth_detail">
                <button className="close_boooth_detail" onClick={this.closeBooothDetail} />
                {details_content}
            </section>
        );
    }
});

module.exports = Detail;
var classNames   = require('classnames');
var Camera       = require('./Camera');
var PhotosClient = require('../../Api/PhotosClient');
var React        = require('react');
var Router       = require('react-router');

var body_classes = [];

var Upload = React.createClass({
    mixins : [Router.Navigation],

    componentWillMount : function () {
        body_classes = React.findDOMNode(window.document.body).className.split(' ');
    },

    componentDidMount : function () {
        document.addEventListener('keydown', this._keyDown, false);

        var new_classes_set = body_classes.concat(['noscroll']);
        React.findDOMNode(window.document.body).className = classNames(new_classes_set);
    },

    componentWillUnmount : function () {
        document.removeEventListener('keydown', this._keyDown, false);

        React.findDOMNode(window.document.body).className = classNames(body_classes);
    },

    handleSubmit : function () {
        var quote       = this.refs.quote.getDOMNode().value;
        var boooth_file = this.refs.camera.getUploadedFile();
        var boooth_snap = this.refs.camera.getSnappedImage();

        var form_data = new FormData();
        form_data.append('quote', quote);

        if (boooth_snap !== null) {
            form_data.append('uploaded_file', boooth_snap);
        }
        else {
            form_data.append('uploaded_file', boooth_file);
        }

        var redirection = function () {
            this.transitionTo('app')
        };

        PhotosClient.uploadNew(form_data, redirection.bind(this));
    },

    _keyDown : function (event) {
        if (event.keyCode == 27) {
            this._closeNewBoooth();
            event.preventDefault();
        }
    },

    _closeNewBoooth : function () {
        if (!this.goBack()) {
            this.transitionTo('boooth_loader');
        }
    },

    render : function() {
        return (
            <section className="new_boooth">
                <button className="close_new_boooth" onClick={this._closeNewBoooth} />

                <div>
                    <Camera ref="camera" />

                    <div className="boooth_upload_submit">
                        <input type="text" name="quote" ref="quote" placeholder="The nicest thought you've got in your mind..." />
                        <button type="button" onClick={this.handleSubmit}>Boooth! <i className="fa fa-paper-plane" /></button>
                    </div>
                </div>
            </section>
        );
    }
});

module.exports = Upload;
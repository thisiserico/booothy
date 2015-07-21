var React = require('react');

var Camera = React.createClass({
    getInitialState : function () {
        return {
            width         : 640,
            height        : null,
            stream        : null,
            streaming     : null,
            video         : null,
            canvas        : null,
            start_button  : null,
            reset_button  : null,
            picture_taken : false
        };
    },

    componentDidMount : function () {
        this.setState({
            video        : this.refs.video.getDOMNode(),
            canvas       : this.refs.canvas.getDOMNode(),
            start_button : this.refs.start_button.getDOMNode(),
            reset_button : this.refs.reset_button.getDOMNode()
        }, this.mountCameraAction);
    },

    componentWillUnmount: function () {
        if (!(this.state.width && this.state.height)) return;

        var video = this.state.video;
        this.state.stream.stop();

        video.pause();
        video.src          = '';
        video.mozSrcObject = null;

        this.setState({ video : video });
    },

    pictureTaken : function () {
        return this.state.picture_taken;
    },

    getSnappedImage : function () {
        if (!this.pictureTaken()) return null;

        var data_url    = this.state.canvas.toDataURL();
        var binary_blob = atob(data_url.split(',')[1]);
        var array       = [];

        for(var i = 0; i < binary_blob.length; i++) {
            array.push(binary_blob.charCodeAt(i));
        }

        return new Blob([new Uint8Array(array)], {type: 'image/png'});
    },

    mountCameraAction : function () {
        var streamVideo = function () {
            return function (stream) {
                var video = this.state.video;

                if (navigator.mozGetUserMedia) {
                    video.mozSrcObject = stream;
                }
                else {
                    video.src = window.URL.createObjectURL(stream);
                }

                this.setState({
                    video  : video,
                    stream : stream
                });

                this.state.video.play();


            }.bind(this);
        };

        navigator.getMedia = (
            navigator.getUserMedia ||
            navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia ||
            navigator.msGetUserMedia
        );

        navigator.getMedia(
            {
                video : true,
                audio : false
            },
            streamVideo.bind(this)(),
            function (err) {}
        );

        var streamingListener = function () {
            return function (event) {
                if (!this.state.streaming) {
                    var height = this.state.video.videoHeight / (this.state.video.videoWidth / this.state.width);

                    if (isNaN(height)) {
                        height = this.state.width / (4 / 3);
                    }

                    video = this.state.video;
                    video.setAttribute('width', this.state.width);
                    video.setAttribute('height', height);

                    canvas = this.state.canvas;
                    canvas.setAttribute('width', this.state.width);
                    canvas.setAttribute('height', height);

                    this.setState({
                        height    : height,
                        video     : video,
                        canvas    : canvas,
                        streaming : true
                    });
                }

                var camera_node = React.findDOMNode(this.refs.camera)
                camera_node.style.width  = this.state.width + 'px'
                camera_node.style.height = this.state.height + 'px'
            }.bind(this);
        };

        this.state.video.addEventListener('canplay', streamingListener.bind(this)(), false);

        var snapImage = function () {
            return function (event) {
                this.takePicture();
                event.preventDefault();
            }.bind(this);
        };

        var resetImage = function () {
            return function (event) {
                this.resetPicture();
                event.preventDefault();
            }.bind(this);
        };

        this.state.start_button.addEventListener('click', snapImage.bind(this)(), false);
        this.state.reset_button.addEventListener('click', resetImage.bind(this)(), false);
    },

    takePicture : function () {
        var context = this.state.canvas.getContext('2d');

        if (this.state.width && this.state.height) {
            this.state.canvas.width  = this.state.width;
            this.state.canvas.height = this.state.height;
            context.drawImage(this.state.video, 0, 0, this.state.width, this.state.height);

            this.setState({ picture_taken : true });
        }
    },

    resetPicture : function () {
        var context = this.state.canvas.getContext('2d');
        context.clearRect (0, 0, this.state.width, this.state.height);

        this.setState({ picture_taken : false });
    },

    render : function () {
        return (
            <div className="camera" ref="camera">
                <video ref="video" className="video">Video stream not available.</video>
                <canvas ref="canvas" className="canvas" />

                <div className="buttons">
                    <button ref="file_button" className="file_button"><i className="fa fa-image fa-2x" />
                        <input type="file" accept="image/*" />
                    </button>
                    <button ref="reset_button" className="reset_button" style={{display : this.state.picture_taken ? 'inline' : 'none'}}><i className="fa fa-refresh fa-2x" /></button>
                    <button ref="start_button" className="start_button" style={{display : this.state.picture_taken ? 'none' : 'inline'}}><i className="fa fa-camera fa-2x" /></button>
                </div>
            </div>
        );
    }
});

module.exports = Camera;
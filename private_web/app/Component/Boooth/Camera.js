var React = require('react');

var Camera = React.createClass({
    getInitialState : function () {
        return {
            width        : 320,
            height       : null,
            streaming    : null,
            video        : null,
            canvas       : null,
            photo        : null,
            start_button : null,
            reset_button : null
        };
    },

    componentDidMount : function () {
        this.setState({
            video        : document.getElementById('video'),
            canvas       : document.getElementById('canvas'),
            photo        : document.getElementById('photo'),
            start_button : document.getElementById('start_button'),
            reset_button : document.getElementById('reset_button')
        }, this.mountCameraAction);
    },

    mountCameraAction : function () {
        var streamVideo = function () {
            return function (stream) {
                if (navigator.mozGetUserMedia) {
                    var video          = this.state.video;
                    video.mozSrcObject = stream;
                    this.setState({ video : video });
                }
                else {
                    var video     = this.state.video;
                    video.src     = window.URL.createObjectURL(stream);
                    this.setState({ video : video });
                }

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
            function (err) {
                console.log("An error occured! " + err);
            }
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

            var data  = this.state.canvas.toDataURL('image/png');
            var photo = this.state.photo;

            photo.setAttribute('src', data);
            this.setState({ photo : photo });
        }
    },

    resetPicture : function () {
        var photo = this.state.photo;
        photo.setAttribute('src', '');
        this.setState({ photo : photo });
    },

    render : function () {
        return (
            <div>
                <div className="camera">
                    <video id="video">Video stream not available.</video>
                    <button id="start_button">Take photo</button>
                    <button id="reset_button">Reset photo</button>
                </div>

                <canvas id="canvas" style={{ display : 'none' }} />
                <div className="output"><img id="photo" /></div>
            </div>
        );
    }
});

module.exports = Camera;
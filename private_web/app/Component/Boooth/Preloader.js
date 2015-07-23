var ImageLoader  = require('react-imageloader');
var React        = require('react');
var RouteHandler = require('react-router').RouteHandler;

var PreLoader = React.createClass({
    getStyle : function () {
        return {
            width      : this.props.default_width,
            height     : this.props.default_width * this.props.height / this.props.width,
            background : this.props.background,
        };
    },

    loadTemporaryImage : function () {
        var styles = this.getStyle();

        return <div style={styles} />;
    },

    render : function() {
        var styles = this.getStyle();

        return (
            <ImageLoader
                    src={this.props.src}
                    preloader={this.loadTemporaryImage}
                    wrapper={React.DOM.div}>
                <div style={styles} />
            </ImageLoader>
        );
    }
});

module.exports = PreLoader;
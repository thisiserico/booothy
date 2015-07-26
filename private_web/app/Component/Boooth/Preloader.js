var ImageLoader  = require('react-imageloader');
var React        = require('react');
var RouteHandler = require('react-router').RouteHandler;

var PreLoader = React.createClass({
    getStyle : function () {
        var expand = this.props.expand_to_default;
        var width  = expand ? this.props.default_width : this.props.width;

        return {
            width      : width + 'px',
            height     : width * this.props.height / this.props.width + 'px',
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
                    src={this.props.src + '?id_token=' + window.auth.id_token}
                    preloader={this.loadTemporaryImage}
                    wrapper={React.DOM.div}>
                <div style={styles} />
            </ImageLoader>
        );
    }
});

module.exports = PreLoader;
var Link         = require('react-router').Link;
var React = require('react');

var PhotoThumbnail = React.createClass({
    render : function() {
        return (
            <Link
                to="boooth_detail"
                params={{ id : this.props.photo['id'] }}
                className="boooth_thumbnail"
                data-content={this.props.photo['quote']}
            >
                <img src={this.props.photo['upload']['download_url']} />
            </Link>
        );
    }
});

module.exports = PhotoThumbnail;
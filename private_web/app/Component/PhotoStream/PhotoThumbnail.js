var React = require('react');

var PhotoThumbnail = React.createClass({
    render: function() {
        return (
            <div className="boooth_thumbnail" data-content={this.props.photo['quote']}>
                <img src={this.props.photo['upload']['download_url']} />
            </div>
        );
    }
});

module.exports = PhotoThumbnail;
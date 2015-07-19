var React = require('react');

var PhotoThumbnail = React.createClass({
    render: function() {
        return (
            <div className="photo">
                <pre>Id: {this.props.photo['id']}</pre>
                <pre>Quote: {this.props.photo['quote']}</pre>
                <pre>Creation date: {this.props.photo['creation_date']}</pre>
                <img src={this.props.photo['upload']['download_url']}  />
            </div>
        );
    }
});

module.exports = PhotoThumbnail;
var Link      = require('react-router').Link;
var Preloader = require('../Boooth/Preloader');
var React     = require('react');

var PhotoThumbnail = React.createClass({
    render : function() {
        return (
            <Link
                to="boooth_detail"
                params={{ id : this.props.photo['id'] }}
                className="boooth_thumbnail"
                data-content={this.props.photo['quote']}
                title={this.props.photo.creation_date}
            >
                <Preloader
                    src={this.props.photo['upload']['thumb_download_url']}
                    default_width={300}
                    expand_to_default={true}
                    width={this.props.photo['image_details']['width'] > 0 ? this.props.photo['image_details']['width'] : '640' }
                    height={this.props.photo['image_details']['height'] > 0 ? this.props.photo['image_details']['height'] : '480' }
                    background={this.props.photo['image_details']['hex_color'] !== '' ? this.props.photo['image_details']['hex_color'] : '#3f1e31' } />
            </Link>
        );
    }
});

module.exports = PhotoThumbnail;
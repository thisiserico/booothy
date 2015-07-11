var React = require('react');
var Photo = require('./Photo.js');

var PhotoList = React.createClass({
    getInitialState: function(){
        return {
            photos: [
                {
                    id : '1234',
                    quote : 'Aloha',
                    upload  : {
                        filename     : 'foo.png',
                        mime_type    : 'image/png',
                        download_url : 'http://booothy.ericlopez.me.dev/index_dev.php/u/tenth.png'
                    },
                    creation_date : '2015-06-26 18:13:41'
                },
                {
                    id : '5678',
                    quote : 'Namaste',
                    upload  : {
                        filename     : 'foo.png',
                        mime_type    : 'image/png',
                        download_url : 'http://booothy.ericlopez.me.dev/index_dev.php/u/tenth.png'
                    },
                    creation_date : '2015-06-26 18:13:41'
                }
            ]
        }
    },

    render: function () {
        return (
            <div>
            {
                this.state.photos.map(function (photo) {
                    return <Photo key={photo.id} photo={photo} />
                })
            }
            </div>
        );
    }
});

module.exports = PhotoList;
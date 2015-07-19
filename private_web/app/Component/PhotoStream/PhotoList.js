var PhotosClient   = require('../../Api/PhotosClient');
var PhotoStore     = require('../../Store/PhotoStore');
var PhotoThumbnail = require('./PhotoThumbnail.js');
var React          = require('react');

var PhotoList = React.createClass({
    getState : function () {
        return {
            all_photos                : PhotoStore.getCollection(),
            loading_new_set           : PhotoStore.newSetBeingLoaded(),
            uploading_boooth          : PhotoStore.booothBeingUploaded(),
            complete_catalogue_loaded : PhotoStore.completeCatalogueLoaded(),
            current_page              : this.state
                ? this.state.current_page
                : parseInt(this.props.page),
            loaded_pages              : this.state
                ? this.state.loaded_pages
                : []
        };
    },

    getInitialState : function () {
        return this.getState();
    },

    componentDidMount : function () {
        PhotoStore.addChangeListener(this._onChange);
        PhotosClient.getCollection(this.props.page);

        this.addScrollListener();
    },

    componentWillUnmount : function () {
        PhotoStore.removeChangeListener(this._onChange);
        this.removeScrollListener();
    },

    addScrollListener : function () {
        window.addEventListener('scroll', this.scrollListener);
        window.addEventListener('resize', this.scrollListener);
    },

    removeScrollListener : function () {
        window.removeEventListener('scroll', this.scrollListener);
        window.removeEventListener('resize', this.scrollListener);
    },

    scrollListener : function () {
        this.removeScrollListener();

        var scrolled_height = window.pageYOffset;
        var page_height     = window.innerHeight;
        var body_height     = window.document.body.offsetHeight;
        var bottom_reached  = (scrolled_height + page_height) >= (body_height - 3000);

        if (bottom_reached && this.shouldLoadNextPage()) {
            var next_page = this.state.current_page + 1;
            PhotosClient.getCollection(next_page);

            var loaded_pages = this.state.loaded_pages;
            loaded_pages.push(this.state.current_page);

            this.setState({
                current_page : next_page,
                loaded_pages : loaded_pages
            });
        }

        this.addScrollListener();
    },

    shouldLoadNextPage : function () {
        var next_page = this.state.current_page + 1;

        return (
            this.state.loaded_pages.indexOf(next_page) === -1
            && !this.state.loading_new_set
            && !this.state.complete_catalogue_loaded
        );
    },

    _onChange : function () {
        this.setState(this.getState());
    },

    render : function () {
        var photos = [];

        this.state.all_photos.map(function (photo) {
            photos.push(<PhotoThumbnail key={photo.id} photo={photo} />);
        })

        return (
            <div>
                <pre>{this.state.uploading_boooth ? 'Uploading' : ''}</pre>
                {photos}
                <pre>{this.state.loading_new_set ? 'Loading' : ''}</pre>
                <pre>{this.state.complete_catalogue_loaded ? 'No more boooths to be shown!' : ''}</pre>
            </div>
        );
    }
});

module.exports = PhotoList;
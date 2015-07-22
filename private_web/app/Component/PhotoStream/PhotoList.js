var MasonryMixin   = require('react-masonry-mixin');
var PhotosClient   = require('../../Api/PhotosClient');
var PhotosStore    = require('../../Store/PhotosStore');
var PhotoThumbnail = require('./PhotoThumbnail.js');
var React          = require('react');

var masonryOptions = { transitionDuration : 0 };

var PhotoList = React.createClass({
    mixins: [MasonryMixin('boooths', masonryOptions)],

    getState : function () {
        return {
            all_photos                : PhotosStore.getCollection(),
            loading_new_set           : PhotosStore.newSetBeingLoaded(),
            complete_catalogue_loaded : PhotosStore.completeCatalogueLoaded(),
            current_page              : this.state ? this.state.current_page : 1,
            loaded_pages              : this.state ? this.state.loaded_pages : []
        };
    },

    getInitialState : function () {
        return this.getState();
    },

    componentDidMount : function () {
        PhotosStore.addChangeListener(this._onChange);
        PhotosClient.getCollection(this.props.page);

        this.addScrollListener();
    },

    componentWillUnmount : function () {
        PhotosStore.removeChangeListener(this._onChange);
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
                <div className="boooths" ref="boooths">
                    {photos}
                </div>
                <pre>{this.state.loading_new_set ? 'Loading' : ''}</pre>
                <pre>{this.state.complete_catalogue_loaded
                    ? <span className="all_loaded">&#9825;</span>
                    : ''
                }</pre>
            </div>
        );
    }
});

module.exports = PhotoList;
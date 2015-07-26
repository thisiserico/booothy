var AppDispatcher  = require('../../Dispatcher/AppDispatcher');
var Link           = require('react-router').Link;
var PhotoConstants = require('../../Constant/PhotoConstants');
var PhotosStore    = require('../../Store/PhotosStore');
var UsersClient    = require('../../Api/UsersClient');
var UsersStore     = require('../../Store/UsersStore');
var React          = require('react');
var RouteHandler   = require('react-router').RouteHandler;
var SignOut        = require('../Auth/SignOut');

var Menu = React.createClass({
    getInitialState : function () {
        return {
            menu_hover     : false,
            users          : [],
            filtering_user : PhotosStore.filteringUser()
        };
    },

    componentDidMount : function () {
        UsersStore.addUsersLoadedListener(this.usersLoaded);
        UsersClient.getCollection();
    },

    usersLoaded : function () {
        this.setState({ users : UsersStore.getUsersCollection() });
    },

    _menuMouseOver : function () {
        if (this.state.menu_hover) return;

        this.setState({ menu_hover : true });
    },

    _menuMouseOut : function () {
        if (!this.state.menu_hover) return;

        this.setState({ menu_hover : false });
    },

    _applyFiltering : function (user_id) {
        AppDispatcher.dispatch({
            actionType : PhotoConstants.FILTER_PER_USER,
            user_id    : user_id
        });

        this.setState({ filtering_user : PhotosStore.filteringUser() });

        event.preventDefault();
    },

    obtainLinkVisibility : function (user) {
        return this.state.filtering_user
            ? (this.state.filtering_user === user.id ? 'display' : 'hide')
            : 'display';
    },

    render : function() {
        var current_user            = undefined;
        var raw_current_user        = UsersStore.getCurrentUser();
        var current_user_visibility = this.obtainLinkVisibility(raw_current_user);
        var users                   = [];
        var raw_users               = this.state.users;

        current_user = (
            <a
                className={current_user_visibility}
                key={raw_current_user.id}
                onClick={this._applyFiltering.bind(this, raw_current_user.id)}
                style={{ display : this.state.menu_hover ? 'block' : 'none' }}>
                    <img src={raw_current_user.avatar} />
            </a>
        );

        raw_users.map(function (user) {
            if (user.id === raw_current_user.id) return;

            var visibility = this.obtainLinkVisibility(user);
            users.push(
                <a
                    className={visibility}
                    key={user.id}
                    onClick={this._applyFiltering.bind(this, user.id)}
                    style={{ display : this.state.menu_hover ? 'block' : 'none' }}>
                        <img src={user.avatar} />
                </a>
            );
        }.bind(this));

        return (
            <div className="menu" onMouseOver={this._menuMouseOver} onMouseOut={this._menuMouseOut}>
                <SignOut style={{ display : this.state.menu_hover ? 'block' : 'none' }} />

                {users}
                {current_user}

                <Link to="boooth">
                    {this.state.menu_hover
                        ? <i className="fa fa-camera" />
                        : <i className="fa fa-plus" />
                    }
                </Link>
            </div>
        );
    }
});

module.exports = Menu;
var Link         = require('react-router').Link;
var UsersClient  = require('../../Api/UsersClient');
var UsersStore   = require('../../Store/UsersStore');
var React        = require('react');
var RouteHandler = require('react-router').RouteHandler;
var SignOut      = require('../Auth/SignOut');

var Menu = React.createClass({
    getInitialState : function () {
        return {
            menu_hover : false,
            users      : []
        };
    },

    componentDidMount : function () {
        UsersStore.addUsersLoadedListener(this._usersLoaded);
        UsersClient.getCollection();
    },

    _menuMouseOver : function () {
        if (this.state.menu_hover) return;

        this.setState({ menu_hover : true });
    },

    _menuMouseOut : function () {
        if (!this.state.menu_hover) return;

        this.setState({ menu_hover : false });
    },

    _usersLoaded : function () {
        this.setState({ users : UsersStore.getUsersCollection() });
    },

    render : function() {
        var users = [];

        this.state.users.map(function (user) {
            users.push(
                <Link key={user.id} to="boooth" style={{ display : this.state.menu_hover ? 'block' : 'none' }}>
                    <img src={user.avatar} />
                </Link>
            );
        }.bind(this));

        return (
            <div className="menu" onMouseOver={this._menuMouseOver} onMouseOut={this._menuMouseOut}>
                <SignOut style={{ display : this.state.menu_hover ? 'block' : 'none' }} />
                <Link to="boooth" style={{ display : this.state.menu_hover ? 'block' : 'none' }}><i className="fa fa-cog" /></Link>

                {users}

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
var Link         = require('react-router').Link;
var React        = require('react');
var RouteHandler = require('react-router').RouteHandler;
var SignOut      = require('./SignOut');

var Menu = React.createClass({
    getInitialState : function () {
        return { menu_hover : false };
    },

    _menuMouseOver : function () {
        if (this.state.menu_hover) return;

        this.setState({ menu_hover : true });
    },

    _menuMouseOut : function () {
        if (!this.state.menu_hover) return;

        this.setState({ menu_hover : false });
    },

    render : function() {
        return (
            <div className="menu" onMouseOver={this._menuMouseOver} onMouseOut={this._menuMouseOut}>
                <SignOut style={{ display : this.state.menu_hover ? 'block' : 'none' }} />
                <Link to="boooth" style={{ display : this.state.menu_hover ? 'block' : 'none' }}><i className="fa fa-cog" /></Link>

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
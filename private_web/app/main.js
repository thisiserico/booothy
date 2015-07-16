var React          = require('react');
var Router         = require('react-router');
var Route          = Router.Route;
var RouteHandler   = Router.RouteHandler;
var BrowserHistory = Router.BrowserHistory;

var App      = require('./Component/Booothy/App.js');
window.React = React;

var routes = (
  <Route history={BrowserHistory} handler={App}>
  </Route>
);

Router.run(routes, Router.HashLocation, function (Root) {
  React.render(<Root/>, document.body);
});
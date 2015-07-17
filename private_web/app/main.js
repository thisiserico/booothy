var React          = require('react');
var Router         = require('react-router');
var Route          = Router.Route;
var BrowserHistory = Router.BrowserHistory;

var App          = require('./Component/Booothy/App.js');
var BooothUpload = require('./Component/Boooth/Upload.js');
window.React     = React;

var routes = (
    <Route history={BrowserHistory} name="app" path="/" handler={App}>
        <Route name="boooth" path="boooth" handler={BooothUpload} ignoreScrollBehavior={true} />
    </Route>
);

Router.run(routes, Router.HashLocation, function (Root) {
  React.render(<Root/>, document.body);
});
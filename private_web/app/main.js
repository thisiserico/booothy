var React          = require('react');
var Router         = require('react-router');
var Route          = Router.Route;
var BrowserHistory = Router.BrowserHistory;
var Redirect       = Router.Redirect;

var App          = require('./Component/Booothy/App.js');
var BooothLoader = require('./Component/Boooth/Loader.js');
var BooothUpload = require('./Component/Boooth/Upload.js');
window.React     = React;

var routes = (
    <Route history={BrowserHistory} name="app" path="/" handler={App}>
        <Redirect from="/" to="boooth_loader" params={{ page : 1 }} />

        <Route name="boooth_loader" path="page/:page" handler={BooothLoader}>
            <Route name="boooth" path="new" handler={BooothUpload} ignoreScrollBehavior={true} />
        </Route>
    </Route>
);

Router.run(routes, Router.HashLocation, function (Root) {
  React.render(<Root/>, document.body);
});
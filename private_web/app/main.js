var React          = require('react');
var Router         = require('react-router');
var Route          = Router.Route;
var BrowserHistory = Router.BrowserHistory;
var Redirect       = Router.Redirect;

var App          = require('./Component/Booothy/App.js');
var BooothLoader = require('./Component/Boooth/Loader.js');
var BooothUpload = require('./Component/Boooth/Upload.js');
var BooothDetail = require('./Component/Boooth/Detail.js');
window.React     = React;

var routes = (
    <Route history={BrowserHistory} name="app" path="/" handler={App}>
        <Route name="boooth_loader" path="boooths" handler={BooothLoader}>
            <Route name="boooth" path="new" handler={BooothUpload} ignoreScrollBehavior={true} />
            <Route name="boooth_detail" path=":id" handler={BooothDetail} />
        </Route>
    </Route>
);

Router.run(routes, Router.HashLocation, function (Root) {
  React.render(<Root/>, document.body);
});
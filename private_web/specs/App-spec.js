var App = require('./../app/App.js');
var React = require('react/addons');
var TestUtils = React.addons.TestUtils;

describe("App", function() {

  it("should render text: Hello boyos! :D", function() {
    var app = TestUtils.renderIntoDocument(React.createElement(App));
    expect(React.findDOMNode(app).textContent).toEqual('Hello boyos! :D');
  });
});
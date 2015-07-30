# Booothy
> Private memories made easy

[![Master Build Status](https://magnum.travis-ci.com/aeony/booothy.svg?token=4kUW5zWBcCwXpR1GwCwA&branch=master)](https://magnum.travis-ci.com/aeony/booothy)


Ever wanted to have a private platform to share some love?
Do you feel like showing gratitude to your loved ones?
Booothy is a build-and-serve yourself platform to do exactly that: enjoy sharing your love and
gratitude with your companion in life. Taking photos ( boooths ) was never this fun and
easy :)

Using a _restful_ php API in the server ( following the _domain driven design_ paradigm ), a
_react_ application in the client side ( using the _flux_ pattern ) and _sass_ to make it
beautiful, this is the perfect gift!

Deploy and impress <3


## Features
- No need to sign up, just use the google sign in button ( only allowed users ;) )
- Boooth stream displayed beautifully
- Boooth detailed view
- Boooth filtering per user
- Use the camera to take boooths
- Upload images as boooths
- Add a nice little thought to each boooth


## Future features
- Responsive design
- User management
- Usability improvements
- Pack everything in a vagrant virtual box
- Online demo
- On demand backups
- Even more!


## How it works
### Server side
The php API is powered by [`Silex`][silex]. We can find everything related to the overall application under
`src/App`. There are three main pieces here:

#### 1. Services definition
The server side is strongly decoupled using de `dependency inversion principle`. Every class
related to booothy itself is declared as a service. Even parameters ( folders, credentials,
urls... ) are declared as services. You might want to take a look to the
`src/App/DependencyInjection/Services/definition_prod.yml` file. As you can see, the configuration
being loaded depends on the environment. There's the possibility to create a
`private_definition_prod.php`. You can use this to avoid sharing sensible information in the
project repository ( open sourcing, you know ;) ). That file might look like

```
<?php

$container->setParameter('google.client_id', 'cool_client_id');
$container->setParameter('google.client_secret', 'super_secret');
```

Once the services are defined, they need to be transpiled into a php class. We use the
`app:dump-services` console command. That command accepts the environments you want to build.

```
bin/console app:dump-services dev prod
```

That command will generate php classes that you might want to avoid adding to the repo.

#### 2. Controllers declaration
The controllers responsibility is to act as a proxy between the framework and booothy itself.
In this case, every possible route is mapped to a controller that will handle the request.

If you take a look to any controller you'll see that they are pretty simple and much alike
each other. They only receive a request, define event listeners when necessary, execute a use case,
and return a response. Nothing else!

#### 3. Booothy!
All the booothy code is placed under `src/Booothy`. This is the application itself, decoupled
from any framework and ready to be understood without having to learn how Silex works. It's just
plain php! Take a look to the code to discover a `DDD` implementation.

### Client side
The client side application is powered by the facebook's flux pattern using react. The whole
application can be found under the `private_web` folder. There's an entry point ( `main.js` )
where the react routes are declared. The components need to be rearranged, but you can get the
idea. The design for the client side is not as polished as it could be. There are not even tests!
Sorry for that.


## Installation
The installation is a two steps process.

### 1. Server side
Dependencies installation using composer.
```
# booothy/
composer install
```

Services definition precompilation ( uses [`symfony/dependency-injection`][dic] ).
```
# booothy/
bin/console app:dump-services dev prod
```

### 2. Client side
Dependencies installation using npm.
```
# booothy/private_web/
npm install
```

There are two ways to bundle the `styles` and `javascript` files: the default way ( use in
development only ) and the deployable way, where everything gets minified.
```
# booothy/private_web/
node_modules/.bin/gulp default
node_modules/.bin/gulp deploy
```

Once installed, you're ready to go. You'll need some kind of host to access your application. You
could to use the built-in php development server. Although this method won't take you too far as
you need to configure a project though the [Google developers console][gdc] and to create and
declare some folders.

The recommendation is to use some kind of web server ( nginx or apache ) within a virtual machine.
```
# booothy/web/
php -S localhost:8000
```


## License
Distributed under an [Apache license 2.0][al2] you're free to fork and modify the code. You can
also onfigure and deploy your own booothy right now :)


## Further work
This is a live project. More features will be implemented. Feel free to [let me know][issues] if
you're having some trouble.

Pull requests are welcome. Hope you like it!

[dic]: https://packagist.org/packages/symfony/dependency-injection
[gdc]: https://console.developers.google.com
[silex]: http://silex.sensiolabs.org/
[al2]: http://www.apache.org/licenses/LICENSE-2.0
[issues]: https://github.com/aeony/booothy/issues
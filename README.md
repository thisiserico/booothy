# Booothy
> Private memories made easy

[![Build Status](https://travis-ci.org/aeony/booothy.svg?branch=master)](https://travis-ci.org/aeony/booothy)

Ever wanted to have a private platform to share some love?
Do you feel like showing gratitude to your loved ones?
Booothy is a serve yourself platform to do exactly that: enjoy sharing your love and
gratitude with your significant others. Taking photos (boooths) was never this fun and
easy :)

Using a _restful_ php API in the server (following the _domain driven design_ paradigm), a
_react_ application in the client side (using the _flux_ pattern) and _sass_ to make it
beautiful, this is the perfect gift!

Deploy and impress <3


## Features
- No need to sign up, just use the google sign in button (only allowed users ;)
- Boooth stream displayed beautifully
- Boooth detailed view
- Boooth per user filtering
- Use the camera to take boooths
- Upload images as boooths
- Add a nice little thought to each boooth
- Dockerized application


## Future features
- Responsive design
- User management
- Usability improvements
- On demand backups
- Even more!


## Installation
Head to the [Google developers console][gdc] and create a new booothy project.
Configure your credentials with this two urls:

```
https://booothy.dev
https://booothy.dev/oauth2callback
```

Execute the following links to build and run booothy
```
# Create SSL keys
openssl genrsa -out config/ssl/private_key.pem 2048
openssl req -new -x509 -key config/ssl/private_key.pem -out config/ssl/cacert.pem -days 365

# Configure development application
cp .env.dist .env
sudo echo 127.0.0.1 booothy.dev >> /etc/hosts

# Install dependencies
composer install
cd private_web
npm install
./node_modules/.bin/gulp deploy
cd ..

# Run booothy
docker-compose up
```

The only remaining step is to set up booothy
```
# Copy your google public and private keys into the .env file

docker exec -it booothy_booothy-fpm_1 sh
cd ../booothy
./bin/console app:dump
./bin/console booothy:create-user -e [your.gmail.address@gmail.com]
```

You can now visit [Booothy!][booothy-dev]

## How it works
### Server side
The php API is powered by [`Silex`][silex]. We can find everything related to the overall application under
`src/App`. There are three main pieces here:

#### 1. Services definition
The server side is strongly decoupled using de `dependency inversion principle`. Every class
related to booothy itself is declared as a service. Even parameters (folders, credentials,
urls...) are declared as services. You might want to take a look to the
`src/App/DependencyInjection/Services/definition.yml` file.

Once the services are defined, they need to be transpiled into a php class. We use the
`app:dump-services` console command.

```
bin/console app:dump-services
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
application can be found under the `private_web` folder. There's an entry point (`main.js`)
where the react routes are declared. The components need to be rearranged, but you can get the
idea. The design for the client side is not as polished as it could be. There are not even tests!
Sorry for that.

## License
Distributed under an [Apache license 2.0][al2] you're free to fork and modify the code. You can
also onfigure and deploy your own booothy right now :)


## Further work
This is a live project. More features will be implemented. Feel free to [let me know][issues] if
you're having some trouble.

Pull requests are welcome. Hope you like it!

[dic]: https://packagist.org/packages/symfony/dependency-injection
[gdc]: https://console.developers.google.com
[booothy-dev]: https://booothy.dev
[silex]: http://silex.sensiolabs.org/
[al2]: http://www.apache.org/licenses/LICENSE-2.0
[issues]: https://github.com/aeony/booothy/issues

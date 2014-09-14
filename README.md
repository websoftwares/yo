#Yo (v0.2.0)
This package lets u perform actions on the [Yo Developers API](http://dev.justyo.co/ "Yo Developers API").

[![Build Status](https://api.travis-ci.org/websoftwares/yo.png)](https://travis-ci.org/websoftwares/yo)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/websoftwares/yo/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/websoftwares/yo/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/websoftwares/yo/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/websoftwares/yo/?branch=master)
[![Dependencies Status](https://depending.in/websoftwares/yo.png)](http://depending.in/websoftwares/yo)

It has no extra dependencies but it can play nice with other curl or http clients by creating an adapter
just implement the _YoClientInterface_ and inject it into the `Yo` class.

## Documentation
We encourage you to read the [documentation](http://dev.justyo.co/documents.html "dev.justyo.co") carefully before proceeding.

## Installing via Composer (recommended)

Install composer in your project:
```
curl -s http://getcomposer.org/installer | php
```

Create a composer.json file in your project root:
```php
{
    "require": {
        "websoftwares/yo": "dev-master"
    }
}
```

Install via composer
```
php composer.phar install
```

## Usage
Basic usage of the `Yo` class.

```php
use Websoftwares\YoClient, Websoftwares\Yo;

// apiKey
$apiKey = 'obtain-valid-api-key-from-yo';

// Instantiate class
$Yo = new Yo(new YoClient($apiKey));

// Perform method
$yo->all();
```

## all();
This will yo all your subscribers
```php
$yo->all();
```
_(optional)_
provide a link argument
This will yo all your subscribers with a link
```php
$yo->all("yo.websoftwar.es");
```

## user();
This will yo an individual user
```php
$yo->user("BORIS010");
```
_(optional)_
provide a link argument
This will yo an individual user with a link
```php
$yo->user("BORIS010", "yo.websoftwar.es");
```

## subscribersCount();
Returns the amount of subscribers
```php
$yo->subscribersCount();
```

## Testing
In the tests folder u can find several tests.

## Goals

* Unit testing 100%
* PSR compliance
* Implement new methods from Yo API when they are available

## License
The [MIT](http://opensource.org/licenses/MIT "MIT") License (MIT).
# Laravel Notification Channels - Netgsm SMS Gateway Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/netgsm.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/netgsm)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-notification-channels/netgsm/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/netgsm)
[![StyleCI](https://styleci.io/repos/:style_ci_id/shield)](https://styleci.io/repos/:style_ci_id)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/:sensio_labs_id.svg?style=flat-square)](https://insight.sensiolabs.com/projects/:sensio_labs_id)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/netgsm.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/netgsm)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/laravel-notification-channels/netgsm/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/netgsm/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/netgsm.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/netgsm)

This package makes it easy to send notifications using [Netgsm](http://www.netgsm.com.tr) with Laravel 5.5+, 6.x and 7.x



## Contents

- [Installation](#installation)
	- [Setting up the Netgsm service](#setting-up-the-Netgsm-service)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

This package can be installed via composer:

```composer require laravel-notification-channels/netgsm```

### Setting up the NetGSM service

1. Create an account and get the API key [here](https://www.netgsm.com.tr)

2. Add credentials to `.env` file:

	```
       NETGSM_USERCODE="NETGSM_PHONE"
       NETGSM_PASSWORD="PASSWORD"
       NETGSM_HEADER="SENDER_ID"
       NETGSM_LANGUAGE="LANGUAGE (tr,en)"
	```

## Usage

You can use this channel by adding `NetgsmChannel::class` to the array in the `via()` method of your notification class. You need to add the `toNetgsm()` method which should return a `NetgsmMessage()` object.

```php
<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\Netgsm\NetgsmChannel;
use NotificationChannels\Netgsm\NetgsmMessage;

class InvoicePaid extends Notification
{
    public function via($notifiable)
    {
        return [NetgsmChannel::class];
    }

    public function toNetgsm() {
        return (NetgsmMessage::create('Hallo!'))
        ->from('Max');
    }
}
```

You will have to set a `routeNotificationForNetgsm()` method in your notifiable model. For example:

```php
class User extends Authenticatable
{
    use Notifiable;

    ....

    /**
     * Specifies the user's Phone Number
     *
     * @return string
     */
    public function routeNotificationForNetgsm()
    {
        return $this->phone_number;
    }
}
```

### Available Message methods

- `getPayloadValue($key)`: Returns payload value for a given key.
- `content(string $message)`: Sets SMS message text.
- `to(string $number)`: Set recipients number. 
- `from(string $from)`: Set senders name.
- `getMessage()`: Get Message body from NetgsmMessage Object.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email burak@sormagec.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Burak Sormageç](https://github.com/bsormagec)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

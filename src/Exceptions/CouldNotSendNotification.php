<?php

namespace NotificationChannels\Netgsm\Exceptions;

class CouldNotSendNotification extends \Exception
{

    public static function apiKeyNotProvided(): self
    {
        return new static('API key is missing.');
    }

    public static function phoneNumberNotProvided(): self
    {
        return new static('No phone number was provided.');
    }

    public static function apiError($error)
    {
        return new static($error);
    }
}

<?php

namespace NotificationChannels\Netgsm;

use NotificationChannels\Netgsm\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;

class NetgsmChannel
{

    /**
     * @var NetGSMClient
     */
    private $client;

    public function __construct(NetGSMClient $client)
    {
        $this->client = $client;
    }


    public function send($notifiable, Notification $notification)
    {

        $message = $notification->toNetgsm($notifiable);

        if (is_string($message)) {
            $message = NetgsmMessage::create($message);
        }

        if (!$message->hasToNumber()) {
            $to = $notifiable->routeNotificationFor('netgsm');

            if (!$to) {
                throw CouldNotSendNotification::phoneNumberNotProvided();
            }

            $message->to($to);
        }

        $params = $message->toArray();

        if ($message instanceof NetgsmMessage) {
            $response = $this->client->sendMessage($params);
        }

        if (!$response->isSuccessful()) {
            throw CouldNotSendNotification::apiError($response->status());
        }


        return [
            'transmissionId' => $response->transmissionId(),
            'status' => $response->status(),
            'status_code' => $response->statusCode(),
            'isSuccessful' => $response->isSuccessful()
        ];

    }


}

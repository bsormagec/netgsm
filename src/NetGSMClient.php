<?php

namespace NotificationChannels\Netgsm;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Arr;

class NetGSMClient
{
    /**
     * The Http client.
     *
     * @var HttpClient
     */
    public $httpClient;


    public function __construct()
    {

        $this->httpClient = new HttpClient([
            'base_uri' => 'https://api.netgsm.com.tr/',
            'defaults' => [
                'headers' => ['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36'],
                'query' => [
                    'usercode' => env('NETGSM_USERCODE'),
                    'password' => env('NETGSM_PASSWORD'),
                    'msgheader' => env('NETGSM_HEADER'),
                    'dil' => env('NETGSM_LANGUAGE'),
                ],
            ],
        ]);
    }

    /**
     * Send a message using the NetGSM services.
     *
     * @param array $params
     * @return NetGSMResponse
     */
    public function sendMessage(array $params): NetGSMResponse
    {
        $queryparams = array_merge($this->getDefaultQueryParameters(), $params);

        try {
            $httpClientResponse = $this->httpClient->get('sms/send/get/', [
                'query' => $queryparams,
            ]);
        } catch (\Exception $exception) {
            throw new \RuntimeException('Something went wrong while sending sms.');
        }
        return new NetGSMResponse((string)$httpClientResponse->getBody());
    }

    /**
     * Get the default query parameters from the client config.
     *
     * @return array
     */
    public function getDefaultQueryParameters(): array
    {
        $configDefaults = $this->httpClient->getConfig('defaults');

        if (null === $configDefaults || !isset($configDefaults['query'])) {
            return [];
        }

        return $configDefaults['query'];
    }

    /**
     * Format the given message.
     *
     * @param string $message
     *
     * @return string
     */
    public function formatMessage(string $message): string
    {
        return preg_replace('/\s+/', ' ', $message);
    }
}

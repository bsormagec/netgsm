<?php

namespace NotificationChannels\Netgsm;

class NetgsmMessage
{
    protected $payload = [];

    /**
     * @param string $message
     */
    public function __construct(string $message = '')
    {
        $this->payload['message'] = $message;
    }

    /**
     * Return new NetgsmMessage object.
     *
     * @param string $message
     * @return NetgsmMessage
     */
    public static function create(string $message = ''): self
    {
        return new self($message);
    }

    /**
     * Returns if recipient number is given or not.
     *
     * @return bool
     */
    public function hasToNumber(): bool
    {
        return isset($this->payload['gsmno']);
    }

    /**
     * Return payload.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->payload;
    }

    /**
     * Set message content.
     *
     * @param string $message
     * @return NetgsmMessage
     */
    public function content(string $message): self
    {
        $this->payload['message'] = $message;

        return $this;
    }

    /**
     * Set recipient phone number.
     *
     * @param string $to
     * @return NetgsmMessage
     */
    public function to(string $to): self
    {
        $this->payload['gsmno'] = $to;

        return $this;
    }

    /**
     * Set sender name.
     *
     * @param string $from
     * @return NetgsmMessage
     */
    public function from(string $from): self
    {
        $this->payload['msgheader'] = $from;

        return $this;
    }

    /**
     * Return Message Text
     * @return mixed
     */
    public function getMessage()
    {
        return $this->payload['message'];
    }

    /**
     * Get the payload value for a given key.
     *
     * @param string $key
     *
     * @return mixed|null
     */
    public function getPayloadValue(string $key)
    {
        return $this->payload[$key] ?? null;
    }
}

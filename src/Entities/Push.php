<?php

namespace Webup\LaravelPush\Entities;

use JsonSerializable;

class Push implements JsonSerializable
{
    /**
     * id to identify the user associated to the device
     * @var string
     */
    public $uuid;

    /**
     * Device token (generated by Apple or Google servers)
     * @var string
     */
    public $token;

    /**
     * iOS (1) or Android (2)
     * @var int
     */
    public $platform;

    /**
     * Language for this token (i.e. "fr")
     * @var string
     */
    public $language;

    public function __construct(string $uuid, string $token, int $platform, string $language)
    {
        $this->uuid = $uuid;
        $this->token = $token;
        $this->platform = $platform;
        $this->language = $language;
    }

    public function jsonSerialize()
    {
        return [
            'uuid' => $this->uuid,
            'token' => $this->token,
            'platform' => intval($this->platform),
            'language' => $this->language,
        ];
    }
}

<?php


namespace gf2007\auth;


class AliYun
{
    private static $accessKeyId;
    private static $accessSecret;
    private static $hasInit = false;

    public static function init($accessKeyId, $accessSecret) {
        self::$accessKeyId = $accessKeyId;
        self::$accessSecret = $accessSecret;
        self::$hasInit = true;
    }

    /**
     * @return mixed
     */
    public static function getAccessKeyId()
    {
        return self::$accessKeyId;
    }

    /**
     * @param mixed $accessKeyId
     */
    public static function setAccessKeyId($accessKeyId)
    {
        self::$accessKeyId = $accessKeyId;
    }

    /**
     * @return mixed
     */
    public static function getAccessSecret()
    {
        return self::$accessSecret;
    }

    /**
     * @param mixed $accessSecret
     */
    public static function setAccessSecret($accessSecret)
    {
        self::$accessSecret = $accessSecret;
    }

    public static function hasInit() {
        return self::$hasInit;
    }


}

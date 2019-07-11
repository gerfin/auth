<?php


namespace gf2007\auth;

use gf2007\auth\exception\InvaildSmsCodeException;

class Auth
{
    private static $redis;
    private static $smsPrefix = "sms_";

    public static function init($redis) {

        self::$redis = $redis;
    }

    public static function sendSms($phone, $expireSecond = 2 * 60, $templateParam = '{code: %s}') {
        if (!Sms::hasInit())
            throw new \Exception("Please init class Sms first");
        if (self::$redis->get(self::$smsPrefix.$phone)) {
            throw new \Exception("短信验证码已下发, 请稍后再试");
        }
        $code = rand(100000, 999999);
        self::$redis->setex(self::$smsPrefix.$phone, $expireSecond, $code);
        Sms::send($phone, sprintf($templateParam, $code));
    }

    public static function validateSmsCode($phone, $code) {

        $codeSaved = self::$redis->get(self::$smsPrefix.$phone);

        return !$codeSaved || intval($codeSaved) !== intval($code) ;
    }


}

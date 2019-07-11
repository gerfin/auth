<?php

namespace gf2007\auth;


use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class Sms
{
    private static $signName;
    private static $templateCode;
    private static $hasInit = false;

    public static function init($signName, $templateCode) {
        if (!AliYun::hasInit()) {
            throw new \Exception("please init class AliYun First!");
        }
        self::$signName = $signName;
        self::$templateCode = $templateCode;
        self::$hasInit = true;
    }



    public static function send(string $phone, string $param) {
        if (!self::$hasInit) {
            throw new \Exception("please init class Sms first!");
        }
        AlibabaCloud::accessKeyClient(AliYun::getAccessKeyId(), AliYun::getAccessSecret())
            ->regionId('cn-hangzhou')
            ->asDefaultClient();

        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->options([
                    'query' => [
                        'RegionId' => "cn-hangzhou",
                        'SignName' => self::$signName,
                        'TemplateCode' => self::$templateCode,
                        'TemplateParam' => $param,
                        'PhoneNumbers' => $phone,
                    ],
                ])
                ->request();
            print_r($result->toArray());
        } catch (ClientException $e) {
            throw $e;
        } catch (ServerException $e) {
           throw $e;
        }
    }

    /**
     * @return mixed
     */
    public static function getSignName()
    {
        return self::$signName;
    }

    /**
     * @param mixed $signName
     */
    public static function setSignName($signName)
    {
        self::$signName = $signName;
    }

    /**
     * @return mixed
     */
    public static function getTemplateCode()
    {
        return self::$templateCode;
    }

    /**
     * @param mixed $templateCode
     */
    public static function setTemplateCode($templateCode)
    {
        self::$templateCode = $templateCode;
    }

    public static function hasInit()
    {
        return self::$hasInit;
    }




}

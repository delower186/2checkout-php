<?php

abstract class TwocheckoutGateway
{
    public static $sid;
    public static $privateKey;
    public static $username;
    public static $password;
    public static $verifySSL = true;
    public static $baseUrl = 'https://www.2checkout.com';
    public static $error;
    public static $demo = true;
    public static $format = 'array';
    const VERSION = '0.5.1';

    public static function sellerId($value = null) {
        self::$sid = $value;
    }

    public static function privateKey($value = null) {
        self::$privateKey = $value;
    }

    public static function username($value = null) {
        self::$username = $value;
    }

    public static function password($value = null) {
        self::$password = $value;
    }

    public static function verifySSL($value = null) {
        if ($value == 0 || $value == false) {
            self::$verifySSL = false;
        } else {
            self::$verifySSL = true;
        }
    }

    public static function demo($value = null) {
        if ($value == 0 || $value == false) {
            self::$demo = false;
        } else {
            self::$demo = true;
        }
    }

    public static function format($value = null) {
        self::$format = $value;
    }
}

require(dirname(__FILE__) . '/Api/TwocheckoutAccount.php');
require(dirname(__FILE__) . '/Api/TwocheckoutPayment.php');
require(dirname(__FILE__) . '/Api/TwocheckoutApi.php');
require(dirname(__FILE__) . '/Api/TwocheckoutSale.php');
require(dirname(__FILE__) . '/Api/TwocheckoutProduct.php');
require(dirname(__FILE__) . '/Api/TwocheckoutUtil.php');
require(dirname(__FILE__) . '/Api/TwocheckoutError.php');
require(dirname(__FILE__) . '/TwocheckoutReturn.php');
require(dirname(__FILE__) . '/TwocheckoutNotification.php');
require(dirname(__FILE__) . '/TwocheckoutCharge.php');
require(dirname(__FILE__) . '/TwocheckoutMessage.php');

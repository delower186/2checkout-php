<?php

class TwocheckoutReturn extends Twocheckout
{

    public static function check($params=array(), $secretWord)
    {
        $hashSecretWord = $secretWord;
        $hashSid = $params['sid'];
        $hashTotal = $params['total'];
        $hashOrder = $params['order_number'];
        $StringToHash = strtoupper(md5($hashSecretWord . $hashSid . $hashOrder . $hashTotal));
        if ($StringToHash != $params['key']) {
            $result = TwocheckoutMessage::message('Fail', 'Hash Mismatch');
        } else {
            $result = TwocheckoutMessage::message('Success', 'Hash Matched');
        }
        return TwocheckoutUtil::returnResponse($result);
    }

}
<?php

class TwocheckoutNotification extends Twocheckout
{

    public static function check($insMessage=array(), $secretWord)
    {
        $hashSid = $insMessage['vendor_id'];
        $hashOrder = $insMessage['sale_id'];
        $hashInvoice = $insMessage['invoice_id'];
        $StringToHash = strtoupper(md5($hashOrder . $hashSid . $hashInvoice . $secretWord));
        if ($StringToHash != $insMessage['md5_hash']) {
            $result = TwocheckoutMessage::message('Fail', 'Hash Mismatch');
        } else {
            $result = TwocheckoutMessage::message('Success', 'Hash Matched');
        }
        return TwocheckoutUtil::returnResponse($result);
    }

}

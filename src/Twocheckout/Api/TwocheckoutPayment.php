<?php

class TwocheckoutPayment extends Twocheckout
{

    public static function retrieve()
    {
        $request = new TwocheckoutApi();
        $urlSuffix = '/api/acct/list_payments';
        $result = $request->doCall($urlSuffix);
        $response = TwocheckoutUtil::returnResponse($result);
        return $response;
    }

    public static function pending()
    {
        $request = new TwocheckoutApi();
        $urlSuffix = '/api/acct/detail_pending_payment';
        $result = $request->doCall($urlSuffix);
        $response = TwocheckoutUtil::returnResponse($result);
        return $response;
    }

}
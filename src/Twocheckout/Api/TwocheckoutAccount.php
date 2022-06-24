<?php

class TwocheckoutCompany extends Twocheckout
{

    public static function retrieve()
    {
        $request = new TwocheckoutApi();
        $urlSuffix = '/api/acct/detail_company_info';
        $result = $request->doCall($urlSuffix);
        return TwocheckoutUtil::returnResponse($result);
    }
}

class TwocheckoutContact extends Twocheckout
{

    public static function retrieve()
    {
        $request = new TwocheckoutApi();
        $urlSuffix = '/api/acct/detail_contact_info';
        $result = $request->doCall($urlSuffix);
        return TwocheckoutUtil::returnResponse($result);
    }
}
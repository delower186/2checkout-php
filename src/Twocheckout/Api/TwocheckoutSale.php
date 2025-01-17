<?php

class TwocheckoutSale extends Twocheckout
{

    public static function retrieve($params=array())
    {
        $request = new TwocheckoutApi();
        if(array_key_exists("sale_id",$params) || array_key_exists("invoice_id",$params)) {
            $urlSuffix = '/api/sales/detail_sale';
        } else {
            $urlSuffix = '/api/sales/list_sales';
        }
        $result = $request->doCall($urlSuffix, $params);
        return TwocheckoutUtil::returnResponse($result);
    }

    public static function refund($params=array()) {
        $request = new TwocheckoutApi();
        if(array_key_exists("lineitem_id",$params)) {
            $urlSuffix ='/api/sales/refund_lineitem';
            $result = $request->doCall($urlSuffix, $params);
        } elseif(array_key_exists("invoice_id",$params) || array_key_exists("sale_id",$params)) {
            $urlSuffix ='/api/sales/refund_invoice';
            $result = $request->doCall($urlSuffix, $params);
        } else {
            $result = TwocheckoutMessage::message('Error', 'You must pass a sale_id, invoice_id or lineitem_id to use this method.');
        }
        return TwocheckoutUtil::returnResponse($result);
    }

    public static function stop($params=array()) {
        $request = new TwocheckoutApi();
        $urlSuffix ='/api/sales/stop_lineitem_recurring';
        if(array_key_exists("lineitem_id",$params)) {
            $result = $request->doCall($urlSuffix, $params);
        } elseif(array_key_exists("sale_id",$params)) {
            $result = TwocheckoutSale::retrieve($params);
            if (!is_array($result)) {
                $result = TwocheckoutUtil::returnResponse($result, 'array');
            }
            $lineitemData = TwocheckoutUtil::getRecurringLineitems($result);
            if (isset($lineitemData[0])) {
                $stoppedLineitems = array();
                foreach( $lineitemData as $value )
                {
                    $params = array('lineitem_id' => $value);
                    $result = $request->doCall($urlSuffix, $params);
                    $result = json_decode($result, true);
                    if ($result['response_code'] == "OK") {
                        $stoppedLineitems[] = $value;
                    }
                }
                $result = TwocheckoutMessage::message('OK', $stoppedLineitems);
            } else {
                throw new TwocheckoutError("No recurring lineitems to stop.");
            }
        } else {
            throw new TwocheckoutError('You must pass a sale_id or lineitem_id to use this method.');
        }
        return TwocheckoutUtil::returnResponse($result);
    }

    public static function active($params=array()) {
        if(array_key_exists("sale_id",$params)) {
            $result = TwocheckoutSale::retrieve($params);
            if (!is_array($result)) {
                $result = TwocheckoutUtil::returnResponse($result, 'array');
            }
            $lineitemData = TwocheckoutUtil::getRecurringLineitems($result);
            if (isset($lineitemData[0])) {
                $result = TwocheckoutMessage::message('OK', $lineitemData);
                return TwocheckoutUtil::returnResponse($result);
            } else {
                throw new TwocheckoutError("No active recurring lineitems.");
            }
        } else {
            throw new TwocheckoutError("You must pass a sale_id to use this method.");
        }
    }

    public static function comment($params=array()) {
        $request = new TwocheckoutApi();
        $urlSuffix ='/api/sales/create_comment';
        $result = $request->doCall($urlSuffix, $params);
        return TwocheckoutUtil::returnResponse($result);
    }

    public static function ship($params=array()) {
        $request = new TwocheckoutApi();
        $urlSuffix ='/api/sales/mark_shipped';
        $result = $request->doCall($urlSuffix, $params);
        return TwocheckoutUtil::returnResponse($result);
    }

}

<?php

class Twocheckout{

    public static function pay($paymentInfo = [],$keys = []){

        TwocheckoutGateway::privateKey($keys['privateKey']);
        TwocheckoutGateway::sellerId($keys['sellerId']);
        TwocheckoutGateway::demo($keys['demo']);

        if(TwocheckoutGateway::$demo === true){
            $paymentInfo['demo'] = true;
        }

        try{
            $charge = TwocheckoutCharge::auth($paymentInfo, 'array');

            if($charge['response']['responseCode'] == 'APPROVED'){

                echo "Paid";

            }
        }catch (TwocheckoutError $e) {

            echo $e->getMessage();
        }

    }
}
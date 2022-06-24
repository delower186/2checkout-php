<?php

use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__) . '/../lib/Twocheckout.php');
class SaleTest extends TestCase
{

    public function setUp(): void
    {
        Twocheckout::username('username');
        Twocheckout::password('pass');
    }

    public function testSaleRetrieve()
    {
        $params = array(
            'sale_id' => 250339324792
        );
        $sale = TwocheckoutSale::retrieve($params);
        $this->assertSame("250339323357", $sale['sale']['sale_id']);
    }

    public function testSaleRetrieveList()
    {
        $params = array(
            'pagesize' => 2
        );
        $sale = TwocheckoutSale::retrieve($params);
        $this->assertSame(2, sizeof($sale['sale_summary']));
    }

    public function testSaleRefundSale()
    {
        $params = array(
            'sale_id' => 250339323357,
            'category' => 1,
            'comment' => 'Order never sent.'
        );
        try {
            $sale = TwocheckoutSale::refund($params);
            $this->assertSame("OK", ($sale['response_code']));
        } catch (TwocheckoutError $e) {
            $this->assertSame("Amount greater than remaining balance on invoice.", $e->getMessage());
        }
    }

    public function testSaleRefundLineitem()
    {
        $params = array(
            'lineitem_id' => 250339324796,
            'category' => 1,
            'comment' => 'Order never sent.'
        );
        try {
            $sale = TwocheckoutSale::refund($params);
            $this->assertSame("OK", $sale['response_code']);
        } catch (TwocheckoutError $e) {
            $this->assertSame("Lineitem amount greater than remaining balance on invoice.", $e->getMessage());
        }
    }

    public function testSaleStopSale()
    {
        $params = array(
            'sale_id' => 250339328202
        );
        try {
            $response = TwocheckoutSale::stop($params);
            $this->assertSame("OK", $response['response_code']);
        } catch (TwocheckoutError $e) {
            $this->assertSame("No recurring lineitems to stop.", $e->getMessage());
        }
    }

    public function testSaleStopLineitem()
    {
        $params = array(
            'lineitem_id' => 9093717693210
        );
        try {
            $response = TwocheckoutSale::stop($params);
            $this->assertSame("OK", $response['response_code']);
        } catch (TwocheckoutError $e) {
            $this->assertSame("Lineitem is not scheduled to recur.", $e->getMessage());
        }
    }

    public function testSaleActive()
    {
        $params = array(
            'sale_id' => 250339328202
        );
        try {
            $response = TwocheckoutSale::active($params);
            $this->assertSame("OK", $response['response_code']);
        } catch (TwocheckoutError $e) {
            $this->assertSame("No active recurring lineitems.", $e->getMessage());
        }
    }

    public function testSaleComment()
    {
        $params = array(
            'sale_id' => 250339328202,
            'sale_comment' => "test"
        );
        $result = TwocheckoutSale::comment($params);
        $this->assertSame("Created comment successfully.", $result['response_message']);
    }

    public function testSaleShip()
    {
        $params = array(
            'sale_id' => 250339331047,
            'tracking_number' => "test"
        );
        try {
            $result = TwocheckoutSale::ship($params);
            $this->assertSame("OK", $result['response_code']);
        } catch (Exception $e) {
            $this->assertSame("Sale already marked shipped.", $e->getMessage());
        }
    }



}

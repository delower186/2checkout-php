<?php

require_once(dirname(__FILE__) . '/../lib/Twocheckout.php');

use PHPUnit\Framework\TestCase;

class CompanyTest extends TestCase
{

    public function setUp(): void
    {
        Twocheckout::username('username');
        Twocheckout::password('pass');
    }

    public function testCompanyRetrieve()
    {
        $company = TwocheckoutCompany::retrieve();
        $this->assertSame("250111206876", $company['vendor_company_info']['vendor_id']);
    }

    public function testContactRetrieve()
    {
        $company = TwocheckoutContact::retrieve();
        $this->assertSame("250111206876", $company['vendor_contact_info']['vendor_id']);
    }
  
}

<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 026 26 01 2015
 * Time: 12:57
 */

namespace tests\API\V1\Finance\BcentralTest;

use TestCase;

class BcentralTest extends TestCase
{
    public function testServiceExits()
    {
        $response = $this->call('GET', '/api/v1/finance/bcentral');

        $this->assertEquals(200, $response->getStatusCode());
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 026 26 01 2015
 * Time: 12:57
 */

namespace tests\API\V1\Finance\BcentralTest;

use App\Commands\API\V1\Finance\Bcentral\DailyIndexesCommand;
use App\Http\Responses\JsendResponse;
use TestCase;

/**
 * Class BcentralTest
 * @package tests\API\V1\Finance\BcentralTest
 */
class BcentralTest extends TestCase
{
    /**
     * @var
     */
    public $content;
    /**
     * @var
     */
    public $jsonContent;
    /**
     * @var
     */
    public $config;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->content = [
            'di' => file_get_contents(__DIR__ . '/bcentral_content.html'),
            'utm' => '',
            ];
        $this->jsonContent = file_get_contents(__DIR__ . '/bcentral_content.json');
        $this->config = \Config::get('finance.bcentral');
    }

    /**
     *
     */
    public function testServiceExits()
    {
        $response = $this->call('GET', '/api/v1/finance/bcentral');

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     *
     */
    public function testDailyIndexesService()
    {

        $command = new DailyIndexesCommand($this->content, $this->config);

        $result = $this->app['Illuminate\Contracts\Bus\Dispatcher']->dispatch($command);
        $response = (new JsendResponse())->success($result);
        $this->assertEquals($response->getContent(), $this->jsonContent);
    }

    /**
     *
     */
    public function testDailyIndexesCachedService()
    {
        \Cache::put('finance_bcentral.daily_indexes.content', $this->content, 1);
        $command = new DailyIndexesCommand($this->content, $this->config);

        $result = $this->app['Illuminate\Contracts\Bus\Dispatcher']->dispatch($command);
        $response = (new JsendResponse())->success($result);
        $this->assertEquals($response->getContent(), $this->jsonContent);
    }
}

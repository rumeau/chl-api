<?php
namespace App\Http\Controllers\API\V1\Finance;

use App\Commands\API\V1\Finance\Bcentral\DailyIndexesCommand;
use App\Http\Responses\JsendResponse;
use Config;
use Cache;
use GuzzleHttp;
use App\Http\Requests;
use App\Http\Controllers\RestController;
use App\Exceptions;
use Illuminate\Http\Request;

class BcentralController extends RestController
{
    /**
     * @var array
     */
    protected $apiTasks = [
        'daily_indexes',
    ];

    /**
     * @var array
     */
    protected $config;

    /**
     * @var GuzzleHttp\Client;
     */
    protected $client;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->client = new GuzzleHttp\Client();
        $this->client->setDefaultOption('verify', false);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        $this->config   = Config::get('finance.bcentral');

        $task       = $request->get('task', 'daily_indexes');
        $methodTask = camel_case($task);
        // If task is not found
        if (!in_array($task, $this->apiTasks)) {
            return $this->error(trans('finance.bcentral.invalid_task', ['task' => $task]));
        }

        $response = new JsendResponse();
        try {
            return $response->success($this->$methodTask($this->load($task)));
        } catch (Exceptions\RestResponseErrorException $e) {
            return $response->error($e->getMessage(), $e->getCode());
        } catch (Exceptions\RestResponseFailException $e) {
            return $response->fail($e->getMessage(), $e->getCode());
        }
	}

    /**
     * @param $content
     * @return mixed
     */
    public function dailyIndexes($content)
    {
        return $this->dispatch(new DailyIndexesCommand($content, $this->config));
    }

    /**
     * Loads the the cached content
     *
     * @param $task
     * @return bool|mixed
     */
    protected function load($task)
    {
        // Attempts to load from the cache

        if (!Cache::has("finance_bcentral.$task.content")) {
            $serviceUrl = array_get($this->config, "$task.service_url");
            $method = array_get($this->config, "$task.method", 'GET');
            // Query the content from the external source
            $content = $this->getServiceContent($serviceUrl, $method);

            if (!$content) {
                Cache::forget("finance_bcentral.$task.content");
                return false;
            }

            Cache::put(
                "finance_bcentral.$task.content",
                $content,
                array_get($this->config, 'expire', 30)
            );
        } else {
            $content = Cache::get("finance_bcentral.$task.content", false);
        }

        return $content;
    }

    /**
     * @param null $serviceUrl
     * @param string $method
     * @param array $params
     * @return bool
     */
    protected function getServiceContent($serviceUrl = null, $method = 'GET', $params = [])
    {
        try {
            if (!is_array($serviceUrl)) {
                $config = [
                    0 => [
                        'url'    => $serviceUrl,
                        'method' => strtolower($method),
                        'params' => $params
                    ]
                ];
            } else {
                $config = $serviceUrl;
            }

            $tmpResult = [];
            foreach ($config as $key => $clientConfig) {
                $clientUrl    = $clientConfig['url'];
                $clientMethod = $clientConfig['method'];
                $clientParams = isset($clientConfig['params']) ? $clientConfig['params'] : [];

                /**
                 * @var GuzzleHttp\Message\Response $response
                 */
                $response = $this->client->$clientMethod($clientUrl, array_merge([
                    'cookies' => true,
                ], $clientParams));

                $code = $response->getStatusCode();
                if ($code != 200) {
                    $tmpResult[$key] = false;
                } else {
                    $tmpResult[$key] = (string)$response->getBody();
                }
            }

            if (!is_array($serviceUrl)) {
                $result = $tmpResult[0];
            } else {
                $result = $tmpResult;
            }
        } catch (\Exception $e) {
            $result = false;
        }

        return $result;
    }
}

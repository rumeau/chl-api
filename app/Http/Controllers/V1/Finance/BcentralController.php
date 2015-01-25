<?php
namespace App\Http\Controllers\V1\Finance;

use Config;
use Cache;
use GuzzleHttp;
use Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Exceptions;
use Illuminate\Http\Request;

class BcentralController extends Controller
{
    /**
     * @var array
     */
    protected $apiTasks = [
        'daily_indexes',
    ];

    /**
     * @var GuzzleHttp\Client;
     */
    protected $client;

    /**
     *
     */
    public function __construct()
    {
        $this->client = new GuzzleHttp\Client();
        $this->client->setDefaultOption('verify', false);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        $config     = Config::get('finance.bcentral');

        $task       = $request->get('task', 'daily_indexes');
        $methodTask = camel_case($task);
        // If task is not found
        if (!in_array($task, $this->apiTasks)) {
            return $this->error(trans('finance.bcentral.invalid_task', ['task' => $task]));
        }

        $content = Cache::remember(
            'finance_bcentral.content',
            array_get($config, 'expire', 30),
            function() use($config, $task) {
                return $this->getServiceContent(
                    array_get($config, "$task.service_url"),
                    array_get($config, "$task.method", 'GET')
                );
            }
        );

        if (!$content) {
            Cache::forget('finance_bcentral.content');
            return $this->error(trans('finance.bcentral.http_client_error'));
        }

        return $this->$methodTask($content);
	}

    public function dailyIndexes($content)
    {

    }

    /**
     * @param null $serviceUrl
     * @param string $method
     * @param array $params
     * @return bool
     */
    protected function getServiceContent($serviceUrl = null, $method = 'GET', $params = [])
    {
        $method = strtolower($method);
        try {
            /**
             * @var GuzzleHttp\Transaction $response
             */
            $response = $this->client->$method($serviceUrl, [
                'cookies' => true,
            ]);
            $code     = $response->getStatusCode();
            if ($code != 200) {
                $result = false;
            } else {
                $result = (string) $response->getBody();
            }
        } catch (\Exception $e) {
            $result = false;
        }

        return $result;
    }

    protected function success($data)
    {
        return response()->json([
            'status'    => 'success',
            'message'   => $data
        ], 200);
    }

    protected function fail($data, $code = 400)
    {
        return response()->json([
            'status'    => 'fail',
            'message'   => $data
        ], $code);
    }

    public function error($message, $code = 500)
    {
        return response()->json([
            'status'    => $code,
            'message'   => $message
        ], $code);
    }
}

<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;

class AllowOrigin implements Middleware
{

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		/**
		 * @var \Illuminate\Http\Response $response
		 */
		$response = $next($request);
		$response->header('access-control-allow-origin','*');

		return $response;
	}

}

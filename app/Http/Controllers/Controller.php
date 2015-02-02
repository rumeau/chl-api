<?php
namespace App\Http\Controllers;

use App\Content;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	public function __construct()
	{
		view()->share('services', api_services());
	}

	/**
	 * @param array $parameters
	 * @return \Illuminate\View\View
	 */
	public function missingMethod($parameters = array())
	{
		return view('404');
	}
}

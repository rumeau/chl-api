<?php
namespace App\Http\Controllers;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
	/**
	 * Show the application dashboard to the user.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		return view('index.index');
	}

}

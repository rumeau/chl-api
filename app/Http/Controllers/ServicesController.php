<?php namespace App\Http\Controllers;

use App\Content;
use App\Http\Requests;

class ServicesController extends Controller
{

    public function getIndex(Content $service)
    {
        return view('services.index')->with('service', $service);
	}

}

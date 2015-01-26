<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 025 25 01 2015
 * Time: 12:16
 */

namespace App\Http\Controllers;

class RestController extends Controller
{
    public function __construct()
    {
        $this->middleware('allowOrigin');
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 026 26 01 2015
 * Time: 13:12
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function getIndex()
    {
        return view('admin.index.index');
    }
}

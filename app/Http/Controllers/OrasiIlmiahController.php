<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrasiIlmiahController extends Controller
{
    public function index()
    {
        return view('pages.orasi-ilmiah');
    }
}

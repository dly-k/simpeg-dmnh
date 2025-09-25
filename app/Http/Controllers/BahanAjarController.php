<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BahanAjarController extends Controller
{
    public function index()
    {
        return view('pages.bahan-ajar');
    }
}
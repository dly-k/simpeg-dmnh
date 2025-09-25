<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengelolaJurnalController extends Controller
{
        public function index()
    {
        return view('pages.pengelola-jurnal');
    }
}

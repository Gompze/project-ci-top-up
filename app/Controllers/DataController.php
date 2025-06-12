<?php

namespace App\Controllers;

class DataController extends BaseController
{
    public function index(): string
    {
        return view('detail_data');
    }
}
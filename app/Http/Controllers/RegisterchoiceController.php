<?php

namespace App\Http\Controllers;

use App\Model\RegisterChoice;
use Illuminate\Http\Request;

class RegisterchoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('register.index');
    }
}
